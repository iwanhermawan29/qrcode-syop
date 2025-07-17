<?php

namespace App\Helpers;

use App\Libraries\AES;

class AesHelper
{
    protected const KEY = '76b2ae9c9a66d7eccf8013df791d83c7c018b3faa88b027d1c7df08c6bc02e33';

    /**
     * Dekripsi keseluruhan cipher-text (hex) yang mungkin terdiri dari beberapa blok.
     */
    public static function paramDecrypt(string $encrypted): string
    {
        $cipher = new AES(AES::AES256);
        $n      = ceil(strlen($encrypted) / 32);
        $plain  = '';

        for ($i = 0; $i < $n; $i++) {
            $chunk  = substr($encrypted, $i * 32, 32);
            $decHex = $cipher->decrypt($chunk, self::KEY);
            $plain .= $cipher->hexToString($decHex);
        }

        return $plain;
    }

    /**
     * Enkripsi string (plain-text), kembalikan hex.
     */
    public static function paramEncrypt(string $plain): string
    {
        $cipher   = new AES(AES::AES256);
        $key      = self::KEY;
        // ubah string ke hex dulu...
        $dataHex  = $cipher->stringToHex($plain);
        $n        = ceil(strlen($dataHex) / 32);
        $ciphered = '';

        for ($i = 0; $i < $n; $i++) {
            $block     = substr($dataHex, $i * 32, 32);
            $ciphered .= $cipher->encrypt($block, $key);
        }

        return $ciphered;
    }
}
