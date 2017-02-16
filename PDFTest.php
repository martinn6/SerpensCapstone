
<?php
require_once( "fpdf/fpdf.php" );
$pdf = new FPDF( 'L', 'mm', 'Letter' );
$pdf->AddPage();
$pdf->Image( "images/AwardBackground.png", 0, 0, 267 );
$pdf->SetFont('Arial','B',16);
$pdf->Cell(40,10,'Hello World! v1.0');
$pdf->Output("pdftest.pdf","I");
?>
