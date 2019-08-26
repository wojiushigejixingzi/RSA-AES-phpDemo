<?php
/*$data = "周六我们去踢球吧！";   //需要加密的数据
$aesKey = "cqmh9PcIfeIwArbu"; //AES的密钥 
$method = 'AES-128-CBC';      //密码学方式
$iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($method));//偏移量，当模式为CBC的时候需要传入偏移量
$options= OPENSSL_RAW_DATA;   //填充方式
echo "================================"."\n";
echo "明文：".$data."\n";
$entryData = base64_encode(openssl_encrypt($data, $method, $aesKey, $options, $iv)); //加密
echo "加密后的数据是：".$entryData."\n";
echo "解密后的数据是：".openssl_decrypt(base64_decode($entryData), $method, $aesKey, $options, $iv)."\n"; //解密
echo "================================";
*/
echo str_repeat("\0",16);

?>