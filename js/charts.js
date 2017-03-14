function ABUGChart(){
	// set the dimensions of the canvas
	var margin = {top: 20, right: 20, bottom: 70, left: 40},
		width = 800 - margin.left - margin.right,
		height = 400 - margin.top - margin.bottom;


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
	var svg = d3.select("#ABUG-chart")
		.classed("svg-container", true)
		.append("svg")
// 		.attr("width", width + margin.left + margin.right)
// 		.attr("height", height + margin.top + margin.bottom)
		.attr("preserveAspectRatio", "xMinYMin meet")
   		.attr("viewBox", "0 0 800 400")
		.style("text-anchor", "end")
		.classed("svg-content-responsive", true)
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
	var svg = d3.select("#UBT-chart")
		.classed("svg-container", true)
		.append("svg")
// 		.attr("width", width + margin.left + margin.right)
// 		.attr("height", height + margin.top + margin.bottom)
		.attr("preserveAspectRatio", "xMinYMin meet")
   		.attr("viewBox", "0 0 600 300")
		.style("text-anchor", "end")
		.classed("svg-content-responsive", true)
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
	var svg = d3.select("#ABM-chart")
		.classed("svg-container", true)
		.append("svg")
// 		.attr("width", width + margin.left + margin.right)
// 		.attr("height", height + margin.top + margin.bottom)
		.attr("preserveAspectRatio", "xMinYMin meet")
   		.attr("viewBox", "0 0 600 300")
		.style("text-anchor", "end")
		.classed("svg-content-responsive", true)
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
	var svg = d3.select("#ABT-chart")
		.classed("svg-container", true)
		.append("svg")
// 		.attr("width", width + margin.left + margin.right)
// 		.attr("height", height + margin.top + margin.bottom)
		.attr("preserveAspectRatio", "xMinYMin meet")
   		.attr("viewBox", "0 0 600 300")
		.style("text-anchor", "end")
		.classed("svg-content-responsive", true)
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
