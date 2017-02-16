
<?php

$version = '1.2';

require_once( "fpdf/fpdf.php" );
$pdf = new FPDF( 'L', 'mm', 'Letter' );
$pdf->AddPage();
$pdf->Image( "images/AwardBackground.png", 0, 0, 280 );
$pdf->SetFont('Arial','B',48);
$pdf->Cell(60,60,'Employee of the Year');
$pdf->SetFont('Arial','B', 8);
$pdf->Cell(200,200, $version);
$pdf->Output("pdftest.pdf","I");
?>
