<?php
require 'connect.php';

if(empty($_SESSION['user']) or $_SESSION['userType'] != 1){
	header("Location: login.php"); 
	die();
} 

if (isset($_POST['delete'])) {
	if ($conn){
		$query = "UPDATE AwardsGiven SET IsDeleted = '1' WHERE AwardGivenId = :AwardGivenId";
		$query_params = array(':AwardGivenId' => $_POST['delete']);
		$stmt = $conn->prepare($query);
		$stmt->execute($query_params) or die();
	}
}

if ($conn){
	$query = "SELECT AwardGivenId, Awards.AwardId, CONVERT(nvarchar(12),AwardedDate) AS AwardedDateTxt, 
					AwardedToFullName, AwardedToEmail, CONVERT(nvarchar(12),CreatedDateTime) AS CreatedDateTimeTxt, AwardTypeName 
				FROM AwardsGiven JOIN Awards ON Awards.AwardId = AwardsGiven.AwardId 
				WHERE AwardGivenByUserId = :AwardGivenByUserId AND IsDeleted = '0'";
	$query_params = array(':AwardGivenByUserId' => $_SESSION['user']);
	$stmt = $conn->prepare($query);
	$result = $stmt->execute($query_params) or die();
	$awards = $stmt->fetchAll();
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
				<li><a href="profile.php"><span class="glyphicon glyphicon-user"></span> Profile</a></li>
				<li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
			</ul>
		</div>
	</div>
</nav>

<div id="menubox" style="margin-top:25px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">                    
	<div class="panel panel-default" >
		<div class="panel-heading">
			<div class="row">
				<div class="col col-xs-6">
					<div class="panel-title">Awards Created</div>
				</div>
				<div class="col col-xs-6 text-right">
					<a href="entry.php"><button type="button" class="btn btn-sm btn-primary btn-create">New Award</button></a>
				</div>
			</div>
		</div>
		<div class="panel-body" >
			<table class="table table-bordered table-list" >
				<thead>
					<tr>
						<th></th>
						<th>Date Created</th>
                        <th>Recipient</th>
                        <th>Email</th>
						<th>Award</th>
						<th>Award Date</th>
						<th>Delete</th>
					</tr> 
				</thead>
				<tbody>
					<form action="awards.php" method="post">
					<?php
						if(count($awards) > 0) {
							foreach($awards as $award) {
								echo "<tr>";
								echo '<td><a href="GenerateAward.php?awardGivenId='.$award['AwardGivenId'].'">View</a>';
								echo "<td>".$award['CreatedDateTimeTxt']."</td>";
								echo "<td>".$award['AwardedToFullName']."</td>";
								echo "<td>".$award['AwardedToEmail']."</td>";
								echo "<td>".$award['AwardTypeName']."</td>";
								echo "<td>".$award['AwardedDateTxt']."</td>";
								echo '<td align="center"><button class="btn btn-danger" name="delete" value="'.$award['AwardGivenId'].'"><span class="glyphicon glyphicon-trash"></span></button></td>';
								echo "</tr>";
							}
						}
					?>
				</form>
				</tbody>
			</table>
			
			<div class="form-group">
				<div class="col-md-12 control">
					<div style="border-top: 1px solid #BABABA; padding-top:10px">
						<a href="main.php">Back to Menu</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

</body>
</html>
