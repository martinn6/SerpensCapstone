<?php
require '/php/connect.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if(isset($_SESSION['user'])){
	header("Location: ../user/main.php"); 
	die();
} 

$form_email = '';
$pass_match = false;

if(!empty($_POST)){
	if (empty($_POST['email'])) {
		$err_msg[] = 'Please enter your email.';
	}

	if (empty($_POST['password'])) {
		$err_msg[] = 'Please enter your password.';
	}

	if (!isset($err_msg)) {
		if ($conn){
			$query = "SELECT * FROM UserAccount WHERE Email = :Email";
			$query_params = array(':Email' => $_POST['email']);
			$stmt = $conn->prepare($query);
			$result = $stmt->execute($query_params) or die();
			$row = $stmt->fetch();

			if($row){
				if(md5($_POST['password']) === $row['Password'] and $row['IsActive'] == 1 and $row['UserTypeId'] = 1) {
					$pass_match = true;
				}
			}

			if ($pass_match){
				$_SESSION['user'] = $row['UserId'];
				$_SESSION['userType'] = $row['UserTypeId'];
				header("Location: main.php"); 
				die();
			} else {
				$form_email = htmlentities($_POST['email']);
				$err_msg[] = "Email/Password is not valid. Try again.";
			}
		}
	}
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
				<li><a href="../user/register.php"><span class="glyphicon glyphicon-user"></span> Register</a></li>
				<li><a href="../user/login.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
				<li><a href="../admin/adminLogin.php"><span class="glyphicon glyphicon-log-in"></span> Admin</a></li>
			</ul>
		</div>
	</div>
</nav>

<div id="loginbox" style="margin-top:50px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">                    
	<div class="panel panel-default" >
		<div class="panel-heading">
			<div class="panel-title">Sign In</div>	
		</div>     

		<div style="padding-top:15px" class="panel-body" >
		<?php
			if(isset($err_msg)){
				foreach($err_msg as $msg){
					echo '<div class="alert alert-danger">'.$msg.'</div>';
				}
			}
		?>
			<form id="loginform" class="form-horizontal" action="login.php" method="post">           
				<div style="margin-bottom: 15px" class="input-group">
					<span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
					<input id="login-email" type="text" class="form-control" name="email" placeholder="Email" value="<?php echo $form_email; ?>" required />                                        
				</div>
                                
				<div style="margin-bottom: 15px" class="input-group">
					<span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
					<input id="login-password" type="password" class="form-control" name="password" placeholder="Password" required />
				</div>

				<div style="margin-top:5px" class="form-group">
					<div class="col-sm-12 controls">
						<input type="submit" value="Login" name = "login" class="btn btn-primary" />
					</div>
				</div>
				
				<div class="form-group">
					<div class="col-md-12 control">
						<div style="border-top: 1px solid #BABABA; padding-top:10px">
							<a href="register.php">Create New Account</a>
						</div>
						<div style="float:left; position: relative"><a href="recovery.php">Forgot Password?</a></div>
					</div>
				</div>
			</form>
			
		</div>                     
	</div>  
</div>

</body>
</html>
