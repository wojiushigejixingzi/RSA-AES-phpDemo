<?php
/**
 * @date:20190805 create by wwb
 * @desc：php aes加密解密类
 */
class Aes{
	private $method = 'AES-128-CBC';
	private $key;

	public function __construct($key)
	{
		$this->key = $key;
	}
	//获取向量
	private function getiv()
	{
		#return openssl_random_pseudo_bytes(openssl_cipher_iv_length($this->method));//偏移量，当模式为CBC的时候需要传入偏移量
		$size = 16;
		return str_repeat("\0",$size);
	}
	//加密
	public function encrypt($data)
	{
		return base64_encode(openssl_encrypt($data, $this->method, $this->key, OPENSSL_RAW_DATA, $this->getiv()));
	}
	//解密
	public function decrypt($data)
	{
		return openssl_decrypt(base64_decode($data), $this->method, $this->key, OPENSSL_RAW_DATA, $this->getiv());
	}
}
?>
