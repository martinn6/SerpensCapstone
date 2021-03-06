<?php
	require 'connect.php';
	require_once( "../fpdf/fpdf.php" );

	$version = 'v5.1';

	//Get awardGivenId parameter from URL
	$awardGivenId = (isset($_GET['awardGivenId']) ? $_GET['awardGivenId'] : null);
	
	if (!$awardGivenId){
		echo "<p>Error: Award not found. </p>";
		exit(1);
	}
	else {
		if($conn){
			//SQL query to get award data
			$sql_select = 
				" 	SELECT ag.AwardId, ag.AwardedToEmail, ag.AwardedToFullName, userFrom.FullName AS UserFromFullname,
						userFrom.SignatureURL, aws.AwardTypeName, CONVERT(nvarchar(12),ag.AwardedDate,101) AS AwardedDateText
					FROM AwardsGiven AS ag
					JOIN UserAccount AS userFrom ON userFrom.UserId = ag.AwardGivenByUserId
					JOIN Awards AS aws ON aws.AwardId = ag.AwardId
					WHERE ag.AwardGivenId = " . (string)$awardGivenId;
			
			//run query
			$stmt = $conn->query($sql_select);
			$award = $stmt->fetch();
			
			$awardId = $award['AwardId'];
			$userToFullname = $award['AwardedToFullName'];
			$userFromFullname = $award['UserFromFullname'];
			$signatureURL = $award['SignatureURL'];
			$awardType = $award['AwardTypeName'];
			$AwardedDate = $award['AwardedDateText'];
				
			//generate PDF using FPDF
			$pdf = new FPDF( 'L', 'mm', 'Letter' );
			$pdf->AddPage();
			
			//award background
			$pdf->Image( "../images/EOYAwardBackground.png", 0, 0, 280 );
			$pdf->Ln(14);
			
			//output version
			$pdf->SetFont('Arial','B', 8);
			$pdf->Cell(0,0, $version . "           ",0,1,'R');
			$pdf->Ln(35);
			
			//output award type
			$pdf->SetFont('Arial','B',48);
			$pdf->Cell(0,0, $awardType,0,1,'C');

			//Awarded To
			$pdf->Ln(30);
			$pdf->SetFont('Arial','B',32);
			$pdf->Cell(0,0,'Awarded To',0,1,'C');

			//Awarded To Name
			$pdf->Ln(30);
			$pdf->SetFont('Arial','U',48);
			$pdf->Cell(0,0,$userToFullname,0,1,'C');
			
			//Awarded Date
			$pdf->Ln(30);
			$pdf->SetFont('Arial','B',24);
			$pdf->Cell(0,0,"on: " . $AwardedDate,0,1,'C');

			//From and Signature Lines
			$pdf->SetXY(24,180);
			$pdf->SetFont('Arial','B',20);
			$pdf->Cell(100,0,"From: ____________________",0,0,'L');
			$pdf->SetX(140);
			$pdf->Cell(100,0,"Signature: ____________________ ",0,0,'L');

			//output from fullname
			$pdf->SetXY(47,180);
			$pdf->Cell(100,0,$userFromFullname,0,0,'L');

			//output signature image
			$pdf->Image($signatureURL, 175, 160, 80 );

			$filename = "../awards/EmployeeAward".$awardGivenId.".pdf";
			$pdf->Output($filename,'F');
			
			header("location: sendAward.php");
		}
	}
?>
