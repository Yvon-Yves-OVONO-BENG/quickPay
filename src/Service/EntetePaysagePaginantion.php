<?php

namespace App\Service;

use App\Entity\ElementsPiedDePage\PaginationPaysage;

class EntetePaysagePaginantion
{
	public function entetePaysagePagination(PaginationPaysage $pdf): PaginationPaysage
	{
		$pdf->Image('../public/images/logo/logo.png', 120, 12, 50);
		$pdf->Image('../public/images/logo/arrierePlan.PNG', 190, 90, 150);
		$pdf->SetFont('Helvetica', 'B', 12);
		// fond de couleur gris (valeurs en RGB)
		$pdf->setFillColor(230, 230, 230);
		// position du coin supérieur gauche par rapport à la marge gauche (mm)
		
		$pdf->SetX(15);
		$pdf->Cell(70, 4, utf8_decode("REPUBLIQUE DU CAMEROUN"), 0, 0, 'C', 0);
		$pdf->Cell(120, 4, '', 0, 0, 'L', 0);
		$pdf->Cell(70, 4, utf8_decode("REPUBLIC OF CAMEROON"), 0, 1, 'C', 0);

		$pdf->SetFont('Helvetica', 'B', 7);
		$pdf->SetX(15);
		$pdf->Cell(70, 4, utf8_decode("Paix - Travail - Patrie"), 0, 0, 'C', 0);
		$pdf->Cell(120, 4, '', 0, 0, 'L', 0);
		$pdf->Cell(70, 4, utf8_decode("Peace - Work - Fatherland"), 0, 1, 'C', 0);

		$pdf->SetX(15);
		$pdf->SetFont('Helvetica', 'B', 8);
		$pdf->Cell(70, 2, '*********', 0, 0, 'C', 0);
		$pdf->Cell(119, 2, '', 0, 0, 'L', 0);
		$pdf->Cell(70, 2, '*********', 0, 1, 'C', 0);

		#################################
		$pdf->SetX(15);
		$pdf->Cell(70, 4, utf8_decode("MINISTRE DE L'INFORMATIQUE"), 0, 0, 'C', 0);
		$pdf->Cell(120, 4, '', 0, 0, 'L', 0);
		$pdf->Cell(70, 4, utf8_decode('MINISTRY OF IT'), 0, 1, 'C', 0);

		$pdf->SetX(15);
		$pdf->SetFont('Helvetica', 'B', 8);
		$pdf->Cell(70, 2, '*********', 0, 0, 'C', 0);
		$pdf->Cell(119, 2, '', 0, 0, 'L', 0);
		$pdf->Cell(70, 2, '*********', 0, 1, 'C', 0);

		$pdf->SetX(15);
		$pdf->Cell(70, 4, utf8_decode("QuickPay"), 0, 0, 'C', 0);
		$pdf->Cell(120, 4, '', 0, 0, 'L', 0);
		$pdf->Cell(70, 4, utf8_decode('QuickPay'), 0, 1, 'C', 0);

		$pdf->SetX(15);
		$pdf->SetFont('Helvetica', 'B', 8);
		$pdf->Cell(70, 2, '*********', 0, 0, 'C', 0);
		$pdf->Cell(119, 2, '', 0, 0, 'L', 0);
		$pdf->Cell(70, 2, '*********', 0, 1, 'C', 0);

		################################
		$pdf->SetX(15);
		$pdf->Cell(70, 4, utf8_decode('BP : xx Yaoundé, Tel : +237 xxx xxx xxx'), 0, 0, 'C', 0);
		$pdf->Cell(120, 4, '', 0, 0, 'L', 0);
		$pdf->Cell(70, 4, utf8_decode('Po.Box : xx Yaoundé, Tel : +237 xxx xxx xxx'), 0, 1, 'C', 0);

		$pdf->SetX(15);
		$pdf->SetFont('Helvetica', 'B', 8);
		$pdf->Cell(70, 2, '*********', 0, 0, 'C', 0);
		$pdf->Cell(119, 2, '', 0, 0, 'L', 0);
		$pdf->Cell(70, 2, '*********', 0, 1, 'C', 0);
		$pdf->Ln(25);
		return $pdf;
	}
}
