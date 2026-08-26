<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

use phpseclib3\Crypt\Rijndael;

if (!function_exists('rijndael256_ecb_encrypt_raw')) {
    function rijndael256_ecb_encrypt_raw($key, $text)
    {
        $blockSize = 32;

        $keyLen = strlen($key);
        if ($keyLen <= 16) {
            $key = str_pad($key, 16, "\0");
        } elseif ($keyLen <= 24) {
            $key = str_pad($key, 24, "\0");
        } elseif ($keyLen <= 32) {
            $key = str_pad($key, 32, "\0");
        } else {
            $key = substr($key, 0, 32);
        }

        $rem = strlen($text) % $blockSize;
        if ($rem !== 0) {
            $text = str_pad($text, strlen($text) + ($blockSize - $rem), "\0");
        }

        $cipher = new Rijndael('ecb');
        $cipher->setBlockLength(256);
        $cipher->setKey($key);
        $cipher->disablePadding();

        return $cipher->encrypt($text);
    }
}

if (!function_exists('legacy_safe_b64encode')) {
    function legacy_safe_b64encode($string)
    {
        $data = base64_encode($string);
        $data = str_replace(['+', '/', '='], ['-', '_', ''], $data);
        return $data;
    }
}

if (!function_exists('legacy_encript')) {
    function legacy_encript($value, $skey = 'hserus$#@!^&*()-')
    {
        if (!$value) {
            return false;
        }
        $crypttext = rijndael256_ecb_encrypt_raw($skey, $value);
        return trim(legacy_safe_b64encode($crypttext));
    }
}
