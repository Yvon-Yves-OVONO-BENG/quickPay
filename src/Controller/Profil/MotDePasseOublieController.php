<?php

namespace App\Controller\Profil;

use App\Entity\DemandeModificationMotDePasse;
use App\Form\DemandeModificationMotDePasseType;
use App\Repository\UserRepository;
use App\Service\InternetConnectionCheckerService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class MotDePasseOublieController extends AbstractController
{
    #[Route('/mot-de-passe-oublie', name: 'mot_de_passe_oublie')]
    public function request(
        Request $request,
        UserRepository $userRepo,
        EntityManagerInterface $em,
        MailerInterface $mailer,
        TranslatorInterface $translator,
        CsrfTokenManagerInterface $csrfTokenManager,
        InternetConnectionCheckerService $internetConnectionCheckerService
    ): Response 
    {
        $form = $this->createForm(DemandeModificationMotDePasseType::class);
        $form->handleRequest($request);

        # je crée mon CSRF pour sécuriser mes formulaires
        $csrfToken = $csrfTokenManager->getToken('motDePasseOublie')->getValue();

        if ($form->isSubmitted() && $form->isValid()) 
        {
            $csrfTokenFormulaire = $request->request->get('csrfToken');

            if ($csrfTokenManager->isTokenValid(
                new CsrfToken('motDePasseOublie', $csrfTokenFormulaire))) 
            {
                $email = $form->get('email')->getData();
                $user = $userRepo->findOneBy(['email' => $email]);

                if ($user) 
                {
                    $token = bin2hex(random_bytes(32));
                    $expiresAt = new \DateTime('+1 hour');

                    $resetRequest = new DemandeModificationMotDePasse($user, $token, $expiresAt);

                    $em->persist($resetRequest);
                    $em->flush();

                    $resetUrl = $this->generateUrl('reinitialiser_mot_de_passe', ['token' => $token], true);

                    if (!$internetConnectionCheckerService->isConnected()) 
                    {
                        // Ne pas envoyer le mail si pas de connexion Internet
                        $this->addFlash('error', $translator->trans('Email pas envoyé ! Problème de connexion'));
            
                        return $this->redirectToRoute('mot_de_passe_oublie');
                    }
                    else
                    {
                        $mail = (new Email())
                        ->to($user->getEmail())
                        ->subject('Réinitialisation de mot de passe / Reset password')
                        ->html("<p>Cliquez sur ce lien pour réinitialiser votre mot de passe / Click on this link to reset your password: <a href=\"$resetUrl\">Réinitialiser / Reset</a></p>");

                        $mailer->send($mail);

                        $this->addFlash('info', $translator('Un mail de réinitialisation vous a été envoyé.'));
                        return $this->redirectToRoute('app_login');

                    }
                    
                }  
            }
            else
            {
                $this->addFlash('info', "Echec d'envoie du mail");
                return $this->redirectToRoute('mot_de_passe_oublie');
            }
        }

        return $this->render('profil/motDePasseOublie.html.twig', [
            'motDePasse' => 0,
            'csrfToken' => $csrfToken,
            'form' => $form->createView()
        ]);
    }

}
