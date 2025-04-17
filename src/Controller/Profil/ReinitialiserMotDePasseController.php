<?php

namespace App\Controller\Profil;

use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use App\Repository\DemandeModificationMotDePasseRepository;
use App\Service\InternetConnectionCheckerService;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

class ReinitialiserMotDePasseController extends AbstractController
{
    public function __construct(
        protected EntityManagerInterface $em,
        protected UserRepository $userRepository,
        private TranslatorInterface $translator,
        private ParameterBagInterface $parametres,
        private CsrfTokenManagerInterface $csrfTokenManager,
        protected UserPasswordHasherInterface $userPasswordHasher,
        private InternetConnectionCheckerService $internetConnectionCheckerService
    )
    {}

    #[Route('/reinitialiser-mot-de-passe/{token}', name: 'reinitialiser_mot_de_passe')]
    public function reset(
        string $token,
        Request $request,
        EntityManagerInterface $em,
        UserPasswordHasherInterface $hasher,
        MailerInterface $mailer,
        DemandeModificationMotDePasseRepository $demandeModificationMotDePasseRepository,
    ): Response 
    {
        $reset = $demandeModificationMotDePasseRepository->findOneBy(['token' => $token]);

        if (!$reset || $reset->getExpiresAt() < new \DateTime()) 
        {
            $this->addFlash('danger', $this->translator->trans('Lien invalide ou expiré.'));

            return $this->redirectToRoute('mot_de_passe_oublie');
        }

        $form = $this->createFormBuilder()
            ->add('password', PasswordType::class, [
                    'label' => 'Nouveau mot de passe',
                    'attr' => [
                        'placeholder' => "Veuillez saisir un nouveau mot de passe"
                    ]
                ])
            // ->add('submit', SubmitType::class, ['label' => 'Réinitialiser'])
            ->getForm();

        $form->handleRequest($request);

        # je crée mon CSRF pour sécuriser mes formulaires
        $csrfToken = $this->csrfTokenManager->getToken('resetMotDePasse')->getValue();

        if ($form->isSubmitted() && $form->isValid()) 
        {
            $csrfTokenFormulaire = $request->request->get('csrfToken');

            if ($this->csrfTokenManager->isTokenValid(
                new CsrfToken('resetMotDePasse', $csrfTokenFormulaire))) 
            {
                    
                $user = $reset->getUser();

                $user->setPassword(
                    $hasher->hashPassword($user, $form->get('password')->getData())
                );

                $em->remove($reset);
                $em->flush();

                if (!$this->internetConnectionCheckerService->isConnected()) 
                {
                    // Ne pas envoyer le mail si pas de connexion Internet
                    $this->addFlash('error', $this->translator->trans('Email pas envoyé ! Problème de connexion'));
        
                    return $this->redirectToRoute('mot_de_passe_oublie');
                }
                else
                {
                    $mail = (new Email())
                    ->to($user->getEmail())
                    ->subject('Confirmation modification de mot de passe / Confirm password change')
                    ->html("<p>Votre mot de passe a été modifié avec succès / Your password has been successfully changed</p>");

                    $mailer->send($mail);

                    $this->addFlash('success', 'Mot de passe réinitialisé avec succès.');

                    return $this->redirectToRoute('app_login');
                }

                
            }
        }

        return $this->render('profil/reinitialiser_mot_de_passe.html.twig', [
            'motDePasse' => 0,
            'csrfToken' => $csrfToken,
            'form' => $form->createView(),
        ]);
    }

}
