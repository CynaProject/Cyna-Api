<?php

namespace App\Service;

class EncryptionService
{
    private string $secretKey;
    private string $cipher = 'aes-256-cbc';

    public function __construct(string $secretKey)
    {
        $this->secretKey = $secretKey;
    }

    public function encrypt(string $plainText): string
    {
        $iv = random_bytes(openssl_cipher_iv_length($this->cipher));
        $encrypted = openssl_encrypt($plainText, $this->cipher, $this->secretKey, 0, $iv);

        return base64_encode($iv . $encrypted);
    }

    public function decrypt(string $encryptedText): ?string
{
    $data = base64_decode($encryptedText, true);
    if ($data === false) {
        // La chaîne n'est pas du base64 valide
        return null;
    }

    $ivLength = openssl_cipher_iv_length($this->cipher);
    if (strlen($data) < $ivLength) {
        // Pas assez de données pour contenir l'IV
        return null;
    }

    $iv = substr($data, 0, $ivLength);
    $cipherText = substr($data, $ivLength);

    $decrypted = openssl_decrypt($cipherText, $this->cipher, $this->secretKey, 0, $iv);

    return $decrypted === false ? null : $decrypted;
}



}
