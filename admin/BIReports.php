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

function ABUGChart(){
	// set the dimensions of the canvas
	var margin = {top: 20, right: 20, bottom: 70, left: 40},
		width = 600 - margin.left - margin.right,
		height = 300 - margin.top - margin.bottom;


	// set the ranges
	var x = d3.scale.ordinal().rangeRoundBands([0, width], .05);

	var y = d3.scale.linear().range([height, 0]);

	// define the axis
	var xAxis = d3.svg.axis()
		.scale(x)
		.orient("bottom")


	var yAxis = d3.svg.axis()
		.scale(y)
		.orient("left")
		.ticks(10);


	// add the SVG element
	var svg = d3.select("#ABUG-chart").append("svg")
		.attr("width", width + margin.left + margin.right)
		.attr("height", height + margin.top + margin.bottom)
		.append("g")
		.attr("transform", 
			"translate(" + margin.left + "," + margin.top + ")");

		var url = "../php/biReports.php";
		var table = "ABUG";
		var send = {table: table};
		$.post(url, send, function(data){

			data.forEach(function(d) {
				d.User = d.User;
				d.Count = +d.Count;
			});
			
		// scale the range of the data
		x.domain(data.map(function(d) { return d.User; }));
		y.domain([0, d3.max(data, function(d) { return d.Count; })]);      

 		svg.append("g")
            .attr("class", "x axis")
            .attr("transform", "translate(0," + height + ")")
            .call(xAxis);

		svg.append("g")
			.attr("class", "y axis")
			.call(yAxis)
			.append("text")
			.attr("transform", "rotate(-90)")
			.attr("y", 5)
			.attr("dy", ".71em")
			.style("text-anchor", "end")
			.text("Total");


		// Add bar chart
		svg.selectAll("bar")
			.data(data)
			.enter().append("rect")
			.attr("class", "bar")
			.attr("x", function(d) { return x(d.User); })
			.attr("width", x.rangeBand())
			.attr("y", function(d) { return y(d.Count); })
			.attr("height", function(d) { return height - y(d.Count); });
	});
}

function UBTChart(){
	// set the dimensions of the canvas
	var margin = {top: 20, right: 20, bottom: 70, left: 40},
		width = 600 - margin.left - margin.right,
		height = 300 - margin.top - margin.bottom;


	// set the ranges
	var x = d3.scale.ordinal().rangeRoundBands([0, width], .05);

	var y = d3.scale.linear().range([height, 0]);

	// define the axis
	var xAxis = d3.svg.axis()
		.scale(x)
		.orient("bottom")


	var yAxis = d3.svg.axis()
		.scale(y)
		.orient("left")
		.ticks(10);


	// add the SVG element
	var svg = d3.select("#UBT-chart").append("svg")
		.attr("width", width + margin.left + margin.right)
		.attr("height", height + margin.top + margin.bottom)
		.append("g")
		.attr("transform", 
			"translate(" + margin.left + "," + margin.top + ")");

		var url = "../php/biReports.php";
		var table = "UBT";
		var send = {table: table};
		$.post(url, send, function(data){

			data.forEach(function(d) {
				d.Type = d.Type;
				d.Count = +d.Count;
			});
			
		// scale the range of the data
		x.domain(data.map(function(d) { return d.Type; }));
		y.domain([0, d3.max(data, function(d) { return d.Count; })]);      

 		svg.append("g")
            .attr("class", "x axis")
            .attr("transform", "translate(0," + height + ")")
            .call(xAxis);

		svg.append("g")
			.attr("class", "y axis")
			.call(yAxis)
			.append("text")
			.attr("transform", "rotate(-90)")
			.attr("y", 5)
			.attr("dy", ".71em")
			.style("text-anchor", "end")
			.text("Total");


		// Add bar chart
		svg.selectAll("bar")
			.data(data)
			.enter().append("rect")
			.attr("class", "bar")
			.attr("x", function(d) { return x(d.Type); })
			.attr("width", x.rangeBand())
			.attr("y", function(d) { return y(d.Count); })
			.attr("height", function(d) { return height - y(d.Count); });
	});
}

function ABMChart(){
	// set the dimensions of the canvas
	var margin = {top: 20, right: 20, bottom: 70, left: 40},
		width = 600 - margin.left - margin.right,
		height = 300 - margin.top - margin.bottom;


	// set the ranges
	var x = d3.scale.ordinal().rangeRoundBands([0, width], .05);

	var y = d3.scale.linear().range([height, 0]);

	// define the axis
	var xAxis = d3.svg.axis()
		.scale(x)
		.orient("bottom")


	var yAxis = d3.svg.axis()
		.scale(y)
		.orient("left")
		.ticks(10);


	// add the SVG element
	var svg = d3.select("#ABM-chart").append("svg")
		.attr("width", width + margin.left + margin.right)
		.attr("height", height + margin.top + margin.bottom)
		.append("g")
		.attr("transform", 
			"translate(" + margin.left + "," + margin.top + ")");

		var url = "../php/biReports.php";
		var table = "ABM";
		var send = {table: table};
		$.post(url, send, function(data){

			data.forEach(function(d) {
				d.Month = d.Month;
				d.Total = +d.Total;
			});
			
		// scale the range of the data
		x.domain(data.map(function(d) { return d.Month; }));
		y.domain([0, d3.max(data, function(d) { return d.Total; })]);      

 		svg.append("g")
            .attr("class", "x axis")
            .attr("transform", "translate(0," + height + ")")
            .call(xAxis);

		svg.append("g")
			.attr("class", "y axis")
			.call(yAxis)
			.append("text")
			.attr("transform", "rotate(-90)")
			.attr("y", 5)
			.attr("dy", ".71em")
			.style("text-anchor", "end")
			.text("Total");


		// Add bar chart
		svg.selectAll("bar")
			.data(data)
			.enter().append("rect")
			.attr("class", "bar")
			.attr("x", function(d) { return x(d.Month); })
			.attr("width", x.rangeBand())
			.attr("y", function(d) { return y(d.Total); })
			.attr("height", function(d) { return height - y(d.Total); });
	});
}

function ABTChart(){
	// set the dimensions of the canvas
	var margin = {top: 20, right: 20, bottom: 70, left: 40},
		width = 600 - margin.left - margin.right,
		height = 300 - margin.top - margin.bottom;


	// set the ranges
	var x = d3.scale.ordinal().rangeRoundBands([0, width], .05);

	var y = d3.scale.linear().range([height, 0]);

	// define the axis
	var xAxis = d3.svg.axis()
		.scale(x)
		.orient("bottom")


	var yAxis = d3.svg.axis()
		.scale(y)
		.orient("left")
		.ticks(10);


	// add the SVG element
	var svg = d3.select("#ABT-chart").append("svg")
		.attr("width", width + margin.left + margin.right)
		.attr("height", height + margin.top + margin.bottom)
		.append("g")
		.attr("transform", 
			"translate(" + margin.left + "," + margin.top + ")");

		var url = "../php/biReports.php";
		var table = "ABT";
		var send = {table: table};
		$.post(url, send, function(data){

			data.forEach(function(d) {
				d.Award = d.Award;
				d.Count = +d.Count;
			});
			
		// scale the range of the data
		x.domain(data.map(function(d) { return d.Award; }));
		y.domain([0, d3.max(data, function(d) { return d.Count; })]);      

		svg.append("g")
            .attr("class", "x axis")
            .attr("transform", "translate(0," + height + ")")
            .call(xAxis);
		

		svg.append("g")
			.attr("class", "y axis")
			.call(yAxis)
			.append("text")
			.attr("transform", "rotate(-90)")
			.attr("y", 5)
			.attr("dy", ".71em")
			.style("text-anchor", "end")
			.text("Count");


		// Add bar chart
		svg.selectAll("bar")
			.data(data)
			.enter().append("rect")
			.attr("class", "bar")
			.attr("x", function(d) { return x(d.Award); })
			.attr("width", x.rangeBand())
			.attr("y", function(d) { return y(d.Count); })
			.attr("height", function(d) { return height - y(d.Count); });
	});
}

$(document).ready(function(){

	$("#aTypeCSV").click(function(e){
		e.preventDefault();
		var MyTable = "awardTypes";
		var filename = "Award_Types.csv";
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
	$("#uTypeCSV").click(function(e){
		e.preventDefault();
		var MyTable = "userTypes";
		var filename = "User_Types.csv";
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
		var filename = "All_Users.csv";
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
	$("#awardsCSV").click(function(e){
		e.preventDefault();
		var MyTable = "awards";
		var filename = "All_Awards.csv";
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
	$("#ABUGCSV").click(function(e){
		e.preventDefault();
		var MyTable = "ABUGforCSV";
		var filename = "AwardsGivenByUser.csv";
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
	$("#UBTCSV").click(function(e){
		e.preventDefault();
		var MyTable = "UBT";
  		var filename = "UsersByType.csv";		
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
		var MyTable = "ABMforCSV";
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
		<section class="col-xs-offset-1 col-xs-10">
			<h1 align="center"><?php echo $user; ?> Business Intelligence Reports</h1>
		</section>
	</div>

    <div class="row">
		<section class="col-xs-offset-2 col-xs-8">
			<div class="panel-group" id="accordion">

				<div class="panel panel-default">
					<div class="panel-heading">
						<h4 class="panel-title">
							<a data-toggle="collapse" data-parent="#accordion" href="#collapseABT">
							Total Awards By Type</a>
						</h4>
					</div>
					<div id="collapseABT" class="panel-collapse collapse">
						<div class="panel-body">
							<div class="col-sm-10">
						        <div id="ABT-chart">
							        <script type="text/javascript">
								        ABTChart();
							        </script>
						        </div>
						        <button type="submit" id="ABTCSV"
                                class="btn btn-default">Download CSV</button>
                            </div>
						</div>
					</div> 
				</div>

                <div class="panel panel-default">
					<div class="panel-heading">
						<h4 class="panel-title">
							<a data-toggle="collapse" data-parent="#accordion" href="#collapseABM">
							Total Awards By Month</a>
						</h4>
					</div>
					<div id="collapseABM" class="panel-collapse collapse">
						<div class="panel-body">
							<div class="col-sm-10">
						        <div id="ABM-chart">
							        <script type="text/javascript">
								        ABMChart();
							        </script>
						        </div>
						        <button type="submit" id="ABMCSV"
                                class="btn btn-default">Download CSV</button>
                            </div>
						</div>
					</div> 
				</div>
				
                <div class="panel panel-default">
					<div class="panel-heading">
						<h4 class="panel-title">
							<a data-toggle="collapse" data-parent="#accordion" href="#collapseABUG">
							Awards Given by User</a>
						</h4>
					</div>
					<div id="collapseABUG" class="panel-collapse collapse">
						<div class="panel-body">
							<div class="col-sm-10">
						        <div id="ABUG-chart">
							        <script type="text/javascript">
								        ABUGChart();
							        </script>
						        </div>
						        <button type="submit" id="ABUGCSV"
                                class="btn btn-default">Download CSV</button>
                            </div>
						</div>
					</div> 
				</div>
				
                <div class="panel panel-default">
					<div class="panel-heading">
						<h4 class="panel-title">
							<a data-toggle="collapse" data-parent="#accordion" href="#collapseUBT">
							Users By Type</a>
						</h4>
					</div>
					<div id="collapseUBT" class="panel-collapse collapse">
						<div class="panel-body">
							<div class="col-sm-10">
						        <div id="UBT-chart">
							        <script type="text/javascript">
								        UBTChart();
							        </script>
						        </div>
						        <button type="submit" id="UBTCSV" text-center
                                class="btn btn-default">Download CSV</button>
                            </div>
						</div>
					</div> 
				</div>

				<div class="panel panel-default">
					<div class="panel-heading">
						<h4 class="panel-title">
							<a data-toggle="collapse" data-parent="#accordion" href="#collapseOther">
							Other CSV Downloads</a>
						</h4>
					</div>
					<div id="collapseOther" class="panel-collapse collapse">
						<div class="panel-body">
							<div class="col-sm-9 col-md-6 col-lg-3">
								<button type="submit" id="usersCSV" class="btn btn-default">All Users</button>
							</div>
							<div class="col-sm-9 col-md-6 col-lg-3">
								<button type="submit" id="awardsCSV" class="btn btn-default">All Awards</button>
							</div>
							<div class="col-sm-9 col-md-6 col-lg-3">
								<button type="submit" id="uTypeCSV" class="btn btn-default">User Types</button>
							</div>
							<div class="col-sm-9 col-md-6 col-lg-3">
								<button type="submit" id="aTypeCSV" class="btn btn-default">Award Types</button>
                            </div>
						</div>
					</div> 
				</div>
				
			</div>
		</div>
	</section>

	<div class="row">
		<section class="col-xs-offset-5 col-xs-2">
			<a href="admin.php" role="button" class="btn btn-primary">Return to Admin</a>
		</section>
	</div>
</div>

</body>
</html>
