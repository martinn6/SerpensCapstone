
<?php

$version = 'v1.4';

require_once( "fpdf/fpdf.php" );
$pdf = new FPDF( 'L', 'mm', 'Letter' );
$pdf->AddPage();
$pdf->Image( "images/AwardBackground.png", 0, 0, 280 );
$pdf->SetFont('Arial','B',48);
$pdf->Cell(280,0,'Employee of the Year',0,2,'C');
$pdf->SetFont('Arial','B', 8);
$pdf->Cell(280,0, $version,0,2,'R');
$pdf->Output("pdftest.pdf","I");
?>
