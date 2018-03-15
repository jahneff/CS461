<?php
include_once 'functions.php';
include_once 'fusioncharts/fusioncharts.php';

$conn = gs2_database_connect();
if(!$conn){
    echo "Connection to database failed";
}

?>

<html>
<head>
    <title>GS2 Dashboard</title>
    <script type="text/javascript" src="fusioncharts/js/fusioncharts.js"></script>
    <script type="text/javascript" src="fusioncharts/js/fusioncharts.theme.ocean.js"></script>
    <style type="text/css" media=screen>
        <!--
        body  { background-color: darkslategray;}
        .chart-container {display: inline-block; border: 1px solid black; width: 25%; margin-right: 2%;}
    </style>
    <h1>Welcome, User</h1>
</head>



<body>

    <?php
        $table = array(array());
        $name = "Timeslice";
        $table = get_table($conn, $name);

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
            $timeArray[$i] = date('H:i:s', strtotime($table[$num_rows - $i]['1']));
            $tempArray[$i] = $table[$num_rows - $i]['2'];
            $humidityArray[$i] = $table[$num_rows - $i]['3'];
            $pressureArray[$i] = $table[$num_rows - $i]['4'];
            $soilmoistureArray[$i] = $table[$num_rows - $i]['5'];
            $soilphArray[$i] = $table[$num_rows - $i]['6'];
            $batteryArray[$i] = $table[$num_rows - $i]['7'];
        }
        $temp_time_Array = array_combine($timeArray, $tempArray);
        $humidity_time_Array = array_combine($timeArray, $humidityArray);
        $pressure_time_Array = array_combine($timeArray, $pressureArray);
        $soilmoisturetime_Array = array_combine($timeArray, $soilmoistureArray);
        $soilph_time_Array = array_combine($timeArray, $soilphArray);


    /* `$arrData` is the associative array that is initialized to store the chart attributes. */
        $tempChart = makeNewBarGraph("Temperature", "Last 12 hours", $temp_time_Array, "chart-1");
        $tempChart->render();
        $humidityChart = makeNewBarGraph("Humidity", "Last 12 hours", $humidity_time_Array, "chart-2");
        $humidityChart->render();
        $pressureChart = makeNewBarGraph("Pressure", "Last 12 hours", $pressure_time_Array, "chart-3");
        $pressureChart->render();
        $soilmoistureChart = makeNewBarGraph("Soil Moisture", "Last 12 hours", $soilmoisturetime_Array, "chart-4");
        $soilmoistureChart->render();
        $soilphChart = makeNewBarGraph("Soil pH", "Last 12 hours", $soilph_time_Array, "chart-5");
        $soilphChart->render();
    ?>
    <div class="chart-container" id="chart-1">Temp chart renders here</div>
    <div class="chart-container" id="chart-2">Humidity chart renders here</div>
    <div class="chart-container" id="chart-3">Pressure chart renders here</div>
    <div class="chart-container" id="chart-4">Soil Moisture chart renders here</div>
    <div class="chart-container" id="chart-5">Soil Ph chart renders here</div>



</body>




</html>