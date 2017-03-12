<?php
require 'connect.php';
require '../PHPMailer/PHPMailerAutoload.php';

$form_email = '';
$err_msg = '';

if(!empty($_POST)){
	if ($conn){
		$query = "SELECT * FROM dbo.UserAccount WHERE Email = :Email";
		$query_params = array(':Email' => $_POST['email']);
		$stmt = $conn->prepare($query);
		$result = $stmt->execute($query_params) or die();
		$row = $stmt->fetch();

		if($row){
			date_default_timezone_set('America/Los_Angeles');
			$resetLink = "http://serpenscapstone.azurewebsites.net/user/reset.php?uid=" . $row['UserId'];
	
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
			$mail->addAddress($row['Email'], $row['FullName']);
			$mail->Subject = 'Employee Recognition - Password Recovery';
			$mail->isHTML(true);
			$mail->Body = "This is a password recovery email message. <a href=\"" . $resetLink . "\">Click Here</a> to reset password.";

			if (!$mail->send()) {
				echo "Error: " . $mail->ErrorInfo;
			}
			
			header("Location: recoverySuccess.php");
			die();
			
		} else {
			$form_email = htmlentities($_POST['email']);
			$err_msg = "<div class='alert alert-danger'>This account does not exist. Try again.</div>";
		}
	}
}
?>

<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Employee Recognition</title>

	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css">

	<!-- Latest compiled and minified JavaScript -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
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
				<li><a href="register.php"><span class="glyphicon glyphicon-user"></span> Register</a></li>
				<li><a href="login.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
				<li><a href="../admin/adminLogin.php"><span class="glyphicon glyphicon-log-in"></span> Admin</a></li>
			</ul>
		</div>
	</div>
</nav>

<div id="loginbox" style="margin-top:50px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">                    
	<div class="panel panel-default" >
		<div class="panel-heading">
			<div class="panel-title">Account Recovery</div>	
		</div>     

		<div style="padding-top:15px" class="panel-body" >
        <?php echo $err_msg; ?>                    
			<form id="recoveryform" class="form-horizontal" action="recovery.php" method="post">             
				<div style="margin-bottom: 15px" class="input-group">
					<span class="input-group-addon"><span class="glyphicon glyphicon-chevron-right"></span></span>
					<input id="recovery-email" type="text" class="form-control" name="email" placeholder="Email" value="<?php echo $form_email; ?>" />                                        
				</div>

				<div style="margin-top:5px" class="form-group">
					<div class="col-sm-12 controls">
						<input type="submit" value="submit" name ="Submit" class="btn btn-primary" />
					</div>
				</div>
				
				<div class="form-group">
					<div class="col-md-12 control">
						<div style="border-top: 1px solid #BABABA; padding-top:10px" >
							<a href="../index.php">Back to Login</a>
						</div>
					</div>
				</div>
			</form>
			
		</div>                     
	</div>  
</div>

</body>
</html>
