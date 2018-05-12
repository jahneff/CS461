<!DOCTYPE html>
<html>

<?php
include_once 'functions.php';
include_once 'fusioncharts/fusioncharts.php';
$conn = gs2_database_connect();
if(!$conn){echo "Connection to database failed";}
?>

<head>
    <title>GS2 Dashboard</title>
    <link rel="stylesheet" type="text/css" href="library/bootstrap.css"/>
    <link rel="stylesheet" type="text/css" href="library/gs2styles.css"/>
    <script type="text/javascript" src="fusioncharts/js/fusioncharts.js"></script>
    <script type="text/javascript" src="fusioncharts/js/fusioncharts.theme.ocean.js"></script>

</head>



<body>
<h1>Welcome, User</h1>

<?php
$height = 200;

$table = array(array());
$name = "Timeslice";
$table = get_table($conn, $name, 8);
$tempArray = array();
$humidityArray = array();
$pressureArray = array();
$soilmoistureArray = array();
$soilphArray = array();
$batteryArray = array();
$timeArray = array();
$timeArray2 = array();
$num_rows = get_num_rows($conn, $name);
for ($i = 1; $i <= 10; $i++){
    $timeArray[$i] = date('H:i:s', strtotime($table[$num_rows - (11 - $i)]['1']));
    $tempArray[$i] = $table[$num_rows - (11 - $i)]['2'];
    $humidityArray[$i] = $table[$num_rows - (11 - $i)]['3'];
    $pressureArray[$i] = $table[$num_rows - (11 - $i)]['4'];
    $soilmoistureArray[$i] = $table[$num_rows - (11 - $i)]['5'];
    $soilphArray[$i] = $table[$num_rows - (11 - $i)]['6'];
    $batteryArray[$i] = $table[$num_rows - (11 - $i)]['7'];
}
$temp_time_Array = array_combine($timeArray, $tempArray);
$humidity_time_Array = array_combine($timeArray, $humidityArray);
$pressure_time_Array = array_combine($timeArray, $pressureArray);
$soilmoisture_time_Array = array_combine($timeArray, $soilmoistureArray);
$soilph_time_Array = array_combine($timeArray, $soilphArray);
/* `$arrData` is the associative array that is initialized to store the chart attributes. */
$tempChart = makeNewBarGraph("Temperature", "Last 12 hours", $temp_time_Array, "chart-1", $height);
$tempChart->render();
$humidityChart = makeNewBarGraph("Humidity", "Last 12 hours", $humidity_time_Array, "chart-2", $height);
$humidityChart->render();
$pressureChart = makeNewBarGraph("Pressure", "Last 12 hours", $pressure_time_Array, "chart-3", $height);
$pressureChart->render();
$soilmoistureChart = makeNewBarGraph("Soil Moisture", "Last 12 hours", $soilmoisture_time_Array, "chart-4", $height);
$soilmoistureChart->render();
$soilphChart = makeNewBarGraph("Soil pH", "Last 12 hours", $soilph_time_Array, "chart-5", $height);
$soilphChart->render();
?>

<div class = "row">
    <div class = "col-sm-2">Left Column</div>
    <div class = "col-sm-8">
        <div class = "category-wrap">
            <div class="chart-container" id="chart-1">Temp chart renders here</div>
        </div>
        <div class = "category-wrap">
            <div class="chart-container" id="chart-2">Temp chart renders here</div>
        </div>
        <div class = "category-wrap">
            <div class="chart-container" id="chart-3">Temp chart renders here</div>
        </div>
        <div class = "category-wrap">
            <div class="chart-container" id="chart-4">Temp chart renders here</div>
        </div>
        <div class = "category-wrap">
            <div class="chart-container" id="chart-5">Temp chart renders here</div>
        </div>
    </div>
    <div class = "col-sm-2">Right Column</div>
</div>


</body>






