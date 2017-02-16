<?php 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if(!isset($_SESSION['admin'])){
	header("Location: ../php/adminLogout.php"); 
	die();
} 
$editUserEmail = $_SESSION['editUserEmail'];
$editUserName = $_SESSION['editUserName'];

?>

<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Edit Admin User</title>
    
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css">

	<!-- Latest compiled and minified JavaScript -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

<script>
function isEmail(email) {
	var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	return regex.test(email);
}
function validPassword(password) {
	var regex = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,16}$/;
	return regex.test(password);
}
function validName(name) {
	var regex = /^[a-zA-Z ]{2,30}$/;
	return regex.test(name);
}
function checkEmailMatch() {
    var oldEmail = $("#OldEmail").val();
    var newEmail = $("#NewEmail").val();
	
	if (newEmail.length == 0){
		$('#email_message').html('').css('color', 'red');
		$('#email-btn').prop('disabled', true);
	} else if (!isEmail(newEmail) ){
		$('#email_message').html('not a valid email').css('color', 'red');
		$('#email-btn').prop('disabled', true);
    }else if (oldEmail == newEmail) {
        $('#email_message').html('must enter a new email').css('color', 'red');
		$('#email-btn').prop('disabled', true);
    } else {
        $('#email_message').html('');
		$('#email-btn').prop('disabled', false);
	}	
}
function checkPasswordMatch() {
    var password = $("#NewPassword").val();
    var confirmPassword = $("#ConfirmPassword").val();
	
	if (password.length == 0){
		$('#new_password_message').html('');
		$('#password-btn').prop('disabled', true);
		return;
	} else if (password.length < 8){
		$('#new_password_message').html('');
		$('#ConfirmPassword').prop('disabled', true);
		return;
	} else if (!validPassword(password)){
		$('#new_password_message').html('not a valid password').css('color', 'red');
		$('#password-btn').prop('disabled', true);
		$('#ConfirmPassword').prop('disabled', true);
		return;
	} else {
		$('#new_password_message').html('');
		$('#password-btn').prop('disabled', false);
		$('#ConfirmPassword').prop('disabled', false);
	}
	
	if (confirmPassword.length == 0){
		$('#confirm_password_message').html('');
		$('#password-btn').prop('disabled', true);
		return;
	} else if (password != confirmPassword) {
        $('#confirm_password_message').html('Passwords do not match').css('color', 'red');
		$('#password-btn').prop('disabled', true);
    } else {
		$('#new_password_message').html('');
		$('#confirm_password_message').html('');
		$('#password-btn').prop('disabled', false);
	}
       
}
function checkNameMatch() {
    var oldFName = $("#OldFName").val();
    var newFName = $("#NewFName").val();
	
	if (newFName.length == 0 && newLName.length == 0){
		$('#fname_message').html('');
		$('#lname_message').html('');
		$('#name-btn').prop('disabled', true);
		return;
	} 
	
	if (newFName.length == 0){
		$('#fname_message').html('');
		return
	} else if (!validName(newFName)){
		$('#fname_message').html('invalid new First Name').css('color', 'red');
		$('#name-btn').prop('disabled', true);
		return;
	} else {
		$('#fname_message').html('');
		$('#name-btn').prop('disabled', false);
	}
	
}
$(document).ready(function () {
	$("#newEmail").keyup(function() {
		checkEmail($(this));
	});
	$("#NewPassword, #ConfirmPassword").keyup(function() {
		checkPasswordMatch($(this));
	});
	$("#NewFName).keyup(function() {
		checkNameMatch($(this));
	});
});
</script>
<div class="container">
	<div class="row">
		<section class="col-xs-offset-2 col-xs-8">
			<h1 class="text-center">Edit Admin Account</h1>
		</section>
	</div>
    <div class="row">
		<section class="col-xs-offset-2 col-xs-8">
			<div class="panel-group" id="accordion">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h4 class="panel-title">
							<a data-toggle="collapse" data-parent="#accordion" href="#collapseEmail">
							</span>CHANGE EMAIL</a>
						</h4>
					</div>
					<div id="collapseEmail" class="panel-collapse collapse">
						<div class="panel-body">
							<form id="email" class="form-horizontal" action="editUser.html"
							  onsubmit="return validateEmailForm();" method="post">
								<div class="row">
									<div class="form-group">
										<label class="col-sm-3" for="OldEmail">
										  Current Email address
										</label>
										<div class="col-sm-7">
											<input type="email" class="form-control" onChange="checkEmailMatch();"
											id="OldEmail" value="a@a.com" readonly="readonly">
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3" for="NewEmail">
										  New Email address
										</label>
										<div class="col-sm-7">
											<input type="email" class="form-control" onChange="checkEmailMatch();"
											id="NewEmail" placeholder="New Email" required>
											<span id='email_message'></span>
										</div>
									</div>
									<div class="form-group">
										<div class="col-sm-offset-3 col-sm-3">
											<button type="submit" id="email-btn"
											class="btn btn-default" disabled>Change Email</button>
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
				
				<div class="panel panel-default">
					<div class="panel-heading">
						<h4 class="panel-title">
							<a data-toggle="collapse" data-parent="#accordion" href="#collapsePassword">
							</span>CHANGE PASSWORD</a>
						</h4>
					</div>
					<div id="collapsePassword" class="panel-collapse collapse">
						<div class="panel-body">
							<form id="password" class="form-horizontal" action="editUser.html"
							onsubmit="return validatePasswordForm();" method="post">
								<div class="row">
									<div class="form-group">
										<label class="col-sm-3" for="NewPassword">
										  New Password
										</label>
										<div class="col-sm-7">
											<input type="password" class="form-control" onChange="checkPasswordMatch($(this));"
											id="NewPassword" maxlength="16" required>
											<span id='new_password_message'></span>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3" for="ConfirmPassword">
										  Re-Enter Password
										</label>
										<div class="col-sm-7">
											<input type="password" class="form-control" onChange="checkPasswordMatch($(this));"
											id="ConfirmPassword" maxlength="16" disabled required>
											<span id='confirm_password_message'></span>
										</div>
									</div>
									<div class="form-group">
										<div class="col-sm-offset-3 col-sm-3">
											<button type="submit" id="password-btn"
											class="btn btn-default" disabled>Change Password</button>
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
				
				<div class="panel panel-default">
					<div class="panel-heading">
						<h4 class="panel-title">
							<a data-toggle="collapse" data-parent="#accordion" href="#collapseName">
							</span>CHANGE NAME</a>
						</h4>
					</div>
					<div id="collapseName" class="panel-collapse collapse">
						<div class="panel-body">
							<form class="form-horizontal" id="name" action="editUser.html"
							onsubmit="return validateUserForm();" method="post">
								<div class="row">
									<div class="form-group">
										<label class="col-sm-3" for="OldFName">
											Current Full Name
										</label>
										<div class="col-sm-7">
											<input type="text" class="form-control"
												id="OldFName" value="Firstname" readonly="readonly">
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3" for="NewFName">
											New Full Name
										</label>
										<div class="col-sm-7">
											<input type="text" class="form-control" onChange="checkNameMatch();"
												id="NewFName">
											<span id='fname_message'></span>
										</div>
									</div>
									<div class="form-group">
										<div class="col-sm-offset-3 col-sm-3">
											<button type="submit" id="name-btn"
											class="btn btn-default" disabled>Change Name</button>
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<div class="row">
		<section class="col-xs-offset-5 col-xs-2">
			<a href="admin.html" role="button" class="btn btn-primary">Return to Admin</a>
		</section>
	</div>
</div>

</body>
</html>
