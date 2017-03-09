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

	<!-- Latest d3js -->
	<script src="http://d3js.org/d3.v3.min.js"></script>
		<style>

  .bar{
    fill: steelblue;
  }

  .bar:hover{
    fill: brown;
  }

	.axis {
	  font: 10px sans-serif;
	}

	.axis path,
	.axis line {
	  fill: none;
	  stroke: #000;
	  shape-rendering: crispEdges;
	}

	</style>
</head>
<body>
<script>
function ConvertToCSV(json, filename) {
	var fields = Object.keys(json[0])
	var replacer = function(key, value) { return value === null ? '' : value } 
	var csv = json.map(function(row){
	  return fields.map(function(fieldName){
	    return JSON.stringify(row[fieldName], replacer)
	  }).join(',')
	})
	csv.unshift(fields.join(',')); // add header column
	var csvFile = csv.join('\r\n');
	console.log(csvFile);
	var blob = new Blob([csvFile], { type: 'text/csv;charset=utf-8;' });
	if (navigator.msSaveBlob) { // IE 10+
	    navigator.msSaveBlob(blob, filename);
	} else {
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
	}
}
function ABTChart(){
	var url = "../php/biReports.php";
	var table = "ABT";
	var d = {table: MyTable};
	$.post(url, d, function(data){
		var width = 960, height = 500;
		var margin = {top: 20, right: 20, bottom: 30, left: 40};
		//x and y Scales
		var xScale = d3.scale.ordinal()
			.rangeRoundBands([0, width], .1);

		var yScale = d3.scale.linear()
			.range([height, 0]);

		xScale.domain(data.map(function(d) { return d.Count; }));
		yScale.domain([0, d3.max(data, function(d) { return d.Award; })]);

		//x and y Axes
		var xAxis = d3.svg.axis()
			.scale(xScale)
			.orient("bottom");

		var yAxis = d3.svg.axis()
			.scale(yScale)
			.orient("left")
			.ticks(10, "%");

		//create svg container
		var svg = d3.select("body")
			.append("svg")
			.attr("width", width + margin.left + margin.right)
			.attr("height", height + margin.top + margin.bottom)
			.append("g")
			.attr("transform", "translate(" + margin.left + "," + margin.top + ")");        

		//create bars
		svg.selectAll(".bar")
			.data(data)
			.enter()
			.append("rect")
			.attr("class", "bar")
			.attr("x", function(d) { return xScale(d.x); })
			.attr("width", xScale.rangeBand())
			.attr("y", function(d) { return yScale(d.y); })
			.attr("height", function(d) { return height - yScale(d.y); });

		//drawing the x axis on svg
		svg.append("g")
			.attr("class", "x axis")
			.attr("transform", "translate(0," + height + ")")
			.call(xAxis);

		//drawing the y axis on svg
		svg.append("g")
			.attr("class", "y axis")
			.call(yAxis)
			.append("text")
			.attr("transform", "rotate(-90)")
			.attr("y", 6)
			.attr("dy", ".71em")
			.style("text-anchor", "end")
			.text("Count");
	});
}

$(document).ready(function(){

		$("#EOYawardsCSV").click(function(e){
			e.preventDefault();
			var MyTable = "EOY";
			var filename = "EOY_Awards.csv";
			var url = "../php/biReports.php"
			var data = {table: MyTable};
			$.post(url, data, function(result){
				console.log(result);
				if(result){
					ConvertToCSV(result, filename);
				} else {
					$('#error_msg').html("ERROR").prop('hidden', false);	
				}
			});
	});
	$("#EOMawardsCSV").click(function(e){
		e.preventDefault();
		var MyTable = "EOM";
		var filename = "EOM_Awards.csv";
		var url = "../php/biReports.php"
		var data = {table: MyTable};
		$.post(url, data, function(result){
			console.log(result);
			if(result){
				ConvertToCSV(result, filename);
			} else {
				$('#error_msg').html("ERROR").prop('hidden', false);	
			}
		});
	});
	$("#usersCSV").click(function(e){
		e.preventDefault();
		var MyTable = "users";
  		var filename = "UserAccounts.csv";		
		var url = "../php/biReports.php"
		var data = {table: MyTable};
		$.post(url, data, function(result){
			console.log(result);
			if(result){
				ConvertToCSV(result, filename);
			} else {
				$('#error_msg').html("ERROR").prop('hidden', false);	
			}
		});
	});
	$("#ABMCSV").click(function(e){
		e.preventDefault();
		var MyTable = "ABM";
  		var filename = "AwardsByMonth.csv";		
		var url = "../php/biReports.php"
		var data = {table: MyTable};
		$.post(url, data, function(result){
			console.log(result);
			if(result){
				ConvertToCSV(result, filename);
			} else {
				$('#error_msg').html("ERROR").prop('hidden', false);	
			}
		});
	});
	$("#ABTCSV").click(function(e){
		e.preventDefault();
		var MyTable = "ABT";
  		var filename = "AwardsByType.csv";		
		var url = "../php/biReports.php"
		var data = {table: MyTable};
		$.post(url, data, function(result){
			console.log(result);
			if(result){
				ConvertToCSV(result, filename);
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
						Awards By Month
						</label>
						<div class="col-sm-10">
						<button type="submit" id="ABMCSV"
						 class="btn btn-default">Download CSV</button>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="form-group">
						<label class="col-sm-2" for="report Type">
						Awards By Type
						</label>
						<div class="col-sm-10">
						<div id="ABT-chart" onload="ABTChart();"></div>
						<button type="submit" id="ABTCSV"
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
