<?php 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if(!isset($_SESSION['admin'])){
	header("Location: ../php/adminLogout.php"); 
	die();
} 
$user = $_SESSION['admin']['name'];

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
function ConvertToCSV(objArray) {
    var array = typeof objArray != 'object' ? JSON.parse(objArray) : objArray;
    var str = '';
    for (var i = 0; i < array.length; i++) {
	var line = '';
	for (var index in array[i]) {
	    if (line != '') line += ','
	    line += array[i][index];
	}
	str += line + '\r\n';
    }
    return str;
}
$(document).ready(function(){

	$("#EOYawardsCSV").click(function(e){
		e.preventDefault();
		var MyTimestamp = new Date().getTime();
		var MyTable = "EOY";
		var MyTitle = "EOY_Awards.csv";
		$.get('../php/csvTEST.php',
		'timestamp='+MyTimestamp+
		'&table='+MyTable+
		'&filename='+MyTitle,function(){
        document.location.href = '../php/csvTEST.php?timestamp='+MyTimestamp+'&table='+MyTable+'&filename='+MyTitle;
		});
	});
	$("#EOMawardsCSV").click(function(e){
		e.preventDefault();
		var MyTimestamp = new Date().getTime();
		var MyTable = "EOM";
		var MyTitle = "EOM_Awards.csv";
		$.get('../php/csvTEST.php',
		'timestamp='+MyTimestamp+
		'&table='+MyTable+
		'&filename='+MyTitle,function(){
        document.location.href = '../php/csvTEST.php?timestamp='+MyTimestamp+'&table='+MyTable+'&filename='+MyTitle;
		});
	});
	$("#usersCSV").click(function(e){
		e.preventDefault();
// 		var MyTimestamp = new Date().getTime();
		var MyTable = "users";
// 		var MyTitle = "UserAccounts.csv";
// 				$.get('../php/csvTEST.php',
// 		'timestamp='+MyTimestamp+
// 		'&table='+MyTable+
// 		'&filename='+MyTitle,function(){
//         document.location.href = '../php/csvTEST.php?timestamp='+MyTimestamp+'&table='+MyTable+'&filename='+MyTitle;
// 		});
		
		var url = "../php/csvTEST.php"
		var data = {table: MyTable};
		$.post(url, data, function(result){
			console.log(result);
			if(result){
// 				$(function(){
// 				  ConvertToCSV(result).download('UserAccounts.csv').go();
// 				});
				var json = result;
				var fields = Object.keys(json[0])
				var replacer = function(key, value) { return value === null ? '' : value } 
				var csv = json.map(function(row){
				  return fields.map(function(fieldName){
				    return JSON.stringify(row[fieldName], replacer)
				  }).join(',')
				})
				csv.unshift(fields.join(',')) // add header column

				console.log(csv.join('\r\n'))
				var link = document.createElement("a");
            if (link.download !== undefined) { // feature detection
                // Browsers that support HTML5 download attribute
                var url = URL.createObjectURL(blob);
                link.setAttribute("href", url);
                link.setAttribute("download", filename);
                link.style.visibility = 'hidden';
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            }
// 				var csv = ConvertToCSV(result);
// 				console.log(csv);
				$('#success_msg').html("SUCCESS").prop('hidden', false);
			} else {
				$('#error_msg').html("ERROR").prop('hidden', false);	
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
<div class="container">
	<div class="row">
		<section class="col-xs-offset-3 col-xs-6">
			<h2><?php echo $user; ?> Business Intelligence Reports</h2>
		</section>
	</div>

	<div class="row">
		<section class="col-xs-offset-2 col-xs-8">
			<form class="form-horizontal" >
				<div class="row">
					<div class="form-group">
						<label class="col-sm-2" for="report Type">
						EOM Awards Report
						</label>
						<div class="col-sm-10">
						<button type="submit" id="EOMawardsCSV"
						 class="btn btn-default">Download CSV</button>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="form-group">
						<label class="col-sm-2" for="report Type">
						EOY Awards Report
						</label>
						<div class="col-sm-10">
						<button type="submit" id="EOYawardsCSV"
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
			<a href="admin.php" role="button" class="btn btn-primary">Return to Admin</a>
		</section>
	</div>
</div>

</body>
</html>
