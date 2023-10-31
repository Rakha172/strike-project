<!DOCTYPE HTML>
<html>
<head>
    <title>Chart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<body>
<script>
window.onload = function () {

var chart = new CanvasJS.Chart("chartContainer", {
	animationEnabled: true,
	title:{
		text: "Leaderboard Strike"
	},
	axisY: {
		title: "Total Fish",
		titleFontColor: "#4F81BC",
		lineColor: "#4F81BC",
		labelFontColor: "#4F81BC",
		tickColor: "#4F81BC"
	},
	toolTip: {
		shared: true
	},
	legend: {
		cursor:"pointer",
		itemclick: toggleDataSeries
	},
	data: [{
		type: "column",
		name: "Total Fish",
		legendText: "Total Fish",
		showInLegend: true,
		dataPoints:[
			{ label: "Adam", y: 25 },
			{ label: "Rafly", y: 20 },
			{ label: "Sidiq", y: 15 },
			{ label: "Azzam", y: 10 },
			{ label: "Keyza", y: 5 }
		]
	}]
});
chart.render();

function toggleDataSeries(e) {
	if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
		e.dataSeries.visible = false;
	}
	else {
		e.dataSeries.visible = true;
	}
	chart.render();
}
}
</script>
</head>
<div id="chartContainer" style="height: 735px; width: 100%;"></div>
<script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
<ul>
    <li><a href="chart-weight" style="color: #000000" text-decoration:none>Chart Weight</a></li>
</ul>
</body>
</html>
