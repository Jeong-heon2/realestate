<?php
//iv vector
define('KEY', '1234567890123456');
define('KEY_128', substr(KEY, 0, 128 / 8));
define('KEY_256', substr(KEY, 0, 256 / 8));

$str1 = '암호화되지 않은 문자';
echo 'plain : ' . $str1 . '<br>';

$str4 = openssl_encrypt($str1, 'AES-256-CBC', KEY_256, 0, KEY_128);
echo 'AES256 encrypted : ' . $str4 . "<br>";

$str5 = openssl_decrypt($str4, "AES-256-CBC", KEY_256, 0, KEY_128);
echo "AES256 decrypted : ". $str5 . '<br>';

?>

