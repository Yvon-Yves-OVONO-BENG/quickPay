<?php

namespace App\Controller\Impression;

use App\Repository\AuditLogRepository;
use App\Service\ImpressionAuditLogPeriodeService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

/**
 * @IsGranted("ROLE_USER", message="Accès refusé. Espace reservé uniquement aux abonnés")
 */
#[Route('/impression')]
class ImpressionAuditLogPeriodeController extends AbstractController
{
    public function __construct(
        protected AuditLogRepository $auditLogRepository,
        protected ImpressionAuditLogPeriodeService $impressionAuditLogPeriodeService
    )
    {}

    #[Route('/impression-audit-log-periode', name: 'impression_audit_log_periode')]
    public function impressionAuditLogPeriode(Request $request): Response
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

        if ($request->request->has('impressionAuditLogPeriode')) 
        {
            // $dateDebut = DateTime::createFromFormat('Y-m-d',$request->request->get('dateDebut'));
            $dateDebut = date_create($request->request->get('dateDebut'));
            $dateFin = date_create($request->request->get('dateFin'));

            $auditLogs = $this->auditLogRepository->getAuditLogPeriode($dateDebut, $dateFin);
            // dd($auditLogs);
            $pdf = $this->impressionAuditLogPeriodeService->impressionAuditLogPeriode($auditLogs, $dateDebut, $dateFin);

            return new Response($pdf->Output(utf8_decode("Audit Log du ".date_format($dateDebut, "d-m-Y")." au ".date_format($dateFin, "d-m-Y")) , "I"), 200, ['content-type' => 'application/pdf']);
        
        }
        else 
        {
            $auditLogs = $this->auditLogRepository->getAuditLog();

            $pdf = $this->impressionAuditLogPeriodeService->impressionAuditLogPeriode($auditLogs);

            return new Response($pdf->Output(utf8_decode("Tous les Audits Logs") , "I"), 200, ['content-type' => 'application/pdf']);
        
        }
        
        
        return $this->redirectToRoute('liste_auditLog');
    }
}
