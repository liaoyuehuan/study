<?php
require __DIR__ . '/../lib/NuoNuoApi.php';

//$res = $obj->getAccessToken('5a264817779ee7cb6708ce4cd201881e','339901999999142');

class  TestNuoNuo
{
    private $nuoNuoApi;

    private $accessToken = 'ef3fb65bb330eba4078beb18ajvccvai';

    public function __construct()
    {
        $this->nuoNuoApi = new  NuoNuoApi();
    }

    public function testOpenInvoice(){
        $taxIncludedAmount = 390;
        $taxRate = 0.06;
        $taxExcludedAmount = bcdiv($taxIncludedAmount,1 + $taxRate,2);
        $tax = bcsub($taxIncludedAmount,$taxExcludedAmount,2);
        $res = $this->nuoNuoApi->openInvoice($this->accessToken, [
            'buyerName' => '东莞市焕宝五金有限公司',
            'buyerTaxNum' => '91441900MA51GCB743',
            'buyerTel' => $param['buyerTel'] ?? '',
            'buyerAddress' => '焕宝地址',
            'buyerAccount' => '148511616151 东莞华南农业银行',
            'orderNo' => 'aaaaaaaaa1000003',
            'invoiceDate' => date('Y-m-d H:i:s'),
            'clerk' => '赖慧聪',
            'salerTaxNum' => '339901999999142',
            'salerTel' => '17816066266',
            'salerAddress' => '浙江省杭州市上城区浙江航信电子发票测试地址',
            'salerAccount' =>'1485116168888 北京华南农业银行',
            'invoiceType' => $param['invoiceType'] ?? 1,
            'remark' => $param['remark'] ?? '电子保函',
            # 收款人
            'payee' => $param['payee'] ?? '',
            # 复核人
            'checker' => $param['checker'] ?? '',
            # 冲红时必填，发票代码
            'invoiceCode' => $param['invoiceCode'] ?? '',
            # 冲红时必填，发票号码
            'invoiceNum' => $param['invoiceNum'] ?? '',
            # 推送方式。推送方式:-1,不推送;0,邮箱;1,手机（默认）; 2,邮箱、手机
            'pushMode' => $param['pushMode'] ?? 1,
            'buyerPhone' => '18814126254',
            'email' => $param['email'] ?? '',

            'invoiceDetail' => [
                'goodsName' => '电子保函',
                # 单价含税标志
                'withTaxFlag' => $param['invoiceDetail']['withTaxFlag'] ?? 1,
                # 税额
                'tax' => $tax,
                # 含税金额。
                'taxIncludedAmount' => $taxIncludedAmount,
                # 不含税金额。含税金额 = 不含税金额 * (1 + 税率)
                'taxExcludedAmount' => $taxExcludedAmount,
                # 税率
                'taxRate' => $taxRate,
            ],
            # https:://test-ebg.conzhu.net/api/independent_third_party/index.php/nuonuo/openInvoice
            'callBackUrl' => 'https://test-ebg.conzhu.net/api/independent_third_party/index.php/nuonuo/openInvoice'
        ], '339901999999142');
        var_dump($res);
    }

    public function testGetPdf(){
        $res  = $this->nuoNuoApi->getPdf($this->accessToken,[
            'invoiceCode' => '011002000711',
            'invoiceNo' => '67737734',
            'inTaxAmount' => '390'
        ],'339901999999142');
        var_dump($res);
    }

    public function getInvoiceStock(){
        $res  = $this->nuoNuoApi->getInvoiceStock($this->accessToken,[],'339901999999142');
        var_dump($res);
    }

    public function testGetReportTax(){
        $res  = $this->nuoNuoApi->getReportTax($this->accessToken,[],'339901999999142');
        var_dump($res);
    }

    public function testInvoiceCancellation(){
        $res  = $this->nuoNuoApi->invoiceCancellation($this->accessToken,[
            'invoiceId' => '21012014274602389552',
            'invoiceCode' => '035001900211',
            'invoiceNo' => '94017398'
        ],'91350100798367927Q');
        var_dump($res);
    }
}

(new TestNuoNuo())->testInvoiceCancellation();