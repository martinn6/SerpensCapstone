
<?php
require_once( "fpdf/fpdf.php" );
$pdf = new FPDF( 'L', 'mm', 'Letter' );
$pdf->AddPage();
$pdf->Image( "images/AwardBackground.png", 0, 0, 280 );
$pdf->SetFont('Arial','B',32);
$pdf->Cell(120,40,'Employee of the Year! v1.1');
$pdf->Output("pdftest.pdf","I");
?>
