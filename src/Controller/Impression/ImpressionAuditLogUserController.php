<?php

namespace App\Controller\Impression;

use App\Repository\AuditLogRepository;
use App\Repository\UserRepository;
use App\Service\ImpressionAuditLogUserService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

/**
 * @IsGranted("ROLE_USER", message="Accès refusé. Espace reservé uniquement aux abonnés")
 */
#[Route('/impression')]
class ImpressionAuditLogUserController extends AbstractController
{
    public function __construct(
        protected UserRepository $userRepository,
        protected AuditLogRepository $auditLogRepository,
        protected ImpressionAuditLogUserService $impressionAuditLogUserService
    )
    {}

    #[Route('/impression-audit-log-user/{slug}', name: 'impression_audit_log_user')]
    public function impressionAuditLogUser(Request $request, string $slug = ""): Response
    {
        # je récupère ma session
        $maSession = $request->getSession();

        if(!$maSession)
        {
            return $this->redirectToRoute("app_logout");
        }

        #je supprime mes variables de la session
        $maSession->set('ajout', null) ;
        $maSession->set('misAjour', null);
        $maSession->set('suppression', null) ;

        if ($request->request->has('impressionAuditLogUser')) 
        {
            $dateDebut = date_create($request->request->get('dateDebut'));
            $dateFin = date_create($request->request->get('dateFin'));
            $user = $this->userRepository->find($request->request->get('user'));
            
            $auditLogs = $this->auditLogRepository->getAuditUserPeriode($user->getId(), $dateDebut, $dateFin);
    
            if (!$auditLogs) 
            {
                $this->addFlash('info', "Cet utilisateur n'a pas d'élément(s) d'audit !");

                $maSession->set('suppression', 1);

                return $this->redirectToRoute('audit_log', ['s' => 1,]);
            }
            else 
            {

                $auditLogs = $this->auditLogRepository->getAuditUserPeriode($user->getId(), $dateDebut, $dateFin);
    
                $pdf = $this->impressionAuditLogUserService->impressionAuditLogUser($user, $auditLogs, $dateDebut, $dateFin);
            
                
            }
        }
        else
        {
            $user = $this->userRepository->findOneBySlug(['slug' => $slug]);

            $auditLogs = $this->auditLogRepository->findBy(['user' => $user ]);

            $pdf = $this->impressionAuditLogUserService->impressionAuditLogUser($user, $auditLogs);
        }
        
        return new Response($pdf->Output(utf8_decode("Audit de ".$user->getGrade()->getGrade()." ".$user->getNom()) , "I"), 200, ['content-type' => 'application/pdf']);
    }
}
