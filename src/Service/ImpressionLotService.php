<?php

namespace App\Service;

use Fpdf\Fpdf;
use App\Entity\ElementsPiedDePage\PaginationPortrait;
use App\Service\EntetePortraitPagination;
use DateTime;

class ImpressionLotService extends FPDF
{
    public function __construct( 
        protected EntetePortraitPagination $entetePortraitPagination,
        )
    {
    }

    /**
     * Fonction qui permet d'imprimer les lots
     *
     * @param array $lots
     * @return PaginationPortrait
     */
    public function impressionLot(array $lots, DateTime $dateDebut = null, DateTime $dateFin = null, int $periode = null): PaginationPortrait
    {
        $pdf = new PaginationPortrait();
        $pdf->addPage('P');

        $pdf = $this->entetePortraitPagination->entetePortraitPagination($pdf);

        $pdf->SetLeftMargin(10);

        $positionY = 50;
        $pdf->SetXY(15, $positionY);

        // $pdf->Image('../public/images/qrcode/'.$lot->getQrCode(), 10, 40, 500);
        // $pdf->Image('../public/images/qrcode/'.$lot->getQrCode(), 165, 67, 34, 34);
        
        $pdf->Ln(15);
        $pdf->SetX(15);
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(0, 5, 'LISTE DES LOTS ', 0, 1, 'C', 0);
        
        if ($periode == 1) 
        {   
            $pdf->SetX(15);
            $pdf->SetFont('Arial', 'B', 10);
            $pdf->Cell(0, 5, utf8_decode('Période du ').date_format($dateDebut, "d-m-Y")." au ".date_format($dateFin, "d-m-Y"), 0, 1, 'C', 0);
        }

        $positionY = 80;
        $pdf->Ln(5);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->SetX(15);
        
        $pdf->Cell(0, 10, utf8_decode('Informations des lots'), 0, 1, 'L', 0);

        $pdf->SetX(15);
        $pdf->SetFillColor(240,240,240);
        $pdf->Cell(10, 5, utf8_decode('N°'), 1, 0, 'C', true);
        $pdf->Cell(75, 5, utf8_decode('Lots'), 1, 0, 'C', true);
        $pdf->Cell(30, 5, utf8_decode('Enregistré le'), 1, 0, 'C', true);
        $pdf->Cell(15, 5, utf8_decode('Qté'), 1, 0, 'C', true);
        $pdf->Cell(15, 5, utf8_decode('Vendu'), 1, 0, 'C', true);
        // $pdf->Cell(10, 5, utf8_decode('Coef'), 1, 0, 'C', true);
        $pdf->Cell(15, 5, utf8_decode('Reste'), 1, 0, 'C', true);
        $pdf->Cell(20, 5, utf8_decode('Date Exp'), 1, 1, 'C', true);

        $i = 1;
        
        foreach ($lots as $lot) 
        {
            if ($i % 2 == 0) 
            {
                $pdf->SetFillColor(202,219,255);
            }else {
                $pdf->SetFillColor(255,255,255);
            }

            $pdf->SetX(15);
            $pdf->SetFont('Arial', '', 7);
            $pdf->Cell(10, 5, utf8_decode($i), 1, 0, 'C', true);
            $pdf->Cell(75, 5, utf8_decode($lot->getReference() ? $lot->getReference():""), 1, 0, 'L', true);
            $pdf->Cell(15, 5, utf8_decode($lot->getEnregistreleAt() ? date_format($lot->getEnregistreleAt(), 'd-m-Y') :""), "LTB", 0, 'C', true);
            $pdf->Cell(15, 5, utf8_decode($lot->getHeureAt() ? date_format($lot->getHeureAt(), 'H:i:s'): ""), "RTB", 0, 'C', true);
            $pdf->Cell(15, 5, utf8_decode(number_format($lot->getQuantite(), 0, '', ' ') ? number_format($lot->getQuantite(), 0, '', ' '):""), 1, 0, 'C', true);
            $pdf->Cell(15, 5, utf8_decode(number_format($lot->getVendu(), 0, '', ' ') ? number_format($lot->getVendu(), 0, '', ' ') : ""), 1, 0, 'C', true);
            $pdf->Cell(15, 5, utf8_decode(number_format(($lot->getQuantite() - $lot->getVendu()), 0, '', ' ')), 1, 0, 'C', true);
            // $pdf->Cell(15, 5, utf8_decode($lot->getPrixAchat() * $lot->getCoef()), 1, 0, 'C', true);
            $pdf->Cell(20, 5, utf8_decode($lot->getDatePeremptionAt() ? date_format($lot->getDatePeremptionAt(), 'd-m-Y'):""), 1, 1, 'C', true);

            $i++;
            
        }

        
        $pdf->SetFillColor(240,240,240);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(135, 5, utf8_decode('TOTAL '), 0, 0, 'R');
        $pdf->Cell(50, 5, utf8_decode(count($lots)." lots"), 1, 1, 'C', true);

        $pdf->SetX($pdf->GetX() + 15);
        $pdf->SetY($pdf->GetY() + 15);
        $pdf->SetFont('Arial', 'BU', 12);
        $pdf->Cell(85, 5, utf8_decode('LA SECRETAIRE'), 0, 0, 'C');
        $pdf->Cell(110, 5, utf8_decode('LA DIRECTEUR'), 0, 1, 'C');

        
        // $pdf->SetFont('Arial', 'B', 10);
        // $pdf->Cell(85, 5, utf8_decode($lot->getEnregistrePar()->getNom() ), 0, 1, 'C');

        return $pdf;
    }
}

