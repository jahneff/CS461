
<?php
/*
    Include the `fusioncharts.php` file that contains functions to embed the charts.
*/
include_once 'functions.php';
include_once 'fusioncharts/fusioncharts.php';

$conn = gs2_database_connect();
if($conn){
    echo "Connection Successful";
}
else {
    echo "Connection to database failed";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>FusionCharts XT - Pie 2D Chart</title>
    <!--  Include the `fusioncharts.js` file. This file is needed to render the chart. Ensure that the path to this JS file is correct. Otherwise, it may lead to JavaScript errors. -->
    <script src="fusioncharts/js/fusioncharts.js"></script>
</head>
<body>
<?php
$table = array(array());
$name = "Timeslice";
$table = get_table($conn, $name);
$tempArray = array();
$timeArray = array();
$num_rows = get_num_rows($conn, $name);
for ($i = 1; $i <= 10; $i++){
    $timeArray[$i] = $table[$num_rows - $i]['1'];
    $tempArray[$i] = $table[$num_rows - $i]['2'];
}
$temp_time_Array = array_combine($timeArray, $tempArray);
$charter = makeNewBarGraph("Titular", "Tatular", $temp_time_Array);

$charter->render();
?>

<div id="chart-1">Fusion Charts will render here</div>
</body>
</html>