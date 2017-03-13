
<?php
date_default_timezone_set('America/Los_Angeles');

	require '../PHPMailer/PHPMailerAutoload.php';
	require_once( "../fpdf/fpdf.php" );

	$version = 'v6.0';

	//Get awardGivenId parameter from URL
	$awardGivenId = (isset($_GET['awardGivenId']) ? $_GET['awardGivenId'] : null);
	
	//SQL server login information
	$host = "cs496osusql.database.windows.net";
	$user = "Serpins_Login";
	$pwd = "T3amSerpin$!";
	$db = "OSU_Capstone";
	
	if (!$awardGivenId)
	{
		echo "<p>Error: Award not found. Have you tried turning your computer off and on again? If so, please contact your admin.</p>";
		exit(1);
	}
	else
	{
		//try connecting to server
		try{
			 $conn = new PDO( "sqlsrv:Server= $host ; Database = $db ", $user, $pwd);
		  }
		 catch(Exception $e){
			 die(print_r($e));
		 }
		 
		if($conn)
		{
			//SQL query to get award data
			$sql_select = 
				" 	SELECT ag.AwardId, ag.AwardedToFullName, ag.AwardedToEmail, userFrom.FullName AS UserFromFullname,
						userFrom.SignatureURL, aws.AwardTypeName, CONVERT(nvarchar(12),ag.AwardedDate,101) AS AwardedDateText
					FROM [dbo].[AwardsGiven] AS ag
					JOIN [dbo].[UserAccount] AS userFrom ON userFrom.UserId = ag.AwardGivenByUserId
					JOIN [dbo].[Awards] AS aws ON aws.AwardId = ag.AwardId
					WHERE ag.AwardGivenId = " . (string)$awardGivenId;
			
			//run query
			$stmt = $conn->query($sql_select);
			$awards = $stmt->fetchAll();
			
			if(count($awards) > 0) {
				foreach($awards as $award) {
					$awardId = $award['AwardId'];
					$userToFullname = $award['AwardedToFullName'];
					$userToEmail = $award['AwardedToEmail'];
					$userFromFullname = $award['UserFromFullname'];
					$signatureURL = $award['SignatureURL'];
					$awardType = $award['AwardTypeName'];
					$AwardedDate = $award['AwardedDateText'];
				}
				
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

				$filename = "../awards/EmployeeAward".$awardId.".pdf";
				$pdf->Output($filename,'F');
				
				
				//////////////////////////////////////////////////////
				// PDF GENEREATED. LETS SEND IT
				//////////////////////////////////////////////////////)
				
				//Create a new PHPMailer instance
				$mail = new PHPMailer;

				//Tell PHPMailer to use SMTP
				$mail->isSMTP();

				//Enable SMTP debugging
				// 0 = off (for production use)
				// 1 = client messages
				// 2 = client and server messages
				$mail->SMTPDebug = 2;

				//Ask for HTML-friendly debug output
				$mail->Debugoutput = 'html';

				//Set the hostname of the mail server
				$mail->Host = 'smtp.gmail.com';
				// use
				// $mail->Host = gethostbyname('smtp.gmail.com');
				// if your network does not support SMTP over IPv6

				//Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
				$mail->Port = 587;

				//Set the encryption system to use - ssl (deprecated) or tls
				$mail->SMTPSecure = 'tls';

				//Whether to use SMTP authentication
				$mail->SMTPAuth = true;

				//Username to use for SMTP authentication - use full email address for gmail
				$mail->Username = "serpenscapstone@gmail.com";

				//Password to use for SMTP authentication
				$mail->Password = "T3amSerpin$!";

				//Set who the message is to be sent from
				$mail->setFrom('serpenscapstone@gmail.com', 'serpens');

				//Set who the message is to be sent to
				$mail->addAddress($userToEmail, $userToFullname);

				//Set the subject line
				$mail->Subject = 'Congratulations! You recieved an employee award.';

				//Read an HTML message body from an external file, convert referenced images to embedded,
				//convert HTML into a basic plain-text alternative body
				$mail->msgHTML = "You have recieved an employee award from ".$UserFromFullname.". <BR>It has been attached to this email.";

				//Replace the plain text body with one created manually
				$mail->Body = "You have recieved an employee award from ".$UserFromFullname.". It has been attached to this email.";

				//attach pdf
				$mail -> Addattachment($filename, EmployeeAward.pdf, "base64", "application/pdf");
				
				//send the message, check for errors
				if (!$mail->send()) {
					echo "Mailer Error: " . $mail->ErrorInfo;
				} else {
					echo "Message sent!";
				}
			}	
			else {
				echo "<p>Error: Award not found. Have you tried turning your computer off and on again? If so, please contact your admin.</p>";
			} 
		}
	}
?>
