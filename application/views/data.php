<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Welcome to CodeIgniter</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
	<style type="text/css">

	::selection{ background-color: #E13300; color: white; }
	::moz-selection{ background-color: #E13300; color: white; }
	::webkit-selection{ background-color: #E13300; color: white; }

	body {
		background-color: #fff;
		margin: 40px;
		font: 13px/20px normal Helvetica, Arial, sans-serif;
		color: #4F5155;
	}

	a {
		color: #003399;
		background-color: transparent;
		font-weight: normal;
	}

	h1 {
		color: #444;
		background-color: transparent;
		border-bottom: 1px solid #D0D0D0;
		font-size: 19px;
		font-weight: normal;
		margin: 0 0 14px 0;
		padding: 14px 15px 10px 15px;
	}

	code {
		font-family: Consolas, Monaco, Courier New, Courier, monospace;
		font-size: 12px;
		background-color: #f9f9f9;
		border: 1px solid #D0D0D0;
		color: #002166;
		display: block;
		margin: 14px 0 14px 0;
		padding: 12px 10px 12px 10px;
	}

	#body{
		margin: 0 15px 0 15px;
	}
	
	p.footer{
		text-align: right;
		font-size: 11px;
		border-top: 1px solid #D0D0D0;
		line-height: 32px;
		padding: 0 10px 0 10px;
		margin: 20px 0 0 0;
	}
	
	#container{
		margin: 10px;
		border: 1px solid #D0D0D0;
		-webkit-box-shadow: 0 0 8px #D0D0D0;
	}

    #chartdiv {
        width: 100%;
        height: 500px;
    }
	</style>
</head>
<body>

<div id="container">
	<h1>Server Data by Divya Karunakaran</h1>

	<div id="body">

        <!-- server name list -->
        <?php if ($serverlist != null) {?>
        <select id="server-list">
            <?php foreach ($serverlist as $servername) {?>
            <option value="<?php	echo ($servername); ?>"><?php	echo ($servername); ?></option>
            <?php } ?>
        </select>
        <?php } ?>

        <!-- chart area -->
        <div id="chartdiv">
        </div>
	</div>

	<p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds</p>
</div>

<!-- import javascript libraries -->
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<script src="https://www.amcharts.com/lib/3/amcharts.js"></script>
<script src="https://www.amcharts.com/lib/3/serial.js"></script>

<script>

var serverDataChart;

$(document).ready(function(){
    
    //making data for chart
    function makeChartData(jsonData) {
        var data = JSON.parse(jsonData);
        var chartData = [];
        for (var i = 0; i < data.length; i++) {
            var unitData = [];
            unitData['data_label'] = data[i]["data_label"];
            unitData['data_value'] = data[i]["data_value"];
            chartData.push(unitData);
        }
        return chartData;
    }

    //drawing chart based on server data
    function showChart(jsonData, url) {
        var chartData = makeChartData(jsonData);
        if (serverDataChart == undefined) {
            var serverDataChart = AmCharts.makeChart("chartdiv", {
                "type": "serial",
                "dataProvider": chartData,
                "titles": [
                    {
                        "text": url,
                        "size": 15
                    }
                ],
                "graphs": [{
                    "balloonText": "<b>[[category]] - [[value]]</b>",
                    "fillAlphas": 0,
                    "bullet": "round",
                    "bulletSize": 10,
                    "bulletAlpha": 0.3,
                    "liineThinkness": 2,
                    "lineColor": "#0022FF",
                    "type": "line",
                    "valueField": "data_value"
                }],
                "chartCursor": {
                    "categoryBalloonEnabled": false,
                    "cursorAlpha": 0,
                    "zoomable": true
                },
                "categoryField": "data_label",
                "categoryAxis": {
                    "gridPosition": "start",
                    "labelRotation": 45
                },
                "export": {
                    "enabled": true
                }

            });
        } else {
            serverDataChart.dataProvider = chartData; 
            serverDataChart.validateData();
        }
        
    }
    
    //event for select server names
    $('#server-list').on('change', function() {
        var selected_servername = $(this).find("option:selected").attr('value');
        //get data by a selected server name
        $.ajax({
            type: 'POST',
            url: 'data/serverdata/' + selected_servername,
            success: function(result) {
                showChart(result, selected_servername);
            }
        })
    });

    //initialize server names
    $('#server-list > option').removeAttr('selected')
    $('#server-list > option:nth-child(1)').attr('selected', true);
    $('#server-list').change();
});
</script>

</body>
</html>