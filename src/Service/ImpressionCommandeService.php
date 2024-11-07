<?php

namespace App\Service;

use Fpdf\Fpdf;
use App\Entity\Commande;
use App\Entity\ElementsPiedDePage\PaginationPortrait;
use App\Entity\ElementsPiedDePage\PDF;
use App\Service\EntetePortraitPagination;

class ImpressionCommandeService extends FPDF
{
    public function __construct( 
        protected EntetePortraitPagination $entetePortraitPagination,
        )
    {
    }

    /**
     * Fonction qui permet d'imprimer une commande
     *
     * @param Commande $commande
     * @return PDF
     */
    public function impressionCommande(Commande $commande): PaginationPortrait
    {
        $pdf = new PaginationPortrait();
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
        $pdf->Cell(85, 5, utf8_decode('Produits'), 1, 0, 'C', true);
        $pdf->Cell(20, 5, utf8_decode('P.A'), 1, 0, 'C', true);
        // $pdf->Cell(10, 5, utf8_decode('Coef'), 1, 0, 'C', true);
        // $pdf->Cell(15, 5, utf8_decode('P.V'), 1, 0, 'C', true);
        $pdf->Cell(20, 5, utf8_decode('Date Exp'), 1, 0, 'C', true);
        $pdf->Cell(20, 5, utf8_decode('Qté'), 1, 0, 'C', true);
        $pdf->Cell(30, 5, utf8_decode('Total'), 1, 1, 'C', true);

        $i = 1;
        $netApayer = 0;
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
            $pdf->Cell(85, 5, utf8_decode($ligneDeCommande->getProduit() ? $ligneDeCommande->getProduit()->getLibelle():""), 1, 0, 'L', true);
            $pdf->Cell(20, 5, utf8_decode($ligneDeCommande->getPrixAchat() ? $ligneDeCommande->getPrixAchat():""), 1, 0, 'C', true);
            // $pdf->Cell(10, 5, utf8_decode($ligneDeCommande->getCoef() ? $ligneDeCommande->getCoef():""), 1, 0, 'C', true);
            // $pdf->Cell(15, 5, utf8_decode($ligneDeCommande->getPrixAchat() * $ligneDeCommande->getCoef()), 1, 0, 'C', true);
            $pdf->Cell(20, 5, utf8_decode($ligneDeCommande->getDatePeremptionAt() ? date_format($ligneDeCommande->getDatePeremptionAt(), 'd-m-Y'):""), 1, 0, 'C', true);
            $pdf->Cell(20, 5, utf8_decode($ligneDeCommande->getQuantite()), 1, 0, 'C', true);
            $pdf->Cell(30, 5, utf8_decode($ligneDeCommande->getPrixAchat() * $ligneDeCommande->getQuantite()), 1, 1, 'C', true);

            $netApayer += $ligneDeCommande->getPrixAchat() * $ligneDeCommande->getQuantite();
            $i++;
            
        }

        
        $pdf->SetFillColor(240,240,240);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(160, 5, utf8_decode('NET A PAYER'), 0, 0, 'R');
        $pdf->Cell(30, 5, utf8_decode(number_format($netApayer, 0, '', ' ')." FCFA"), 1, 1, 'C', true);

        $pdf->SetX($pdf->GetX() + 15);
        $pdf->SetY($pdf->GetY() + 15);
        $pdf->SetFont('Arial', 'BU', 12);
        $pdf->Cell(85, 5, utf8_decode('LA SECRETAIRE'), 0, 0, 'C');
        $pdf->Cell(110, 5, utf8_decode('LA DIRECTEUR'), 0, 1, 'C');

        
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(85, 5, utf8_decode($commande->getSecretaire()->getNom() ), 0, 1, 'C');

        return $pdf;
    }
}

