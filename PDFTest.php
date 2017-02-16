
<?php

$version = 'v1.9';
$awardId = htmlspecialchars($_POST["awardId"]);
$awardedName = "         ";

require_once( "fpdf/fpdf.php" );
$pdf = new FPDF( 'L', 'mm', 'Letter' );
$pdf->AddPage();
$pdf->Image( "images/AwardBackground.png", 0, 0, 280 );
$pdf->SetFont('Arial','B',48);
$pdf->Ln(30);
$pdf->Cell(0,0,'Employee of the Year',0,1,'C');
$pdf->SetFont('Arial','B', 8);
$pdf->Cell(0,0, $version . "      ",0,1,'R');

$pdf->Ln(30);
$pdf->SetFont('Arial','B',32);
$pdf->Cell(0,0,'Awarded To',0,1,'C');

$pdf->Ln(30);
$pdf->SetFont('Arial','U',40);
$pdf->Cell(0,0,$awardId,0,1,'C');

$pdf->Output("pdftest.pdf","I");
?>
