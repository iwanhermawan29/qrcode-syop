<?php

namespace App\Libraries;

class AES
{
    public const AES128 = 128;
    public const AES192 = 192;
    public const AES256 = 256;

    private string $method;

    public function __construct(int $strength = self::AES256)
    {
        $this->method = match ($strength) {
            self::AES128 => 'aes-128-ecb',
            self::AES192 => 'aes-192-ecb',
            default       => 'aes-256-ecb',
        };
    }

    public function stringToHex(string $str): string
    {
        return bin2hex($str);
    }

    public function hexToString(string $hex): string
    {
        return hex2bin($hex);
    }

    public function encrypt(string $dataHex, string $keyHex): string
    {
        $data      = hex2bin($dataHex);
        $key       = hex2bin($keyHex);
        $rawCipher = openssl_encrypt(
            $data,
            $this->method,
            $key,
            OPENSSL_RAW_DATA | OPENSSL_ZERO_PADDING
        );
        return bin2hex($rawCipher);
    }

    public function decrypt(string $dataHex, string $keyHex): string
    {
        $data     = hex2bin($dataHex);
        $key      = hex2bin($keyHex);
        $rawPlain = openssl_decrypt(
            $data,
            $this->method,
            $key,
            OPENSSL_RAW_DATA | OPENSSL_ZERO_PADDING
        );
        return bin2hex($rawPlain);
    }
}
