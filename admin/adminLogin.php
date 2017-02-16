<?php
require 'connect.php';

$form_email = '';
$err_msg = '';
$cred_match = false;

if (isset($_POST['submit'])){
	if ($conn){
		$query = "SELECT * FROM dbo.UserAccount WHERE Email = :Email";
		$query_params = array(':Email' => $_POST['email']);
		$stmt = $conn->prepare($query);
		$result = $stmt->execute($query_params) or die();
		$row = $stmt->fetch();

		if($row){
			if($_POST['password'] === $row['Password']){
				$cred_match = true;
			}
			if(md5($_POST['password']) === $row['Password']){
				$cred_match = true;
			}
		}
		
		if ($cred_match){
			$_SESSION['admin'] = $row;
			header("Location: admin.php"); 
			die();
		} else {
			$form_email = htmlentities($_POST['email']);
			$err_msg = "<div class='alert alert-danger'>Email/Password does not match. Try again.</div>";
		}
	}
} else {
	echo "fail!";
}
?>

</body>
</html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Serpens Admin Login</title>
  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/styles.css">
  </head>
<body>
<script src="../js/jquery-2.1.4.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
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
		$('#submitBtn').prop('disabled', true);
		return;
    } else if (!isEmail(email) ){
		$('#email_message').html('not a valid email');
		$('#submitBtn').prop('disabled', true);
		return;
	} else {
        $('#email_message').html('');
		$('#submitBtn').prop('disabled', false);
	}	
}

function checkPassword() {
    var password = $('#adminPassword').val();
	
	if (password.length == 0){
		$('#password_message').html('');
		$('#password-btn').prop('disabled', true);
		return;
	} else if (password.length < 8){
		$('#password_message').html('');

		return;
	} else if (!validPassword(password)){
		$('#password_message').html('not a valid password').css('color', 'red');
		$('#submitBtn').prop('disabled', true);
		return;
	} else {
		$('#password_message').html('');
		$('#submitBtn').prop('disabled', false);
	}
	       
}

$(document).ready(function(){
	
	$("#adminEmail").keyup(function() {
		checkEmail();	
	});
	$("#adminPassword ").keyup(function() {
		checkPasswordMatch();
	});
	$("#submitBtn").click(function(e){
		$("#resultSpan").html('').css('color', 'red');
		e.preventDefault();
		var url = "adminLogin.php";
		var password = $('#adminPassword').val();
		var email = $('#adminEmail').val();
		var data = {email: email, password: password}
		console.log(data);
		$.post(url, data, function(result){
			console.log(result);
		});
		
	});
	
});

</script>
<div class="container">
	<div class="row">
		<section class="col-xs-offset-3 col-xs-6">
			<h1>Admin Login Page</h1>
		</section>
	</div>
	<?php echo $err_msg; ?>
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
							placeholder="Email" value="<?php echo $form_email; ?>"
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