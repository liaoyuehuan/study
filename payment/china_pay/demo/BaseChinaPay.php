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

    protected $merId = '000091906209147';

    public function __construct()
    {
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
        $url = $this->gateway . $router;
        $response = $this->post($url, $postParam);
        if ($response) {
            parse_str($response, $data);
            return $data;
        } else {
            return false;
        }
    }

    protected function post($url, $postParam)
    {
        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query($postParam),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => false
        ]);
        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            throw new RuntimeException("curl error [error_code : %s,error_msg : %s]", curl_error($ch), curl_error($ch));
        }
        return $response;
    }
}