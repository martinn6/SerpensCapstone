
<?php

$version = 'v4.1';

$awardId = (isset($_GET['awardId']) ? $_GET['awardId'] : null);

$awardedName = "         ";
$awardedFrom = "Serpen's Test";

require_once( "fpdf/fpdf.php" );
$pdf = new FPDF( 'L', 'mm', 'Letter' );
$pdf->AddPage();
$pdf->Image( "images/EOYAwardBackground.png", 0, 0, 280 );
$pdf->Ln(14);
$pdf->SetFont('Arial','B', 8);
$pdf->Cell(0,0, $version . "           ",0,1,'R');
$pdf->Ln(35);
$pdf->SetFont('Arial','B',48);
$pdf->Cell(0,0,'Employee of the Year',0,1,'C');

//Awarded To
$pdf->Ln(30);
$pdf->SetFont('Arial','B',32);
$pdf->Cell(0,0,'Awarded To',0,1,'C');

//Awarded To Name
$pdf->Ln(30);
$pdf->SetFont('Arial','U',48);
$pdf->Cell(0,0,$awardId,0,1,'C');

//Awarded To Name
$pdf->SetXY(24,180);
$pdf->SetFont('Arial','B',20);
$pdf->Cell(100,0,"From: ____________________",0,0,'L');
$pdf->SetX(140);
$pdf->Cell(100,0,"Signature: ____________________ ",0,0,'L');

$pdf->SetXY(47,180);
$pdf->Cell(100,0,$awardedFrom,0,0,'L');

//snake signature
$pdf->Image( "images/SerpensTestSig.png", 175, 160, 80 );

$pdf->Output("pdftest.pdf","I");
?>
