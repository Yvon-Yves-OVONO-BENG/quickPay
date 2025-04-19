<?php

namespace App\Controller;

use App\Repository\PorteMonnaieRepository;
use App\Repository\TransactionRepository;
use App\Service\UtilisateurService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[IsGranted('ROLE_USER')]
class TableauDeBordController extends AbstractController
{
    public function __construct(
        private RouterInterface $router,
        private UtilisateurService $utilisateurService,
        private TransactionRepository $transactionRepository,
        private PorteMonnaieRepository $porteMonnaieRepository,
    )
    {}

    #[Route('/tableau-de-bord', name: 'tableau_de_bord')]
    public function tableauDeBord(Request $request): Response
    {
        #je recupère la session
        $maSession = $request->getSession();

        #je collectionne toutes les routes de mon application
        $collection = $this->router->getRouteCollection();
        $allRoutes = $collection->all();

        #j'initialise mes variable session
        $maSession->set('ajout',null);
        $maSession->set('suppression', null);
        $maSession->set('miseAjour', null);

        #je récupère le solde de l'utilisateur connecté
        $porteMonnaie = $this->porteMonnaieRepository->findOneByUser([
            'user' => $this->getUser()
        ]);

        #je récupère les statistiques
        /**
         * @var User
         */
        $user = $this->getUser();
        $statistiques = $this->utilisateurService->getStatistiquesParUtilisateur($user->getId());
        
        #Toutes les transactions
        $toutesLesTransactions = $this->utilisateurService->findTransactionParUtilisateur($user->getId());

        #les transactions recus
        $transactionsRecus = $this->utilisateurService->transactionsRecus($user->getId());

        #les transactions envoyés
        $transactionsEnvoyes = $this->utilisateurService->transactionsEnvoyes($user->getId());

        ////Début: je vérifie si le profil est complété///////
        $temoin = false;
        if ($user) {
            if ($user->getContact() == null or $user->getNumCni() == null or $user->getCode() == null or $user->getAdresse() == null) {
                $temoin = true;
            }        
        }
        ////Fin: je vérifie si le profil est complété///////
        
        return $this->render('tableauDeBord/tableauDeBord.html.twig', [
            'statistiques' => $statistiques,
            'porteMonnaie' => $porteMonnaie,
            'transactionsRecus' => $transactionsRecus,
            'transactionsEnvoyes' => $transactionsEnvoyes,
            'toutesLesTransactions' => $toutesLesTransactions,
            'temoin' => $temoin,
        ]);
        

    }
}
