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
        $param['InMerId'] = $this->merId;
        $param['MerOrderNo'] = '48546581561515616';
        $param['TranDate'] = date('Ymd');
        $param['TranType'] = '0902';
        $param['MerResv'] = 'MerResvValue';
        $param['TranReserved'] = json_encode(['ok' => 'ok']);
        $router = '/CTITS/service/rest/forward/syn/000000000092/0/0/0/0/0';
        $responseData = $this->request($router, $param);
        return $responseData;
    }

    public function amountSeparate()
    {
        $param['InMerId'] = '000091906209149';
        $param['LiqType'] = '0';
        $param['MerOrderNo'] = '48546581561515618';
        $param['TranDate'] = date('Ymd');
        $param['TranTime'] = date('His');
        $param['TranType'] = '0903';
        $param['AmtType'] = '0';
        $param['OrderAmt'] = '100';
        $param['PayMemo'] = '附言';
        $param['MerResv'] = '商户私有域';
        $param['TranReserved'] = json_encode(['data' => '交易扩展域']);
        $router = '/CTITS/service/rest/forward/syn/000000000093/0/0/0/0/0';
        $responseData = $this->request($router, $param);
        return $responseData;
    }

    public function merchantComputableSearch()
    {
        $param['InMerId'] = '000091906209147';
        $param['TranType'] = '0904';
        $router = '/CTITS/service/rest/forward/syn/000000000094/0/0/0/0/0';
        $responseData = $this->request($router, $param);
        return $responseData;
    }
}

try {
    $obj = new TestChinaPay();
    var_dump($obj->merchantComputableSearch());
} catch (RuntimeException $e) {
   throw $e;
}
