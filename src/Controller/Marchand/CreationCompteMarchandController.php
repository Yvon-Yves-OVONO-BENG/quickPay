<?php

namespace App\Controller\Marchand;

use App\Entity\ConstantsClass;
use App\Entity\PorteMonnaie;
use App\Entity\CodeQr;
use Exception;
use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Service\QrcodeService;
use Doctrine\ORM\EntityManagerInterface;
use Endroid\QrCode\Writer\PngWriter;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Mailer\Transport\TransportInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class CreationCompteMarchandController extends AbstractController
{
    public function __construct(
        protected MailerInterface $mailer,
        protected EntityManagerInterface $em,
        protected QrcodeService $qrcodeService,
        protected TranslatorInterface $translator,
        protected CsrfTokenManagerInterface $csrfTokenManager,
    )
    {}

    #[Route('/compte-marchand', name: 'compte_marchand')]
    public function compteMarchand(Request $request, UserPasswordHasherInterface $userPasswordHasher, 
    MailerInterface $mailer, TransportInterface $transport): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        # je crée mon CSRF pour sécuriser mes formulaires
        $csrfToken = $this->csrfTokenManager->getToken('enregistrement')->getValue();

        if ($form->isSubmitted() && $form->isValid()) 
        {
            $csrfTokenFormulaire = $request->request->get('csrfToken');
            if ($this->csrfTokenManager->isTokenValid(
                new CsrfToken('enregistrement', $csrfTokenFormulaire))) 
            {
                // encode the plain password
                $user->setPassword(
                    $userPasswordHasher->hashPassword(
                        $user,
                        $form->get('password')->getData()
                    )
                );

                
                #Création du porte monnaie
                $porteMonnaie = new PorteMonnaie;
                $porteMonnaie->setSolde(0.0)
                            ->setUser($user);

                $slug = uniqid('', true);

                #Création de l'entité codeQr
                $codeQr = new CodeQr;
                $urlPaiement = 'https://quickPay.freedomsoftwarepro.com/paiement/'.$slug;

                $qrCode = $this->qrcodeService->generateQrCode($urlPaiement);
                
                $codeQr->setQrCode($qrCode);

                $user->setPorteMonnaie($porteMonnaie)
                    ->setCodeQr($codeQr)
                    ->setSlug($slug)
                    ->setRoles([ConstantsClass::ROLE_MARCHAND])
                    ;
                           
                // Envoi de l'email de confirmation
                $email = (new TemplatedEmail())
                    ->from(new Address('quickPay@freedomsoftwarepro.com', "QUICK-PAY"))
                    ->to($form->get('email')->getData())
                    ->subject("Bienvenue chez QuickPay / Welcome to QuickPay")
                    ->htmlTemplate('emails/envoieEmailMarchand.html.twig')
                    ->context([
                        'user' => $user,
                    ])
                    ;
                try 
                {
                    $transport->send($email);
                    $mailer->send($email);

                } 
                catch (TransportExceptionInterface $e)
                {
                    $this->addFlash('danger', $this->translator->trans("Error sending mail !"));
                    // return $this->redirectToRoute("compte_marchand");
                }

                $this->em->persist($user);
                $this->em->persist($porteMonnaie);
                $this->em->persist($codeQr);
                $this->em->flush();

                // Envoi de l'email de confirmation
                $email = (new TemplatedEmail())
                ->from(new Address('quickPay@freedomsoftwarepro.com', "QUICK-PAY"))
                ->to($form->get('email')->getData())
                ->subject("Bienvenue chez QuickPay / Welcome to QuickPay")
                ->htmlTemplate('emails/envoieEmailMarchand.html.twig')
                ->context([
                    'user' => $user,
                ])
                ;
            try 
            {
                $transport->send($email);
                $mailer->send($email);

            } 
            catch (TransportExceptionInterface $e)
            {
                $this->addFlash('danger', $this->translator->trans("Error sending mail !"));

                // return $this->redirectToRoute("transcript_student");
            }

                $this->addFlash('info', 'Compte créé avec succès !');
                $user = new User();
                $form = $this->createForm(RegistrationFormType::class, $user);
                return $this->redirectToRoute('compte_marchand');
            }
            else
            {
                $this->addFlash('error', 'Tentative de création de compte non autoriées !');
                return $this->redirectToRoute('accueil', ['b' => 1 ]);
            }
            
        }

        return $this->render('marchand/creationCompteMarchand.html.twig', [
            'licence' => 1,
            'motDePasse' => 0,
            'csrfToken' => $csrfToken,
            'comptemarchandForm' => $form,
        ]);
    }
}
