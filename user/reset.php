<?php
require 'connect.php';

if(!empty($_POST)){

	if (empty($_POST['password-old'])) {
		$err_msg[] = 'Please enter your old password.';
	}
	
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
			<a class="navbar-brand" href="index.html">Employee Recognition</a>
		</div>
		<div class="collapse navbar-collapse" id="myNavbar">
			<ul class="nav navbar-nav navbar-right">
				<li><a href="register.php"><span class="glyphicon glyphicon-user"></span> Register</a></li>
				<li><a href="login.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
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
			<form id="loginform" class="form-horizontal" action="register.php" method="post" enctype="multipart/form-data">           
 				<div style="margin-bottom: 15px" class="input-group">
					<span class="input-group-addon"><span class="glyphicon glyphicon-chevron-right"></span></span>
					<input id="register-password" type="password" class="form-control" name="password-old" placeholder="Old Password" required />
				</div>
				
				<div style="margin-bottom: 15px" class="input-group">
					<span class="input-group-addon"><span class="glyphicon glyphicon-chevron-right"></span></span>
					<input id="register-password" type="password" class="form-control" name="password" placeholder="New Password" required />
				</div>

				<div style="margin-bottom: 15px" class="input-group">
					<span class="input-group-addon"><span class="glyphicon glyphicon-chevron-right"></span></span>
					<input id="register-password-confirm" type="password" class="form-control" name="password-confirm" placeholder="Confirm New Password" required />
				</div>

				<div style="margin-top:5px" class="form-group">
					<div class="col-sm-12 controls">
						<input type="submit" value="Register" name ="register" class="btn btn-primary" />
					</div>
				</div>
				
			</form>

		</div>                     
	</div>  
</div>

</body>
</html>
