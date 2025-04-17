<?php

namespace App\Controller\Message;

use App\Repository\MessageRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
#[Route('/messages')]
class SupprimerMessageController extends AbstractController
{
    public function __construct(
        protected EntityManagerInterface $em,
        protected MessageRepository $messageRepository,
    )
    {}

    #[Route('/supprimer-message/{slug}', name: 'supprimer_message')]
    public function supprimerMessage(Request $request, $slug): Response
    {
        // $collection = $this->router->getRouteCollection();
        // $allRoutes = $collection->all();

        # je récupère ma session
        $maSession = $request->getSession();
        $maSession->set('ajout',null);
        $maSession->set('suppression', null);
        $maSession->set('miseAjour', null);
        
        if(!$maSession)
        {
            return $this->redirectToRoute("app_logout");
        }

        #je récupère le message à supprimer
        $message = $this->messageRepository->findOneBy(['slug' => $slug]);

        if ($message->isSupprime() == 0) 
        {
            $message->setSupprime(1)
            ->setSupprimePar($this->getUser())
            ->setSupprimeLeAt(new DateTime('now'))
            ;

            $this->em->persist($message);
            $this->em->flush(); 

            $this->addFlash('info', 'Message supprimé avec succès !');
            
            #j'affecte 1 à ma variable pour afficher le message
            $maSession->set('suppression', 1);

            return $this->redirectToRoute('boite_messages', ['s' => 1]);
        } 
        else 
        {
            $message->setSupprime(0)
            ->setSupprimePar($this->getUser())
            ->setSupprimeLeAt(new DateTime('now'))
            ;

            $this->em->persist($message);
            $this->em->flush(); 

            $this->addFlash('info', 'Message restauré avec succès !');
            
            #j'affecte 1 à ma variable pour afficher le message
            $maSession->set('suppression', 1);

            return $this->redirectToRoute('boite_messages', ['m' => 1]);
        }
        
        
    }
}
