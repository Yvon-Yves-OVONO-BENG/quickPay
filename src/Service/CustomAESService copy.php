<?php

namespace App\Service;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class CustomAESService
{
    // Clé de chiffrement
    private string $key;
    // Table de substitution AES (S-box)
    private $sbox;
    // Constantes de rondes (Rcon)
    private $rcon;
    // Inverse de la S-box
    private $invSbox;

    public function __construct( private ParameterBagInterface $params)
    {
        // Vérifie si la clé a une longueur de 16 octets (128 bits)
        $secretKey = $params->get('aes_secret_key');

        if(!ctype_xdigit($secretKey) || strlen($secretKey) % 2 !==0 )
        {
            throw new \InvalidArgumentException('aes_secret_key doit être une chaîne hexadécimale de longueur paire');
        }

        $key = hex2bin($_ENV['APP_AES_KEY']);
        
        if (strlen($key) !== 16) {
            throw new \InvalidArgumentException('La clé doit être de 16 octets.');
        }

        $this->key = $key ;
        $this->sbox = $this->generateSBox();
        $this->invSbox = $this->generateInvSBox();
        $this->rcon = $this->generateRcon();
        
    }

    // Génère la table S-box pour substitution
    private function generateSBox()
    {
        return [
        0x63, 0x7c, 0x77, 0x7b, 0xf2, 0x6b, 0x6f, 0xc5,
        0x30, 0x01, 0x67, 0x2b, 0xfe, 0xd7, 0xab, 0x76,
        0xca, 0x82, 0xc9, 0x7d, 0xfa, 0x59, 0x47, 0xf0,
        0xad, 0xd4, 0xa2, 0xaf, 0x9c, 0xa4, 0x72, 0xc0,
        0xb7, 0xfd, 0x93, 0x26, 0x36, 0x3f, 0xf7, 0xcc,
        0x34, 0xa5, 0xe5, 0xf1, 0x71, 0xd8, 0x31, 0x15,
        0x04, 0xc7, 0x23, 0xc3, 0x18, 0x96, 0x05, 0x9a,
        0x07, 0x12, 0x80, 0xe2, 0xeb, 0x27, 0xb2, 0x75,
        0x09, 0x83, 0x2c, 0x1a, 0x1b, 0x6e, 0x5a, 0xa0,
        0x52, 0x3b, 0xd6, 0xb3, 0x29, 0xe3, 0x2f, 0x84,
        0x53, 0xd1, 0x00, 0xed, 0x20, 0xfc, 0xb1, 0x5b,
        0x6a, 0xcb, 0xbe, 0x39, 0x4a, 0x4c, 0x58, 0xcf,
        0xd0, 0xef, 0xaa, 0xfb, 0x43, 0x4d, 0x33, 0x85,
        0x45, 0xf9, 0x02, 0x7f, 0x50, 0x3c, 0x9f, 0xa8,
        0x51, 0xa3, 0x40, 0x8f, 0x92, 0x9d, 0x38, 0xf5,
        0xbc, 0xb6, 0xda, 0x21, 0x10, 0xff, 0xf3, 0xd2,
        0xcd, 0x0c, 0x13, 0xec, 0x5f, 0x97, 0x44, 0x17,
        0xc4, 0xa7, 0x7e, 0x3d, 0x64, 0x5d, 0x19, 0x73,
        0x60, 0x81, 0x4f, 0xdc, 0x22, 0x2a, 0x90, 0x88,
        0x46, 0xee, 0xb8, 0x14, 0xde, 0x5e, 0x0b, 0xdb,
        0xe0, 0x32, 0x3a, 0x0a, 0x49, 0x06, 0x24, 0x5c,
        0xc2, 0xd3, 0xac, 0x62, 0x91, 0x95, 0xe4, 0x79,
        0xe7, 0xc8, 0x37, 0x6d, 0x8d, 0xd5, 0x4e, 0xa9,
        0x6c, 0x56, 0xf4, 0xea, 0x65, 0x7a, 0xae, 0x08,
        0xba, 0x78, 0x25, 0x2e, 0x1c, 0xa6, 0xb4, 0xc6,
        0xe8, 0xdd, 0x74, 0x1f, 0x4b, 0xbd, 0x8b, 0x8a,
        0x70, 0x3e, 0xb5, 0x66, 0x48, 0x03, 0xf6, 0x0e,
        0x61, 0x35, 0x57, 0xb9, 0x86, 0xc1, 0x1d, 0x9e,
        0xe1, 0xf8, 0x98, 0x11, 0x69, 0xd9, 0x8e, 0x94,
        0x9b, 0x1e, 0x87, 0xe9, 0xce, 0x55, 0x28, 0xdf,
        0x8c, 0xa1, 0x89, 0x0d, 0xbf, 0xe6, 0x42, 0x68,
        0x41, 0x99, 0x2d, 0x0f, 0xb0, 0x54, 0xbb, 0x16,
        ];
    }

    // Génère la table inversée de la S-box
    private function generateInvSBox()
    {
        return [
            0x52, 0x09, 0x6A, 0xD5, 0x30, 0x36, 0xA5, 0x38, 0xBF, 0x40, 0xA3, 0x9E, 0x81, 0xF3, 0xD7, 0xFB,
            0x7C, 0x7B, 0xF2, 0x93, 0x26, 0x36, 0x3F, 0xF7, 0xCC, 0x34, 0xA5, 0xE5, 0xF5, 0x02, 0xC2, 0xE4,
            0xD3, 0x58, 0x07, 0x9C, 0x11, 0x12, 0x1A, 0xD2, 0x27, 0xB9, 0x3D, 0x9F, 0x5A, 0xA0, 0xF3, 0x53,
            0x62, 0x02, 0x1C, 0xD3, 0x9F, 0xA4, 0xC9, 0x55, 0x4B, 0x01, 0x5C, 0x60, 0x2F, 0x9A, 0x0E, 0xB8,
            0x3E, 0x58, 0x63, 0xA3, 0xE4, 0xAA, 0x77, 0xE8, 0x41, 0xAC, 0xE9, 0x76, 0x4E, 0x33, 0x37, 0x82
        ];
    }

    // Constantes de ronde (Rcon) utilisées dans AES
    private function generateRcon()
    {
        return [
            0x8D, 0x01, 0x02, 0x04, 0x08, 0x10, 0x20, 0x40, 0x80, 0x1B, 0x36, 0x6C, 0xD8, 0xAB, 0x4D, 0x9A
        ];
    }


    private static function getSBox(): array
    {
        return  [
            // S-Box standard AES
            0x63, 0x7c, 0x77, 0x7b, 0xf2, 0x6b, 0x6f, 0xc5,
            0x30, 0x01, 0x67, 0x2b, 0xfe, 0xd7, 0xab, 0x76,
            0xca, 0x82, 0xc9, 0x7d, 0xfa, 0x59, 0x47, 0xf0,
            0xad, 0xd4, 0xa2, 0xaf, 0x9c, 0xa4, 0x72, 0xc0,
            0xb7, 0xfd, 0x93, 0x26, 0x36, 0x3f, 0xf7, 0xcc,
            0x34, 0xa5, 0xe5, 0xf1, 0x71, 0xd8, 0x31, 0x15,
            0x04, 0xc7, 0x23, 0xc3, 0x18, 0x96, 0x05, 0x9a,
            0x07, 0x12, 0x80, 0xe2, 0xeb, 0x27, 0xb2, 0x75,
            0x09, 0x83, 0x2c, 0x1a, 0x1b, 0x6e, 0x5a, 0xa0,
            0x52, 0x3b, 0xd6, 0xb3, 0x29, 0xe3, 0x2f, 0x84,
            0x53, 0xd1, 0x00, 0xed, 0x20, 0xfc, 0xb1, 0x5b,
            0x6a, 0xcb, 0xbe, 0x39, 0x4a, 0x4c, 0x58, 0xcf,
            0xd0, 0xef, 0xaa, 0xfb, 0x43, 0x4d, 0x33, 0x85,
            0x45, 0xf9, 0x02, 0x7f, 0x50, 0x3c, 0x9f, 0xa8,
            0x51, 0xa3, 0x40, 0x8f, 0x92, 0x9d, 0x38, 0xf5,
            0xbc, 0xb6, 0xda, 0x21, 0x10, 0xff, 0xf3, 0xd2,
            0xcd, 0x0c, 0x13, 0xec, 0x5f, 0x97, 0x44, 0x17,
            0xc4, 0xa7, 0x7e, 0x3d, 0x64, 0x5d, 0x19, 0x73,
            0x60, 0x81, 0x4f, 0xdc, 0x22, 0x2a, 0x90, 0x88,
            0x46, 0xee, 0xb8, 0x14, 0xde, 0x5e, 0x0b, 0xdb,
            0xe0, 0x32, 0x3a, 0x0a, 0x49, 0x06, 0x24, 0x5c,
            0xc2, 0xd3, 0xac, 0x62, 0x91, 0x95, 0xe4, 0x79,
            0xe7, 0xc8, 0x37, 0x6d, 0x8d, 0xd5, 0x4e, 0xa9,
            0x6c, 0x56, 0xf4, 0xea, 0x65, 0x7a, 0xae, 0x08,
            0xba, 0x78, 0x25, 0x2e, 0x1c, 0xa6, 0xb4, 0xc6,
            0xe8, 0xdd, 0x74, 0x1f, 0x4b, 0xbd, 0x8b, 0x8a,
            0x70, 0x3e, 0xb5, 0x66, 0x48, 0x03, 0xf6, 0x0e,
            0x61, 0x35, 0x57, 0xb9, 0x86, 0xc1, 0x1d, 0x9e,
            0xe1, 0xf8, 0x98, 0x11, 0x69, 0xd9, 0x8e, 0x94,
            0x9b, 0x1e, 0x87, 0xe9, 0xce, 0x55, 0x28, 0xdf,
            0x8c, 0xa1, 0x89, 0x0d, 0xbf, 0xe6, 0x42, 0x68,
            0x41, 0x99, 0x2d, 0x0f, 0xb0, 0x54, 0xbb, 0x16
        ];
    
    }

    // Substitution des octets avec la S-box
    private function subBytes($state)
    {
        foreach ($state as $row => $cols) {
            foreach ($cols as $col => $value) {
                $state[$row][$col] = self::getSBox()[$value];
            }
        }
        return $state;
    }

    // ShiftRows : rotation des lignes du tableau d'état
    private function shiftRows($state)
    {
        // Décalage circulaire des lignes
        $state[1] = $this->rotateLeft($state[1], 1);
        $state[2] = $this->rotateLeft($state[2], 2);
        $state[3] = $this->rotateLeft($state[3], 3);
        return $state;
    }

    // Rotation à gauche d'une ligne
    private function rotateLeft($row, $n)
    {
        return array_merge(array_slice($row, $n), array_slice($row, 0, $n));
    }

    // MixColumns : application d'une transformation sur les colonnes
    private function mixColumns($state)
    {
        // Implémentation du mixage des colonnes
        for ($i = 0; $i < 4; $i++) {
            $col = array_column($state, $i);
            $state[0][$i] = $this->mixColumn($col[0], $col[1], $col[2], $col[3]);
        }
        return $state;
    }

    // Application de MixColumns à une colonne
    private function mixColumn($a, $b, $c, $d)
    {
        return $a ^ $b ^ $c ^ $d;
    }

    // Fonction de chiffrement AES
    public function encrypt($plaintext)
    {
        $state = $this->textToState($plaintext);
        $roundKeys = $this->keyExpansion($this->key);
        $state = $this->addRoundKey($state, $roundKeys, 0);
        
        for ($round = 1; $round < 10; $round++) 
        {
            $state = $this->subBytes($state);
            $state = $this->shiftRows($state);
            $state = $this->mixColumns($state);
            $state = $this->addRoundKey($state, $roundKeys, $round);
        }

        $state = $this->subBytes($state);
        $state = $this->shiftRows($state);
        $state = $this->addRoundKey($state, $roundKeys, 10);

        return $this->stateToText($state);
    }

    // Fonction de déchiffrement AES
    public function decrypt($ciphertext)
    {
        $state = $this->textToState($ciphertext);
        $roundKeys = $this->keyExpansion($this->key);
        $state = $this->addRoundKey($state, $roundKeys, 0);

        for ($round = 1; $round < 10; $round++) {
            $state = $this->invSubBytes($state);
            $state = $this->invShiftRows($state);
            $state = $this->invMixColumns($state);
            $state = $this->addRoundKey($state, $roundKeys, $round);
        }

        $state = $this->invSubBytes($state);
        $state = $this->invShiftRows($state);
        $state = $this->addRoundKey($state, $roundKeys, 10);

        return $this->stateToText($state);
    }


    function stringToMatrix($string)
    {
        $matrix = [];
        // $chars = unpack("C*", $str);

        // $index = 1;

        // for($col = 0; $col < 4; $col++)
        // {
        //     for($row = 0; $row < 4; $row++)
        //     {
        //         $matrix[$row][$col] = $chars[$index++];
        //     }
        // }

        for ($i=0; $i < 16; $i++) 
        { 
            $col = $i % 4;
            $row = intdiv($i, 4);
            $matrix[$row][$col] = ord($string[$i]);
        }



        return $matrix;
    }

    private function subWord(array $word)
    {
        return [
            self::getSBox()[$word[0] & 0xFF],
            self::getSBox()[$word[1] & 0xFF],
            self::getSBox()[$word[2] & 0xFF],
            self::getSBox()[$word[3] & 0xFF],
            
        ];
    }

    private function rotWord(array $word)
    {
        #on déplace chaque octet d'une position vers la gauche
        return [
            $word[1],
            $word[2],
            $word[3],
            $word[0],
        ];
    }

    private array $Rcon = [
        0x00000000,
        0x01000000,
        0x02000000,
        0x04000000,
        0x08000000,
        0x10000000,
        0x20000000,
        0x40000000,
        0x80000000,
        0x1b000000,
        0x36000000,
    ];


    private function generateRoundKey(string $key): array
    {
        #Converti la clé en tableau d'octets
        $keyBytes = array_map('ord', str_split($key));

        $roundKey = [];

        for ($i = 0; $i < 4; $i++) 
        { 
            for ($j = 0; $j < 4; $j++) 
            { 
                #colonne par colonne
                $roundKey[$j][$i] = $keyBytes[$i*4 + $j];
            }
        }

        return $roundKey;
    }

    // Expansion de la clé pour générer les sous-clés de chaque tour
    private function keyExpansion(string $key): array
    {
        $Nb = 4; // Nombre de colonnes dans l'état (AES standard = 4)
        $Nk = strlen($key) / 4; // Longueur de la clé en mots de 32 bits (4 octets par mot)
        $Nr = $Nk + 6; // Nombre de tours AES (AES-128 = 10, AES-192 = 12, AES-256 = 14)
    
        // Convertir la clé en tableau d'octets
        $keyBytes = [];
        for ($i = 0; $i < strlen($key); $i++) {
            $keyBytes[] = ord($key[$i]);
        }
    
        $w = [];
        $temp = [];
    
        // Initialisation : copier la clé d'origine dans le début de w
        for ($i = 0; $i < $Nk; $i++) {
            $w[$i] = [
                $keyBytes[4 * $i],
                $keyBytes[4 * $i + 1],
                $keyBytes[4 * $i + 2],
                $keyBytes[4 * $i + 3],
            ];
        }
    
        // Génération des clés de tour
        for ($i = $Nk; $i < $Nb * ($Nr + 1); $i++) {
            $temp = $w[$i - 1];
    
            if ($i % $Nk == 0) {
                // Effectuer la rotation des octets à gauche
                $temp = $this->subWord($this->rotWord($temp));
                
                // XOR avec le Rcon (vecteur de constante de tour)
                $temp[0] ^= $this->Rcon[intdiv($i, $Nk)];
            } elseif ($Nk > 6 && $i % $Nk == 4) {
                $temp = $this->subWord($temp);
            }
    
            // XOR avec le mot Nk positions plus tôt
            $w[$i] = [
                $w[$i - $Nk][0] ^ $temp[0],
                $w[$i - $Nk][1] ^ $temp[1],
                $w[$i - $Nk][2] ^ $temp[2],
                $w[$i - $Nk][3] ^ $temp[3],
            ];
        }
    
        // Pour être sûr que $w est sous forme de tableau 4x4
        $roundKey = [];
        foreach ($w as $key => $word) {
            $roundKey[] = $word;
        }
        // for ($col=0; $col < 4; $col++) 
        // { 
        //     for ($row=0; $row < 4; $row++) 
        //     { 
        //         $roundKey[$row][$col] = $w[$col][$row];
        //     }
        // }
    
        return $roundKey; // C'est bien un tableau de sous-tableaux
    }
    
    // Ajouter la clé de tour à l'état
    private function addRoundKey($state, $key, $round)
    {
        $key = "a1b2c3d4e5f6a7b8c9d0e1f2a3b4c5d6";
    
        if (is_string($key)) 
        {
            $roundKey = $this->keyExpansion($key);
        }
        // dump($state);
        // dd($roundKey);
        
        for ($col = 0; $col < 4; $col++) 
        {
            for ($row = 0; $row < 4; $row++) 
            {
                $index = ($round * 4) + $col;
                // dump($index);
                
                if (isset($roundKey[$row][$index])) 
                {
                    $state[$row][$col] ^= $roundKey[$row][$index];
                } 
                else 
                {
                    throw new \Exception("Clé manquante dans roundKey pour row = $row, col = $index ");
                    
                }
                
                
            }
        }
        // dd('ok');
        return $state;
    }
    
    // Convertir le texte en état 4x4
    private function textToState($text)
    {
        $state = [];
        $bytes = str_split($text, 4);
        for ($i = 0; $i < 4; $i++) {
            $state[] = array_map('ord', str_split($bytes[$i]));
        }
        return $state;
    }

    // Convertir l'état en texte
    private function stateToText($state)
    {
        $text = '';
        foreach ($state as $row) {
            foreach ($row as $value) {
                $text .= chr($value);
            }
        }
        return $text;
    }

    // SubBytes inverse pour le déchiffrement
    private function invSubBytes($state)
    {
        foreach ($state as $row => $cols) {
            foreach ($cols as $col => $value) {
                $state[$row][$col] = $this->invSbox[$value];
            }
        }
        return $state;
    }

    // ShiftRows inverse pour le déchiffrement
    private function invShiftRows($state)
    {
        // Décalage inverse des lignes
        $state[1] = $this->rotateLeft($state[1], 3);
        $state[2] = $this->rotateLeft($state[2], 2);
        $state[3] = $this->rotateLeft($state[3], 1);
        return $state;
    }

    // MixColumns inverse pour le déchiffrement
    private function invMixColumns($state)
    {
        // Cette fonction est laissée de côté, mais vous pouvez implémenter l'inverse du mixage ici
        return $state;
    }
}
