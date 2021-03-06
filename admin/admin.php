<?php 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if(!isset($_SESSION['admin'])){
	header("Location: ../php/adminLogout.php"); 
	die();
} 
if(isset($_SESSION['editUser'])){
	unset($_SESSION['editUser']);
}

$user = $_SESSION['admin']['name'];
$userEmail = $_SESSION['admin']['email'];



?>

<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Serpens Admin Portal</title>
    
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css">

	<!-- Latest compiled and minified JavaScript -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<script src="../js/jquery.cropit.js"></script>

		<style>
      .cropit-preview {
        border: 1px solid #ccc;
        border-radius: 3px;
        margin-top: 7px;
      }

      .cropit-preview-image-container {
        cursor: move;
      }

      input {
        display: block;
      }

      #result {
        margin-top: 10px;
        width: 900px;
      }

      #result-data {
        display: block;
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
        word-wrap: break-word;
      }
	</style>
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
	var regex = /^[a-zA-Z ]{1,30}$/;
	return regex.test(name);
}
function checkEmail(thisObj) {
    var email = thisObj.val();
	var message = thisObj.parent().children('span');
	
	if (email.length < 5) {
		message.html('');
		return false;
    } else if (!isEmail(email) ){
		message.html('not a valid email').css('color', 'red');
	    	return false;
	} else {
        	message.html('');
		return true;
	}	
}

function checkEmailMatch() {
	var userEmail = "<?php echo $userEmail; ?>";
	var deleteEmail = $('#deleteEmail').val();

	if (userEmail == deleteEmail) {
		$('#delete_email_message').html('Cannot delete account you are logged into');
		return false;
	} else {
		$('#new_password_message').html('');
		return true;
	}
	
}

function checkPasswordMatch(pass,cPass) {
    var password = pass.val();
	var message = pass.parent().children('span');
    var confirmPassword = cPass.val();
	var confirmMessage = cPass.parent().children('span');
	
	if (password.length == 0){
		message.html('');
		cPass.prop('disabled', true);
		return false;
	} else if (password.length < 4){
		message.html('');
		cPass.prop('disabled', true);
		return false;
	} else if (!validPassword(password)){
		message.html('not a valid password (passwords are 8-16 Alpha-Numeric only)').css('color', 'red');
		cPass.prop('disabled', true);
		return false;
	} else {
		message.html('');
		cPass.prop('disabled', false);
	}
	
	if (confirmPassword.length == 0){
		confirmMessage.html('');
		return false;
	} else if (password != confirmPassword) {
        confirmMessage.html('Passwords do not match').css('color', 'red'); 
		return false;
    } else {
		message.html('');
		confirmMessage.html('');
		return true;
	}
		
}

function checkName(thisObj) {
	var fName = thisObj.val();
	var message = thisObj.parent().children('span');
	
	if (fName.length == 0) {
	message.html('');
	return false;
    } else if (!validName(fName) ){
	message.html('not a valid Full Name format').css('color', 'red');
	return false;
	} else {
        message.html('');
	return true;
	}

}
	
$(document).ready(function(){

	$("#newEmail, #newPassword, #confirmPassword, #FName").keyup(function() {
		if(checkEmail($('#newEmail')) && checkPasswordMatch($('#newPassword'),$('#confirmPassword')) && checkName($('#FName'))){
			$('#addBtn').prop('disabled', false);
		} else {
			$('#addBtn').prop('disabled', true);
		}
	});

	$("#editEmail").keyup(function() {
		if(checkEmail($(this))){
			$('#editBtn').prop('disabled', false);
		} else {
			$('#editBtn').prop('disabled', true);
		}
	});
	$("#deleteEmail").keyup(function() {
		if(checkEmail($(this)) && checkEmailMatch()){
			$('#deleteBtn').prop('disabled', false);
		} else {
			$('#deleteBtn').prop('disabled', true);
		}
	});
	$(document).click(function() {
		$('#error_msg').prop('hidden', true);
		$('#success_msg').prop('hidden', true);
	});

	$("#addBtn").click(function(e){
		$("#resultSpan").html('');
		e.preventDefault();
		var url = "../php/addUser.php";
		var email = $('#newEmail').val();
		var password = $('#newPassword').val();
		var name = $('#FName').val();
		var data = {email: email, password: password, name: name}
		$.post(url, data, function(result){
			if(!result){
				$('#success_msg').html("Successful added new Admin User: " + name).prop('hidden', false);
				$('#newEmail').val("");
				$('#newPassword').val("");
				$('#confirmPassword').val("").prop('hidden', false);
				$('#FName').val("");
				$('#addBtn').prop('disabled', true);
			} else{
				$('#error_msg').html(result).prop('hidden', false);	
			}
		});
		
	});
	$("#addUserBtn").click(function(e){
		$("#resultSpan").html('');
		e.preventDefault();
		var url = "../php/addUser.php";
		var email = $('#newEmailUser').val();
		var password = $('#newPasswordUser').val();
		var name = $('#FNameUser').val();
		var file = $('#Signature').files[0];
		var data = {email: email, password: password, name: name, file: file}
		$.post(url, data, function(result){
			if(!result){
				$('#success_msg').html("Successful added new Admin User: " + name).prop('hidden', false);
				$('#newEmail').val("");
				$('#newPassword').val("");
				$('#confirmPassword').val("").prop('hidden', false);
				$('#FName').val("");
				$('#addBtn').prop('disabled', true);
			} else{
				$('#error_msg').html(result).prop('hidden', false);	
			}
		});
		
	});
	$("#editBtn").click(function(e){
		$("#resultSpan").html('');
		e.preventDefault();
		var url = "../php/editUser.php";
		var email = $('#editEmail').val();
		var data = {email: email}
		$.post(url, data, function(result){
			if(!result){
				window.location.href="editUser.php";
			} else {
				$('#error_msg').html(result).prop('hidden', false);	
			}
		});
		
	});
	
	
	$("#deleteBtn").click(function(e){
		$("#resultSpan").html('');
		e.preventDefault();
		var url = "../php/deleteUser.php";
		var email = $('#deleteEmail').val();
		var data = {email: email}
		$.post(url, data, function(result){
			console.log(result);
			if(!result){
				$('#success_msg').html("Successful deleted Admin User: " +email).prop('hidden', false);
				$('#deleteEmail').val("");
				$('#deleteBtn').prop('disabled', true);
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
			<a class="navbar-brand" href="../index.php">Employee Recognition</a>
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
			<h1 class="text-center"><?php echo $user; ?> Admin Page</h1>
		</section>
	</div>
	
    <div class="row">
		<span id="resultSpan"></span>
		<section class="col-xs-offset-2 col-xs-8">

			<div class="panel-group" id="accordion">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h4 class="panel-title">
							<a data-toggle="collapse" data-parent="#accordion" href="#newAdmin">
							ADD ADMIN</a>
						</h4>
					</div>
					<div id="newAdmin" class="panel-collapse collapse in">
						<div class="panel-body">
							<form class="form-horizontal" action="" id="addUserForm">
								<div class="row">
									<div class="form-group">
										<label class="col-sm-3" for="newEmail">
										  Email address
										</label>
										<div class="col-sm-7">
											<input type="email" class="form-control" onkeyup="checkEmail($(this))"
											name="email" id="newEmail" placeholder="Email" required>
											<span id='new_email_message'></span>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3" for="newPassword">
										  Password
										</label>
										<div class="col-sm-7">
											<input type="password" class="form-control" onkeyup="checkPasswordMatch($(this),$('#confirmPassword'))"
											name="newPassword" id="newPassword" maxlength="16" required>
											<span id='new_password_message'></span>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3" for="confirmPassword">
										  Re-Enter Password
										</label>
										<div class="col-sm-7">
											<input type="password" class="form-control" onkeyup="checkPasswordMatch($('#newPassword'),$(this))"
											id="confirmPassword" maxlength="16" disabled required>
											<span id='confirm_password_message'></span>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3" for="newFName">
											Full Name
										</label>
										<div class="col-sm-7">
											<input type="text" class="form-control" name="FName" onkeyup="checkName($(this))"
												id="FName" placeholder="Full Name" required>
												<span id='fName_message'></span>
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
							<a data-toggle="collapse" data-parent="#accordion" href="#newUser">
							REGISTER NEW USER</a>
						</h4>
					</div>
					<div id="newUser" class="panel-collapse collapse">
						<div class="panel-body">
							<div class="col-sm-offset-5">
								<a href="../admin/register.php" role="button" class="btn btn-primary">Register New User</a>
							</div>
						</div>
					</div>
				</div>
				
				<div class="panel panel-default">
					<div class="panel-heading">
						<h4 class="panel-title">
							<a data-toggle="collapse" data-parent="#accordion" href="#editUser">
							EDIT ADMIN/USER</a>
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
											<input type="email" class="form-control" onkeyup="checkEmail($(this))"
											name="email" id="editEmail" placeholder="Email" required>
											<span name='email_message'></span>
										</div>
									</div>
									<div class="form-group">
										<div class="col-sm-offset-3 col-sm-7">
											<button type="submit" id="editBtn"
											class="btn btn-default" disabled>Edit Admin/User</button>
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
							DELETE ADMIN/USER</a>
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
											<input type="email" class="form-control" onkeyup="checkEmail($(this))"
											name="email" id="deleteEmail" placeholder="Email" required>
											<span id='delete_email_message'></span>
										</div>
									</div>
									<div class="form-group">
										<div class="col-sm-offset-3 col-sm-7">
											<button type="submit" id="deleteBtn"
											class="btn btn-default" disabled>Delete Admin/User</button>
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
							<div class="col-sm-offset-5">
								<a href="BIReports.php" role="button" class="btn btn-primary">view BI Reports</a>
							</div>
						</div>
					</div>
				</div>
			</div>
			
		</section>
	</div>
</div>

</body>
</html>

