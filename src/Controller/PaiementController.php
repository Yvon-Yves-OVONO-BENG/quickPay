<?php

namespace App\Controller;

use App\Entity\ConstantsClass;
use App\Entity\Transaction;
use App\Repository\StatutTransactionRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

class PaiementController extends AbstractController
{
    public function __construct(
        protected Security $security,
        protected EntityManagerInterface $em,
        protected UserRepository $userRepository,
        protected CsrfTokenManagerInterface $csrfTokenManager,
        protected StatutTransactionRepository $statutTransactionRepository,
    )
    {}

    #[Route('/paiement/{slug}', name: 'paiement')]
    public function paiement(Request $request, $slug): Response
    {
        $form = $this->createFormBuilder()
                ->add('montant', MoneyType::class, ['label' => 'Montant'])
                ->add('code', PasswordType::class, ['label' => 'Code de sécurité'])
                // ->add('payer', SubmitType::class, ['label' => 'Payer'])
                ->getForm();

        $form->handleRequest($request);

        # je crée mon CSRF pour sécuriser mes formulaires
        $csrfToken = $this->csrfTokenManager->getToken('paiement')->getValue();

        if ($form->isSubmitted() && $form->isValid()) 
        {
            $csrfTokenFormulaire = $request->request->get('csrfToken');

            if ($this->csrfTokenManager->isTokenValid(
                new CsrfToken('envoieMessage', $csrfTokenFormulaire))) 
            {
                $destinataire = $this->userRepository->findOneBySlug(['slug' => $slug]);
                
                if (!$destinataire) 
                {
                    throw $this->createNotFoundException('Destinataire introuvable');
                }
                
                $donnees = $form->getData();
                $montant = $donnees['montant'];
                $code = $donnees['code'];

                $expediteur = $this->userRepository->findOneByCode(['code' => $code]);
                $porteMonnaieExpediteur = $expediteur->getPorteMonnaie();

                $porteMonnaieDestinataire = $this->userRepository->findOneBySlug(['slug' => $slug])->getPorteMonnaie();
                
                if ($porteMonnaieExpediteur->getSolde() < $montant) 
                {
                    $this->addFlash('error', 'Solde insuffisant / Insufficient balance');

                    return $this->redirectToRoute('paiement', ['slug' => $slug]);
                }

                #je met à jour les soldes
                $porteMonnaieExpediteur->setSolde($porteMonnaieExpediteur->getSolde() - $montant);
                $porteMonnaieDestinataire->setSolde($porteMonnaieDestinataire->getSolde() + $montant);

                #je crée une transaction
                
                $effectuee = $this->statutTransactionRepository->findOneBy(['statutTransaction' => ConstantsClass::EFFECTUEE]);
                $transaction = new Transaction;
                $transaction->setMontant($montant)
                            ->setCreatedAt(new \Datetime())
                            ->setStatutTransaction($effectuee)
                            ->setExpediteur($this->userRepository->find($expediteur->getId()))
                            ->setDestinataire($this->userRepository->finOneBySlug(['slug' => $slug]));

                $this->em->persist($transaction);
                $this->em->flush();

                $this->addFlash('success', 'Paiement effectué avec succès / Successful payment !');

                return $this->redirectToRoute('tableau_bord');
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
        
        return $this->render('paiement/paiement.html.twig', [
            'csrfToken' => $csrfToken,
            'paiementForm' => $form->createView(),
            'destinataire' => $this->userRepository->findOneBySlug(['slug' => $slug]),
        ]);
    }
}
