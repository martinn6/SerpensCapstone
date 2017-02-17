<?php
require 'connect.php';

if(empty($_SESSION['user'])){
	header("Location: login.php"); 
	die();
} 

$fname = '';

if ($conn){
	$query = "SELECT * FROM dbo.UserAccount WHERE UserId = :UserId";
	$query_params = array(':UserId' => $_SESSION['user']);
	$stmt = $conn->prepare($query);
	$result = $stmt->execute($query_params) or die();
	$row = $stmt->fetch();

	$fname = $row['FullName'];
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
			<a class="navbar-brand" href="index.html">Employee Recognition</a>
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
			<div class="panel-title">User Profile</div>	
		</div>     

		<div style="padding-top:15px" class="panel-body" >
			<form id="loginform" class="form-horizontal">           
				<div style="margin-bottom: 15px" class="input-group">
					<span class="input-group-addon"><span class="glyphicon glyphicon-chevron-right"></span></span>
					<input id="register-fname" type="text" class="form-control" name="fname" placeholder="Full Name" value="<?php echo $fname; ?>">                                        
				</div>
                                
				<div style="margin-bottom: 15px" class="input-group">
					<span class="input-group-addon"><span class="glyphicon glyphicon-chevron-right"></span></span>
					<input id="register-password" type="password" class="form-control" name="password" placeholder="New Password">
				</div>

				<div style="margin-bottom: 15px" class="input-group">
					<span class="input-group-addon"><span class="glyphicon glyphicon-chevron-right"></span></span>
					<input id="register-password2" type="password" class="form-control" name="password2" placeholder="Confirm New Password">
				</div>
				<img src="images/signature.jpg" />
				<div style="margin-bottom: 15px" class="input-group">
					<span class="input-group-addon"><span class="glyphicon glyphicon-chevron-right"> </span></span>
					<label class="btn btn-default btn-file">
						Upload New Signature<input type="file" class="hidden">
					</label>
				</div>

				<div style="margin-top:5px" class="form-group">
					<div class="col-sm-12 controls">
						<a id="btn-login" href="#" class="btn btn-primary">Save</a>
					</div>
				</div>
				
				<div class="form-group">
					<div class="col-md-12 control">
						<div style="border-top: 1px solid #BABABA; padding-top:10px">
							<a href="main.php">Back to Menu</a>
						</div>
					</div>
				</div>
			</form>
			
		</div>                     
	</div>  
</div>

</body>
</html>
