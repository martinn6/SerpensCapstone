<?php 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if(!isset($_SESSION['admin'])){
	header("Location: ../php/adminLogout.php"); 
	die();
} 
if(!isset($_SESSION['editUser']['editName']) || !isset($_SESSION['editUser']['editEmail'])){
	header("Location: admin.php"); 
	die();
} 
$user = $_SESSION['admin']['name'];
$editUserName = $_SESSION['editUser']['editName'];
$editUserEmail = $_SESSION['editUser']['editEmail'];

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
		return false;
	} else if (!isEmail(newEmail) ){
		$('#email_message').html('not a valid email').css('color', 'red');
		return false;
    }else if (oldEmail == newEmail) {
        $('#email_message').html('must enter a new email').css('color', 'red');
		return false;
    } else {
        $('#email_message').html('');
		return true;
	}	
}
function checkPasswordMatch() {
    var password = $("#NewPassword").val();
    var confirmPassword = $("#ConfirmPassword").val();
	
	if (password.length == 0){
		$('#new_password_message').html('');
		return false;
	} else if (password.length < 8){
		$('#new_password_message').html('');
		$('#ConfirmPassword').prop('disabled', true);
		return false;
	} else if (!validPassword(password)){
		$('#new_password_message').html('not a valid password').css('color', 'red');
		$('#ConfirmPassword').prop('disabled', true);
		return false;
	} else {
		$('#new_password_message').html('');
		$('#ConfirmPassword').prop('disabled', false);
	}
	
	if (confirmPassword.length == 0){
		$('#confirm_password_message').html('');
		return false;
	} else if (password != confirmPassword) {
        $('#confirm_password_message').html('Passwords do not match').css('color', 'red');
		return false;
    } else {
		$('#new_password_message').html('');
		$('#confirm_password_message').html('');
	  	return true;
	}
       
}
function checkNameMatch() {
    var oldName = $("#OldName").val();
    var newName = $("#NewName").val();
	
	if (newName.length == 0){
		$('#fname_message').html('');
		return false;
	} else if (!validName(newName)){
		$('#fname_message').html('invalid new Full Name').css('color', 'red');
		return false;
	} else {
		$('#fname_message').html('');
		return true;
	}
	
}

$(document).ready(function () {
	$("#NewEmail").keyup(function() {
		if(checkEmailMatch()){
			$('#email-btn').prop('disabled', false);
		} else {
			$('#email-btn').prop('disabled', true);
		}
	});
	$("#NewPassword, #ConfirmPassword").keyup(function() {
		if(checkPasswordMatch()){
			$('#password-btn').prop('disabled', false);
		} else {
			$('#password-btn').prop('disabled', true);
		}
	});
	$("#NewName").keyup(function() {
		if(checkNameMatch()){
			$('#name-btn').prop('disabled', false);
		} else {
			$('#name-btn').prop('disabled', true);
		}
	});
	$(document).click(function() {
		$('#error_msg').prop('hidden', true);
		$('#success_msg').prop('hidden', true);
	});
	
	$("#email-btn").click(function(e){
		$("#resultSpan").html('');
		e.preventDefault();
		var url = "../php/editEmail.php";
		var newEmail = $('#NewEmail').val();
		var oldEmail = '<?php echo $editUserEmail; ?>';
		var data = {newEmail: newEmail}
		$.post(url, data, function(result){
			if(!result){
				$('#success_msg').html("Email Update Successful").prop('hidden', false);
				$('#OldEmail').val(newEmail);
				$('#NewEmail').val("");
				$('#email-btn').prop('disabled', true);
			} else {
				$('#error_msg').html(result).prop('hidden', false);	
			}
		});
	});

		$("#password-btn").click(function(e){
		$("#resultSpan").html('');
		e.preventDefault();
		var url = "../php/editPassword.php";
		var password = $('#NewPassword').val();
		var oldEmail = '<?php echo $editUserEmail; ?>';
		var data = {password: password}
		$.post(url, data, function(result){
			if(!result){
				$('#success_msg').html("Password Update Successful").prop('hidden', false);
				$('#NewPassword').val("");
				$('#ConfirmPassword').val("").prop('disabled', true);
				$('#password-btn').prop('disabled', true);
			} else {
				$('#error_msg').html(result).prop('hidden', false);	
			}
		});
	});
	
	$("#name-btn").click(function(e){
		$("#resultSpan").html('');
		e.preventDefault();
		var url = "../php/editName.php";
		var name = $('#NewName').val();
		var oldEmail = '<?php echo $editUserEmail; ?>';
		var data = {name: name}
		$.post(url, data, function(result){
			if(!result){
				$('#success_msg').html("Name Update Successful").prop('hidden', false);
				$('#titleName').html(name);
				$('#OldName').val(name);
				$('#NewName').val("");
				$('#name-btn').prop('disabled', true);
			} else {
				$('#error_msg').html(result).prop('hidden', false);	
			}
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
				<li><a href="../php/adminLogout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
			</ul>
		</div>
	</div>
</nav>
<div class='alert alert-danger' id="error_msg" hidden></div>
<div class='alert alert-success' id="success_msg" hidden></div>	
<div class="container">
	<div class="row">
		<section class="col-xs-offset-2 col-xs-8">
			<h1 class="text-center">Edit '<span id="titleName"><?php echo $editUserName; ?></span>' Account</h1>
		</section>
	</div>
    <div class="row">
		<section class="col-xs-offset-2 col-xs-8">
			<div class="panel-group" id="accordion">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h4 class="panel-title">
							<a data-toggle="collapse" data-parent="#accordion" href="#collapseEmail">
							CHANGE EMAIL</a>
						</h4>
					</div>
					<div id="collapseEmail" class="panel-collapse collapse">
						<div class="panel-body">
							<form id="email" class="form-horizontal" action="">
								<div class="row">
									<div class="form-group">
										<label class="col-sm-3" for="OldEmail">
										  Current Email address
										</label>
										<div class="col-sm-7">
											<input type="text" class="form-control"
											id="OldEmail" value="<?php echo $editUserEmail; ?>" readonly="readonly">
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3" for="NewEmail">
										  New Email address
										</label>
										<div class="col-sm-7">
											<input type="email" class="form-control"
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
							CHANGE PASSWORD</a>
						</h4>
					</div>
					<div id="collapsePassword" class="panel-collapse collapse">
						<div class="panel-body">
							<form id="password" class="form-horizontal" action="">
								<div class="row">
									<div class="form-group">
										<label class="col-sm-3" for="NewPassword">
										  New Password
										</label>
										<div class="col-sm-7">
											<input type="password" class="form-control"
											id="NewPassword" maxlength="16" required>
											<span id='new_password_message'></span>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3" for="ConfirmPassword">
										  Re-Enter Password
										</label>
										<div class="col-sm-7">
											<input type="password" class="form-control"
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
							CHANGE NAME</a>
						</h4>
					</div>
					<div id="collapseName" class="panel-collapse collapse">
						<div class="panel-body">
							<form class="form-horizontal" id="name" action="">
								<div class="row">
									<div class="form-group">
										<label class="col-sm-3" for="OldName">
											Current Full Name
										</label>
										<div class="col-sm-7">
											<input type="text" class="form-control"
												id="OldName" value="<?php echo $editUserName; ?>" readonly="readonly">
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3" for="NewName">
											New Full Name
										</label>
										<div class="col-sm-7">
											<input type="text" class="form-control"
												id="NewName">
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
			<a href="admin.php" role="button" class="btn btn-primary">Return to Admin</a>
		</section>
	</div>
</div>

</body>
</html>
