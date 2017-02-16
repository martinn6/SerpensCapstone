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
  <title>BI Reports</title>
    
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
$(document).ready(function(){

	$("#awardsCSV").click(function(e){
		e.preventDefault();
		var MyTimestamp = new Date().getTime();
		var MyTable = "dbo.Awards";
		var MyTitle = "Awards.csv";
		$.get('../php/csvTEST.php',
		'timestamp='+MyTimestamp+
		'&table='+MyTable+
		'&filename='+MyTitle,function(){
        document.location.href = '../php/csvTEST.php?timestamp='+MyTimestamp+'&table='+MyTable+'&filename='+MyTitle;
		});
	});

	$("#usersCSV").click(function(e){
		e.preventDefault();
		var MyTimestamp = new Date().getTime();
		var MyTable = "dbo.UserAccounts";
		var MyTitle = "UserAccounts.csv";
				$.get('../php/csvTEST.php',
		'timestamp='+MyTimestamp+
		'&table='+MyTable+
		'&filename='+MyTitle,function(){
        document.location.href = '../php/csvTEST.php?timestamp='+MyTimestamp+'&table='+MyTable+'&filename='+MyTitle;
		});
	});
	
});
</script>
<div class="container">
	<div class="row">
		<section class="col-xs-offset-3 col-xs-6">
			<h2>Business Intelligence Reports</h2>
		</section>
	</div>

	<div class="row">
		<section class="col-xs-offset-2 col-xs-8">
			<form class="form-horizontal" action="adminLanding.html">
				<div class="row">
					<div class="form-group">
						<label class="col-sm-2" for="report Type">
						Awards Report
						</label>
						<div class="col-sm-10">
						<button type="submit" id="awardsCSV"
						 class="btn btn-default">Download CSV</button>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="form-group">
						<label class="col-sm-2" for="report Type">
						Users Report
						</label>
						<div class="col-sm-10">
						<button type="submit" id="usersCSV"
						 class="btn btn-default">Download CSV</button>
						</div>
					</div>
				</div>
			</form>
		</section>
	</div>
	
	<div class="row">
		<section class="col-xs-offset-3 col-xs-6">
			<a href="admin.html" role="button" class="btn btn-primary">Return to Admin</a>
		</section>
	</div>
</div>


<script src="../js/jquery-2.1.4.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/script.js"></script>
</body>
</html>