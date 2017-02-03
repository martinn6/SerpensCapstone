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
	<?php
	 // DB connection info
	 $host = "cs496osusql.database.windows.net";
	 $user = "Serpins_Login";
	 $pwd = "T3amSerpin$!";
	 $db = "OSU_Capstone";
	 echo "<p>Trying to connect....</p>";
	 try{
		 $conn = new PDO( "sqlsrv:Server= $host ; Database = $db ", $user, $pwd);
	  }
	 catch(Exception $e){
		 die(print_r($e));
	 }
	 
	 if($conn)
	 {
    echo "<p>Connection Established.</p>";
    // fetch mysql table rows
    $sql = "SELECT * FROM dbo.Awards";
    $sqlResultesult = sqlsrv_query($conn, $sql);

	$csvName = "export.csv"

	$fp = fopen(csvName , 'w');
	echo "opened";
	while ($export = odbc_fetch_array($sqlRresult)) {
		if (!isset($headings))
		{
			$headings = array_keys($export);
			fputcsv($fp, $headings, ',', '"');
		}
		fputcsv($fp, $export, ',', '"');
	}
	fclose($fp);
	echo "<p>success</p>";
    }
?>

<script src="../js/jquery-2.1.4.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/script.js"></script>
</body>
</html>