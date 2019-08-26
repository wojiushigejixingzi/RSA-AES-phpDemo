<?php
include 'Aes.php';
include 'Rsa.php';
class Demo
{
    private $Rsa;
    private $Aes;
    private $aesKey = "";
    private $yuanshishuju = "今天是周六，天气晴朗我们去踢球吧";
    private $sendData = array('data'=>"",'aesKey'=>'');
    public function run()
    {
        echo "【start】发送反开始加密,明文数据是>>>>>>>>>>".$this->yuanshishuju."\n";
        $this->aesKey = self::generateRandomString(); //生成AES key
        echo "【info】这是生成的AES key>>>>>>>>>>>>>>>>>>".$this->aesKey."\n";
        $this->Rsa = new Rsa();
        //通过RSA私钥去加密AES key
        $this->sendData['aesKey'] = $this->encryAesKey();
        echo "【info】这是RSA加密过后的AES key>>>>>>>>>>".$this->sendData['aesKey']."\n";
        //AES加密数据
        $this->sendData['data'] = $this->encryData();
        echo "【info】这是AES加密过后的数据>>>>>>>>>>>>>>". $this->sendData['data']."\n";
        /* *接收方*/
        //首先通过RSA私钥解密数据
        $aesKey = $this->rsaPrivateDecrypt($this->sendData['aesKey']);
        echo "【info】这是接收方解密后的AES key>>>>>>>>>>>". $aesKey."\n";
        //AES key去解密数据
        $data = $this->aesDecrypt($aesKey);
        echo "【info】这是接收方解密后的数据>>>>>>>>>>>>>>". $data."\n";
        echo "【end】";
    }
    /* AES key加密数据 */
    public function encryData()
    {
        $aes = new Aes($this->aesKey);//实例化AES
        return $aes->encrypt($this->yuanshishuju);
    }
    //RSA 公钥 加密AES key
    public function encryAesKey()
    {
        return $this->Rsa->publicEncrypt($this->aesKey);
    }
    //RSA 私钥解密数据
    public function rsaPrivateDecrypt($data)
    {
        return $this->Rsa->privDecrypt($data);
    }
    //AES key解密数据
    public function aesDecrypt($aesKey)
    {
        $aes = new Aes($aesKey);//实例化AES
        return $aes->decrypt($this->sendData['data']);
    }
    /* 随机生成16为字符串 */
    public static function generateRandomString($length = 16) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomString;
    }
    /*
    *openssl genrsa -out php_private.pem 2048     //1：执行命令（生成私钥）
    *openssl rsa -pubout -in php_private.pem -out php_public.pem //2：执行命令（创建私钥对应的公钥）
    */

}
$run = new Demo();
$run->run();
?>