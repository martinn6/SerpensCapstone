<?php
?>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Serpens Admin Login</title>
  
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css">

	<!-- Latest compiled and minified JavaScript -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  </head>
<body>
<script src="../js/script.js"></script>
<script>
function isEmail(email) {
	var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	return regex.test(email);
}

function validPassword(password) {
	var regex = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,16}$/;
	return regex.test(password);
}

function checkEmail() {
    var email = $('#adminEmail').val();
	
	if (email.length < 6) {
		$('#email_message').html('');
		return false;
    } else if (!isEmail(email) ){
		$('#email_message').html('not a valid email').css('color', 'red');
		return false;
	} else {
        $('#email_message').html('');
		return true;
	}	
}

function checkPassword() {
    var password = $('#adminPassword').val();
	
	if (password.length == 0){
		$('#password_message').html('');
		return false;
	} else if (password.length < 8){
		$('#password_message').html('');
		return false;
	} else if (!validPassword(password)){
		$('#password_message').html('not a valid password').css('color', 'red');
		return false;
	} else {
		$('#password_message').html('');
		return true;
	}
	       
}

$(document).ready(function(){
	
	$("#adminEmail, #adminPassword").keyup(function() {
		if (checkEmail() && checkPassword()){
			$('#submitBtn').prop('disabled', false);
		} else {
			$('#submitBtn').prop('disabled', true);
		}
	});

	$("#submitBtn").click(function(e){
		$("#resultSpan").html('');
		e.preventDefault();
		var url = "../php/adminLogin.php";
		var password = $('#adminPassword').val();
		var email = $('#adminEmail').val();
		var data = {email: email, password: password}
		$.post(url, data, function(result){
			console.log(result);
			$('#error_msg').toggle().append(result);
		});
		
	});
});

</script>
<nav class="navbar navbar-default">
	<div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
				<span class="glyphicon glyphicon-menu-hamburger"></span>                     
			</button>
			<a class="navbar-brand" href="../index.html">Employee Recognition</a>
		</div>
		<div class="collapse navbar-collapse" id="myNavbar">
			<ul class="nav navbar-nav navbar-right">
				<li><a href="adminLogin.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
			</ul>
		</div>
	</div>
</nav>
<div class='alert alert-danger' id="error_msg" hidden></div>;
<div class="container">
	<div class="row">
		<section class="col-xs-offset-3 col-xs-6">
			<h1>Admin Login Page</h1>
		</section>
	</div>
	<div class="row">
		<section class="col-xs-offset-2 col-xs-8">
			<form class="form-horizontal" action="" method="post" id="loginForm">
				<div class="row">
					<div class="form-group">
						<label class="col-sm-2" for="adminEmail">
						Email address
						</label>
						<div class="col-sm-10">
							<input type="email" class="form-control" name="email" onChange="checkEmail()"
							placeholder="Email" value=""
							id="adminEmail" required>
							<span id='email_message'></span>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2" for="adminPassword">
						Password
						</label>
						<div class="col-sm-10">
							<input type="password" class="form-control" name="password" onChange="checkPassword()"
							id="adminPassword" placeholder="Password" required>
							<span id='password_message'></span>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							<button type="submit" id="submitBtn" disabled
							class="btn btn-default">Sign in</button>
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="col-md-12 control">
						<div style="float:left; position: relative"><a href="recovery.php">Forgot Password?</a></div>
					</div>
				</div>
			</form>
		</section>
	</div> 
</div>
</body>
</html>