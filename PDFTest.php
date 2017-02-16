
<?php

$version = 'v2.3';

$awardId = (isset($_GET['awardId']) ? $_GET['awardId'] : null);

$awardedName = "         ";

require_once( "fpdf/fpdf.php" );
$pdf = new FPDF( 'L', 'mm', 'Letter' );
$pdf->AddPage();
$pdf->Image( "images/AwardBackground.png", 0, 0, 280 );
$pdf->Ln(30);
$pdf->SetFont('Arial','B', 8);
$pdf->Cell(0,0, $version . "           ",0,1,'R');
$pdf->SetFont('Arial','B',48);
$pdf->Cell(0,0,'Employee of the Year',0,1,'C');

//Awarded To
$pdf->Ln(30);
$pdf->SetFont('Arial','B',32);
$pdf->Cell(0,0,'Awarded To',0,1,'C');

//Awarded To Name
$pdf->Ln(30);
$pdf->SetFont('Arial','U',40);
$pdf->Cell(0,0,$awardId,0,1,'C');

$pdf->Output("pdftest.pdf","I");
?>
