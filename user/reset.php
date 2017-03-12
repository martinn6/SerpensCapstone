<?php
require 'connect.php';

$store_uid = $_GET['uid'];
$uid = null;

if(isset($_GET['uid'])) {
	if ($conn){
		$query = "SELECT * FROM UserAccount WHERE UserId = :UserId";
		$query_params = array(':UserId' => $_GET['uid']);
		$stmt = $conn->prepare($query);
		$stmt->execute($query_params);
		$row = $stmt->fetch();

		if($row) {
			$uid = $row['UserId'];
		}
	}
}

if(empty($uid)) {
	$err_msg[] = "Please check the password reset link in your email.";
}

if(!empty($_POST) and !empty($uid)) {
	if (empty($_POST['password'])) {
		$err_msg[] = 'Please enter a password.';
	}
	
	if (empty($_POST['password-confirm'])) {
		$err_msg[] = 'Please confirm your password.';
	}
	
	if (!empty($_POST['password']) && !empty($_POST['password-confirm'])) {
		if ($_POST['password'] !== $_POST['password-confirm']) {
			$err_msg[] = 'Passwords do not match. Re-enter passwords.';
		}
	}
	
    if (!isset($err_msg)) {
		$password = md5($_POST['password']);

		if ($conn){
			$query = "UPDATE UserAccount SET Password = :Password "
                . "WHERE UserId = " . $uid;
			$query_params = array( 
				':Password' => $password
			);
			$stmt = $conn->prepare($query);
			$stmt->execute($query_params) or die();
		}
		
		header("location: resetSuccess.php");
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
			<div class="panel-title">Password Reset</div>	
		</div>     

		<div style="padding-top:15px" class="panel-body" >
		<?php
			if(isset($err_msg)){
				foreach($err_msg as $msg){
					echo '<div class="alert alert-danger">'.$msg.'</div>';
				}
			}
		?>
			<form id="loginform" class="form-horizontal" action="reset.php?uid=<?php echo $store_uid ?>" method="post">           
				<div style="margin-bottom: 15px" class="input-group">
					<span class="input-group-addon"><span class="glyphicon glyphicon-chevron-right"></span></span>
					<input id="reset-password" type="password" class="form-control" name="password" placeholder="New Password" required />
				</div>

				<div style="margin-bottom: 15px" class="input-group">
					<span class="input-group-addon"><span class="glyphicon glyphicon-chevron-right"></span></span>
					<input id="reset-password-confirm" type="password" class="form-control" name="password-confirm" placeholder="Confirm New Password" required />
				</div>

				<div style="margin-top:5px" class="form-group">
					<div class="col-sm-12 controls">
						<input type="submit" value="Submit" name ="Submit" class="btn btn-primary" />
					</div>
				</div>
				
			</form>

		</div>                     
	</div>  
</div>

</body>
</html>
