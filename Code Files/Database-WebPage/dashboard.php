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
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.9/js/all.js" integrity="sha384-8iPTk2s/jMVj81dnzb/iFR2sdA7u06vHJyyLlAd4snFpCl/SnyUjRrbdJsw1pGIl" crossorigin="anonymous"></script>
    <nav class="navbar  navbar-dark bg-primary sticky-top" style="margin-bottom: 10px; background-color: #5cb85c;">
        <a class="navbar-brand" href="#" style="color: white;"><b>My Smart Gardening System</b></a>
    </nav>
</head>

<body>

<?php
$height = 200;

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
    <div class = "col-sm-2">
        Left Column Top
    </div>
    <div class = "col-sm-8">
        <div class = "status-bar">
            <div class="status-bar-section">
                <a href="#chart-1">
                    <span class="link-spanner"></span>
                </a>
                <div class="status-bar-section-left">
                    <i class="fas fa-thermometer-full"></i>
                    <?php
                    $current_temp = number_format($tempArray[1], 1);
                    echo html_entity_decode($current_temp . "&deg"); ?>
                </div>
                <div class="status-bar-section-right">
                    <span class="status-bar-units">F</span>
                </div>
            </div>
            <div class="status-bar-section">
                <a href="#chart-2">
                    <span class="link-spanner"></span>
                </a>
                <div class="status-bar-section-left">
                <i class="fas fa-cloud"></i>
                <?php echo number_format($humidityArray[1], 1); ?>
                </div>
                <div class="status-bar-section-right">
                    <span class="status-bar-units">100%</span>
                </div>
            </div>
            <div class="status-bar-section">
                <a href="#chart-3">
                    <span class="link-spanner"></span>
                </a>
                <div class="status-bar-section-left">
                <i class="fas fa-weight"></i>
                <?php echo number_format($pressureArray[1], 1); ?>
                </div>
                <div class="status-bar-section-right">
                    <span class="status-bar-units">Pa</span>
                </div>
            </div>
            <div class="status-bar-section">
                <a href="#chart-4">
                    <span class="link-spanner"></span>
                </a>
                <div class="status-bar-section-left">

                    <i class="fas fa-tint"></i>
                    <?php echo number_format($soilmoistureArray[1], 1); ?>
                </div>
                <div class="status-bar-section-right">
                    <span class="status-bar-units">Units</span>
                </div>
            </div>
            <div class="status-bar-section">
                <a href="#chart-5">
                    <span class="link-spanner"></span>
                </a>
                <div class="status-bar-section-left">

                <i class="fas fa-lightbulb"></i>
                <?php echo number_format($soilphArray[1], 1); ?>
                </div>
                <div class="status-bar-section-right">
                    <span class="status-bar-units">lm</span>
                </div>
            </div>
        </div>
    </div>
    <div class = "col-sm-2">Right Column Top</div>
</div>
<div class = "row">
    <div class = "col-sm-2">Put past data summary here + any notifications</div>
    <div class = "col-sm-8">
        <div class = "category-wrap">
            <div class="chart-container" id="chart-1">Temp chart renders here</div>
            <div class="data-container" style="height: <?php echo $height; ?>px;">
                <?php
                echo "<div class = 'data-container-datum'>Now " . $tempArray[1] . "</div>";
                echo "<div class = 'data-container-datum'>Average " . getAverage($tempArray) . "</div>";
                echo "<div class = 'data-container-datum'>Trend " . getTrend($tempArray) . "/hr</div>";
                echo "<div class = 'data-container-datum'>High " . getMax($tempArray) . "</div>";
                echo "<div class = 'data-container-datum'>Low " . getMin($tempArray) . "</div>";
                ?>
            </div>
        </div>
        <div class = "category-wrap">
            <div class="chart-container" id="chart-2">Temp chart renders here</div>
            <div class="data-container" style="height: <?php echo $height; ?>px;">
                <?php
                echo "<div class = 'data-container-datum'>Now " . $humidityArray[1] . "</div>";
                echo "<div class = 'data-container-datum'>Average " . getAverage($humidityArray) . "</div>";
                echo "<div class = 'data-container-datum'>Trend " . getTrend($humidityArray) . "/hr</div>";
                echo "<div class = 'data-container-datum'>High " . getMax($humidityArray) . "</div>";
                echo "<div class = 'data-container-datum'>Low " . getMin($humidityArray) . "</div>";
                ?>            </div>
        </div>
        <div class = "category-wrap">
            <div class="chart-container" id="chart-3">Temp chart renders here</div>
            <div class="data-container" style="height: <?php echo $height; ?>px;">
                <?php
                echo "<div class = 'data-container-datum'>Now " . $pressureArray[1] . "</div>";
                echo "<div class = 'data-container-datum'>Average " . getAverage($pressureArray) . "</div>";
                echo "<div class = 'data-container-datum'>Trend " . getTrend($pressureArray) . "/hr</div>";
                echo "<div class = 'data-container-datum'>High " . getMax($pressureArray) . "</div>";
                echo "<div class = 'data-container-datum'>Low " . getMin($pressureArray) . "</div>";
                ?>            </div>
        </div>
        <div class = "category-wrap">
            <div class="chart-container" id="chart-4">Temp chart renders here</div>
            <div class="data-container" style="height: <?php echo $height; ?>px;">
                <?php
                echo "<div class = 'data-container-datum'>Now " . $soilmoistureArray[1] . "</div>";
                echo "<div class = 'data-container-datum'>Average " . getAverage($soilmoistureArray) . "</div>";
                echo "<div class = 'data-container-datum'>Trend " . getTrend($soilmoistureArray) . "/hr</div>";
                echo "<div class = 'data-container-datum'>High " . getMax($soilmoistureArray) . "</div>";
                echo "<div class = 'data-container-datum'>Low " . getMin($soilmoistureArray) . "</div>";
                ?>            </div>
        </div>
        <div class = "category-wrap">
            <div class="chart-container" id="chart-5">Temp chart renders here</div>
            <div class="data-container" style="height: <?php echo $height; ?>px;">
                <?php
                echo "<div class = 'data-container-datum'>Now " . $soilphArray[1] . "</div>";
                echo "<div class = 'data-container-datum'>Average " . getAverage($soilphArray) . "</div>";
                echo "<div class = 'data-container-datum'>Trend " . getTrend($soilphArray) . "/hr</div>";
                echo "<div class = 'data-container-datum'>High " . getMax($soilphArray) . "</div>";
                echo "<div class = 'data-container-datum'>Low " . getMin($soilphArray) . "</div>";
                ?>            </div>
        </div>
    </div>
    <div class = "col-sm-2">Put weather forecast API here</div>
</div>


</body>




