<?php

namespace App\Service;

use DateTime;
use Fpdf\Fpdf;
use App\Service\EntetePaysagePaginantion;
use App\Entity\ElementsPiedDePage\PaginationPaysage;

class ImpressionEtatDeVenteService extends FPDF
{
    public function __construct(
        protected EntetePaysagePaginantion $entetePaysagePagination, 
        )
    {
    }

    /**
     * Undocumented function
     *
     * @param array $produits
     * @return PaginationPaysage
     */
    public function impressionEtatDeVente(array $produits, DateTime $dateDebut = null, DateTime $dateFin = null, bool $periode = null): PaginationPaysage
    {
        $pdf = new PaginationPaysage();
        $pdf->addPage('L');
        
        $pdf = $this->entetePaysagePagination->entetePaysagePagination($pdf);

        $pdf->SetLeftMargin(10);

        $positionY = 50;
        $pdf->SetXY(15, $positionY);

        // $pdf->Image('../public/images/qrcode/'.$facture->getQrCode(), 10, 40, 500);
        // $pdf->Image('../public/images/qrcode/'.$facture->getQrCode(), 165, 67, 34, 34);
        
        $pdf->Ln(8);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 5, 'FICHE ETAT DE VENTE', 0, 1, 'C', 0);
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

        $i = 1 ;
        $montant = 0;
        foreach ($produits as $produit) 
        {   
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
            $pdf->Cell(75, 5, utf8_decode($produit->getLibelle()), 1, 0, 'L', true);
            $pdf->Cell(75, 5, utf8_decode($produit->getLot()->getReference()), 1, 0, 'L', true);
            if ($produit->getLot()->getEnregistreLeAt()) 
            {
                $pdf->Cell(25, 5, utf8_decode(date_format($produit->getLot()->getEnregistreLeAt(), 'd-m-Y')), 1, 0, 'C', true);
            } 
            else 
            {
                $pdf->Cell(25, 5, utf8_decode("").' / '.utf8_decode(""), 1, 0, 'C', true);
            }
            
            
            
            $pdf->Cell(20, 5, utf8_decode(number_format($produit->getLot()->getVendu(), 0, '', ' ')), 1, 0, 'C', true);
            $pdf->Cell(20, 5, utf8_decode(number_format(($produit->getLot()->getQuantite() - $produit->getLot()->getVendu()), 0, '', ' ')), 1, 0, 'C', true);
            $pdf->Cell(20, 5, utf8_decode(number_format($produit->getPrixVente(), 0, '', ' ')), 1, 0, 'C', true);
            $pdf->Cell(30, 5, utf8_decode(number_format(($produit->getLot()->getVendu() * $produit->getPrixVente()), 0, '', ' ')), 1, 1, 'C', true);

            $montant += $produit->getLot()->getVendu() * $produit->getPrixVente();
            $i++;
        }

        $pdf = $this->basTableau($pdf, $montant);
        

        $pdf->Ln(10);
        $pdf->SetX(15);
        
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(120, 5, utf8_decode('Le/La Responsable'), 0, 0, 'C');
        $pdf->Cell(180, 5, utf8_decode("L'Administration"), 0, 0, 'C');

        return $pdf;
    }


    public function enteteTableau(PaginationPaysage $pdf): PaginationPaysage
    {
        $pdf->SetX(10);
        $pdf->SetFillColor(240,240,240);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(10, 5, utf8_decode('N°'), 1, 0, 'C', true);
        $pdf->Cell(75, 5, utf8_decode('Désignation'), 1, 0, 'C', true);
        $pdf->Cell(75, 5, utf8_decode('Lot'), 1, 0, 'C', true);
        $pdf->Cell(25, 5, utf8_decode('Date entrée'), 1, 0, 'C', true);
        $pdf->Cell(20, 5, utf8_decode('Vendu'), 1, 0, 'C', true);
        $pdf->Cell(20, 5, utf8_decode('Reste'), 1, 0, 'C', true);
        $pdf->Cell(20, 5, utf8_decode('Prix'), 1, 0, 'C', true);
        $pdf->Cell(30, 5, utf8_decode('Vendu x Prix'), 1, 1, 'C', true);

        return $pdf;
    }

    public function basTableau(PaginationPaysage $pdf, int $montant): PaginationPaysage
    {
        $pdf->SetX(10);
        $pdf->SetFillColor(240,240,240);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(225, 5, utf8_decode('TOTAL'), 1, 0, 'C', true);
        $pdf->Cell(50, 5, utf8_decode(number_format($montant, 0, '', ' ')." FCFA"), 1, 1, 'C', true);

        return $pdf;
    }
}

