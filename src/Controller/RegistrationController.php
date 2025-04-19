<?php

namespace App\Controller;

use App\Entity\ConstantsClass;
use App\Entity\PorteMonnaie;
use App\Entity\CodeQr;
use Exception;
use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Repository\PaysRepository;
use App\Service\LocalisationService;
use App\Service\NumeroCompteService;
use App\Service\QrcodeService;
use Doctrine\ORM\EntityManagerInterface;
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

class RegistrationController extends AbstractController
{
    public function __construct(
        private MailerInterface $mailer,
        private EntityManagerInterface $em,
        private QrcodeService $qrcodeService,
        private PaysRepository $paysRepository,
        private TranslatorInterface $translator,
        private NumeroCompteService $numeroCompteService,
        private LocalisationService $localisationService,
        private CsrfTokenManagerInterface $csrfTokenManager,
    )
    {}

    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, 
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

                #UTILISATION DE L'ALGORITHME BRUTE
                /**
                 * Fonction qui calcul le pgcd de deux nombres
                 *
                 * @param [type] $a
                 * @param [type] $b
                 * @return void
                 */
                function pgcd($a, $b) {
                    return $b == 0 ? $a : pgcd($b, $a % $b);
                }
                
                /**
                 * Fonction qui calcul le modulp inverse
                 *
                 * @param [type] $a
                 * @param [type] $m
                 * @return void
                 */
                function modInverse($a, $m) {
                    for ($x = 1; $x < $m; $x++) {
                        if (($a * $x) % $m == 1) return $x;
                    }
                    return null;
                }
                
                /**
                 * fonction qui vérifie si un nombre est premier
                 *
                 * @param [type] $nombre
                 * @return void
                 */
                function estPremier($nombre)
                {
                    if($nombre < 2) return false;
                    for($i = 2; $i <= sqrt($nombre); $i++)
                    {
                        if ($nombre % $i === 0 ) return false;
                    }
                    return true;
                }

                /**
                 * fonction qui renvoie un nombre premier aleatoire entre 100 et 200
                 *
                 * @param integer $min
                 * @param integer $max
                 * @return void
                 */
                function nombrePremierAleatoire($min = 100, $max = 200)
                {
                    do {
                        $nombre = rand($min, $max);
                    }
                    while (!estPremier($nombre));

                    return $nombre;
                }

                $p = 0;
                $q = 0;

                /**
                 * Boucle qui génère p et q
                 */
                do {
                    $p = nombrePremierAleatoire();
                    $q = nombrePremierAleatoire();
                }
                while ($p === $q);

                $n = $p * $q; 
                $phi = ($p - 1) * ($q - 1); 
                
                $e = 0;

                /**
                 * function qui permet de trouver e
                 *
                 * @param [type] $phi
                 * @return void
                 */
                function choisirE($phi)
                {
                    do {
                        //e doît être entre 2 et phi-1
                        $e = rand(2, $phi - 1);
                    }
                    while(pgcd($e, $phi) !== 1);
                    return $e;
                }

                $e = choisirE($phi);

                if (pgcd($e, $phi) !== 1) 
                {
                    throw new Exception("e n'est pas premier avec phi");
                }
                
                $d = modInverse($e, $phi); 
                
                // echo "Clé publique : ($e, $n)\n";
                // echo "Clé privée : ($d, $n)\n";

                $publicKey = "$e, $n";
                $privateKey = "$d, $n";

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

                // $ip = $request->getClientIp(); // Symfony détecte automatiquement l'IP
                // if ($ip === '127.0.0.1' || $ip === '::1') 
                // {
                //     $ip = '154.72.40.10';
                // }

                
                // $codePays = $this->localisationService->detecterPaysParIp($ip);

                // // Recherche le Pays correspondant
                // $pays = $this->paysRepository->findOneBy(['code' => $codePays]);

                // $user->setPays($pays);

                $numeroCompte = $this->numeroCompteService->genererNumeroUnique();
                
                // $porteMonnaie->setNumeroCompte($pays->getAlpha3().$numeroCompte);
                $porteMonnaie->setNumeroCompte($numeroCompte);
                
                $user->setCleRsaPrivee($privateKey)
                    ->setCleRsaPublique($publicKey)
                    ->setPorteMonnaie($porteMonnaie)
                    ->setCodeQr($codeQr)
                    ->setSlug($slug)
                    ->setRoles([ConstantsClass::ROLE_UTILISATEUR])
                    ;

                // Envoi de l'email de confirmation
                // $email = (new TemplatedEmail())
                //     ->from(new Address('quickPay@freedomsoftwarepro.com', "QUICK-PAY"))
                //     ->to($form->get('email')->getData())
                //     ->subject("Bienvenue chez QuickPay / Welcome to QuickPay")
                //     ->htmlTemplate('emails/envoieEmail.html.twig')
                //     ->context([
                //         'user' => $user,
                //     ])
                //     ;
                // try 
                // {
                //     $transport->send($email);
                //     $mailer->send($email);

                // } 
                // catch (TransportExceptionInterface $e)
                // {
                //     $this->addFlash('danger', $this->translator->trans("Error sending mail !"));

                //     return $this->redirectToRoute("app_login");
                // }

                $this->em->persist($user);
                $this->em->persist($porteMonnaie);
                $this->em->persist($codeQr);
                $this->em->flush();

                // Envoi de l'email de confirmation
                $email = (new TemplatedEmail())
                ->from(new Address('quickPay@freedomsoftwarepro.com', "QUICK-PAY"))
                ->to($form->get('email')->getData())
                ->subject("Bienvenue chez QuickPay / Welcome to QuickPay")
                ->htmlTemplate('emails/envoieEmail.html.twig')
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

                    return $this->redirectToRoute("app_login");
                }

                $this->addFlash('info', 'Compte créé avec succès !');

                return $this->redirectToRoute('app_login');
            }
            else
            {
                $this->addFlash('error', 'Tentative de création de compte non autoriées !');
                return $this->redirectToRoute('accueil', ['b' => 1 ]);
            }
            
        }

        return $this->render('registration/register.html.twig', [
            'licence' => 1,
            'motDePasse' => 0,
            'csrfToken' => $csrfToken,
            'registrationForm' => $form,
        ]);
    }
}
