<?php 
if(session_status() == PHP_SESSION_NONE){
	header("Location: ../php/adminLogout.php"); 
	die();
} 
require '../php/getName.php';

?>

<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Serpens Admin Portal</title>
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
function validName(name) {
	var regex = /^[a-zA-Z ]{1,30}$/;
	return regex.test(name);
}
function checkEmail(thisObj) {
    var email = thisObj.val();
	var button = thisObj.closest("form").find('.btn');
	var message = thisObj.parent().children('span');
	
	if (email.length < 6) {
		message.html('');
		button.prop('disabled', true);
		return;
    } else if (!isEmail(email) ){
		message.html('not a valid email').css('color', 'red');
		button.prop('disabled', true);
		return;
	} else {
        message.html('');
		button.prop('disabled', false);
	}	
}

function checkPasswordMatch() {
    var password = $("#NewPassword").val();
    var confirmPassword = $("#ConfirmPassword").val();
	var button = false;
	
	if (password.length == 0){
		$('#new_password_message').html('');
		$('#addBtn').prop('disabled', true);
		$('#ConfirmPassword').prop('disabled', true);
		button = false;
		return;
	} else if (password.length < 8){
		$('#new_password_message').html('');
		$('#ConfirmPassword').prop('disabled', true);
		$('#addBtn').prop('disabled', true);
		button = false;
		return;
	} else if (!validPassword(password)){
		$('#new_password_message').html('not a valid password').css('color', 'red');
		$('#addBtn').prop('disabled', true);
		$('#ConfirmPassword').prop('disabled', true);
		button = false;
		return;
	} else {
		$('#new_password_message').html('');
		$('#addBtn').prop('disabled', false);
		$('#ConfirmPassword').prop('disabled', false);
		button = true;
	}
	
	if (confirmPassword.length == 0){
		$('#confirm_password_message').html('');
		$('#addBtn').prop('disabled', true);
		button = false;
		return;
	} else if (confirmPassword.length < password.length){
		$('#confirm_password_message').html('');
		$('#addBtn').prop('disabled', true);
		button = false;
	} else if (password != confirmPassword) {
        $('#confirm_password_message').html('Passwords do not match').css('color', 'red');
		$('#addBtn').prop('disabled', true);
		button = false;
    } else {
		$('#new_password_message').html('');
		$('#confirm_password_message').html('');
		$('#addBtn').prop('disabled', false);
		button = true;
	}
		
	return button;
}

function checkName() {
    var fName = $("#FName").val();
    var lName = $("#LName").val();
	var button = false;
	
	if (fName.length == 0) {
		$('#fName_message').html('');
		$('#addBtn').prop('disabled', true);
		button = false;
		return;
    } else if (!validName(fName) ){
		$('#fName_message').html('not a valid First Name format').css('color', 'red');
		$('#addBtn').prop('disabled', true);
		button = false;
		return;
	} else {
        $('#fName_message').html('');
		$('#addBtn').prop('disabled', false);
		button = true;
	}
	
	if (lName.length == 0) {
		$('#lName_message').html('');
		$('#addBtn').prop('disabled', true);
		button = false;
		return;
    } else if (!validName(lName) ){
		$('#lName_message').html('not a valid Last Name format').css('color', 'red');
		$('#addBtn').prop('disabled', true);
		button = false;
		return;
	} else {
        $('#lName_message').html('');
		$('#addBtn').prop('disabled', false);
		button = true;
	}
	
	return button;
}
	
$(document).ready(function(){
	
	$("#newEmail").keyup(function() {
		checkEmail($(this));	
	});
	$("#NewPassword, #ConfirmPassword").keyup(function() {
		checkPasswordMatch($(this));
	});
	$("#FName, #LName").keyup(function() {
		checkName($(this));
	});
	$("#editEmail").keyup(function() {
		checkEmail($(this));
	});
	$("#deleteEmail").keyup(function() {
		checkEmail($(this));
	});
	$("#addBtn").click(function(e){
		$("#resultSpan").html('').css('color', 'red');
		e.preventDefault();
		$('#ConfirmPassword').attr('disabled', true);
		var url = "../php/addUser.php";
		var data = $('#addUserForm').serialize();
		$.post(url, data, function(result){
			$("#resultSpan").html(result).css('color', 'red');
			$('#ConfirmPassword').attr('disabled', false)
			$("#addUserForm").each(function(){
				this.reset();
			});
		});
		
	});
	
	$("#editBtn").click(function(e){
		$("#resultSpan").html('').css('color', 'red');
		e.preventDefault();
		var url = "../php/editUser.php";
		var data = $('#editUserForm').serialize();
		console.log(data);
		$.post(url, data, function(result){
			$("#resultSpan").html(result).css('color', 'red');
		});
		
	});
	
	$("#deleteBtn").click(function(e){
		$("#resultSpan").html('').css('color', 'red');
		e.preventDefault();
		var url = "../php/deleteUser.php";
		var data = $('#deleteUserForm').serialize();
		console.log(data);
		$.post(url, data, function(result){
			$("#resultSpan").html(result).css('color', 'green');
		})
		.fail(function() {
			$("#resultSpan").html(result).css('color', 'red');
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
<div class="container">
	<div class="row">
		<section class="col-xs-offset-2 col-xs-8">
			<h1 class="text-center"><<?php echo $user; ?>Admin Page</h1>
		</section>
	</div>
    <div class="row">
		<span id="resultSpan"></span>
		<section class="col-xs-offset-2 col-xs-8">
			<div class="panel-group" id="accordion">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h4 class="panel-title">
							<a data-toggle="collapse" data-parent="#accordion" href="#newUser">
							ADD USER</a>
						</h4>
					</div>
					<div id="newUser" class="panel-collapse collapse">
						<div class="panel-body">
							<form class="form-horizontal" action="" id="addUserForm">
								<div class="row">
									<div class="form-group">
										<label class="col-sm-3" for="newEmail">
										  Email address
										</label>
										<div class="col-sm-7">
											<input type="email" class="form-control" onChange="checkEmail($(this));"
											name="email" id="newEmail" placeholder="Email" required>
											<span id='new_email_message'></span>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3" for="newPassword">
										  Password
										</label>
										<div class="col-sm-7">
											<input type="password" class="form-control" onChange="checkPasswordMatch();"
											name="password" id="NewPassword" maxlength="16" required>
											<span id='new_password_message'></span>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3" for="newPassword2">
										  Re-Enter Password
										</label>
										<div class="col-sm-7">
											<input type="password" class="form-control" onChange="checkPasswordMatch();"
											id="ConfirmPassword" maxlength="16" disabled required>
											<span id='confirm_password_message'></span>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3" for="newFName">
											First Name
										</label>
										<div class="col-sm-7">
											<input type="text" class="form-control" name="FName" onChange="checkName();"
												id="FName" placeholder="FirstName" required>
												<span id='fName_message'></span>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3" for="newLName">
											Last Name
										</label>
										<div class="col-sm-7">
											<input type="text" class="form-control" name="LName" onChange="checkName();"
												id="LName" placeholder="LastName" required>
												<span id='lName_message'></span>
										</div>
									</div>
									<div class="form-group">
										<div class="col-sm-offset-3 col-sm-3">
											<button type="submit" id="addBtn"
											class="btn btn-default" disabled>Add User</button>
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
							<a data-toggle="collapse" data-parent="#accordion" href="#editUser">
							EDIT USER</a>
						</h4>
					</div>
					<div id="editUser" class="panel-collapse collapse">
						<div class="panel-body">
							<form class="form-horizontal" action="" id="editUserForm">
								<div class="row">
									<div class="form-group">
										<label class="col-sm-3" for="editEmail">
											Email address
										</label>
										<div class="col-sm-7">
											<input type="email" class="form-control" onChange="checkEmail($(this));"
											name="email" id="editEmail" placeholder="Email" required>
											<span name='email_message'></span>
										</div>
									</div>
									<div class="form-group">
										<div class="col-sm-offset-3 col-sm-7">
											<button type="submit" id="editBtn"
											class="btn btn-default" disabled>Edit User</button>
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
							<a data-toggle="collapse" data-parent="#accordion" href="#deleteUser">
							DELETE USER</a>
						</h4>
					</div>
					<div id="deleteUser" class="panel-collapse collapse">
						<div class="panel-body">
							<form class="form-horizontal" action="" id="deleteUserForm">
								<div class="row">
									<div class="form-group">
										<label class="col-sm-3" for="deleteEmail">
											Email address
										</label>
										<div class="col-sm-7">
											<input type="email" class="form-control" onChange="checkEmail($(this));"
											name="email" id="deleteEmail" placeholder="Email" required>
											<span name='email_message'></span>
										</div>
									</div>
									<div class="form-group">
										<div class="col-sm-offset-3 col-sm-7">
											<button type="submit" id="deleteBtn"
											class="btn btn-default" disabled>Delete User</button>
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
							<a data-toggle="collapse" data-parent="#accordion" href="#reports">
							BI REPORTS</a>
						</h4>
					</div>
					<div id="reports" class="panel-collapse collapse">
						<div class="panel-body">
							<a href="BIReports.html" role="button" class="btn btn-primary">view BI Reports</a>
						</div>
					</div>
				</div>
			</div>
			
		</section>
	</div>
</div>

</body>
</html>
