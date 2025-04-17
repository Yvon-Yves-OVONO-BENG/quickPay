<?php

namespace App\Service;

class CustomAESService
{
    // Attributs pour stocker la clé AES et le nom de l'algorithme
    private string $key;
    private string $cipher;

    // Constructeur : on initialise la clé et l’algorithme de chiffrement
    public function __construct(string $key)
    {
        // je récupère la clé dans ma variable d'environnement
        $key = $_ENV['APP_AES_KEY'];
        
        $this->key = $key;
        // $this->key = substr(hash('sha256', $key, true), 0, 16);

        // On définit l’algorithme de chiffrement : AES en mode CBC avec une clé de 256 bits
        $this->cipher = 'aes-256-cbc';
    }

    // Méthode de chiffrement
    public function encrypt(string $plaintext): string
    {
        // Génère un IV (vecteur d'initialisation) aléatoire de la bonne taille
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($this->cipher));

        // Chiffre le texte brut en binaire brut (OPENSSL_RAW_DATA) avec la clé et l'IV
        $ciphertext = openssl_encrypt($plaintext, $this->cipher, $this->key, OPENSSL_RAW_DATA, $iv);

        // On retourne l’IV concaténé avec le ciphertext, le tout encodé en base64 pour stockage/transfert
        return base64_encode($iv . $ciphertext);
    }

    // Méthode de déchiffrement
    public function decrypt(string $encoded): string
    {
        // Décode la chaîne base64 pour récupérer l'IV et le ciphertext
        $data = base64_decode($encoded);

        // Récupère la longueur de l’IV pour cet algorithme
        $ivLength = openssl_cipher_iv_length($this->cipher);

        // Extrait l’IV depuis le début des données
        $iv = substr($data, 0, $ivLength);

        // Extrait le ciphertext (le reste après l’IV)
        $ciphertext = substr($data, $ivLength);


        // Déchiffre le texte chiffré en texte clair
        return openssl_decrypt($ciphertext, $this->cipher, $this->key, OPENSSL_RAW_DATA, $iv);
    }

}