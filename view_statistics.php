<?php

	include('scripts.php');
	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
    
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<script src="js/jquery.js"></script>
		<script src="js/amcharts.js" type="text/javascript"></script>
        <script src="js/serial.js" type="text/javascript"></script>
     </head>
    
    <body>
		<div id='data_gender' style="display:none; float:left;"></div>
		<div id='data_education' style="display:none; float:left;"> </div>
		<div id='data_civil_status' style="display:none; float:left;"></div>
		<div id='data_city' style="display:none; float:left;"></div>
		<div id='data_age' style="display:none; float:left;"></div>
		
				 <!--style="display:none; float:left;"-->
		<div class="row">
			<div class="col-lg-4">
				<!--Gender Div-->
				<h4>Gender</h4><small style='float:right;'><a href='Library/01simple-download-xlsx.php' >Download All</a></small>
				<div id="chart_gender" style="width: 90%; height: 150px;"></div>
				<!--Employment Div-->
				<h4>Employment</h4><small style='float:right;'><a href='#download'>Download All</a></small>
				<div id="chart_employment" style="width: 100%; height: 200px; float:left;"></div>
			</div>
			<div class="col-lg-8">
				<!--Education Div-->
				<h4>Education</h4><small style='float:right;'><a href='#download'>Download All</a></small>
				<div id="chart_education" style="width: 100%; float:left;"></div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-6">
				<!--Civil Status Div-->
				<h4>Civil Status</h4><small style='float:right;'><a href='#download'>Download All</a></small>
				<div id="chart_civil_status" style="width: 90%; height: 300px;"></div>		
			</div>
			<div class="col-lg-6">
				<!--Age Div-->
				<h4>Age</h4><small style='float:right;'><a href='#download'>Download All</a></small>
				<div id="chart_age" style="width: 100%; float:left;"></div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12">
				<!--Location/City Div-->
				<h4>City location</h4><small style='float:right;'><a href='#download'>Download All</a></small>
				<div id="chart_city" style="width: 100%; height: 400px; float:left;"></div>				
			</div>
		</div>
		
    </body>

        <script type="text/javascript">
		var chart;
		var temp_data;
		$(document).ready(function(){
           
			function get_statistics(function_name, element) {
				$.ajax({
					type: "POST",
					url:'controller.php',
					data: {'function_name':function_name},
					async: false,
					success: function(data) {
						$(element).html(data);
					},
					error: function() {
						alert('Error occured');
					}
				});
			}
			
			/*******************************************Age SCRIPT*******************************************/
			get_statistics('get_stat_age','#data_age');
			var data_age = $('#data_age').text();
			data_age = jQuery.parseJSON( data_age );
			console.log(data_age);
			
			var tbl_age = '';
			
			tbl_age = '<table class="table table-responsive"><tr><td>Age Range</td><td>Total No.</td></tr>'
			$(data_age).each(function(k,v){
			
				if(v.group != null)
				{
					var count = (v.count == null) ? 0 : v.count;
					
					tbl_age += '<tr id="'+v.group+'">';
					tbl_age += '<td>'+v.group+'</td>';
					tbl_age += '<td>'+count+'</td>';
					tbl_age += '</tr>';	
				}
			});
			tbl_age += '</table>';
			$('#chart_age').html(tbl_age);
			
			/*******************************************GENDER SCRIPT*******************************************/
			get_statistics('get_stat_gender','#data_gender');
			var data_gender = $('#data_gender').text();
			data_gender = jQuery.parseJSON( data_gender );
			console.log(data_gender);
			
            AmCharts.ready(function () {
                // SERIAL CHART
                chart = new AmCharts.AmSerialChart();
                chart.dataProvider = data_gender;
                chart.categoryField = "gender";
                chart.startDuration = 1;

                // AXES
                // category
                var categoryAxis = chart.categoryAxis;
                categoryAxis.labelRotation = 90;
                categoryAxis.gridPosition = "start";

                // value
                // in case you don't want to change default settings of value axis,
                // you don't need to create it, as one value axis is created automatically.

                // GRAPH
                var graph = new AmCharts.AmGraph();
                graph.valueField = "gender_count";
                graph.balloonText = "[[category]]: <b>[[value]]</b>";
                graph.type = "column";
                graph.lineAlpha = 0;
                graph.fillAlphas = 1;
                chart.addGraph(graph);

                // CURSOR
                var chartCursor = new AmCharts.ChartCursor();
                chartCursor.cursorAlpha = 0;
                chartCursor.zoomable = false;
                chartCursor.categoryBalloonEnabled = false;
                chart.addChartCursor(chartCursor);

                chart.write("chart_gender");
				//chart.addListener("clickGraphItem", handleClick);
            });
			
			/**********************************EDUCATION SCRIPT*******************************************/
			var chart1;
			get_statistics('get_stat_education','#data_education');
			var data_education = $('#data_education').text();
			data_education = jQuery.parseJSON( data_education );
			var tbl_education = '';
			
			tbl_education = '<table class="table table-responsive"><tr><td>Status</td><td>Total No.</td></tr>'
			$(data_education).each(function(k,v){
				var educ_count = (v.education_count == null) ? 0 : v.education_count;
				
				tbl_education += '<tr id="'+v.education_id+'">';
				tbl_education += '<td>'+v.education+'</td>';
				tbl_education += '<td>'+educ_count+'</td>';
				tbl_education += '</tr>';
			});
			tbl_education += '</table>';
			
			$('#chart_education').html(tbl_education);
			
			/*******************************************Employment SCRIPT*******************************************/
			get_statistics('get_stat_employment','#chart_employment');
			var data_employment = $('#chart_employment').text();
			data_employment = jQuery.parseJSON( data_employment );
			
			var tbl_employment = '';
			
			tbl_employment = '<table class="table table-responsive"><tr><td>Status</td><td>Total No.</td></tr>'
			$(data_employment).each(function(k,v){
				var emp_count = (v.employment_count == null) ? 0 : v.employment_count;
				
				tbl_employment += '<tr id="'+v.employment_id+'">';
				tbl_employment += '<td>'+v.employment+'</td>';
				tbl_employment += '<td>'+emp_count+'</td>';
				tbl_employment += '</tr>';
			});
			tbl_employment += '</table>';
			
			$('#chart_employment').html(tbl_employment);
			
			/*******************************************Civil Status SCRIPT*******************************************/
			get_statistics('get_stat_civil_status','#data_civil_status');
			var data_civil_status = $('#data_civil_status').text();
			data_civil_status = jQuery.parseJSON( data_civil_status );
			console.log(data_civil_status);
			
			
		 AmCharts.ready(function () {
                // SERIAL CHART
                chart = new AmCharts.AmSerialChart();
                chart.dataProvider = data_civil_status;
                chart.categoryField = "civil_status";
                chart.startDuration = 1;
                chart.plotAreaBorderColor = "#DADADA";
                chart.plotAreaBorderAlpha = 1;
                // this single line makes the chart a bar chart          
                chart.rotate = true;

                // AXES
                // Category
                var categoryAxis = chart.categoryAxis;
                categoryAxis.gridPosition = "start";
                categoryAxis.gridAlpha = 0.1;
                categoryAxis.axisAlpha = 0;

                // Value
                var valueAxis = new AmCharts.ValueAxis();
                valueAxis.axisAlpha = 0;
                valueAxis.gridAlpha = 0.1;
                valueAxis.position = "top";
                chart.addValueAxis(valueAxis);

             
                var graph2 = new AmCharts.AmGraph();
                graph2.type = "column";
                graph2.title = "civil_status_count";
                graph2.valueField = "civil_status_count";
                graph2.balloonText = "civil_status_count:[[value]]";
                graph2.lineAlpha = 0;
                graph2.fillColors = "#ADD981";
                graph2.fillAlphas = 1;
                chart.addGraph(graph2);

                // LEGEND
                var legend = new AmCharts.AmLegend();
                chart.addLegend(legend);

                // WRITE
                chart.write("chart_civil_status");
            });
			
			/*******************************************City SCRIPT*******************************************/
			get_statistics('get_stat_city','#data_city');
			var data_city = $('#data_city').text();
			data_city = jQuery.parseJSON( data_city );
			console.log(data_city);
			
			 AmCharts.ready(function () {
                // SERIAL CHART
                chart = new AmCharts.AmSerialChart();
                chart.dataProvider = data_city;
                chart.categoryField = "city";
                chart.color = "#000000";
                chart.fontSize = 14;
                chart.startDuration = 1;
                chart.plotAreaFillAlphas = 1;
                // the following two lines makes chart 3D
                chart.angle = 30;
                chart.depth3D = 60;

                // AXES
                // category
                var categoryAxis = chart.categoryAxis;
                categoryAxis.gridAlpha = 1;
                categoryAxis.gridPosition = "start";
                categoryAxis.gridColor = "#fafafa";
                categoryAxis.axisColor = "#fafafa";
                categoryAxis.axisAlpha = 1;
				categoryAxis.labelRotation = 90;
                categoryAxis.dashLength = 5;

                // value
                var valueAxis = new AmCharts.ValueAxis();
                valueAxis.stackType = "3d"; // This line makes chart 3D stacked (columns are placed one behind another)
               // valueAxis.gridAlpha = 0.2;
                valueAxis.gridColor = "#000000";
                valueAxis.axisColor = "#000000";
                valueAxis.axisAlpha = 1;
                valueAxis.dashLength = 5;
                valueAxis.unit = "%";
                chart.addValueAxis(valueAxis);

                // GRAPHS         
                // first graph
                var graph1 = new AmCharts.AmGraph();
                graph1.title = "2004";
                graph1.valueField = "city_count";
                graph1.type = "column";
                graph1.lineAlpha = 1;
                graph1.lineColor = "#FCF421";
                graph1.fillAlphas = 1;
                graph1.balloonText = "Total No. of Users from [[category]]: <b>[[value]]</b>";
                chart.addGraph(graph1);
           
                chart.write("chart_city");
            });
		});	
		
		
			
        </script>
</html>