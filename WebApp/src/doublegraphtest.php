<!DOCTYPE html>
<html>
<head>
    <title>FusionCharts XT - Pie 2D Chart</title>
    <!--  Include the `fusioncharts.js` file. This file is needed to render the chart. Ensure that the path to this JS file is correct. Otherwise, it may lead to JavaScript errors. -->
    <script src="fusioncharts/js/fusioncharts.js"></script>
</head>
<body>
<?php
/*
    Include the `fusioncharts.php` file that contains functions to embed the charts.
*/
include_once 'functions.php';
include_once 'fusioncharts/fusioncharts.php';

$tests = 0;
$successfultests= 0;
//Test 1
echo "Testing connection to database...";
$conn = gs2_database_connect();


$table = get_raw_table($conn, "Timeslice");
$tempArray = array();
$timeArray = array();
$num_rows = get_num_rows($conn, "Timeslice");


$charter = makeNewCustomBarGraph("Testting Graph Render", "PASSED", $table, "chart-1", 300, date("Y/m/d"));
$charter->render();

?>
<div class="chart-container" id="chart-1">Fusion Charts will render here</div>

</body>
</html>