<?php
session_start();

if(empty($_SESSION['user']) or $_SESSION['userType'] != 1){
	header("Location: login.php"); 
	die();
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

<div id="menubox" style="margin-top:25px;" class="col-sm-8 col-sm-offset-2">                    
	<div class="panel panel-default">
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
		<div class="panel-body">
			<table class="table table-striped table-bordered table-list">
				<thead>
					<tr>
						<th>Date Created</th>
                        <th>Recipient</th>
                        <th>Email</th>
						<th>Award Type</th>
						<th>Award Date</th>
						<th>Delete</th>
					</tr> 
				</thead>
				<tbody>
					<tr>
						<td>JUL 23 02:16:57 2016</td>
						<td>John Doe</td>
						<td>johndoe@example.com</td>
						<td>Employee of the Month</td>
						<td>JUL 23 2016</td>
						<td align="center"><a class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span></a></td>
					</tr>
					<tr>
						<td>JUL 23 02:16:57 2016</td>
						<td>John Doe</td>
						<td>johndoe@example.com</td>
						<td>Employee of the Week</td>
						<td>JUL 23 2016</td>
						<td align="center"><a class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span></a></td>
					</tr>
					<tr>
						<td>JUL 23 02:16:57 2016</td>
						<td>John Doe</td>
						<td>johndoe@example.com</td>
						<td>Employee of the Month</td>
						<td>JUL 23 2016</td>
						<td align="center"><a class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span></a></td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="panel-footer">
			<div class="row">
				<div class="col col-xs-6">
					<ul class="pagination">
						<li><a href="#">1</a></li>
						<li><a href="#">2</a></li>
						<li><a href="#">3</a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>                     
</div>

</body>
</html>
