<?php
/**
 * Created by PhpStorm.
 * User: hj
 * Date: 2019-6-27
 * Time: 17:47
 */
require_once __DIR__ . '/BaseChinaPay.php';

class TestDataChinaPay extends BaseChinaPay
{
    public function encrypt()
    {
        $plainData = 'hello';
        $this->secssUtil->encryptData($plainData);
        if ('00' !== $this->secssUtil->getErrCode()) {
            throw new RuntimeException("加密过程发生错误，错误信息为-->" . $this->secssUtil->getErrMsg());
        }
        $encData = $this->secssUtil->getEncValue();
        $this->secssUtil->decryptData($encData);
        $plainData = $this->secssUtil->getDecValue();
        return $plainData;
    }

    public function decrypt()
    {
        $encData = 'KvzCKOEf01HvCbr6m+Nrn1lkK4vECCLuvyUerYUnCIUN6gEh9BEZ0H4JE3xrkMYLIjwClu3X6qTb3DDTlsFJVP4qXRGJPBmRSjianeMD+SpMqCtiAwTyWbX1cUxvp4pbAW1QghojF+/6HWk55QpTAOuYQ29VNQ0S6nfsy8d3HU0=';
        $this->secssUtil->decryptData($encData);
        if ('00' !== $this->secssUtil->getErrCode()) {
            throw new RuntimeException("解密过程发生错误，错误信息为-->" . $this->secssUtil->getErrMsg());
        }
        $plainData = $this->secssUtil->getDecValue();
        return $plainData;
    }
}

try {
    $obj = new TestDataChinaPay();
    var_dump($obj->encrypt());
} catch (RuntimeException $e) {
    throw $e;
}
