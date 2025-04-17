<?php

namespace App\Controller\Message;

use App\Service\CustomAESService;
use App\Repository\MessageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[IsGranted('ROLE_USER')]
#[Route('message')]
class LireMessageController extends AbstractController
{
    public function __construct(
        protected EntityManagerInterface $em,
        protected MessageRepository $messageRepository,
    )
    {}

    #[Route('/lire-message-rsa/{slug}/{cryptographie}', name: 'lire_message_rsa')]
    public function lireMessageRSA(Request $request, $slug, $cryptographie): Response
    {
        $maSession = $request->getSession();
        $maSession->set('ajout',null);
        $maSession->set('suppression', null);
        $maSession->set('miseAjour', null);
        
        if(!$maSession)
        {
            return $this->redirectToRoute("app_logout");
        }

        /**
         * @var User
         */
        $user = $this->getUser();

         ##les messages recus
         $messagesRecus = $this->messageRepository->findBy([
            'supprime' => 0,
            'destinataire' => $user,
        ]);

        ##les messages recus non lus
        $messagesRecusNonLus = $this->messageRepository->findBy([
            'lu' => 0,
            'destinataire' => $user,
        ]);

         ##les messages envoyés
         $messagesEnvoyes = $this->messageRepository->findBy([
            'supprime' => 0,
            'expediteur' => $user
        ]);

        ##les messages supprimes
        $messagesSupprimes = $this->messageRepository->findBy([
            'supprime' => 1,
            'expediteur' => $user
        ]);

        ##les messages importants
        $messagesImportants = $this->messageRepository->findMessageImportant($user->getId());


        $message = $this->messageRepository->findOneBy([
            'slug' => $slug ]);
       
        if ($message->getDestinataire()->getId() == $user->getId()) 
        {
            $message->setLu(1);

            $this->em->persist($message);
            $this->em->flush();
        }
        
        switch ($cryptographie) 
        {
            case 'AES':
                // Définition de la clé secrète à utiliser (tu peux la personnaliser)
                $key = "a1b2c3d4e5f6a7b8c9d0e1f2a3b4c5d6";

                // Création d'une instance du service AES avec la clé
                $aes = new CustomAESService($key);
                
                // Déchiffrement du texte
                $messageDechiffre = $aes->decrypt($message->getMessageCrypte());

                break;
            
            case 'RSA':
                function dechiffrement($encryptedText, $d, $n) 
                {
                    $encryptedBlocks = explode(' ', trim($encryptedText));
                    $decrypted = '';
                
                    foreach ($encryptedBlocks as $block) {
                        $ascii = bcpowmod($block, (string)$d, (string)$n);
                        $char = chr((int)$ascii);
                        $decrypted .= $char;
                    }
                
                    return $decrypted;
                }

                $clePrivee = $message->getExpediteur()->getCleRsaPrivee();
                    
                list($d,$n) = explode(', ',$clePrivee);

                $messageDechiffre = dechiffrement($message->getMessageCrypte(), $d, $n);
                break;
        }
        

        return $this->render('message/lireMessage.html.twig', [
            'message' => $message,
            'boiteEnvoie' => 0,
            'messagesRecus' => $messagesRecus,
            'messagesRecusNonLus' => $messagesRecusNonLus,
            'messagesEnvoyes' => $messagesEnvoyes,
            'messagesSupprimes' => $messagesSupprimes,
            'messagesImportants' => $messagesImportants,
            'messageDechiffre' => $messageDechiffre,
        ]);
    }
}
