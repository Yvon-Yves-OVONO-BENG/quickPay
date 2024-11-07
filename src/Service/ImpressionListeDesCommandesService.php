<?php

namespace App\Service;

use Fpdf\Fpdf;
use App\Entity\ElementsPiedDePage\PaginationPortrait;
use App\Service\EntetePortraitPagination;

class ImpressionListeDesCommandesService extends FPDF
{
    public function __construct( 
        protected EntetePortraitPagination $entetePortraitPagination,
        )
    {
    }

    /**
     * Fonction qui retorune la liste des commandes
     *
     * @param array $commandes
     * @return PaginationPortrait
     */
    public function impressionListeDesCommandes(array $commandes): PaginationPortrait
    {   
        $pdf = new PaginationPortrait();
        
        foreach ($commandes as $commande) 
        {
            
            $pdf->addPage('P');

            $pdf = $this->entetePortraitPagination->entetePortraitPagination($pdf);

            $pdf->SetLeftMargin(10);

            $positionY = 50;
            $pdf->SetXY(15, $positionY);

            // $pdf->Image('../public/images/qrcode/'.$commande->getQrCode(), 10, 40, 500);
            // $pdf->Image('../public/images/qrcode/'.$commande->getQrCode(), 165, 67, 34, 34);
            
            $pdf->Ln(15);
            $pdf->SetX(15);
            $pdf->SetFont('Arial', 'B', 12);
            $pdf->Cell(100, 5, 'DETAILS DE LA COMMANDE : '.$commande->getReference(), 0, 1, 'L', 0);

            $pdf->SetX(15);
            $pdf->SetFont('Arial', 'B', 8);
            $pdf->Cell(0, 5, utf8_decode("Date d'entrée de la commande : ").date_format($commande->getDateEntreeAt(), 'd-m-Y H:i:s'), 0, 1, 'L', 0);
            
            $pdf->Ln(5);
            $pdf->SetX(15);
            $pdf->SetFont('Arial', 'B', 10);
            $pdf->Cell(40, 5, utf8_decode("FOURNISSEUR :"), 0, 1, 'L', 0);
            $pdf->SetX(15);
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(0, 5, utf8_decode($commande->getFournisseur()->getFournisseur()), 0, 1, 'L', 0);

            $pdf->SetX(15);
            $pdf->SetFont('Arial', 'B', 8);
            $pdf->Cell(15, 5, utf8_decode("Adresse : "), 0, 0, 'L', 0);

            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(40, 5, utf8_decode($commande->getFournisseur()->getAdresse()), 0, 1, 'L', 0);

            $pdf->SetX(15);
            $pdf->SetFont('Arial', 'B', 8);
            $pdf->Cell(15, 5, utf8_decode("Contact :"), 0, 0, 'L', 0);
            
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(40, 5, utf8_decode($commande->getFournisseur()->getContact()), 0, 1, 'L', 0);

            $positionY = 80;
            $pdf->Ln(5);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->SetX(15);
            
            $pdf->Cell(0, 10, utf8_decode('Eléménts de la commande'), 0, 1, 'L', 0);

            $pdf->SetX(15);
            $pdf->SetFillColor(240,240,240);
            $pdf->Cell(10, 5, utf8_decode('N°'), 1, 0, 'C', true);
            $pdf->Cell(90, 5, utf8_decode('Produits'), 1, 0, 'C', true);
            $pdf->Cell(15, 5, utf8_decode('P.A'), 1, 0, 'C', true);
            $pdf->Cell(10, 5, utf8_decode('Coef'), 1, 0, 'C', true);
            $pdf->Cell(15, 5, utf8_decode('P.V'), 1, 0, 'C', true);
            $pdf->Cell(20, 5, utf8_decode('Date Exp'), 1, 0, 'C', true);
            $pdf->Cell(20, 5, utf8_decode('Qté'), 1, 1, 'C', true);

            $i = 1;
            foreach ($commande->getLigneDeCommandes() as $ligneDeCommande) 
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
                $pdf->Cell(90, 5, utf8_decode($ligneDeCommande->getProduit() ? $ligneDeCommande->getProduit():""), 1, 0, 'L', true);
                $pdf->Cell(15, 5, utf8_decode(number_format($ligneDeCommande->getPrixAchat(), 0, '', ' ') ? number_format($ligneDeCommande->getPrixAchat(), 0, '', ' ') :""), 1, 0, 'C', true);
                $pdf->Cell(10, 5, utf8_decode($ligneDeCommande->getCoef() ? $ligneDeCommande->getCoef():""), 1, 0, 'C', true);
                $pdf->Cell(15, 5, utf8_decode(number_format(($ligneDeCommande->getPrixAchat() * $ligneDeCommande->getCoef()), 0, '', ' ')), 1, 0, 'C', true);
                $pdf->Cell(20, 5, utf8_decode($ligneDeCommande->getDatePeremptionAt() ? date_format($ligneDeCommande->getDatePeremptionAt(), 'd-m-Y'):""), 1, 0, 'C', true);
                $pdf->Cell(20, 5, utf8_decode(number_format($ligneDeCommande->getQuantite(), 0, '', ' ')), 1, 1, 'C', true);

                $i++;
                
            }

            $pdf->SetX($pdf->GetX() + 15);
            $pdf->SetY($pdf->GetY() + 15);
            $pdf->SetFont('Arial', 'BU', 12);
            $pdf->Cell(142, 5, utf8_decode('LA SECRETAIRE'), 0, 0, 'R');

        }
        return $pdf;
        
    }
}