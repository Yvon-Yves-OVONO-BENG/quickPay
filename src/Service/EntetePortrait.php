<?php

namespace App\Service;

use Fpdf\Fpdf;

class EntetePortrait
{
	public function __construct()
	{
	}

	public function entetePortrait(Fpdf $pdf): Fpdf
	{
		$pdf->Image('../public/images/logo/logo.png', 90, 12, 30);
		$pdf->Image('../public/images/logo/arrierePlan.PNG', 30, 90, 150);
		$pdf->SetFont('Helvetica', 'B', 11);
		// fond de couleur gris (valeurs en RGB)
		$pdf->setFillColor(230, 230, 230);
		// position du coin supérieur gauche par rapport à la marge gauche (mm)
		$pdf->SetX(15);
		$pdf->Cell(70, 4, utf8_decode("REPUBLIQUE DU CAMEROUN"), 0, 0, 'C', 0);
		$pdf->Cell(40, 4, '', 0, 0, 'L', 0);
		$pdf->Cell(70, 4, utf8_decode("REPUBLIC OF CAMEROON"), 0, 1, 'C', 0);

		$pdf->SetFont('Helvetica', 'B', 7);
		$pdf->SetX(15);
		$pdf->Cell(70, 4, utf8_decode("Paix - Travail - Patrie"), 0, 0, 'C', 0);
		$pdf->Cell(40, 4, '', 0, 0, 'L', 0);
		$pdf->Cell(70, 4, utf8_decode("Peace - Work - Fatherland"), 0, 1, 'C', 0);

		$pdf->SetX(15);
		$pdf->SetFont('Helvetica', 'B', 8);
		$pdf->Cell(70, 2, '*********', 0, 0, 'C', 0);
		$pdf->Cell(40, 2, '', 0, 0, 'L', 0);
		$pdf->Cell(70, 2, '*********', 0, 1, 'C', 0);

		$pdf->SetX(15);
		$pdf->SetX(15);
		$pdf->Cell(70, 4, utf8_decode("MINISTRE DE L'INFORMATIQUE"), 0, 0, 'C', 0);
		$pdf->Cell(40, 4, '', 0, 0, 'L', 0);
		$pdf->Cell(70, 4, utf8_decode('MINISTRY OF IT'), 0, 1, 'C', 0);

		$pdf->SetX(15);
		$pdf->SetFont('Helvetica', 'B', 8);
		$pdf->Cell(70, 2, '*********', 0, 0, 'C', 0);
		$pdf->Cell(40, 2, '', 0, 0, 'L', 0);
		$pdf->Cell(70, 2, '*********', 0, 1, 'C', 0);

		$pdf->SetX(15);
		$pdf->Cell(70, 4, utf8_decode("QuickPay"), 0, 0, 'C', 0);
		$pdf->Cell(40, 4, '', 0, 0, 'L', 0);
		$pdf->Cell(70, 4, utf8_decode('QuickPay'), 0, 1, 'C', 0);

		$pdf->SetX(15);
		$pdf->SetFont('Helvetica', 'B', 8);
		$pdf->Cell(70, 2, '*********', 0, 0, 'C', 0);
		$pdf->Cell(40, 2, '', 0, 0, 'L', 0);
		$pdf->Cell(70, 2, '*********', 0, 1, 'C', 0);

		################################
		$pdf->SetX(15);
		$pdf->Cell(70, 4, utf8_decode('BP : xx Yaoundé, Tel : +237 xxx xxx xxx'), 0, 0, 'C', 0);
		$pdf->Cell(40, 4, '', 0, 0, 'L', 0);
		$pdf->Cell(70, 4, utf8_decode('Po.Box : xx Yaoundé, Tel : +237 xxx xxx xxx'), 0, 1, 'C', 0);

		$pdf->SetX(15);
		$pdf->SetFont('Helvetica', 'B', 8);
		$pdf->Cell(70, 2, '*********', 0, 0, 'C', 0);
		$pdf->Cell(40, 2, '', 0, 0, 'L', 0);
		$pdf->Cell(70, 2, '*********', 0, 1, 'C', 0);
		$pdf->Ln(15);

		return $pdf;
	}
}
