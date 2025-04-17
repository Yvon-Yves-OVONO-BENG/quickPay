<?php

namespace App\Controller\Utilisateur;

use App\Entity\ConstantsClass;
use App\Entity\Profil;
use App\Entity\User;
use App\Form\AjoutUtilisateurType;
use App\Repository\UserRepository;
use App\Service\StrService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * @IsGranted("ROLE_USER", message="Accès refusé. Espace reservé uniquement aux abonnés")
 *
 */
#[Route('utilisateur')]
class AjouterUtilisateurController extends AbstractController
{
    public function __construct(
        protected StrService $strService,
        protected EntityManagerInterface $em,
        protected UserRepository $userRepository,
        protected TranslatorInterface $translator,
        protected CsrfTokenManagerInterface $csrfTokenManager,
    )
    {}
    
    #[Route('/ajout-utilisateur', name: 'ajouter_utilisateur')]
    public function ajoutUtilisateur(Request $request, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        # je récupère ma session
        $maSession = $request->getSession();

        if(!$maSession)
        {
            return $this->redirectToRoute("app_logout");
        }
        
        #mes variables témoin pour afficher les sweetAlert
        $maSession->set('ajout',null);
        $maSession->set('suppression', null);
        $maSession->set('miseAjour', null);

        $slug = 0;

        #je déclare une nouvelle instace d'un utilisateur
        $utilisateur = new User;

        $profil = new Profil;

        #je crée mon formulaire et je le lie à mon instance
        $form = $this->createForm(AjoutUtilisateurType::class, $utilisateur);

        #je demande à mon formulaire de récupérer les donnéesqui sont dans le POST avec la $request
        $form->handleRequest($request);
        
        # je crée mon CSRF pour sécuriser mes formulaires
        $csrfToken = $this->csrfTokenManager->getToken('envoieFormulaireUtilisateur')->getValue();

        #je teste si mon formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) 
        {
            $csrfTokenFormulaire = $request->request->get('csrfToken');

            if ($this->csrfTokenManager->isTokenValid(
                new CsrfToken('envoieFormulaireGarde', $csrfTokenFormulaire))) 
            {
                //////j'extrait le dernier utilisateur de la table
                $derniereUtilisateur = $this->userRepository->findBy([],['id' => 'DESC'],1,0);

                /////je récupère l'id du sernier utilisateur
                $id = $derniereUtilisateur[0]->getId();

                #je met le nom de l'utilisateur en CAPITAL LETTER
                $utilisateur->setNom($this->strService->strToUpper($utilisateur->getNom()))
                        ->setSlug(uniqid('', true))
                        ->setEtat(1)
                        ->setPhoto(ConstantsClass::NOM_PHOTO)
                ;

                #je hash le mot de passe
                $utilisateur->setPassword(
                    $userPasswordHasher->hashPassword(
                        $utilisateur,
                        $form->getData()->getPassword()
                    )
                );

                $profil->setNom($this->strService->strToUpper($utilisateur->getNom()))
                        ->setContact($utilisateur->getContact())
                        ->setAdresse($utilisateur->getAdresse())
                        ->setEmail($utilisateur->getEmail())
                        ->setUsername($utilisateur->getUsername())
                        ->setUser($utilisateur)
                        ->setGenre($utilisateur->getGenre())
                ;

                # je récupère le type utlisateur
                $typeUtilisateur = $form->getData()->getTypeUtilisateur()->getTypeUtilisateur();

                #selon le type utilisateur je set le rôle
                switch ($typeUtilisateur) 
                {
                    case ConstantsClass::ADMINISTRATEUR:
                        $utilisateur->setRoles([ConstantsClass::ROLE_ADMINISTRATEUR]);
                        break;

                    case ConstantsClass::GARDE:
                        $utilisateur->setRoles([ConstantsClass::ROLE_GARDE]);
                        break;
                }

                # je prépare ma requête avec entityManager
                $this->em->persist($utilisateur);
                $this->em->persist($profil);

                #j'exécute ma requête
                $this->em->flush();

                #j'affiche le message de confirmation d'ajout
                $this->addFlash('info', $this->translator->trans('Utilisateur ajoutée avec succès !'));

                #j'affecte 1 à ma variable pour afficher le message
                $maSession->set('ajout', 1);
                
                #je déclare une nouvelle instace d'une utilisateur
                $utilisateur = new User;

                #je crée mon formulaire et je le lie à mon instance
                $form = $this->createForm(AjoutUtilisateurType::class, $utilisateur);
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

        #je rénitialise mon slug
        $slug = 0;

        return $this->render('utilisateur/ajouterUtilisateur.html.twig', [
            'licence' => 1,
            'slug' => $slug,
            'csrfToken' => $csrfToken,
            'formUtilisateur' => $form->createView(),
        ]);
    }
}
