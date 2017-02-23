
<?php

	$version = 'v4.6';

	$awardGivenId = (isset($_GET['awardGivenId']) ? $_GET['awardGivenId'] : null);
	$host = "cs496osusql.database.windows.net";
	$user = "Serpins_Login";
	$pwd = "T3amSerpin$!";
	$db = "OSU_Capstone";
	
	if ($awardGivenId < 1)
	{
		echo "<p>Award not found.</p>";
		break;
	}
	else
	{
		try{
			 $conn = new PDO( "sqlsrv:Server= $host ; Database = $db ", $user, $pwd);
		  }
		 catch(Exception $e){
			 die(print_r($e));
		 }
		 
		if($conn)
		{
			$sql_select = 
				" 	SELECT ag.AwardId, userTo.FullName AS UserToFullname, userFrom.FullName AS UserFromFullname,
						userFrom.SignatureURL, aws.AwardTypeName
					FROM [dbo].[AwardsGiven] AS ag
					JOIN [dbo].[UserAccount] AS userTo ON userTo.UserId = ag.AwardedToUserId
					JOIN [dbo].[UserAccount] AS userFrom ON userFrom.UserId = ag.AwardGivenByUserId
					JOIN [dbo].[Awards] AS aws ON aws.AwardId = ag.AwardId
					WHERE ag.AwardGivenId = " . (string)$awardGivenId;
					
			$stmt = $conn->query($sql_select);
			$awards = $stmt->fetchAll();
			if(count($awards) > 0) {
				foreach($awards as $award) {
					$awardId = $award['AwardId'];
					$userToFullname = $award['UserToFullname'];
					$userFromFullname = $award['UserFromFullname'];
					$signatureURL = $award['SignatureURL'];
					$awardType = $award['AwardTypeName'];
				}
				
				$awardedFrom = "Serpen's Test";

				require_once( "../fpdf/fpdf.php" );
				$pdf = new FPDF( 'L', 'mm', 'Letter' );
				$pdf->AddPage();
				$pdf->Image( "../images/EOYAwardBackground.png", 0, 0, 280 );
				$pdf->Ln(14);
				$pdf->SetFont('Arial','B', 8);
				$pdf->Cell(0,0, $version . "           ",0,1,'R');
				$pdf->Ln(35);
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

				//Awarded To Name
				$pdf->SetXY(24,180);
				$pdf->SetFont('Arial','B',20);
				$pdf->Cell(100,0,"From: ____________________",0,0,'L');
				$pdf->SetX(140);
				$pdf->Cell(100,0,"Signature: ____________________ ",0,0,'L');

				$pdf->SetXY(47,180);
				$pdf->Cell(100,0,$userFromFullname,0,0,'L');

				//snake signature
				$pdf->Image( "../".$signatureURL, 175, 160, 80 );

				$pdf->Output("EOMAward.pdf","I");
						
						
			}	
			else {
				echo "<p>Award not found.</p>";
			} 
		}
	}
?>
