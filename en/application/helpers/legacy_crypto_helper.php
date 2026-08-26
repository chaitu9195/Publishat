<?php
if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

use phpseclib3\Crypt\Rijndael;

/**
 * Legacy Rijndael-256 / ECB encryption compatible with the old ext-mcrypt code.
 *
 * The application originally produced document tokens with:
 *
 *     mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, $text, MCRYPT_MODE_ECB, $iv);
 *
 * ext-mcrypt was removed in PHP 7.2 and OpenSSL cannot do Rijndael with a
 * 256-bit block, so we reproduce the exact byte output with phpseclib3.
 *
 * To stay byte-for-byte compatible with the old ciphertext (the tokens are
 * decrypted by a separate mobile_ws backend), we must replicate mcrypt's
 * quirks exactly:
 *
 *   1. Key is zero-padded up to the next valid Rijndael key size.
 *      "hserus$#@!^&*()-" is 15 bytes -> padded to 16 bytes with one NUL.
 *   2. Block size is 256 bits (32 bytes).
 *   3. Plaintext is zero-padded (NOT PKCS7) to a multiple of the block size.
 *   4. ECB mode (the IV is irrelevant and was never used).
 *
 * phpseclib defaults to PKCS7 padding and a 128-bit block, so both are
 * overridden below.
 */
if (!function_exists('rijndael256_ecb_encrypt_raw')) {
	/**
	 * Encrypt and return the raw ciphertext bytes (mcrypt-compatible).
	 *
	 * @param string $key  Secret key (zero-padded to next valid size).
	 * @param string $text Plaintext.
	 * @return string Raw ciphertext.
	 */
	function rijndael256_ecb_encrypt_raw($key, $text)
	{
		$blockSize = 32; // 256-bit block

		// (1) Replicate mcrypt key handling: zero-pad the key UP TO the next
		// valid Rijndael key size (16, 24 or 32 bytes). A key that is already
		// a valid size is used verbatim (str_pad to the same length is a no-op).
		// The app's historical key "hserus$#@!^&*()-" is exactly 16 bytes, so
		// no padding occurs.
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

		// (3) Replicate mcrypt data handling: zero-pad plaintext to a full block.
		$rem = strlen($text) % $blockSize;
		if ($rem !== 0) {
			$text = str_pad($text, strlen($text) + ($blockSize - $rem), "\0");
		}

		$cipher = new Rijndael('ecb');
		$cipher->setBlockLength(256);   // (2) 256-bit block
		$cipher->setKey($key);
		$cipher->disablePadding();       // (3) we zero-pad manually, like mcrypt

		return $cipher->encrypt($text);
	}
}

if (!function_exists('legacy_safe_b64encode')) {
	/**
	 * URL-safe base64 identical to the models' safe_b64encode().
	 */
	function legacy_safe_b64encode($string)
	{
		$data = base64_encode($string);
		$data = str_replace(array('+', '/', '='), array('-', '_', ''), $data);
		return $data;
	}
}

if (!function_exists('legacy_encript')) {
	/**
	 * Drop-in replacement for the models' encript() method.
	 * Produces the same token the old mcrypt code produced.
	 *
	 * @param string $value Plaintext to encrypt.
	 * @param string $skey  Secret key (defaults to the app's historical key).
	 * @return string|false URL-safe base64 token, or false for empty input.
	 */
	function legacy_encript($value, $skey = 'hserus$#@!^&*()-')
	{
		if (!$value) {
			return false;
		}
		$crypttext = rijndael256_ecb_encrypt_raw($skey, $value);
		return trim(legacy_safe_b64encode($crypttext));
	}
}
