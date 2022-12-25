<html>
<head>

    <!-- Morris Charts CSS -->
    <link href="vm/vendor/morrisjs/morris.css" rel="stylesheet">

</head>
<body onload="chartView()">
<table align=center width=90%>
<th>
	<center><b> Penilaian Vendor </b></center>
	<div id="financial-year-sales-graph" style="height:180px;"></div>
	
<script type="text/javascript">
	function chartView()
	{
		function formatDate(myDate){
			var m_names = new Array("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec");
		
			var d = new Date(myDate);
		
			var curr_month = d.getMonth();
			//var curr_year = d.getFullYear();
			//return (m_names[curr_month] + "-" + curr_year);
			return (m_names[curr_month]);
		}

		function formatDate2(myDate){
			var m_names = new Array("Year1","Year2","Year3","Year4","Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec");
		
			var d = new Date(myDate);
			
			//get string position if not match return value
			
			var curr_month = d.getMonth();
			//var curr_year = d.getFullYear();
			//return (m_names[curr_month] + "-" + curr_year);
			
			return (m_names[curr_month]);
		}
		
		function formatHoverLabel(row, preUnit) {
			var m_long_names = new Array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
			var d = new Date(row.month);
			var curr_month = d.getMonth();
		
			var salesText = "Data "+m_long_names[curr_month];
			a=1;
			for (i in yearsInGraph) {
				salesText = salesText + "<br/>"+yearsInGraph[i]+": "+preUnit+row['data'+(a++)];
			}
			return salesText;
		}
		
		//yearsInGraph = [2012];

		new Morris.Line({
			element: 'financial-year-sales-graph',
			data: [
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
			// The name of the data record attribute that contains x-values.
			xkey: ['mdata'],
			// A list of names of data record attributes that contain y-values.
			ykeys: ['data1', 'data2'],
			// Labels for the ykeys -- will be displayed when you hover over the
			// chart.
			label: ['data1', 'data2'],
			//xLabelFormat: function(str){
			//	return formatDate(str);
			//},
			//preUnits: '$',
			parseTime: false,
			lineColors: ['#0b62a4', '#D58665']
		});

	}
</script>
</th>
</table>
<!-- jQuery -->
    <script src="vm/vendor/jquery/jquery.min.js"></script>

    <!-- Morris Charts JavaScript -->
    <script src="vm/vendor/raphael/raphael.min.js"></script>
    <script src="vm/vendor/morrisjs/morris.min.js"></script>


</body>
</html>