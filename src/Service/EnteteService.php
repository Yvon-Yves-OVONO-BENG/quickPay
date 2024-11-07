<?php

namespace App\Service;

use Fpdf\Fpdf;

class EnteteService
{
    public function getEnteteService(Fpdf $pdf, float $width1, float $height, float $fontSize): Fpdf
    {
        $pdf->Image('build/appCustom/assets/images/brand/FALIS-SAS-LOGO.jpg', 15, 10, -150);
        $pdf->Cell($width1, $height-2, utf8_decode(""), 0, 0, 'C');
        $pdf->Cell($width1-40, $height-2, utf8_decode(""), 0, 0, 'C');
        $pdf->Cell($width1, $height-2, utf8_decode(""), 0, 1, 'C');

        $pdf->setFont('Times', 'B', $fontSize-3);
        $pdf->Cell($width1, $height-2, utf8_decode(""), 0, 0, 'C');
        $pdf->Cell($width1-40, $height-2, utf8_decode(""), 0, 0, 'C');
        $pdf->Cell($width1, $height-2, utf8_decode(""), 0, 1, 'C');

        $pdf->Cell($width1, $height-2, utf8_decode(""), 0, 0, 'C');
        $pdf->Cell($width1-40, $height-2, utf8_decode(""), 0, 0, 'C');
        $pdf->Cell($width1, $height-2, utf8_decode(""), 0, 1, 'C');

        $pdf->setFont('Times', 'B', $fontSize);
        $pdf->Cell($width1, $height-2, utf8_decode(""), 0, 0, 'C');
        $pdf->Cell($width1-40, $height-2, utf8_decode(""), 0, 0, 'C');
        $pdf->Cell($width1, $height-2, utf8_decode(""), 0, 1, 'C');

        $pdf->setFont('Times', 'B', $fontSize-3);
        $pdf->Cell($width1, $height-2, utf8_decode("Salut BERNADETTE SOLANGE,"), 0, 0, 'C');
        $pdf->Cell($width1-40, $height-2, utf8_decode(""), 0, 0, 'C');
        $pdf->Cell($width1, $height-2, utf8_decode(""), 0, 1, 'C');

        $pdf->setFont('Times', 'B', $fontSize);
        $pdf->Cell($width1, $height-2, utf8_decode(""), 0, 0, 'C');
        $pdf->Cell($width1-40, $height-2, utf8_decode(""), 0, 0, 'C');
        $pdf->Cell($width1, $height-2, utf8_decode(""), 0, 1, 'C');

        $pdf->setFont('Times', 'B', $fontSize-3);
        $pdf->Cell($width1, $height-2, utf8_decode(""), 0, 0, 'C');
        $pdf->Cell($width1-40, $height-2, utf8_decode(""), 0, 0, 'C');
        $pdf->Cell($width1, $height-2, utf8_decode(""), 0, 1, 'C');
        $pdf->Ln();
        $pdf->Ln();
        $pdf->Ln();
        
        return $pdf;
    }
}