<?php

	include('scripts.php');
	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
    
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>amCharts examples</title>
        
    </head>
    
    <body>
		<div id='data_gender' style="display:none; float:left;"></div>
		<div id='data_education' style="display:none; float:left;"> </div>
				 <!--style="display:none; float:left;"-->
		<div class="row">
			<div class="col-lg-4">
				<!--Gender Div-->
				<h4>Gender</h4><small style='float:right;'><a href='#download'>Download All</a></small>
				<div id="chart_gender" style="width: 100%; height: 200px;"></div>
			</div>
			<div class="col-lg-8">
				<!--Education Div-->
				<h4>Education</h4><small style='float:right;'><a href='#download'>Download All</a></small>
				<div id="chart_education" style="width: 100%; height: 250px; float:left;"></div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-4">
				<!--Civil Status Div-->
				<h4>Civil Status</h4><small style='float:right;'><a href='#download'>Download All</a></small>
				<div id="chart_civil_status" style="width: 100%; height: 200px;"></div>
			</div>
			<div class="col-lg-4">
				<!--Employment Div-->
				<h4>Employment</h4><small style='float:right;'><a href='#download'>Download All</a></small>
				<div id="chart_employment" style="width: 100%; height: 200px; float:left;"></div>
			</div>
			<div class="col-lg-4">
				<!--Employment Div-->
				<h4>Age</h4><small style='float:right;'><a href='#download'>Download All</a></small>
				<div id="chart_age" style="width: 100%; height: 200px; float:left;"></div>
			</div>
		</div>
    </body>

        <script type="text/javascript">
            var chart;
			var temp_data;
			
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
			console.log(data_education);
			
			AmCharts.ready(function () {
                // SERIAL CHART
                var chart1 = new AmCharts.AmSerialChart();
                chart1.dataProvider = data_education;
                chart1.categoryField = "education";
                chart1.rotate = true;
				chart1.color = "#FFFFFF";
                chart1.handDrawn = true;
                chart1.handDrawScatter = 0;


                // sometimes we need to set margins manually
                // autoMargins should be set to false in order chart to use custom margin values 
                chart1.autoMargins = false;
                chart1.marginTop = 10;
                chart1.marginLeft = 50;
                chart1.marginRight = 30;
                chart1.startDuration = 1;

                var categoryAxis1 = chart1.categoryAxis;
                categoryAxis1.gridAlpha = 0;
                categoryAxis1.axisAlpha = 0;
                categoryAxis1.labelsEnabled = true;

                // value
                var valueAxis1 = new AmCharts.ValueAxis();
                valueAxis1.gridAlpha = 0;
                valueAxis1.axisAlpha = 0;
                valueAxis1.labelsEnabled = true;
                valueAxis1.minimum = 0;
                chart1.addValueAxis(valueAxis1);

                // GRAPH
                var graph1 = new AmCharts.AmGraph();
                graph1.balloonText = "[[category]]: [[value]]";
                graph1.valueField = "education_count";
                graph1.type = "column";
                graph1.lineAlpha = 0;
                graph1.fillAlphas = 1;
                // you can pass any number of colors in array to create more fancy gradients
                graph1.fillColors = ["#6B8D03"];
                graph1.gradientOrientation = "horizontal";
                graph1.labelPosition = "bottom";
                graph1.labelText = "[[category]]: [[value]]";
                graph1.balloonText = "[[category]]: [[value]]";
                chart1.addGraph(graph1);

                // LABEL
                //chart1.addLabel(50, 170, "Education", "left", 15, "#000000", 0, 1, true);

                // WRITE
                chart1.write("chart_education");
            });
			
			
			/*******************************************Employment SCRIPT*******************************************/
			get_statistics('get_stat_employment','#chart_employment');
			var data_employment = $('#chart_employment').text();
			data_employment = jQuery.parseJSON( data_employment );
			
			var tbl_employment = '';
			
			tbl_employment = '<table class="table table-responsive"><tr><td>Status</td><td>No.</td></tr>'
			$(data_employment).each(function(k,v){
				var emp_count = (v.employment_count == null) ? 0 : v.employment_count;
				
				tbl_employment += '<tr id="'+v.employment_id+'">';
				tbl_employment += '<td>'+v.employment+'</td>';
				tbl_employment += '<td>'+emp_count+'</td>';
				tbl_employment += '</tr>';
			});
			tbl_employment += '</table>';
			
			$('#chart_employment').html(tbl_employment);
			
			
        </script>
</html>