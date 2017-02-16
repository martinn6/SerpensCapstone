
<?php

$version = 'v1.7';

require_once( "fpdf/fpdf.php" );
$pdf = new FPDF( 'L', 'mm', 'Letter' );
$pdf->AddPage();
$pdf->Image( "images/AwardBackground.png", 0, 0, 280 );
$pdf->SetFont('Arial','B',48);
$pdf->Ln(20);
$pdf->Cell(0,0,'Employee of the Year',0,1,'C');
$pdf->SetFont('Arial','B', 8);
$pdf->Ln(20);
$pdf->Cell(0,0, $version + "      ",0,1,'R');
$pdf->Output("pdftest.pdf","I");
?>
