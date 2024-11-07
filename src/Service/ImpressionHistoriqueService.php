<?php

namespace App\Service;

use DateTime;
use Fpdf\Fpdf;
use App\Entity\User;
use App\Entity\ConstantsClass;
use App\Service\EntetePaysage;
use App\Service\EntetePortrait;



class ImpressionHistoriqueService extends FPDF
{
    public function __construct(
        protected EntetePaysage $entetePaysage, 
        protected EntetePortrait $entetePortrait,
        )
    {
    }

    public function impressionHistorique(array $commandes, User $user, int $typeUser): Fpdf
    {
        if ($typeUser == 1) 
        {
            $pdf = new Fpdf();
            $pdf->addPage('P');

            $pdf = $this->entetePortrait->entetePortrait($pdf);

            $pdf->SetLeftMargin(10);

            $positionY = 40;
            $pdf->SetXY(15, $positionY);

            $pdf->SetFont('Times', 'B', 16);
            $pdf->Cell(0, 8, 'HISTORIQUE DE MES COMMANDES', 0, 1, 'C', 0);
            $pdf->SetFont('Times', 'I', 14);
            $pdf->Cell(0, 5, 'HISTORY OF MY ORDERS', 0, 1, 'C', 0);
            $pdf->Ln();
            $pdf->SetFont('Times', 'B', 12);
            $pdf->Cell(0, 5, "Nom du client / Customer's Name", 0, 1, 'C', 0);

            

            $positionY = 80;
            $pdf->Ln(5);
            $pdf->SetFont('Times', 'B', 12);
            $pdf->SetX(15);
            $pdf->SetFillColor(240,240,240);
            $pdf->Cell(7, 5, utf8_decode('N°'), 1, 0, 'C', true);
            $pdf->Cell(28, 5, utf8_decode('Réf / Ref'), 1, 0, 'C', true);
            $pdf->Cell(25, 5, utf8_decode('Date'), 1, 0, 'C', true);
            $pdf->Cell(40, 5, utf8_decode('Montant / Amount'), 1, 0, 'C', true);
            $pdf->Cell(15, 5, utf8_decode('Table'), 1, 0, 'C', true);
            $pdf->SetFont('Times', 'B', 8);
            $pdf->Cell(50, 5, utf8_decode('Mode de paiement / Payment method '), 1, 0, 'C', true);
            $pdf->SetFont('Times', 'B', 8);
            $pdf->Cell(20, 5, utf8_decode('Statut / Status'), 1, 1, 'C', true);
            $pdf->SetFont('Times', 'B', 6);

            $i = 1;
            foreach ($commandes as $commande) 
            {
                if ($i % 2 == 0) 
                {
                    $pdf->SetFillColor(202,219,255);
                }else {
                    $pdf->SetFillColor(255,255,255);
                }
                $pdf->SetX(15);
                $pdf->SetFont('Times', 'B', 8);
                $pdf->Cell(7, 5, utf8_decode($i), 1, 0, 'C', true);
                $pdf->Cell(28, 5, utf8_decode($commande->getReference()), 1, 0, 'C', true);
                $pdf->Cell(25, 5, utf8_decode(date_format($commande->getDateCommandeAt(), 'd-m-Y H:i')), 1, 0, 'C', true);
                $pdf->Cell(40, 5, utf8_decode(number_format($commande->getTotal(), 0, '', ' ')." FCFA"), 1, 0, 'C', true);
                $pdf->Cell(15, 5, utf8_decode(number_format($commande->getNumeroTable(), 0, '', ' ')), 1, 0, 'C', true);
                $pdf->Cell(50, 5, utf8_decode($commande->getModePaiement()->getModePaiement()), 1, 0, 'C', true);
                $pdf->Cell(20, 5, utf8_decode($commande->getEtatCommande()->getEtatCommande()), 1, 1, 'C', true);
                
                $i++;
                
            }
        } elseif($typeUser == 2)
        {
            $pdf = new Fpdf();
            $pdf->addPage('L');

            $pdf = $this->entetePaysage->entetePaysage($pdf);

            $pdf->SetLeftMargin(10);

            $positionY = 40;
            $pdf->SetXY(15, $positionY);

            $pdf->SetFont('Times', 'B', 16);
            $pdf->Cell(0, 8, 'HISTORIQUE DES COMMANDES', 0, 1, 'C', 0);
            $pdf->SetFont('Times', 'I', 14);
            $pdf->Cell(0, 5, 'HISTORY OF ORDERS', 0, 1, 'C', 0);

            $positionY = 80;
            $pdf->Ln(5);
            $pdf->SetFont('Times', 'B', 12);
            $pdf->SetX(10);
            $pdf->SetFillColor(240,240,240);
            $pdf->Cell(7, 10, utf8_decode('N°'), 1, 0, 'C', true);
            $pdf->Cell(25, 10, utf8_decode('Réf / Ref'), 1, 0, 'C', true);
            $pdf->Cell(40, 10, utf8_decode('Utilisateur'), 1, 0, 'C', true);
            $pdf->Cell(20, 10, utf8_decode('Tél'), 1, 0, 'C', true);
            $pdf->Cell(40, 10, utf8_decode('Nom commande'), 1, 0, 'C', true);
            $pdf->Cell(20, 10, utf8_decode('Tél comm.'), 1, 0, 'C', true);
            $pdf->Cell(25, 10, utf8_decode('Date'), 1, 0, 'C', true);
            $pdf->Cell(25, 5, utf8_decode('Montant'), 'LTR', 0, 'C', true);
            $pdf->Cell(15, 10, utf8_decode('Table'), 1, 0, 'C', true);
            $pdf->Cell(40, 5, utf8_decode('Mode de paiement'), 'TLR', 0, 'C', true);
            $pdf->SetFont('Times', 'B', 8);
            $pdf->Cell(20, 10, utf8_decode('Statut / Status'), 1, 1, 'C', true);

            // $pdf->Ln(-5);
            $pdf->SetY(63);
            $pdf->SetX( $pdf->GetX()+177);
            $pdf->Cell(25, 5, utf8_decode('Amount'), 'BLR', 0, 'C', true);
            $pdf->SetX(227);
            $pdf->Cell(40, 5, utf8_decode('Payment method'), 'BLR', 1, 'C', true);
            $pdf->SetFont('Times', 'B', 6);

            $i = 1;
            foreach ($commandes as $commande) 
            {
                if ($i % 2 == 0) 
                {
                    $pdf->SetFillColor(202,219,255);
                }else {
                    $pdf->SetFillColor(255,255,255);
                }
                $pdf->SetX(10);
                $pdf->SetFont('Times', 'B', 8);
                $pdf->Cell(7, 5, utf8_decode($i), 1, 0, 'C', true);
                $pdf->Cell(25, 5, utf8_decode($commande->getReference()), 1, 0, 'C', true);
                $pdf->SetFont('Times', 'B', 7);
                $pdf->Cell(40, 5, utf8_decode($commande->getUser()->getFullName()), 1, 0, 'C', true);
                $pdf->SetFont('Times', 'B', 8);
                $pdf->Cell(20, 5, utf8_decode($commande->getUser()->getTelephone()), 1, 0, 'C', true);
                $pdf->SetFont('Times', 'B', 7);
                $pdf->Cell(40, 5, utf8_decode($commande->getNomClient()), 1, 0, 'C', true);
                $pdf->SetFont('Times', 'B', 8);
                $pdf->Cell(20, 5, utf8_decode($commande->getNumeroTelephone()), 1, 0, 'C', true);
                $pdf->Cell(25, 5, utf8_decode(date_format($commande->getDateCommandeAt(), 'd-m-Y H:i')), 1, 0, 'C', true);
                $pdf->Cell(25, 5, utf8_decode(number_format($commande->getTotal(), 0, '', ' ')." FCFA"), 1, 0, 'C', true);
                $pdf->Cell(15, 5, utf8_decode(number_format($commande->getNumeroTable(), 0, '', ' ')), 1, 0, 'C', true);
                $pdf->Cell(40, 5, utf8_decode($commande->getModePaiement()->getModePaiement()), 1, 0, 'C', true);
                $pdf->Cell(20, 5, utf8_decode($commande->getEtatCommande()->getEtatCommande()), 1, 1, 'C', true);
                
                $i++;
                
            }
        }
        

        

        $pdf->AliasNbPages();
        return $pdf;
    }


    public function impressionHistoriqueClient(array $commandes, User $user): Fpdf
    {
        $pdf = new Fpdf();
        $pdf->addPage('P');

        $pdf = $this->entetePortrait->entetePortrait($pdf);

        $pdf->SetLeftMargin(10);

        $positionY = 40;
        $pdf->SetXY(15, $positionY);
        $pdf->SetFont('Times', 'B', 22);

        
        $pdf->SetFont('Times', 'B', 16);
        $pdf->Cell(0, 8, 'HISTORIQUE DES COMMANDES DE ', 0, 1, 'C', 0);
        $pdf->SetFont('Times', 'I', 14);
        $pdf->Cell(0, 5, 'HISTORY ORDERS OF', 0, 1, 'C', 0);
        $pdf->Ln();
        $pdf->SetFont('Times', 'B', 12);
        $pdf->Cell(0, 5, "Nom du client / Customer's Name", 0, 1, 'C', 0);

        

        $positionY = 80;
        $pdf->Ln(5);
        $pdf->SetFont('Times', 'B', 12);
        $pdf->SetX(15);
        $pdf->SetFillColor(240,240,240);
        $pdf->Cell(7, 5, utf8_decode('N°'), 1, 0, 'C', true);
        $pdf->Cell(28, 5, utf8_decode('Réf / Ref'), 1, 0, 'C', true);
        $pdf->Cell(25, 5, utf8_decode('Date'), 1, 0, 'C', true);
        $pdf->Cell(40, 5, utf8_decode('Montant / Amount'), 1, 0, 'C', true);
        $pdf->Cell(15, 5, utf8_decode('Table'), 1, 0, 'C', true);
        $pdf->SetFont('Times', 'B', 8);
        $pdf->Cell(50, 5, utf8_decode('Mode de paiement / Payment method '), 1, 0, 'C', true);
        $pdf->SetFont('Times', 'B', 8);
        $pdf->Cell(20, 5, utf8_decode('Statut / Status'), 1, 1, 'C', true);
        $pdf->SetFont('Times', 'B', 6);

        $i = 1;
        foreach ($commandes as $commande) 
        {
            if ($i % 2 == 0) 
            {
                $pdf->SetFillColor(202,219,255);
            }else {
                $pdf->SetFillColor(255,255,255);
            }
            $pdf->SetX(15);
            $pdf->SetFont('Times', 'B', 8);
            $pdf->Cell(7, 5, utf8_decode($i), 1, 0, 'C', true);
            $pdf->Cell(28, 5, utf8_decode($commande->getReference()), 1, 0, 'C', true);
            $pdf->Cell(25, 5, utf8_decode(date_format($commande->getDateCommandeAt(), 'd-m-Y H:i')), 1, 0, 'C', true);
            $pdf->Cell(40, 5, utf8_decode(number_format($commande->getTotal(), 0, '', ' ')." FCFA"), 1, 0, 'C', true);
            $pdf->Cell(15, 5, utf8_decode(number_format($commande->getNumeroTable(), 0, '', ' ')), 1, 0, 'C', true);
            $pdf->Cell(50, 5, utf8_decode($commande->getModePaiement()->getModePaiement()), 1, 0, 'C', true);
            $pdf->Cell(20, 5, utf8_decode($commande->getEtatCommande()->getEtatCommande()), 1, 1, 'C', true);
            
            $i++;
            
        }
        
        

        

        $pdf->AliasNbPages();
        return $pdf;
    }


    public function impressionHistoriqueEtat(array $commandes): Fpdf
    {
        $pdf = new Fpdf();
            $pdf->addPage('L');

            $pdf = $this->entetePaysage->entetePaysage($pdf);

            $pdf->SetLeftMargin(10);

            $positionY = 40;
            $pdf->SetXY(15, $positionY);

            $pdf->SetFont('Times', 'B', 16);
            $pdf->Cell(0, 8, 'HISTORIQUE DES COMMANDES', 0, 1, 'C', 0);
            $pdf->SetFont('Times', 'I', 14);
            $pdf->Cell(0, 5, 'HISTORY OF ORDERS', 0, 1, 'C', 0);

            $positionY = 80;
            $pdf->Ln(5);
            $pdf->SetFont('Times', 'B', 12);
            $pdf->SetX(10);
            $pdf->SetFillColor(240,240,240);
            $pdf->Cell(7, 10, utf8_decode('N°'), 1, 0, 'C', true);
            $pdf->Cell(25, 10, utf8_decode('Réf / Ref'), 1, 0, 'C', true);
            $pdf->Cell(40, 10, utf8_decode('Utilisateur'), 1, 0, 'C', true);
            $pdf->Cell(20, 10, utf8_decode('Tél'), 1, 0, 'C', true);
            $pdf->Cell(40, 10, utf8_decode('Nom commande'), 1, 0, 'C', true);
            $pdf->Cell(20, 10, utf8_decode('Tél comm.'), 1, 0, 'C', true);
            $pdf->Cell(25, 10, utf8_decode('Date'), 1, 0, 'C', true);
            $pdf->Cell(25, 5, utf8_decode('Montant'), 'LTR', 0, 'C', true);
            $pdf->Cell(15, 10, utf8_decode('Table'), 1, 0, 'C', true);
            $pdf->Cell(40, 5, utf8_decode('Mode de paiement'), 'TLR', 0, 'C', true);
            $pdf->SetFont('Times', 'B', 8);
            $pdf->Cell(20, 10, utf8_decode('Statut / Status'), 1, 1, 'C', true);

            // $pdf->Ln(-5);
            $pdf->SetY(63);
            $pdf->SetX( $pdf->GetX()+177);
            $pdf->Cell(25, 5, utf8_decode('Amount'), 'BLR', 0, 'C', true);
            $pdf->SetX(227);
            $pdf->Cell(40, 5, utf8_decode('Payment method'), 'BLR', 1, 'C', true);
            $pdf->SetFont('Times', 'B', 6);

            $i = 1;
            foreach ($commandes as $commande) 
            {
                if ($i % 2 == 0) 
                {
                    $pdf->SetFillColor(202,219,255);
                }else {
                    $pdf->SetFillColor(255,255,255);
                }
                $pdf->SetX(10);
                $pdf->SetFont('Times', 'B', 8);
                $pdf->Cell(7, 5, utf8_decode($i), 1, 0, 'C', true);
                $pdf->Cell(25, 5, utf8_decode($commande->getReference()), 1, 0, 'C', true);
                $pdf->SetFont('Times', 'B', 7);
                $pdf->Cell(40, 5, utf8_decode($commande->getUser()->getFullName()), 1, 0, 'C', true);
                $pdf->SetFont('Times', 'B', 8);
                $pdf->Cell(20, 5, utf8_decode($commande->getUser()->getTelephone()), 1, 0, 'C', true);
                $pdf->SetFont('Times', 'B', 7);
                $pdf->Cell(40, 5, utf8_decode($commande->getNomClient()), 1, 0, 'C', true);
                $pdf->SetFont('Times', 'B', 8);
                $pdf->Cell(20, 5, utf8_decode($commande->getNumeroTelephone()), 1, 0, 'C', true);
                $pdf->Cell(25, 5, utf8_decode(date_format($commande->getDateCommandeAt(), 'd-m-Y H:i')), 1, 0, 'C', true);
                $pdf->Cell(25, 5, utf8_decode(number_format($commande->getTotal(), 0, '', ' ')." FCFA"), 1, 0, 'C', true);
                $pdf->Cell(15, 5, utf8_decode(number_format($commande->getNumeroTable(), 0, '', ' ')), 1, 0, 'C', true);
                $pdf->Cell(40, 5, utf8_decode($commande->getModePaiement()->getModePaiement()), 1, 0, 'C', true);
                $pdf->Cell(20, 5, utf8_decode($commande->getEtatCommande()->getEtatCommande()), 1, 1, 'C', true);
                
                $i++;
                
            }
        
        
        $pdf->AliasNbPages();
        return $pdf;
    }
}

