<?php
/**
 * Created by PhpStorm.
 * User: hj
 * Date: 2019-6-21
 * Time: 15:46
 */

require_once __DIR__ . '/BaseChinaPay.php';

class TestChinaPay extends BaseChinaPay
{
    public function actionDetailSearch()
    {
        $param['InMerId'] = '000091906209146';
        $param['MerOrderNo'] = '20190703140641';
        $param['TranDate'] = '20190703';
        $param['TranType'] = '0902';
//        $param['MerResv'] = 'MerResvValue';
//        $param['TranReserved'] = json_encode(['ok' => 'ok']);
        $router = '/CTITS/service/rest/forward/syn/000000000092/0/0/0/0/0';
        $responseData = $this->request($router, $param);
        return $responseData;
    }

    public function amountSeparate()
    {
        $param['InMerId'] = '000091906209146';
        # 0 => 划款, 1 => 分张
        $param['LiqType'] = '1';
        # LiqType = 1 是才需要
        $param['ShareMerId'] = '000091906209147';

        $param['MerOrderNo'] = date('YmdHis');
        $param['TranDate'] = date('Ymd');
        $param['TranTime'] = date('His');
        $param['TranType'] = '0903';

        # AmtType 0 => 固定金额， 1 => 划付所有可划付金额
        $param['AmtType'] = '0';

        $param['OrderAmt'] = '100';
        $param['PayMemo'] = '附言';
        $param['MerResv'] = '商户私有域';
        $param['TranReserved'] = json_encode([

        ]);

        $router = '/CTITS/service/rest/forward/syn/000000000093/0/0/0/0/0';
        $responseData = $this->request($router, $param);
        return $responseData;
    }

    public function merchantComputableSearch()
    {
        $param['InMerId'] = '000091906209146';
        $param['TranType'] = '0904';
        $router = '/CTITS/service/rest/forward/syn/000000000094/0/0/0/0/0';
        $responseData = $this->request($router, $param);
        return $responseData;
    }

    /**
     * 可用于测试
     * @return array|bool
     */
    public function backendPayment()
    {
        $param = [
            'MerOrderNo' => '1812519841888',
            'TranDate' => date("Ymd", time()),
            'TranTime' => date("His", time()),
            'OrderAmt' => bcmul(99.99, 100, 0),
            // 0005 => 小程序
            // 0001 => 网页
            'TranType' => '0005',
            'BusiType' => '0001',
            # 分账
            'SplitType' => '0001',
            'SplitMethod' => '1',
            ## 分账方商户号^金额或比例;分账方商户号^金额或比,
            ## 分张方一定是关联商户
            'MerSplitMsg' => "000091906209146^80;000091906209147^20",

            'MerBgUrl' => ":https://127.0.0.1/e/allpay/chinapay/test_notify_url.php",

            # 非必须字段
            'CommodityMsg' => '保函',
            'MerResv' => 'MerResv',
            'TranReserved' => json_encode([
                'MiniPayUrl' => 'http://127.0.0.1:8008',
                'MiniPayFlag' => 1
            ]),
            'PayTimeOut' => '10',
            'TimeStamp' => date('YmdHis'),
            'RemoteAddr' => '127.0.0.1',
        ];
        $response = $this->request('/CTITS/service/rest/forward/syn/000000000017/0/0/0/0/0', $param);
        return $response;
    }

    public function frontendPayment()
    {
        $param = [
            'MerOrderNo' => '1812519841100',
            'TranDate' => date("Ymd", time()),
            'TranTime' => date("His", time()),
            'OrderAmt' => bcmul(99.99, 100, 0),
            'TranType' => '0001',
            'BusiType' => '0001',
            # 分账
            'SplitType' => '0001',
            'SplitMethod' => '1',
            // 分账方商户号^金额或比例;分账方商户号^金额或比,
            'MerSplitMsg' => "000091906209147^100",

            'MerBgUrl' => ":https://127.0.0.1/e/allpay/chinapay/test_notify_url.php",

            # 非必须字段
            'CommodityMsg' => '保函',
            'MerResv' => 'MerResv',
//            'TranReserved' => json_encode(['xixi' => 'xixi']),
            'PayTimeOut' => '10',
            'TimeStamp' => date('YmdHis'),
            'RemoteAddr' => '127.0.0.1',
        ];
        $data = [
            'post_data' => $this->getPostParam($param),
            'post_url' => '/CTITS/service/rest/page/nref/000000000017/0/0/0/0/0'
        ];
        // 使用js的form post请求
    }

    public function tradeSearch()
    {
        $param['MerOrderNo'] = '1812519841600';
        $param['TranDate'] = '20190626';
        $param['TranType'] = '0502';
        $param['BusiType'] = '0001';
        $param['TranReserved'] = json_encode(['ok' => 'ok']);
        $router = '/CTITS/service/rest/forward/syn/000000000060/0/0/0/0/0';
        $responseData = $this->request($router, $param);
        return $responseData;
    }

    public function refund()
    {
        $param['MerOrderNo'] = '111111110013';
        $param['TranDate'] = date('Ymd');
        $param['TranTime'] = date('His');
        $param['OriOrderNo'] = '1812519841127';
        $param['OriTranDate'] = '20190626';
        $param['RefundAmt'] = '1000';
        $param['TranType'] = '0401';
        $param['BusiType'] = '0001';
        $param['SplitType'] = '0001';
        $param['SplitMethod'] = '1';
        $param['MerSplitMsg'] = '000091906209146^80;000091906209147^20';
        $router = '/CTITS/service/rest/forward/syn/000000000065/0/0/0/0/0';
        $responseData = $this->request($router, $param);
        return $responseData;
    }

    public function noticeSeparate()
    {
        $param['MerOrderNo'] = date('YmdHis');
        $param['TranDate'] = date('Ymd');
        $param['TranTime'] = date('His');
        $param['OriOrderNo'] = '1812576618';
        $param['OriTranDate'] = '20190712';
        $param['OrderAmt'] = '3300';
        $param['TranType'] = '9908';
        $param['BusiType'] = '0001';
        $router = '/CTITS/service/rest/forward/syn/000000000065/0/0/0/0/0';
        $responseData = $this->request($router, $param);
        return $responseData;
    }

    public function testBgTransGet()
    {
        $param = [
            'AccessType' => '0',
            'MerOrderNo' => '18125198404770',
            'TranDate' => date("Ymd", time()),
            'TranTime' => date("His", time()),
            'OrderAmt' => bcmul(99.99, 100, 0),
            'TranType' => '0009',
            'BusiType' => '0001',
            'CurryNo' => 'CNY',
            # 分账
            'SplitType' => '0001',
            'SplitMethod' => '1',
            ## 分账方商户号^金额或比例;分账方商户号^金额或比,
            ## 分张方一定是关联商户
            'MerSplitMsg' => "000091906209146^80;000091906209147^20",

            'MerBgUrl' => "https://127.0.0.1/e/allpay/chinapay/test_notify_url.php",

            # 非必须字段
            'CommodityMsg' => '保函',
            'MerResv' => 'MerResv',
//            'TranReserved' => json_encode(['xixi' => 'xixi']),
            'PayTimeOut' => '10',
            'TimeStamp' => date('YmdHis'),
            'RemoteAddr' => '127.0.0.1',
            'OrderReserved' => json_encode([
                'OrderType' => '0001',
//                'OrderValidTime' => date('YmdHis',time() + 10 * 60),
                'qrPattern' => 'link'
            ])
        ];
        $response = $this->request('https://bianmin-test.chinapay.com/momsMgr/bgTransGet', $param);
        return $response;
    }
}

try {
    $obj = new TestChinaPay();
    var_dump($obj->testBgTransGet());
} catch (RuntimeException $e) {
    throw $e;
}
