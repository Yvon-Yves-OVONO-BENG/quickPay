<?php

namespace App\Service;


use App\Service\CustomAESService;

class CustomAES
{
    private $aes;

    public function __construct(string $key)
    {
        if (strlen($key) !== 16) {
            throw new \InvalidArgumentException('La clé doit être de 16 octets.');
        }
        
        $this->aes = new CustomAESService($key);
    }

    public function encrypt(string $data)
    {
        return $this->aes->encrypt($data);
    }

    public function decrypt(string $data)
    {
        return $this->aes->decrypt($data);
    }
}
