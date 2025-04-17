<?php

namespace App\Controller\AES;

use App\Service\CustomAESService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
#[Route('/messages')]
class ChiffrementAesController extends AbstractController
{
    public function __construct(
        protected CustomAESService $customAESService
    )
    {}

    #[Route('/chiffrement-aes', name: 'chiffrement_aes', methods:["GET", "POST"])]
    public function encryptText()
    {

        // Définition de la clé secrète à utiliser (tu peux la personnaliser)
        $key = "a1b2c3d4e5f6a7b8c9d0e1f2a3b4c5d6";

        // Création d'une instance du service AES avec la clé
        $aes = new CustomAESService($key);

        // Texte que l’on souhaite chiffrer
        $texte = "Bonjour ovono";

        // Chiffrement du texte
        $chiffre = $aes->encrypt($texte);

        // Affichage du texte chiffré
        dump("Chiffré :". $chiffre);

        // Déchiffrement du texte
        $dechiffre = $aes->decrypt($chiffre);

        // Affichage du texte original déchiffré
        dd("Déchiffré :". $dechiffre);

        // $key = 'a1b2c3d4e5f6a7b8c9d0e1f2a3b4c5d6';
        // $plaintext = "Texte à chiffrer";

        // $aes = $this->customAESService;
        // $encryptedText = $aes->encrypt($plaintext);
        // dd($encryptedText);


        return $this->json([
            'chiffre' => $chiffre,
            'dechiffre' => $dechiffre
        ]);
    }

    #[Route('/dechiffrement-aes', name: 'dechiffrement_aes', methods:["GET", "POST"])]
    public function decryptText()
    {
        $key = '16bytessecretkey!';
        $ciphertext = "Texte chiffré ici";

        $aes = new CustomAESService($key);
        $decryptedText = $aes->decrypt($ciphertext);

        return $this->json([
            'decrypted' => $decryptedText
        ]);
    }
}