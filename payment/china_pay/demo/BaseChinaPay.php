<?php
/**
 * Created by PhpStorm.
 * User: hj
 * Date: 2019-6-22
 * Time: 9:47
 */
require_once __DIR__ . '/../lib/SecssUtil.class.php';

abstract class BaseChinaPay
{
    protected $securityPropertiesFile = __DIR__ . '/../lib/security.properties';

    protected $gateway = 'https://newpayment-test.chinapay.com';

//    protected $gateway= 'https://payment.chinapay.com/CTITS/service/rest/forward/syn/000000000092/0/0/0/0/0';


    protected $secssUtil;

    protected $version = '20140728';

    protected $merId = '000091906209145';

    private $allowFailPostCount = 3;

    public function __construct()
    {
        define('CHINA_PAY_CERTIFICATE_DIR', __DIR__ . '/../cert-conzhu');
        $this->secssUtil = new SecssUtil();
        $this->secssUtil->init($this->securityPropertiesFile);
    }

    /**
     * @param $param
     * @return mixed
     */
    protected function getPostParam($param)
    {
        $postParam = array_merge($this->getCommonParam(), $param);
        $this->secssUtil->sign($postParam);
        if ("00" !== $this->secssUtil->getErrCode()) {
            throw  new RuntimeException("签名过程发生错误，错误信息为 --> {$this->secssUtil->getErrMsg()}");
        }
        $postParam['Signature'] = $this->secssUtil->getSign();
        return $postParam;
    }

    /**
     * @return array
     */
    protected function getCommonParam()
    {
        return [
            'Version' => $this->version,
            'MerId' => $this->merId,
        ];
    }


    /**
     * @param string $router
     * @param array $param
     * @return bool | array 说明：成功返回 array ，失败返回 false
     */
    protected function request($router, $param)
    {
        $postParam = $this->getPostParam($param);
        if (strpos($router, 'http') === 0) {
            $url = $router;
        } else {
            $url = $this->gateway . $router;
        }
        # 请求
        echo json_encode($postParam) . PHP_EOL;
        $response = $this->post($url, $postParam);
        if (empty($response)) {
            return false;
        }
        # 验签
        echo $response . PHP_EOL;
        $data = $this->parseQueryString($response);
        echo json_encode($data) . PHP_EOL;
        if ($data['respCode'] === '0000') {
            $this->verify($data);
        }
        return $data;
    }

    protected function post($url, $postParam)
    {
        $postFunction = function () use ($url, $postParam) {
            $ch = curl_init($url);
            curl_setopt_array($ch, [
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => http_build_query($postParam),
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_FOLLOWLOCATION => false,
                CURLOPT_TIMEOUT => 5
            ]);
            $response = curl_exec($ch);
            if (curl_errno($ch)) {
                throw new RuntimeException(sprintf("curl error [error_code : %s,error_msg : %s]", curl_error($ch), curl_error($ch)));
            }
            return $response;
        };
        return $this->callFunction($postFunction);
    }

    public function verify(array $signParam)
    {
        $this->secssUtil->verify($signParam);
        if ("00" !== $this->secssUtil->getErrCode()) {
            throw new RuntimeException("验签过程发生错误，错误信息为-->" . $this->secssUtil->getErrMsg());
        }
    }

    private function parseQueryString($queryString)
    {
        $keyValueList = explode('&', $queryString);
        $param = [];
        foreach ($keyValueList as $keyValue) {
            list($key, $value) = explode('=', $keyValue);
            $param[$key] = $value;
        }
        return $param;
    }

    public function callFunction(callable $function)
    {
        $failCount = 0;
        $callFunction = function (callable $function) use (&$failCount, &$callFunction) {
            try {
                return call_user_func($function);
            } catch (Exception $e) {
                $failCount++;
                if ($failCount <= $this->allowFailPostCount) {
                    return call_user_func($callFunction, $function);
                } else {
                    return $e;
                }
            }
        };
        return call_user_func($callFunction, $function);
    }
}