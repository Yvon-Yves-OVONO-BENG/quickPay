<?php

namespace App\Service;

use Fpdf\Fpdf;
use App\Entity\ElementsPiedDePage\PaginationPaysage;
use App\Entity\AuditLog;
use DateTime;

class ImpressionAuditLogPeriodeService extends FPDF
{
    public function __construct(
        protected EntetePaysagePaginantion $entetePaysagePagination
        ){}

    /**
     * Fonction qui retourne les auditLogs d'une période
     *
     * @param array $auditLogs
     * @param DateTime $dateDebut
     * @param DateTime $dateFin
     * @return PaginationPaysage
     */
    public function impressionAuditLogPeriode(array $auditLogs, ?DateTime $dateDebut = null, ?DateTime $dateFin = null): PaginationPaysage
    {
        $pdf = new PaginationPaysage();
        $pdf->addPage('L');

        $pdf = $this->entetePaysagePagination->entetePaysagePagination($pdf);

        $pdf->SetLeftMargin(10);

        $positionY = 70;
        
        $pdf->SetXY(15, $positionY);

        // $pdf->Ln(15);
        // $pdf->SetX(10);
        $pdf->SetFont('Arial', 'B', 15);
        $pdf->Cell(0, 5, 'AUDIT DES UTILISATEURS', 0, 1, 'C', 0);

        $pdf->SetX(15);
        $pdf->SetFont('Arial', 'B', 10);

        if ($dateDebut) 
        {
            $pdf->Cell(0, 5, utf8_decode('Période allat du : ').date_format($dateDebut, 'd-m-Y').utf8_decode(' au ').date_format($dateFin, 'd-m-Y'), 0, 1, 'C', 0);
        }
        
        $pdf->Ln(10);
        $pdf->SetX(15);
        $pdf->SetFont('Arial', 'B', 12);
        
        // Entête du tableau
        $pdf = $this->enteteTableau($pdf);

        $i = 1 ;
        foreach ($auditLogs as $auditLog) 
        {
            $pdf = $this->contenuTableau($pdf, $i, $auditLog);
            $i++;
        }

        $pdf->Ln(10);
        $pdf->SetX(15);
        
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(100, 5, utf8_decode(''), 0, 0, 'C');
        $pdf->Cell(180, 5, utf8_decode("Le Responsable"), 0, 0, 'C');

        return $pdf;
    }

    /**
     * Undocumented function
     *
     * @param PaginationPaysage $pdf
     * @return PaginationPaysage
     */
    public function enteteTableau(PaginationPaysage $pdf): PaginationPaysage
    {
        $pdf->SetX(15);
        $pdf->SetFillColor(240,240,240);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(13, 7, utf8_decode('N°'), 1, 0, 'C', true);
        $pdf->Cell(70, 7, utf8_decode('Nom'), 1, 0, 'C', true);
        $pdf->Cell(70, 7, utf8_decode('Contact'), 1, 0, 'C', true);
        $pdf->Cell(50, 7, utf8_decode('Action'), 1, 0, 'C', true);
        $pdf->Cell(50, 7, utf8_decode('Date et heure'), 1, 1, 'C', true);

        return $pdf;
    }

    /**
     * Contenu du tableau
     *
     * @param PaginationPaysage $pdf
     * @param integer $i
     * @param AuditLog $auditLog
     * @return PaginationPaysage
     */
    public function contenuTableau(PaginationPaysage $pdf, int $i, AuditLog $auditLog): PaginationPaysage
    {
        if ($i % 2 == 0) 
        {
            $pdf->SetFillColor(184,204,228);
        } 
        else 
        {
            $pdf->SetFillColor(255,255,255);
        }
                
        $pdf->SetX(15);
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(13, 7, utf8_decode($i), 1, 0, 'C', true);
        $pdf->Cell(70, 7, utf8_decode($auditLog->getUser()->getUsername()), 1, 0, 'C', true);
        $pdf->Cell(70, 7, utf8_decode($auditLog->getUser()->getContact()), 1, 0, 'C', true);
        $pdf->Cell(50, 7, utf8_decode($auditLog->getActionLog()->getActionLog()), 1, 0, 'C', true);
        $pdf->Cell(50, 7, utf8_decode(date_format($auditLog->getDateActionAt(), 'd/m/Y')." - ".date_format($auditLog->getDateActionAt(), 'H:i:s')), 1, 1, 'C', true);

        return $pdf;
    }

  
}

