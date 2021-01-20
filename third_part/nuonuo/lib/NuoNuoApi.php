<?php

include_once __DIR__ . '/NuoNuo.php';

class NuoNuoApi
{
    private $nuoNuo;

    public function __construct()
    {
        $this->nuoNuo = new NuoNuo([
            'app_key' => '67346968',
            'app_secret' => '2EB7554FC8634726',
            'redirect_uri' => 'https://test-ebg.conzhu.net/api/independent_third_party/index.php/nuoNuo/receiveInvoice',
            'access_token_gateway' => 'https://open.nuonuo.com/accessToken',
            'gateway' => 'https://sdk.nuonuo.com/open/v1/services'
        ]);
    }

    public function getAccessToken($code, $taxNum = '')
    {
        return $this->nuoNuo->getAccessToken($code . $taxNum);
    }

    public function openInvoice($accessToken, $param, $taxNum)
    {
        return $this->nuoNuo->apiRequest(
            $accessToken,
            'nuonuo.electronInvoice.requestBillingNew',
            [
                'order' => [
                    ## 买家信息
                    'buyerName' => $param['buyerName'],
                    'buyerTaxNum' => $taxNum,
                    'buyerTel' => $param['buyerTel'] ?? '',
                    'buyerAddress' => $param['buyerAddress'] ?? '',
                    'buyerAccount' => $param['buyerAccount'] ?? '',

                    ## 订单信息
                    'orderNo' => $param['orderNo'],
                    'invoiceDate' => $param['invoiceDate'],
                    'invoiceType' => $param['invoiceType'] ?? 1,
                    'remark' => $param['remark'] ?? '',

                    ## 销方信息
                    'salerTaxNum' => $param['salerTaxNum'],
                    'salerTel' => $param['salerTel'],
                    'salerAddress' => $param['salerAddress'],
                    'salerAccount' => $param['salerAccount'] ?? '',
                    # 开票员
                    'clerk' => $param['clerk'],
                    # 收款人
                    'payee' => $param['payee'] ?? '',
                    # 复核人
                    'checker' => $param['checker'],
                    # 冲红时必填，发票代码
                    'invoiceCode' => $param['invoiceCode'] ?? '',
                    # 冲红时必填，发票号码
                    'invoiceNum' => $param['invoiceNum'] ?? '',
                    # 推送方式。推送方式:-1,不推送;0,邮箱;1,手机（默认）; 2,邮箱、手机
                    'pushMode' => $param['pushMode'] ?? 1,
                    'buyerPhone' => $param['buyerPhone'],
                    'email' => $param['email'] ?? '',

                    'invoiceDetail' => [
                        'goodsName' => $param['invoiceDetail']['goodsName'],
                        # 单价含税标志
                        'withTaxFlag' => $param['invoiceDetail']['withTaxFlag'] ?? 1,
                        # 税额
                        'tax' => $param['invoiceDetail']['tax'] ?? 1,
                        # 含税金额。
                        'taxIncludedAmount' => $param['invoiceDetail']['taxIncludedAmount'],
                        # 不含税金额。含税金额 = 不含税金额 * (1 + 税率)
                        'taxExcludedAmount' => $param['invoiceDetail']['taxExcludedAmount'],
                        # 税率
                        'taxRate' => $param['invoiceDetail']['taxRate'],
                    ],
                    # https:://test-ebg.conzhu.net/api/independent_third_party/index.php/nuonuo/openInvoice
                    'callBackUrl' => $param['callBackUrl'] ?? ''
                ]
            ], $taxNum);
    }

    public function getPdf($accessToken, $param, $taxNum)
    {
        return $this->nuoNuo->apiRequest($accessToken, 'nuonuo.ElectronInvoice.getPDF', [
            'invoiceCode' => $param['invoiceCode'],
            'invoiceNo' => $param['invoiceNo'],
            # 含税金额
            'inTaxAmount' => $param['inTaxAmount'],
        ], $taxNum);
    }

    public function getInvoiceStock($accessToken, array $param, $taxNum)
    {
        return $this->nuoNuo->apiRequest($accessToken, 'nuonuo.ElectronInvoice.getInvoiceStock', [
            'departmentId' => $param['departmentId'] ?? '',
            'extensionNums' => $param['extensionNums'] ?? []
        ], $taxNum);
    }

    public function getReportTax($accessToken, array $param, $taxNum)
    {
        return $this->nuoNuo->apiRequest($accessToken, 'nuonuo.ElectronInvoice.getReportTax', [
            'departmentId' => $param['departmentId'] ?? '',
            'extensionNums' => $param['extensionNums'] ?? []
        ], $taxNum);
    }

    public function invoiceCancellation($accessToken, array $param, $taxNum){
        return $this->nuoNuo->apiRequest($accessToken, 'nuonuo.electronInvoice.invoiceCancellation', [
            'invoiceId' => $param['invoiceId'],
            'invoiceCode' => $param['invoiceCode'],
            'invoiceNo' => $param['invoiceNo']
        ], $taxNum);
    }
}