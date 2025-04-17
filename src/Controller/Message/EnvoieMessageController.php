<?php

namespace App\Controller\Message;

use App\Entity\Message;
use App\Form\MessageType;
use App\Service\CustomAESService;
use App\Repository\UserRepository;
use App\Repository\MessageRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\CryptographieRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[IsGranted('ROLE_USER')]
#[Route('message')]
class EnvoieMessageController extends AbstractController
{
    public function __construct(
        protected EntityManagerInterface $em,
        protected UserRepository $userRepository,
        protected MessageRepository $messageRepository,
        protected CsrfTokenManagerInterface $csrfTokenManager,
        protected CryptographieRepository $cryptographieRepository,
    )
    {}

    #[Route('/envoie-message', name: 'envoie_message')]
    public function envoieMessage(Request $request): Response
    {
        $maSession = $request->getSession();

        $maSession->set('ajout',null);
        $maSession->set('suppression', null);
        $maSession->set('miseAjour', null);
        
        $slug = "";

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
        ], [ 'id' => 'DESC']);

        ##les messages recus non lus
        $messagesRecusNonLus = $this->messageRepository->findBy([
            'lu' => 0,
            'destinataire' => $user,
        ], [ 'id' => 'DESC']);

         ##les messages envoyés
         $messagesEnvoyes = $this->messageRepository->findBy([
            'supprime' => 0,
            'expediteur' => $user
        ], [ 'id' => 'DESC']);

        ##les messages supprimes
        $messagesSupprimes = $this->messageRepository->findBy([
            'supprime' => 1,
            'expediteur' => $user
        ], [ 'id' => 'DESC']);

        ##les messages importants
        $messagesImportants = $this->messageRepository->findMessageImportant($user->getId());

        ############################
        $message = new Message;

        $form = $this->createForm(MessageType::class, $message);
        $form->handleRequest($request);

        # je crée mon CSRF pour sécuriser mes formulaires
        $csrfToken = $this->csrfTokenManager->getToken('envoieMessage')->getValue();
        
        if ($form->isSubmitted() && $form->isValid()) 
        {
            $csrfTokenFormulaire = $request->request->get('csrfToken');

            if ($this->csrfTokenManager->isTokenValid(
                new CsrfToken('envoieMessage', $csrfTokenFormulaire))) 
            {
                $emailDestinataire = $request->request->get('emailDestinataire');
                $cryptographie = $form->getData()->getCryptographie();
                $important = $form->getData()->isImportant();
                $messageForm = $form->getData()->getMessageCrypte();

               
                if (!$important) 
                {
                    $important = 0;
                }
                
                $destinataire = $this->userRepository->findOneBy(['email' => $emailDestinataire]);

                if (!$destinataire) 
                {
                    $this->addFlash('error', 'Adresse email invalide !');
                    $maSession->set('suppression', 1);
                    return $this->redirectToRoute('envoie_message');

                }

                $nouveauMessage = new Message();
                $nouveauMessage->setExpediteur($this->getUser())
                ->setDestinataire($destinataire)
                ->setCryptographie($cryptographie)
                ->setLu(0)
                ->setSlug(uniqid('', true))
                ->setEnvoyeLeAt(new \DateTime())
                ->setSupprime(0)
                ->setImportant($important)
                ->setSupprimerDefinitivement(0);

                if ($cryptographie->getCryptographie() === 'RSA') 
                {
                    function egcd($a, $b) {
                        if ($a == 0) return [$b, 0, 1];
                        list($g, $x, $y) = egcd($b % $a, $a);
                        return [$g, $y - intdiv($b, $a) * $x, $x];
                    }
                    
                    function modinv($a, $m) {
                        list($g, $x) = egcd($a, $m);
                        if ($g != 1) return null; // pas d'inverse modulaire
                        return ($x % $m + $m) % $m;
                    }
                    
                    function rsa_generate_keys($p, $q) {
                        $n = $p * $q;
                        $phi = ($p - 1) * ($q - 1);
                        $e = 65537; // Exposant public standard
                    
                        if (gcd($e, $phi) != 1) {
                            $e = 17; // autre petit nombre premier
                        }
                    
                        $d = modinv($e, $phi);
                        return [$e, $d, $n];
                    }
                    
                    function gcd($a, $b) {
                        return $b == 0 ? $a : gcd($b, $a % $b);
                    }

                    function chiffrement($message, $e, $n) {
                        $chars = str_split($message);
                        $encrypted = [];
                    
                        foreach ($chars as $char) 
                        {
                            $ascii = ord($char);
                            $c = bcpowmod((string)$ascii, (string)$e, (string)$n);
                            $encrypted[] = $c;
                        }
                    
                        return implode(' ', $encrypted);
                    }
                    
                    function dechiffrement($encryptedText, $d, $n) {
                        $encryptedBlocks = explode(' ', trim($encryptedText));
                        $decrypted = '';
                    
                        foreach ($encryptedBlocks as $block) {
                            $ascii = bcpowmod($block, (string)$d, (string)$n);
                            $char = chr((int)$ascii);
                            $decrypted .= $char;
                        }
                    
                        return $decrypted;
                    }

                    /**
                     * @var User
                     */
                    $user = $this->getUser();

                    $clePublique = $user->getCleRsaPublique();
                    $clePrivee = $user->getCleRsaPrivee();
                    
                    list($e,$n) = explode(', ',$clePublique);
                    list($d,$n) = explode(', ',$clePrivee);
                    
                    // $message = "OVONO BENG Yvon Yves Noel et EKOBO MFOMO ANNIE Sandrine Yolande";
                    
                    $messageChiffre = chiffrement($messageForm, $e, $n);
                    // dump( "Message chiffré : ". $messageChiffre);
                
                    $nouveauMessage->setMessageCrypte($messageChiffre);
                } 
                else 
                {
                    // Définition de la clé secrète à utiliser (tu peux la personnaliser)
                    $key = "a1b2c3d4e5f6a7b8c9d0e1f2a3b4c5d6";

                    // Création d'une instance du service AES avec la clé
                    $aes = new CustomAESService($key);

                    // Chiffrement du message
                    $messageChiffre = $aes->encrypt($messageForm);

                    $nouveauMessage->setMessageCrypte($messageChiffre);
                    
                }

                $this->em->persist($nouveauMessage);
                $this->em->flush();

                $this->addFlash('info', 'Message envoyé avec succès !');
                
                #j'affecte 1 à ma variable pour afficher le message
                $maSession->set('ajout', 1);

                $message = new Message;

                $form = $this->createForm(MessageType::class, $message);
                $form->handleRequest($request);

            } 
            else 
            {
                /**
                 * @var User
                 */
                $user = $this->getUser();
                $user->setEtat(1);

                $this->em->persist($user);
                $this->em->flush();

                return $this->redirectToRoute('accueil', ['b' => 1 ]);

            }
            
        }
       
        return $this->render('message/envoieMessage.html.twig', [
            'licence' => 1,
            'slug' => $slug,
            'boiteEnvoie' => 0,
            'csrfToken' => $csrfToken,
            'messagesRecus' => $messagesRecus,
            'messagesEnvoyes' => $messagesEnvoyes,
            'messagesSupprimes' => $messagesSupprimes,
            'envoieMessageForm' => $form->createView(),
            'messagesImportants' => $messagesImportants,
            'messagesRecusNonLus' => $messagesRecusNonLus,
        ]);
    }
}
