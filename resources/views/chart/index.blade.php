<!DOCTYPE HTML>
<html>
<head>
<script>
window.onload = function () {

var chart = new CanvasJS.Chart("chartContainer", {
	animationEnabled: true,
	title:{
		text: "Leaderboard Strike"
	},
	axisY: {
		title: "Total Weight",
		titleFontColor: "#4F81BC",
		lineColor: "#4F81BC",
		labelFontColor: "#4F81BC",
		tickColor: "#4F81BC"
	},
	axisY2: {
		title: "Special",
		titleFontColor: "#C0504E",
		lineColor: "#C0504E",
		labelFontColor: "#C0504E",
		tickColor: "#C0504E"
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
		name: "Total Weight",
		legendText: "Total Weight",
		showInLegend: true,
		dataPoints:[
			{ label: "Saudi", y: 266 },
			{ label: "Venezuela", y: 302 },
			{ label: "Iran", y: 157 },
			{ label: "Iraq", y: 148 },
			{ label: "Kuwait", y: 101 },
			{ label: "UAE", y: 97 }
		]
	},
	{
		type: "column",
		name: "Special",
		legendText: "Special",
		axisYType: "secondary",
		showInLegend: true,
		dataPoints:[
			{ label: "Saudi", y: 10},
			{ label: "Venezuela", y: 2 },
			{ label: "Iran", y: 3 },
			{ label: "Iraq", y: 4 },
			{ label: "Kuwait", y: 2 },
			{ label: "UAE", y: 3 }
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
<body>
<div id="chartContainer" style="height: 370px; width: 100%;"></div>
<script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
</body>
</html>
