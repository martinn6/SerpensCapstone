<?php
require 'connect.php';

if(empty($_SESSION['user']) or $_SESSION['userType'] != 1){
	header("Location: login.php"); 
	die();
} 

if ($conn){
	$query = "SELECT * FROM UserAccount WHERE UserId = :UserId";
	$query_params = array(':UserId' => $_SESSION['user']);
	$stmt = $conn->prepare($query);
	$result = $stmt->execute($query_params) or die();
	$row = $stmt->fetch();

	$email = $row['Email'];
	$fname = $row['FullName'];
	$password = $row['Password'];
	$sig_image = $row['SignatureURL'];
}

if(!empty($_POST)){
	if (empty($_POST['email'])) {
		$err_msg[] = 'Please enter an email address.';
	} 
	
	if ($email != $_POST['email']) {
		if ($conn){
			$query = "SELECT * FROM UserAccount WHERE Email = :Email";
			$query_params = array(':Email' => $_POST['email']);
			$stmt = $conn->prepare($query);
			$stmt->execute($query_params) or die();
			$row = $stmt->fetch();

			if($row){
				$err_msg[] = 'Email address already exists. Enter another email.';
			}
		}
	}

	if (empty($_POST['fname'])) {
		$err_msg[] = 'Please enter your full name.';
	}

	if (!empty($_POST['password']) && !empty($_POST['password-confirm'])) {
		if ($_POST['password'] !== $_POST['password-confirm']) {
			$err_msg[] = 'Passwords do not match. Re-enter passwords.';
		} else {
			$password = md5($_POST['password']);
		}
	}

	if (empty($_FILES['signature'])) {
		if (!preg_match("!image!", $_FILES['signature']['type'])) {
			$err_msg[] = 'Signature file is not an image. Re-upload image.';
		}
	}
	
    if (!isset($err_msg)) {
        $signature_path = 'images/'.$_FILES['signature']['name'];

		define('UPLOAD_DIR', '../images/');
		$img = $_POST['image-data'];
		$img = str_replace('data:image/png;base64,', '', $img);
		$img = str_replace(' ', '+', $img);
		$data = base64_decode($img);
		$file = UPLOAD_DIR . uniqid() . '.png';

		if ($conn){
			file_put_contents($file, $data);
			$query = "UPDATE UserAccount SET Email = :Email, FullName = :FullName, Password = :Password, SignatureURL = :SignatureURL "
                . "WHERE UserId = " . $_SESSION['user'];
			$query_params = array( 
				':Email' => $_POST['email'], 
				':FullName' => $_POST['fname'], 
				':Password' => $password, 
				':SignatureURL' => $file
			);
			$stmt = $conn->prepare($query);
			$stmt->execute($query_params) or die();
		}
		
		header("location: profile.php");
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
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
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

<div id="menubox" style="margin-top:50px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">                    
	<div class="panel panel-default" >
		<div class="panel-heading">
			<div class="panel-title">User Profile - Edit</div>	
		</div>     

		<div style="padding-top:15px" class="panel-body" >
		<?php
			if(isset($err_msg)){
				foreach($err_msg as $msg){
					echo '<div class="alert alert-danger">'.$msg.'</div>';
				}
			}
		?>
			<form id="editform" class="form-horizontal" action="editProfile.php" method="post" enctype="multipart/form-data">           
				<div style="margin-bottom: 15px" class="input-group">
					<span class="input-group-addon"><span class="glyphicon glyphicon-chevron-right"></span></span>
					<input id="edit-email" type="text" class="form-control" name="email" placeholder="Email" value="<?php echo $email; ?>" required />                                        
				</div>
				
				<div style="margin-bottom: 15px" class="input-group">
					<span class="input-group-addon"><span class="glyphicon glyphicon-chevron-right"></span></span>
					<input id="edit-fname" type="text" class="form-control" name="fname" placeholder="Full Name" value="<?php echo $fname; ?>" >                                        
				</div>
                                
				<div style="margin-bottom: 15px" class="input-group">
					<span class="input-group-addon"><span class="glyphicon glyphicon-chevron-right"></span></span>
					<input id="edit-password" type="password" class="form-control" name="password" placeholder="New Password" >
				</div>

				<div style="margin-bottom: 15px" class="input-group">
					<span class="input-group-addon"><span class="glyphicon glyphicon-chevron-right"></span></span>
					<input id="edit-password-confirm" type="password" class="form-control" name="password-confirm" placeholder="Confirm New Password" >
				</div>
				
				<div class="image-editor">
					<label>Upload New Signature</label><input type="file" class="cropit-image-input" name="signature" accept="image/*" >
					<div class="cropit-preview"></div>
					<div class="image-size-label">
					  Resize image
					</div>
					<input type="range" class="cropit-image-zoom-input">
					<input type="hidden" name="image-data" class="hidden-image-data" />
				</div>

				<div style="margin-top:5px" class="form-group">
					<div class="col-sm-10 controls">
						<input type="submit" value="Save" name ="save" class="btn btn-primary" />
					</div>
				</div>
				
				<div class="form-group">
					<div class="col-md-12 control">
						<div style="border-top: 1px solid #BABABA; padding-top:10px">
							<a href="profile.php"> Cancel</a>
						</div>
					</div>
				</div>
			</form>

		</div>                     
	</div>  
</div>
    <script>
      $(function() {
        $('.image-editor').cropit();

        $('form').submit(function() {
          var imageData = $('.image-editor').cropit('export');
          $('.hidden-image-data').val(imageData);
        });
      });
    </script>

</body>
</html>
