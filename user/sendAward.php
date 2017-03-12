<?php
require 'connect.php';
require '../PHPMailer/PHPMailerAutoload.php';

if(empty($_SESSION['user']) or $_SESSION['userType'] != 1){
	header("Location: login.php"); 
	die();
} 

if ($conn){
	$query = "SELECT * FROM AwardsGiven WHERE AwardGivenId = :AwardGivenId";
	$query_params = array(':AwardGivenId' => $_SESSION['AwardGivenId']);
	$stmt = $conn->prepare($query);
	$result = $stmt->execute($query_params) or die();
	$row = $stmt->fetch();

	$rewardtype = $row['AwardId'] == 0 ? "Employee of the Year" : "Employee of the Month";
	$recname = $row['AwardedToFullName'];
	$recemail = $row['AwardedToEmail'];
	$awardPDF = "GenerateAward.php?awardGivenId=" . $_SESSION['AwardGivenId'];
	$awardURL = "http://serpenscapstone.azurewebsites.net/user/GenerateAward.php?awardGivenId=" . $_SESSION['AwardGivenId'];
	$success = $stmt->closeCursor();
}

if(!empty($_POST)){
			date_default_timezone_set('America/Los_Angeles');
	
			$mail = new PHPMailer;
			$mail->isSMTP();
			$mail->SMTPDebug = 0;
			$mail->Debugoutput = 'html';
			$mail->Host = 'smtp.gmail.com';
			$mail->Port = 587;
			$mail->SMTPSecure = 'tls';
			$mail->SMTPAuth = true;
			$mail->Username = "serpenscapstone@gmail.com";
			$mail->Password = "T3amSerpin$!";
			$mail->setFrom('serpenscapstone@gmail.com', 'Employee Recognition');
			$mail->addAddress($recemail, $recname);
			$mail->Subject = 'Employee Recognition Award';
			$mail->isHTML(true);
			$mail->Body = "You received an employee recognition award. <a href=\"".$awardURL."\">Click Here</a> to download certificate.";

			if (!$mail->send()) {
				echo "Error: " . $mail->ErrorInfo;
			}
			
			header("Location: sendSuccess.php");
			die();
}
?>

<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Employee Recognition</title>

	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</head>

<body>
<nav class="navbar navbar-default">
	<div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
				<span class="glyphicon glyphicon-menu-hamburger"></span>                     
			</button>
			<a class="navbar-brand" href="../index.php">Employee Recognition</a>
		</div>
		<div class="collapse navbar-collapse" id="myNavbar">
			<ul class="nav navbar-nav navbar-right">
				<li><a href="profile.php"><span class="glyphicon glyphicon-user"></span> Profile</a></li>
				<li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
			</ul>
		</div>
	</div>
</nav>

<div id="menubox" style="margin-top:25px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">                    
	<div class="panel panel-default" >
		<div class="panel-heading">
			<div class="panel-title">Award Certificate</div>	
		</div>

		<div style="padding-top:15px" class="panel-body" >
			<table class="table "table-responsive"">
				<tbody>
					<tr>
						<td>Award:</td>
						<td><?php echo $rewardtype; ?></td>
					</tr>
					<tr>
						<td>Recipient:</td>
						<td><?php echo $recname; ?></td>
					</tr>
					<tr>
						<td>Email:</td>
						<td><?php echo $recemail; ?></td>
					</tr>
					<tr>
						<td>Preview:</td>
						<td><a href="<?php echo $awardPDF; ?>">View Award</a></td>
					</tr>
				</tbody>
			</table>
			
			<form id="entryform" class="form-horizontal" action="sendAward.php" method="post">          
				<div style="margin-top:5px" class="form-group">
					<div class="col-sm-12 controls">
						<input type="submit" value="send" name ="Send" class="btn btn-primary" />
					</div>
				</div>
				
				<div class="form-group">
					<div class="col-md-12 control">
						<div style="border-top: 1px solid #BABABA; padding-top:10px">
							<a href="main.php">Cancel</a>
						</div>
					</div>
				</div>
			</form>
			
		</div>                     
	</div>  
</div>

</body>
</html>
