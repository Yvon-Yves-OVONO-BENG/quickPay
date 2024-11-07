<?php

namespace App\Service;

use Fpdf\Fpdf;
use App\Service\EntetePortrait;
use App\Entity\ElementsPiedDePage\Pagination;
use App\Entity\ElementsPiedDePage\PaginationPaysage;
use DateTime;

class ImpressionProduitsPerimesService extends FPDF
{
    public function __construct(
        protected EntetePaysagePaginantion $entetePaysagePaginantion,
        )
    {}

    /**
     * Fonction qui retourne les produits périmés
     *
     * @param array $produits
     * @return Pagination
     */
    public function impressionProduitsPerimes(array $produitsPerimes, int $bientot): PaginationPaysage
    {
        $pdf = new PaginationPaysage();
        $pdf->addPage('L');

        $pdf = $this->entetePaysagePaginantion->entetePaysagePagination($pdf);

        $pdf->SetLeftMargin(10);

        $positionY = 50;
        $pdf->Ln(15);
        $pdf->SetXY(15, $positionY);

        // $pdf->Image('../public/images/qrcode/'.$facture->getQrCode(), 10, 40, 500);
        // $pdf->Image('../public/images/qrcode/'.$facture->getQrCode(), 165, 67, 34, 34);
        
        $pdf->SetFont('Arial', 'B', 12);

        if ($bientot) 
        {
            $pdf->Ln(15);
            $pdf->SetX(15);
            $pdf->Cell(0, 5, 'PRODUITS PERIMES DANS MOINS DE 90 JOURS', 0, 1, 'C', 0);
        } 
        else 
        {
            $pdf->Ln(15);
            $pdf->SetX(15);
            $pdf->Cell(0, 5, 'PRODUITS PERIMES', 0, 1, 'C', 0);
        }
        
        $pdf->SetX(15);
        $pdf->SetFont('Arial', 'B', 8);

        if ($produitsPerimes) 
        {
            $pdf->Cell(0, 5, 'Date : '.date_format(new DateTime('now'), 'd-m-Y H:i:s'), 0, 1, 'C', 0);

            $pdf->Ln(10);
            $pdf->SetX(15);
            $pdf->SetFont('Arial', 'B', 12);


            // Entête du tableau
            $pdf = $this->enteteTableau($pdf);

            $pdf->SetFont('Arial', '', 8);
            $i = 1 ;
            foreach ($produitsPerimes as $produit) 
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
                $pdf->Cell(10, 5, utf8_decode($i), 1, 0, 'C', true);
                $pdf->Cell(80, 5, utf8_decode($produit->getLot()->getReference()), 1, 0, 'L', true);
                $pdf->Cell(80, 5, utf8_decode($produit->getLibelle()), 1, 0, 'L', true);
                $pdf->Cell(40, 5, utf8_decode($produit->getLot()->getEnregistreLeAt() ? date_format($produit->getLot()->getEnregistreLeAt(), 'd-m-Y H:i:s'): ""), 1, 0, 'C', true);
                $pdf->Cell(40, 5, utf8_decode($produit->getLot()->getDatePeremptionAt() ? date_format($produit->getLot()->getDatePeremptionAt(), 'd-m-Y'): ""), 1, 0, 'C', true);
                $pdf->Cell(20, 5, utf8_decode(number_format($produit->getLot()->getQuantite(), 0, '', ' ')), 1, 1, 'C', true);
                $i++;
            }
        }
        else
        {
            $pdf->Ln(15);
            $pdf->SetX(15);
            $pdf->Cell(0, 5, 'PAS DE PRODUITS PERIMES', 0, 1, 'C', 0);
        }
        
        $pdf->Ln(10);
        $pdf->SetX(15);
        
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(120, 5, utf8_decode('Le/La Responsable'), 0, 0, 'C');
        $pdf->Cell(180, 5, utf8_decode("L'Administration"), 0, 0, 'C');

        return $pdf;
    }

    public function enteteTableau(PaginationPaysage $pdf): PaginationPaysage
    {
        $pdf->SetX(15);
        $pdf->SetFillColor(240,240,240);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(10, 5, utf8_decode('N°'), 1, 0, 'C', true);
        $pdf->Cell(80, 5, utf8_decode('Lot'), 1, 0, 'C', true);
        $pdf->Cell(80, 5, utf8_decode('Désignation'), 1, 0, 'C', true);
        $pdf->Cell(40, 5, utf8_decode('Date Entrée'), 1, 0, 'C', true);
        $pdf->Cell(40, 5, utf8_decode('Date péremption'), 1, 0, 'C', true);
        $pdf->Cell(20, 5, utf8_decode('Quantité'), 1, 1, 'C', true);

        return $pdf;
    }

}

