<?php

namespace App\Service;

use Fpdf\Fpdf;
use App\Entity\User;
use App\Service\EntetePaysage;
use App\Service\EntetePortrait;
use App\Entity\ElementsPiedDePage\PDF;
use App\Entity\ElementsPiedDePage\Pagination;
use DateTime;

class ImpressionEtatStockService extends FPDF
{
    public function __construct(
        protected EntetePaysage $entetePaysage, 
        protected EntetePortrait $entetePortrait,
        )
    {
    }

    /**
     * Undocumented function
     *
     * @param array $produits
     * @return Pagination
     */
    public function impressionEtatStock(array $produits, DateTime $dateDebut = null, DateTime $dateFin = null, bool $periode = null): Pagination
    {
        $pdf = new Pagination();
        $pdf->addPage('P');

        $pdf = $this->entetePortrait->entetePortrait($pdf);

        $pdf->SetLeftMargin(10);

        $positionY = 50;
        $pdf->SetXY(15, $positionY);

        // $pdf->Image('../public/images/qrcode/'.$facture->getQrCode(), 10, 40, 500);
        // $pdf->Image('../public/images/qrcode/'.$facture->getQrCode(), 165, 67, 34, 34);
        
        $pdf->Ln(8);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 5, 'ETAT DU STOCK DES MEDICAMENTS', 0, 1, 'C', 0);
        $pdf->SetFont('Arial', 'BI', 7);
        $pdf->Cell(0, 5, 'Date : '. date_format(new DateTime(), 'd-m-Y H:i:s'), 0, 1, 'C', 0);
        $pdf->Cell(0, 5, 'Les prix sont en fcfa', 0, 1, 'C', 0);

        $pdf->SetFont('Arial', 'BI', 9);
        if ($periode) 
        {
            $pdf->Cell(0, 5, 'PERIODE : du '.date_format($dateDebut, 'd-m-Y').' au '.date_format($dateFin, 'd-m-Y'), 0, 1, 'C', 0);
        }

        $pdf->SetX(15);
        $pdf->SetFont('Arial', 'B', 8);

        $pdf->Ln(5);
        $pdf->SetX(15);

        // Entête du tableau
        $pdf = $this->enteteTableau($pdf);

        $pdf->SetFont('Arial', '', 7);

        $i = 0 ;
        $montant = 0;
        foreach ($produits as $produit) 
        {   $i++;
            if ($i % 2 == 0) 
            {
                $pdf->SetFillColor(184,204,228);
            } 
            else 
            {
                $pdf->SetFillColor(255,255,255);
            }
            
            $pdf->SetX(10);
            $pdf->Cell(10, 5, utf8_decode($i), 1, 0, 'C', true);
            $pdf->Cell(90, 5, utf8_decode($produit->getLibelle()), 1, 0, 'L', true);

            if ($produit->getLot()->getDatePeremptionAt()) 
            {
                $pdf->Cell(25, 5, utf8_decode(date_format($produit->getLot()->getDatePeremptionAt(), 'd-m-Y')), 1, 0, 'C', true);
            } 
            else 
            {
                $pdf->Cell(25, 5, utf8_decode("").' / '.utf8_decode(""), 1, 0, 'C', true);
            }
            
            
            $pdf->Cell(20, 5, utf8_decode(number_format($produit->getLot()->getQuantite(), 0, '', ' ')), 1, 0, 'C', true);
            $pdf->Cell(20, 5, utf8_decode(number_format($produit->getLot()->getVendu(), 0, '', ' ')), 1, 0, 'C', true);
            $pdf->Cell(20, 5, utf8_decode(number_format(($produit->getLot()->getQuantite() - $produit->getLot()->getVendu()), 0, '', ' ')), 1, 1, 'C', true);

            $montant += $produit->getLot()->getVendu() * $produit->getPrixVente();
            
        }

        $pdf = $this->basTableau($pdf, $i);
        
        $pdf->Ln(10);
        $pdf->SetX(15);
        
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(90, 5, utf8_decode('Le/La Responsable'), 0, 0, 'C');
        $pdf->Cell(90, 5, utf8_decode("L'Administration"), 0, 0, 'C');

        return $pdf;
    }


    public function enteteTableau(Pagination $pdf): Pagination
    {
        $pdf->SetX(10);
        $pdf->SetFillColor(240,240,240);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(10, 5, utf8_decode('N°'), 1, 0, 'C', true);
        $pdf->Cell(90, 5, utf8_decode('Désignation'), 1, 0, 'C', true);
        $pdf->Cell(25, 5, utf8_decode('Date Exp.'), 1, 0, 'C', true);
        $pdf->Cell(20, 5, utf8_decode('Quantité'), 1, 0, 'C', true);
        $pdf->Cell(20, 5, utf8_decode('Vendu'), 1, 0, 'C', true);
        $pdf->Cell(20, 5, utf8_decode('Reste'), 1, 1, 'C', true);

        return $pdf;
    }

    public function basTableau(Pagination $pdf, int $i): Pagination
    {
        $pdf->SetX(10);
        $pdf->SetFillColor(240,240,240);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(145, 5, utf8_decode('TOTAL'), 1, 0, 'C', true);
        $pdf->Cell(40, 5, utf8_decode(number_format($i, 0, '', ' ')." produits"), 1, 1, 'C', true);

        return $pdf;
    }
}

