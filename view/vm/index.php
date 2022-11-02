<html>
<body>
<link href="js/style.css" rel="stylesheet">
<div id="chartdiv"></div>
<script src="js/amcharts.js"></script>
<script src="js/serial.js"></script>
<script src="js/light.js"></script>
<script>
	var chart = AmCharts.makeChart("chartdiv", {
  	"type": "serial",
  	"theme": "light",

  	"dataProvider": [
  				{ mdata: '2014', 	data1: 26, data2: 20},
				{ mdata: '2015', 	data1: 26, data2: 18.33},
				{ mdata: '2016', 	data1: 26, data2: 4.46},
				{ mdata: 'Ytd-2017',data1: 26, data2: 6},
				{ mdata: '2017-01', data1: 26, data2: 0},
				{ mdata: '2017-02', data1: 26, data2: 23},
				{ mdata: '2017-03', data1: 26, data2: 1},
				{ mdata: '2017-04', data1: 26, data2: 0},
				{ mdata: '2017-05', data1: 26, data2: 0},
				{ mdata: '2017-06', data1: 26, data2: 0},
				{ mdata: '2017-07', data1: 26, data2: 0},
				{ mdata: '2017-08', data1: 26, data2: 0},
				{ mdata: '2017-09', data1: 26, data2: 0},
				{ mdata: '2017-10', data1: 26, data2: 0},
				{ mdata: '2017-11', data1: 26, data2: 0},
				{ mdata: '2017-12', data1: 26, data2: 0}
   	],

	  "graphs": [
	  	{
	  		"title": "Planning",
	  		"balloonText": "[[title]]: <b>[[value]]</b>",
	  	  	"valueField": "data1",
	  	  	"lineThickness": 5,
	  	  	"bullet": "round",
	  	  	"bulletSize": 20,
	  	  	"labelText": "[[value]]",
	  	  	"labelPosition": "middle",
	  	  	"color": "#000"
	  	  	//"lineColor": "#fbd51a"
	  	},
	  	{
	  	  	"title": "Performance",
	  	  	"balloonText": "[[title]]: <b>[[value]]</b>",
	  	  	"valueField": "data2",
	  	  	"lineThickness": 5,
	  	  	"bullet": "round",
	  	  	"bulletSize": 20,
	  	  	"labelText": "[[value]]",
	  	  	"labelPosition": "middle",
	  	  	"color": "#000"
	  	  	//"lineColor": "#3001FE"
	  	}
	  ],

	  	"chartCursor": {
    	"categoryBalloonEnabled": true,
    	//"cursorAlpha": 0,
    	"zoomable": false
  		},

  		"categoryField": "mdata",
	   	"legend": {}
	});

</script>
</body>

</html>