<?php
require 'connect.php';

if(empty($_SESSION['user']) or $_SESSION['userType'] != 1){
	header("Location: login.php"); 
	die("");
}

if(!empty($_POST)){
	if (!isset($_POST['awardtype'])) {
		$err_msg[] = 'Please select an award.';
	}

	if (empty($_POST['recname'])) {
		$err_msg[] = 'Please enter name of recipient.';
	}

	if (empty($_POST['recemail'])) {
		$err_msg[] = 'Please enter email of recipient.';
	}

	if (filter_var($_POST['recemail'], FILTER_VALIDATE_EMAIL) === false) {
		$err_msg[] = 'Please enter a valid email.';
	}

	if (empty($_POST['awarddate'])) {
		$err_msg[] = 'Please enter date of award.';
	}

	if (!empty($_POST['awarddate'])) {
		$datePart = explode("-",$_POST['awarddate']);
		if(!checkdate($datePart[1], $datePart[2], $datePart[0]) Or ($datePart[0] < 1753) Or ($datePart[0] > 9999)) {
			$err_msg[] = 'Please enter a valid date.';
		}
	}

    if (!isset($err_msg)) {
		if ($conn){
			$query = "INSERT INTO AwardsGiven (AwardId, AwardedToFullName, AwardedToEmail, AwardedDate, AwardGivenByUserId) "
				. "VALUES (:AwardId, :AwardedToFullName, :AwardedToEmail, :AwardedDate, :AwardGivenByUserId)";
			$query_params = array(
				':AwardId' => $_POST['awardtype'], 
				':AwardedToFullName' => $_POST['recname'], 
				':AwardedToEmail' => $_POST['recemail'], 
				':AwardedDate' => $_POST['awarddate'], 
				':AwardGivenByUserId' => $_SESSION['user']
			);
			$stmt = $conn->prepare($query);
			$stmt->execute($query_params) or die();
			
			$insert_Id = $conn->lastInsertId();
			$_SESSION['AwardGivenId'] = $insert_Id;

			header("location: GenerateAward.php?awardGivenId=".$insert_Id);
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
			<a class="navbar-brand" href="../index.php">Employee Recognition</a>
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
			<div class="panel-title">New Award</div>	
		</div>     

		<div style="padding-top:15px" class="panel-body" >
		<?php
			if(isset($err_msg)){
				foreach($err_msg as $msg){
					echo '<div class="alert alert-danger">'.$msg.'</div>';
				}
			}
		?>
		
			<form id="entryform" class="form-horizontal" action="entry.php" method="post">          
				<div style="margin-bottom: 15px" class="input-group">
					<span class="input-group-addon"><span class="glyphicon glyphicon-chevron-right"></span></span>
					<select class="form-control" id="awardtype" name="awardtype" required>
						<option value="" disabled selected hidden>Please Select an Award</option>
						<option <?php if(isset($err_msg) And ($_POST['awardtype'] == '0')){echo "selected";} ?> value="0">Employee of the Year</option>
						<option <?php if(isset($err_msg) And ($_POST['awardtype'] == '1')){echo "selected";} ?> value="1">Employee of the Month</option>
					</select>                                       
				</div>
				
				<div style="margin-bottom: 15px" class="input-group">
					<span class="input-group-addon"><span class="glyphicon glyphicon-chevron-right"></span></span>
					<input id="recname" type="text" class="form-control" name="recname" placeholder="Recipient's Name" value="<?php echo isset($err_msg) ? $_POST['recname'] : '' ?>" required />                                        
				</div>

				<div style="margin-bottom: 15px" class="input-group">
					<span class="input-group-addon"><span class="glyphicon glyphicon-chevron-right"></span></span>
					<input id="recemail" type="text" class="form-control" name="recemail" placeholder="Recipient's Email" value="<?php echo isset($err_msg) ? $_POST['recemail'] : '' ?>" required />                                        
				</div>
                                
				<div style="margin-bottom: 15px" class="input-group">
					<span class="input-group-addon"><span class="glyphicon glyphicon-chevron-right"></span></span>
					<input id="awarddate" type="date" class="form-control" name="awarddate" placeholder="Date" value="<?php echo isset($err_msg) ? $_POST['awarddate'] : '' ?>" required />
				</div>

				<div style="margin-top:5px" class="form-group">
					<div class="col-sm-12 controls">
						<input type="submit" value="create" name ="Create" class="btn btn-primary" />
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
