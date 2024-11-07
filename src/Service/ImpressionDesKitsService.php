<?php

namespace App\Service;

use Fpdf\Fpdf;
use App\Entity\Kit;
use App\Entity\ElementsPiedDePage\PaginationPortrait;
use App\Entity\Produit;
use App\Repository\LigneDeKitRepository;
use App\Service\EntetePortraitPagination;

class ImpressionDesKitsService extends FPDF
{
    public function __construct( 
        protected BlocChiffreService $blocChiffreService,
        protected LigneDeKitRepository $ligneDeKitRepository,
        protected EntetePortraitPagination $entetePortraitPagination,
        )
    {}

    /**
     * Fonction qui imprime la liste des kits
     *
     * @param array $kits
     * @return PaginationPortrait
     */
    public function impressionDesKits(array $kits): PaginationPortrait
    {
        $pdf = new PaginationPortrait();

        $pdf->addPage('P');

        $pdf = $this->entetePortraitPagination->entetePortraitPagination($pdf);

        $pdf->SetLeftMargin(10);

        $positionY = 50;
        $pdf->SetXY(15, $positionY);

        // $pdf->Image('../public/images/qrcode/'.$kit->getQrCode(), 10, 40, 500);
        // $pdf->Image('../public/images/qrcode/'.$kit->getQrCode(), 165, 67, 34, 34);
        $pdf->SetX(15);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 5, 'LISTE DES KITS ', 0, 1, 'C', 0);
        $pdf->Ln();

        $pdf->SetX(15);
        $pdf->SetFillColor(240,240,240);
        $pdf->Cell(15, 5, utf8_decode('N°'), 1, 0, 'C', true);
        $pdf->Cell(100, 5, utf8_decode('Kit'), 1, 0, 'C', true);
        $pdf->Cell(40, 5, utf8_decode('Qté produits'), 1, 0, 'C', true);
        $pdf->Cell(30, 5, utf8_decode('Prix'), 1, 1, 'C', true);

        $prix = 0;
        $i = 1;

        foreach ($kits as $kit) 
        {
            $pdf->SetX(15);
            
            $positionY = 80;
            $pdf->SetFont('Arial', 'B', 10);
            $pdf->SetX(15);
            
            if ($i % 2 == 0) 
            {
                $pdf->SetFillColor(202,219,255);
            }else {
                $pdf->SetFillColor(255,255,255);
            }
            $pdf->SetX(15);
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(15, 5, utf8_decode($i), 1, 0, 'C', true);
            $pdf->Cell(100, 5, utf8_decode($kit->getLibelle()), 1, 0, 'L', true);

            #je récupère ses lignes des kit
            $ligneDeKits = $this->ligneDeKitRepository->findBy([
                'produitKit' => $kit
            ]);

            $pdf->Cell(40, 5, utf8_decode(number_format(count($ligneDeKits), 0, '', ' ')), 1, 0, 'C', true);
            
            $pdf->Cell(30, 5, utf8_decode(number_format($kit->getPrixVente(), 0, '', ' ')." FCFA"), 1, 1, 'C', true);
            // $pdf->Cell(30, 5, utf8_decode($this->blocChiffreService->diviserEnBlocs($kit->getPrixVente())." FCFA"), 1, 1, 'C', true);
            
            $i++;

        }
        
        $pdf->SetX($pdf->GetX() + 15);
        $pdf->SetY($pdf->GetY() + 15);
        $pdf->SetFont('Arial', 'BU', 12);
        $pdf->Cell(150, 5, utf8_decode('LE PHARMACIEN'), 0, 0, 'R');

        return $pdf;
    }
}

