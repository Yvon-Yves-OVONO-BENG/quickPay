<?php

namespace App\Controller\Message;

use App\Entity\Message;
use App\Repository\UserRepository;
use App\Repository\MessageRepository;
use App\Repository\AuditLogRepository;
use App\Repository\CryptographieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
#[Route('/messages')]
class BoiteMessagesController extends AbstractController
{
    public function __construct(
        protected RouterInterface $router,
        protected EntityManagerInterface $em,
        protected UserRepository $userRepository,
        protected TranslatorInterface $translator,
        protected AuditLogRepository $auditLogRepository,
        protected MessageRepository $messageRepository,
        protected CryptographieRepository $cryptographieRepository
        
    )
    {}

    #[Route('/boite-messages/{s<[0-1]{1}>}/{m<[0-1]{1}>}/{dossier}', name: 'boite_messages')]
    public function boiteMessages(Request $request, $s = 0, $m = 0, ?string $dossier = null): Response
    {
        $collection = $this->router->getRouteCollection();
        $allRoutes = $collection->all();

        # je récupère ma session
        $maSession = $request->getSession();
        if ($s == 1) 
        {
            #mes variables témoin pour afficher les sweetAlert
            $maSession->set('ajout', null);
            $maSession->set('misAjour', null);
            $maSession->set('suppression', 1);
            
        }
        elseif ($m == 1) 
        {
            #mes variables témoin pour afficher les sweetAlert
            $maSession->set('ajout', null);
            $maSession->set('misAjour', 1);
            $maSession->set('suppression', null);
        }
        else 
        {
            #mes variables témoin pour afficher les sweetAlert
            $maSession->set('ajout', null);
            $maSession->set('misAjour', null);
            $maSession->set('suppression', null);
        }
        
        if(!$maSession)
        {
            return $this->redirectToRoute("app_logout");
        }

        #je récupère les messages de l'utilisateur connecté
        /**
         * @var User
         */
        
        $user = $this->getUser();

        $envoie = 0;
        $corbeille = 0;
        $reception = 0;
        $important = 0;

        switch ($dossier) {
            case 'envoie':
                $envoie = 1;
                ##les messages envoyés
                $messages = $this->messageRepository->findBy([
                    'supprime' => 0,
                    'expediteur' => $user
                ], [ 'id' => 'DESC']);
                break;

            case 'corbeille':
                $corbeille = 1;
                ##les messages supprimes
                $messages = $this->messageRepository->findBy([
                    'supprime' => 1,
                    'supprimePar' => $user
                ], [ 'id' => 'DESC']);
                break;

            case 'important':
                $important = 1;
                ##les messages supprimes
                $messages = $this->messageRepository->findBy([
                    'important' => 1,
                ], [ 'id' => 'DESC']);
                break;
            
            default:
                $reception = 1;
                
                ##les messages recus
                $messages = $this->messageRepository->findBy([
                    'supprime' => 0,
                    'destinataire' => $user,
                ], [ 'id' => 'DESC']);
                break;
        }

        // if ($dossier == "envoie") 
        // {
        //     $envoie = 1;
        //     ##les messages envoyés
        //     $messages = $this->messageRepository->findBy([
        //         'supprime' => 0,
        //         'expediteur' => $user
        //     ]);
        // }
        // elseif ($dossier == "corbeille") 
        // {
        //     $corbeille = 1;
        //     ##les messages supprimes
        //     $messages = $this->messageRepository->findBy([
        //         'supprime' => 1,
        //         'supprimePar' => $user
        //     ]);
        // }
        // elseif ($dossier == "important") 
        // {
        //     $important = 1;
        //     ##les messages supprimes
        //     $messages = $this->messageRepository->findBy([
        //         'important' => 1,
        //     ]);
        // }
        // else 
        // {
        //     $reception = 1;
            
        //     ##les messages recus
        //     $messages = $this->messageRepository->findBy([
        //         'supprime' => 0,
        //         'destinataire' => $user,
        //     ]);
        // }
        
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
        
        return $this->render('message/boiteMessages.html.twig', [
            'licence' => 1,
            'envoie' => $envoie,
            'reception' => $reception,
            'corbeille' => $corbeille,
            'messages' => $messages,
            'important' => $important,
            'messagesRecus' => $messagesRecus,
            'messagesEnvoyes' => $messagesEnvoyes,
            'messagesSupprimes' => $messagesSupprimes,
            'messagesImportants' => $messagesImportants,
            'messagesRecusNonLus' => $messagesRecusNonLus,
        ]);

    }
}
