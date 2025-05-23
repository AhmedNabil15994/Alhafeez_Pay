<?php
namespace App\Tocaan\Payments\traits;

trait KpaySecurityTrait
{
    private $tocaan_encryption_key = 'myTocaan';
    private $cipher = 'bf-cbc';

    /** ======== Payment Encrypt Functions Started ======
     * this functions created by knet developer don't change anything
     */
    /**
     * @param $str
     * @param $key
     *
     * @return string
     */
    public function encryptAES($str, $key)
    {
        $str = $this->pkcs5_pad($str);
        $encrypted = openssl_encrypt($str, 'AES-128-CBC', $key, OPENSSL_ZERO_PADDING, $key);
        $encrypted = base64_decode($encrypted);
        $encrypted = unpack('C*', ($encrypted));
        $encrypted = $this->byteArray2Hex($encrypted);
        $encrypted = urlencode($encrypted);

        return $encrypted;
    }

    /**
     * @param $text
     *
     * @return string
     */
    public function pkcs5_pad($text)
    {
        $blocksize = 16;
        $pad = $blocksize - (strlen($text) % $blocksize);

        return $text . str_repeat(chr($pad), $pad);
    }

    /**
     * @param $byteArray
     *
     * @return string
     */
    public function byteArray2Hex($byteArray)
    {
        $chars = array_map("chr", $byteArray);
        $bin = join($chars);

        return bin2hex($bin);
    }

    /**
     * @param $code
     * @param $key
     *
     * @return bool|string
     */
    public function decrypt($code, $key)
    {
        $code = $this->hex2ByteArray(trim($code));
        $code = $this->byteArray2String($code);
        $iv = $key;
        $code = base64_encode($code);
        $decrypted = openssl_decrypt($code, 'AES-128-CBC', $key, OPENSSL_ZERO_PADDING, $iv);

        return $this->pkcs5_unpad($decrypted);
    }

    /**
     * @param $hexString
     *
     * @return array
     */
    public function hex2ByteArray($hexString)
    {
        $string = hex2bin($hexString);

        return unpack('C*', $string);
    }

    /**
     * @param $byteArray
     *
     * @return string
     */
    public function byteArray2String($byteArray)
    {
        $chars = array_map("chr", $byteArray);

        return join($chars);
    }

    /**
     * @param $text
     *
     * @return bool|string
     */
    public function pkcs5_unpad($text)
    {

        $index = (strlen($text) - 1);
        $pad = ord($text[$index]);

        if ($pad > strlen($text)) {
            return false;
        }
        if (strspn($text, chr($pad), strlen($text) - $pad) != $pad) {
            return false;
        }

        return substr($text, 0, -1 * $pad);
    }
    /** ======== Payment Encrypt Functions Ended ====== */

    public function encryptString($string)
    {
        $ivlen = openssl_cipher_iv_length($this->cipher);
        $iv = openssl_random_pseudo_bytes($ivlen);

        return openssl_encrypt($string, $this->cipher, $this->tocaan_encryption_key, $options=0, $iv, $tag);;
    }

    public function decryptString($hash)
    {
        return openssl_decrypt($hash, $this->cipher, $this->tocaan_encryption_key);
    }
}
