<?php
/* 
 *
 *RSA加密
 */
class Rsa
{
    private $_config = [
        'public_key' => '',
        'private_key' => ''
    ];

    public function __construct() {
        $this->_config['public_key'] = $this->_getContents("php_public.pem");
        $this->_config['private_key'] = $this->_getContents("php_private.pem");
    }

    /**
     * @uses 获取文件内容
     * @param $file_path string
     * @return bool|string
     */
    private function _getContents($file_path) {
        file_exists($file_path) or die ('密钥或公钥的文件路径错误');
        return file_get_contents($file_path);
    }

    /**     
     * @uses 获取公钥
     * @return bool|resource     
     */    
    private function _getPublicKey() {        
        $public_key = $this->_config['public_key'];
        return openssl_pkey_get_public($public_key);
    }

    /**     
     * @uses 公钥加密     
     * @param string $data     
     * @return null|string     
     */    
    public function publicEncrypt($data = '') {        
        if (!is_string($data)) {
            return null;        
        }
	#return openssl_public_encrypt('48656c6c6f776f726c64313233343536', $encrypted, $this->_getPublicKey()) ? bin2hex($encrypted) : null ;
	return openssl_public_encrypt($data, $encrypted, $this->_getPublicKey()) ? base64_encode($encrypted) : null ;
   }

    /**     
     *公钥解密
     * @return null     
     */    
    public function publicDecrypt($encrypted = '') {        
	if (!is_string($encrypted)) {
	    return null;        
        } 
	    #return (openssl_public_decrypt(hex2bin($encrypted), $decrypted, $this->_getPublicKey())) ? $decrypted : null;   //对接java解密过程中需要把密文从16进制转成2进制    
	    return (openssl_public_decrypt($encrypted, $decrypted, $this->_getPublicKey())) ? $decrypted : null;       
    }

    /**     
     * @uses 获取私钥
     * @return bool|resource     
     */ 
      private function _getPrivateKey() {
        $priv_key = $this->_config['private_key'];
        return openssl_pkey_get_private($priv_key);
    }  

     /**     
     * @uses 私钥加密
     * @param string $data     
     * @return null|string     
     */    
    public function privEncrypt($data = '') {     
        if (!is_string($data)) {
            return null;       
        }
        return openssl_private_encrypt($data, $encrypted, $this->_getPrivateKey()) ? base64_encode($encrypted) : null;
    }
    
    /**     
     * @uses 私钥解密     
     * @param string $encrypted     
     * @return null     
     */    
      public function privDecrypt($encrypted = '') {     
        if (!is_string($encrypted)) {
            return null;        
        }
        return (openssl_private_decrypt(base64_decode($encrypted), $decrypted, $this->_getPrivateKey())) ? $decrypted : null;
    }   


    /**
     * 生成签名
     * @param string 签名材料
     * @param string 签名编码（base64/hex/bin）
     * @return bool|string 签名值
     */
    public function sign($data, $code = 'base64')
    {
        $ret = false;
        if (openssl_sign($data, $ret, $this->_getPrivateKey())) {
            $ret = $this->_encode($ret, $code);
        }
        return $ret;
    }

    private function _encode($data, $code)
    {
        switch (strtolower($code)) {
            case 'base64':
                $data = base64_encode('' . $data);
                break;
            case 'hex':
                $data = bin2hex($data);
                break;
            case 'bin':
            default:
        }
        return $data;
    }

    private function _decode($data, $code)
    {
        switch (strtolower($code)) {
            case 'base64':
                $data = base64_decode($data);
                break;
            case 'hex':
                $data = $this->_hex2bin($data);
                break;
            case 'bin':
            default:
        }
        return $data;
    }

}
?>
