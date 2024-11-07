<?php

namespace App\Service;

use Fpdf\Fpdf;
use App\Entity\Kit;
use App\Entity\ElementsPiedDePage\PaginationPortrait;
use App\Entity\Produit;
use App\Service\EntetePortraitPagination;

class ImpressionKitService extends FPDF
{
    public function __construct( 
        protected EntetePortraitPagination $entetePortraitPagination,
        )
    {
    }

    /**
     * Fonction qui permet d'imprimer une kit
     * Undocumented function
     *
     * @param Produit $kit
     * @return PaginationPortrait
     */
    public function impressionKit(Produit $kit): PaginationPortrait
    {
        $pdf = new PaginationPortrait();
        $pdf->addPage('P');

        $pdf = $this->entetePortraitPagination->entetePortraitPagination($pdf);

        $pdf->SetLeftMargin(10);

        $positionY = 50;
        $pdf->SetXY(15, $positionY);

        // $pdf->Image('../public/images/qrcode/'.$kit->getQrCode(), 10, 40, 500);
        // $pdf->Image('../public/images/qrcode/'.$kit->getQrCode(), 165, 67, 34, 34);
        
        // $pdf->Ln(15);
        $pdf->SetX(15);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(100, 5, 'DETAILS DU KIT : '.$kit->getLibelle(), 0, 1, 'L', 0);

        $pdf->SetX(15);
        
        $positionY = 80;
        $pdf->Ln(5);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->SetX(15);
        
        $pdf->Cell(0, 10, utf8_decode('Eléménts du kit'), 0, 1, 'L', 0);

        $pdf->SetX(15);
        $pdf->SetFillColor(240,240,240);
        $pdf->Cell(10, 5, utf8_decode('N°'), 1, 0, 'C', true);
        $pdf->Cell(100, 5, utf8_decode('Produits'), 1, 0, 'C', true);
        $pdf->Cell(20, 5, utf8_decode('Prix'), 1, 0, 'C', true);
        $pdf->Cell(20, 5, utf8_decode('Qté'), 1, 0, 'C', true);
        $pdf->Cell(30, 5, utf8_decode('Total'), 1, 1, 'C', true);

        $i = 1;
        foreach ($kit->getProduitLigneDeKits() as $ligneDeKit) 
        {
            if ($i % 2 == 0) 
            {
                $pdf->SetFillColor(202,219,255);
            }else {
                $pdf->SetFillColor(255,255,255);
            }
            $pdf->SetX(15);
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(10, 5, utf8_decode($i), 1, 0, 'C', true);
            $pdf->Cell(100, 5, utf8_decode($ligneDeKit->getProduit()->getLibelle()), 1, 0, 'L', true);
            $pdf->Cell(20, 5, utf8_decode(number_format($ligneDeKit->getPrix(), 0, '', ' ')), 1, 0, 'C', true);
            $pdf->Cell(20, 5, utf8_decode(number_format($ligneDeKit->getQuantite(), 0, '', ' ')), 1, 0, 'C', true);
            $pdf->Cell(30, 5, utf8_decode(number_format(($ligneDeKit->getQuantite() * $ligneDeKit->getPrix()), 0, '', ' ')), 1, 1, 'C', true);

            $i++;
            
        }

        $pdf->SetX(15);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetFillColor(240,240,240);
        $pdf->Cell(150, 5, utf8_decode('PRIX TOTAL'), 0, 0, 'R');
        $pdf->Cell(30, 5, utf8_decode(number_format($kit->getPrixVente(), 0, '', ' ')." FCFA"), 1, 1, 'C', true);

        $pdf->SetX($pdf->GetX() + 15);
        $pdf->SetY($pdf->GetY() + 15);
        $pdf->SetFont('Arial', 'BU', 12);
        $pdf->Cell(142, 5, utf8_decode('LE PHARMACIEN'), 0, 0, 'R');

        return $pdf;
    }
}

