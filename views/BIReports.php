<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/styles.css">
  <title>BI Reports</title>
</head>
<body>

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
						Report Type
						</label>
						<div class="col-sm-10">
						<input type="email" class="form-control"
						id="adminEmail" placeholder="Email" required>
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

	<?php include('/csvTest.php'); ?>
<script src="../js/jquery-2.1.4.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/script.js"></script>
</body>
</html>