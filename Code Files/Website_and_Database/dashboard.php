<!DOCTYPE html>
<html>

<?php
include_once 'functions.php';
include_once 'fusioncharts/fusioncharts.php';
$conn = gs2_database_connect();
?>

<head>
    <title>GS2 Dashboard</title>
    <link rel="stylesheet" type="text/css" href="library/bootstrap.css"/>
    <link rel="stylesheet" type="text/css" href="library/gs2styles.css"/>
    <script src="fusioncharts/js/fusioncharts.js"></script>
    <script src="fusioncharts/js/fusioncharts.theme.ocean.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.9/js/all.js" integrity="sha384-8iPTk2s/jMVj81dnzb/iFR2sdA7u06vHJyyLlAd4snFpCl/SnyUjRrbdJsw1pGIl" crossorigin="anonymous"></script>

    <nav class="navbar  navbar-dark bg-primary sticky-top" style="margin-bottom: 0px; background-color: #5cb85c;">
        <a class="navbar-brand" href="#" style="color: white;"><b>My Smart Gardening System</b></a>
        <div class="gs2-button" style="float:right; margin-right: 10px;">
            <a class="btn btn-primary" href="parameters.php?" role="button" style="background-color:#5cb85c; border-color: #ffffff; margin: 5% auto; font-size: 125%;"><b>Set system parameters</b></a>
        </div>
    </nav>
</head>

<body>

<?php


$weather=file_get_contents("http://dataservice.accuweather.com/locations/v1/cities/search?q=97333&apikey=42chrUuGeePyvQGvwJGZ2bKGoCGTvGx5&metric=true");

$pos = strpos($weather, "\"Key\":\"");
$begin = $pos + 7;
$pos = strpos($weather, "\"Type\":\"");
$end = $pos - 2;
$length = $end - $begin;
$substr = substr($weather, $begin, $length);

$current=file_get_contents("http://dataservice.accuweather.com/forecasts/v1/hourly/12hour/" . $substr. "?apikey=42chrUuGeePyvQGvwJGZ2bKGoCGTvGx5&metric=true");


//$current = '[{"DateTime":"2018-05-11T16:00:00-07:00","EpochDateTime":1526079600,"WeatherIcon":2,"IconPhrase":"Mostly sunny","IsDaylight":true,"Temperature":{"Value":17.9,"Unit":"C","UnitType":17},"PrecipitationProbability":0,"MobileLink":"http://m.accuweather.com/en/us/corvallis-or/97330/hourly-weather-forecast/40973_pc?day=1&unit=c&lang=en-us","Link":"http://www.accuweather.com/en/us/corvallis-or/97330/hourly-weather-forecast/40973_pc?day=1&hbhhour=16&unit=c&lang=en-us"},{"DateTime":"2018-05-11T17:00:00-07:00","EpochDateTime":1526083200,"WeatherIcon":2,"IconPhrase":"Mostly sunny","IsDaylight":true,"Temperature":{"Value":18.5,"Unit":"C","UnitType":17},"PrecipitationProbability":0,"MobileLink":"http://m.accuweather.com/en/us/corvallis-or/97330/hourly-weather-forecast/40973_pc?day=1&unit=c&lang=en-us","Link":"http://www.accuweather.com/en/us/corvallis-or/97330/hourly-weather-forecast/40973_pc?day=1&hbhhour=17&unit=c&lang=en-us"},{"DateTime":"2018-05-11T18:00:00-07:00","EpochDateTime":1526086800,"WeatherIcon":2,"IconPhrase":"Mostly sunny","IsDaylight":true,"Temperature":{"Value":17.9,"Unit":"C","UnitType":17},"PrecipitationProbability":0,"MobileLink":"http://m.accuweather.com/en/us/corvallis-or/97330/hourly-weather-forecast/40973_pc?day=1&unit=c&lang=en-us","Link":"http://www.accuweather.com/en/us/corvallis-or/97330/hourly-weather-forecast/40973_pc?day=1&hbhhour=18&unit=c&lang=en-us"},{"DateTime":"2018-05-11T19:00:00-07:00","EpochDateTime":1526090400,"WeatherIcon":2,"IconPhrase":"Mostly sunny","IsDaylight":true,"Temperature":{"Value":16.7,"Unit":"C","UnitType":17},"PrecipitationProbability":0,"MobileLink":"http://m.accuweather.com/en/us/corvallis-or/97330/hourly-weather-forecast/40973_pc?day=1&unit=c&lang=en-us","Link":"http://www.accuweather.com/en/us/corvallis-or/97330/hourly-weather-forecast/40973_pc?day=1&hbhhour=19&unit=c&lang=en-us"},{"DateTime":"2018-05-11T20:00:00-07:00","EpochDateTime":1526094000,"WeatherIcon":2,"IconPhrase":"Mostly sunny","IsDaylight":true,"Temperature":{"Value":15.5,"Unit":"C","UnitType":17},"PrecipitationProbability":0,"MobileLink":"http://m.accuweather.com/en/us/corvallis-or/97330/hourly-weather-forecast/40973_pc?day=1&unit=c&lang=en-us","Link":"http://www.accuweather.com/en/us/corvallis-or/97330/hourly-weather-forecast/40973_pc?day=1&hbhhour=20&unit=c&lang=en-us"},{"DateTime":"2018-05-11T21:00:00-07:00","EpochDateTime":1526097600,"WeatherIcon":34,"IconPhrase":"Mostly clear","IsDaylight":false,"Temperature":{"Value":13.6,"Unit":"C","UnitType":17},"PrecipitationProbability":0,"MobileLink":"http://m.accuweather.com/en/us/corvallis-or/97330/hourly-weather-forecast/40973_pc?day=1&unit=c&lang=en-us","Link":"http://www.accuweather.com/en/us/corvallis-or/97330/hourly-weather-forecast/40973_pc?day=1&hbhhour=21&unit=c&lang=en-us"},{"DateTime":"2018-05-11T22:00:00-07:00","EpochDateTime":1526101200,"WeatherIcon":34,"IconPhrase":"Mostly clear","IsDaylight":false,"Temperature":{"Value":12.2,"Unit":"C","UnitType":17},"PrecipitationProbability":0,"MobileLink":"http://m.accuweather.com/en/us/corvallis-or/97330/hourly-weather-forecast/40973_pc?day=1&unit=c&lang=en-us","Link":"http://www.accuweather.com/en/us/corvallis-or/97330/hourly-weather-forecast/40973_pc?day=1&hbhhour=22&unit=c&lang=en-us"},{"DateTime":"2018-05-11T23:00:00-07:00","EpochDateTime":1526104800,"WeatherIcon":34,"IconPhrase":"Mostly clear","IsDaylight":false,"Temperature":{"Value":11.1,"Unit":"C","UnitType":17},"PrecipitationProbability":0,"MobileLink":"http://m.accuweather.com/en/us/corvallis-or/97330/hourly-weather-forecast/40973_pc?day=1&unit=c&lang=en-us","Link":"http://www.accuweather.com/en/us/corvallis-or/97330/hourly-weather-forecast/40973_pc?day=1&hbhhour=23&unit=c&lang=en-us"},{"DateTime":"2018-05-12T00:00:00-07:00","EpochDateTime":1526108400,"WeatherIcon":34,"IconPhrase":"Mostly clear","IsDaylight":false,"Temperature":{"Value":10.5,"Unit":"C","UnitType":17},"PrecipitationProbability":0,"MobileLink":"http://m.accuweather.com/en/us/corvallis-or/97330/hourly-weather-forecast/40973_pc?day=2&unit=c&lang=en-us","Link":"http://www.accuweather.com/en/us/corvallis-or/97330/hourly-weather-forecast/40973_pc?day=2&hbhhour=0&unit=c&lang=en-us"},{"DateTime":"2018-05-12T01:00:00-07:00","EpochDateTime":1526112000,"WeatherIcon":34,"IconPhrase":"Mostly clear","IsDaylight":false,"Temperature":{"Value":9.9,"Unit":"C","UnitType":17},"PrecipitationProbability":0,"MobileLink":"http://m.accuweather.com/en/us/corvallis-or/97330/hourly-weather-forecast/40973_pc?day=2&unit=c&lang=en-us","Link":"http://www.accuweather.com/en/us/corvallis-or/97330/hourly-weather-forecast/40973_pc?day=2&hbhhour=1&unit=c&lang=en-us"},{"DateTime":"2018-05-12T02:00:00-07:00","EpochDateTime":1526115600,"WeatherIcon":34,"IconPhrase":"Mostly clear","IsDaylight":false,"Temperature":{"Value":9.2,"Unit":"C","UnitType":17},"PrecipitationProbability":0,"MobileLink":"http://m.accuweather.com/en/us/corvallis-or/97330/hourly-weather-forecast/40973_pc?day=2&unit=c&lang=en-us","Link":"http://www.accuweather.com/en/us/corvallis-or/97330/hourly-weather-forecast/40973_pc?day=2&hbhhour=2&unit=c&lang=en-us"},{"DateTime":"2018-05-12T03:00:00-07:00","EpochDateTime":1526119200,"WeatherIcon":34,"IconPhrase":"Mostly clear","IsDaylight":false,"Temperature":{"Value":8.8,"Unit":"C","UnitType":17},"PrecipitationProbability":0,"MobileLink":"http://m.accuweather.com/en/us/corvallis-or/97330/hourly-weather-forecast/40973_pc?day=2&unit=c&lang=en-us","Link":"http://www.accuweather.com/en/us/corvallis-or/97330/hourly-weather-forecast/40973_pc?day=2&hbhhour=3&unit=c&lang=en-us"}]';
//echo $current;
$temp = $current;
$begin = strpos($temp, "hbhhour=");
$end = strpos($temp, "&lang=en-us\"},{\"DateTime\"");

$hour = substr($temp, ($begin + 8), ($end - $begin));


$forecasttemparray = array();
$forecastcondarray = array();


for ($i = 0; $i < 12; $i++) {
    $forecastcondarray[$i] = parseTemp($current, "\"IconPhrase\":\"", ",\"IsDaylight\"");
    $current = parseString($current, ",\"IsDaylight\"");

    $forecasttemparray[$i] = parseTemp($current, "{\"Value\":", "\"Unit\":\"C\"");
    $current = parseString($current, "\"Unit\":\"C\"");
}



$table1 = array(array());

$name = "Parameters";
$table1 = get_table($conn, $name, 12);


$hitempbound = $table1[0][1];
$lotempbound = $table1[0][2];
$hihumidbound = $table1[0][3];
$lohumidbound = $table1[0][4];
$hipresbound = $table1[0][5];
$lopresbound = $table1[0][6];
$himoistbound = $table1[0][7];
$lomoistbound = $table1[0][8];
$interval = $table1[0][11];


if(isset($_GET['readings']) && $_GET['readings']!=""){
    $num_readings = $_GET['readings'];
}
else {
    $num_readings = 10;
}

$height = 400;

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
for ($i = 1; $i <= $num_readings; $i++){
    $timeArray[$i] = date('H:i:s', strtotime($table[$num_rows - ($num_readings - $i + 1)]['1']));
    $tempArray[$i] = $table[$num_rows - ($num_readings - $i + 1)]['2'];
    $humidityArray[$i] = $table[$num_rows - ($num_readings - $i + 1)]['3'];
    $pressureArray[$i] = $table[$num_rows - ($num_readings - $i + 1)]['4'];
    $soilmoistureArray[$i] = $table[$num_rows - ($num_readings - $i + 1)]['5'];
    $soilphArray[$i] = $table[$num_rows - ($num_readings - $i + 1)]['6'];
    $batteryArray[$i] = $table[$num_rows - ($num_readings - $i + 1)]['7'];
}

$currentDay = date('M d Y', strtotime($table[$num_rows-1][1]));
$temp_time_Array = array_combine($timeArray, $tempArray);
$humidity_time_Array = array_combine($timeArray, $humidityArray);
$pressure_time_Array = array_combine($timeArray, $pressureArray);
$soilmoisture_time_Array = array_combine($timeArray, $soilmoistureArray);
$soilph_time_Array = array_combine($timeArray, $soilphArray);
$subtitle = "Last " . $num_readings . " readings";
$tempChart = makeNewBarGraph("Temperature", $subtitle, $temp_time_Array, "chart-1", $height, $currentDay, $num_readings);
$tempChart->render();
$humidityChart = makeNewBarGraph("Humidity", $subtitle, $humidity_time_Array, "chart-2", $height, $currentDay, $num_readings);
$humidityChart->render();
$pressureChart = makeNewBarGraph("Pressure", $subtitle, $pressure_time_Array, "chart-3", $height, $currentDay, $num_readings);
$pressureChart->render();
$soilmoistureChart = makeNewBarGraph("Soil Moisture", $subtitle, $soilmoisture_time_Array, "chart-4", $height, $currentDay, $num_readings);
$soilmoistureChart->render();
$soilphChart = makeNewBarGraph("Light Intensity", $subtitle, $soilph_time_Array, "chart-5", $height, $currentDay, $num_readings);
$soilphChart->render();


$current_temperature = number_format($tempArray[$num_readings], 1);
$current_humidity = number_format($humidityArray[$num_readings], 1);
$current_pressure = number_format($pressureArray[$num_readings], 1);
$current_moisture = number_format($soilmoistureArray[$num_readings], 1);
$current_pH = number_format($soilphArray[$num_readings], 1);


if(isset($_GET['chart']) && $_GET['chart']!=""){
    if ($_GET['chart']==1){
        $chart = "chart-1";
        $array = $tempArray;
        $currentgraphedval = number_format($tempArray[$num_readings], 1);
        $hibound = $hitempbound;
        $lobound = $lotempbound;
    }
    else if ($_GET['chart']==2){
        $chart = "chart-2";
        $array = $humidityArray;
        $currentgraphedval = number_format($humidityArray[$num_readings], 1);
        $hibound = $hihumidbound;
        $lobound = $lohumidbound;
    }
    else if ($_GET['chart']==3){
        $chart = "chart-3";
        $array = $pressureArray;
        $currentgraphedval = number_format($pressureArray[$num_readings], 1);
        $hibound = $hipresbound;
        $lobound = $lopresbound;
    }
    else if ($_GET['chart']==4){
        $chart = "chart-4";
        $array = $soilmoistureArray;
        $currentgraphedval = number_format($soilmoistureArray[$num_readings], 1);
        $hibound = $himoistbound;
        $lobound = $lomoistbound;
    }
    else {
        $chart = "chart-5";
        $array = $soilphArray;
        $currentgraphedval = number_format($soilphArray[$num_readings], 1);
        $hibound = 999;
        $lobound = -999;
    }
}
else{
    $chart = "chart-1";
    $array = $tempArray;
    $currentgraphedval = number_format($tempArray[$num_readings], 1);
    $hibound = $hitempbound;
    $lobound = $lotempbound;
}

?>

<div class = "row">
    <div class = "col-sm-1">

    </div>

    <div class = "col-sm-10">
        <div class="status-bar-label-container">
            Below are the current conditions. Click to see graph.
        </div>

        <div class = "status-bar" style="margin-bottom: 5px;">
            <div class="status-bar-section" title="Temperature (Click to view graph)" style="<?php if($lotempbound > $current_temperature){echo 'color:#b5d5ff';} else if($hitempbound < $current_temperature){echo 'color:#d01d1d';}?>">
                <a href="dashboard.php?chart=1">
                    <span class="link-spanner"></span>
                </a>
                <div class="status-bar-section-left">
                    <i class="fas fa-thermometer-full"></i>
                    <?php
                    echo html_entity_decode($current_temperature . "&deg"); ?>
                </div>
                <div class="status-bar-section-right">
                    <span class="status-bar-units">Temperature (C)</span>
                </div>
            </div>
            <div class="status-bar-section" style="<?php if($lohumidbound > $current_humidity){echo 'color:#b5d5ff';} else if($hihumidbound < $current_humidity){echo 'color:#d01d1d';}?>">
                <a href="dashboard.php?chart=2">
                    <span class="link-spanner"></span>
                </a>
                <div class="status-bar-section-left">
                <i class="fas fa-cloud"></i>
                <?php echo $current_humidity ?>
                </div>
                <div class="status-bar-section-right">
                    <span class="status-bar-units">Humidity (%)</span>
                </div>
            </div>
            <div class="status-bar-section" style="<?php if($lopresbound > $current_pressure){echo 'color:#b5d5ff';} else if($hipresbound < $current_pressure){echo 'color:#d01d1d';}?>">
                <a href="dashboard.php?chart=3">
                    <span class="link-spanner"></span>
                </a>
                <div class="status-bar-section-left">
                <i class="fas fa-weight"></i>
                <?php echo $current_pressure ?>
                </div>
                <div class="status-bar-section-right">
                    <span class="status-bar-units">Pressure (hPa)</span>
                </div>
            </div>
            <div class="status-bar-section" style="<?php if($lomoistbound > $current_moisture){echo 'color:#b5d5ff';} else if($himoistbound < $current_moisture){echo 'color:#d01d1d';}?>">
                <a href="dashboard.php?chart=4">
                    <span class="link-spanner"></span>
                </a>
                <div class="status-bar-section-left">

                    <i class="fas fa-tint"></i>
                    <?php echo $current_moisture ?>
                </div>
                <div class="status-bar-section-right">
                    <span class="status-bar-units">Soil Moisture (%)</span>
                </div>
            </div>
            <div class="status-bar-section">
                <a href="dashboard.php?chart=5">
                    <span class="link-spanner"></span>
                </a>
                <div class="status-bar-section-left">

                <i class="fas fa-lightbulb"></i>
                <?php echo $current_pH ?>
                </div>
                <div class="status-bar-section-right">
                    <span class="status-bar-units">Light (lx)</span>
                </div>
            </div>

        </div>
    </div>
    <div class = "col-sm-1">

    </div>
</div>
<div class = "row">
    <div class = "col-sm-2">
        <div class="weather-wrap">
<?php
                if ($hour > 12)
                {
                    $ampm = "pm";
                    $next = "am";
                    $hour = $hour % 12;
                }
                else {
                    $ampm = "am";
                    $next = "pm";
                }
                for ($i = 0; $i < 12; $i++) {
                    if ($hour > 12) {
                        $printhour = $hour % 12;
                        $ampm = $next;
                    }
                    else{
                        $printhour = $hour;

                    }

                        if ($printhour == 0){
                        $printhour = 12;
                    }
                    echo "<div class='weather-wrap-inner'>";
                        echo "<div class='forecast-time'>";
                            echo $printhour . ":00" . $ampm;
                        echo "</div>";
                        echo "<div class='forecast-time'>";
                            echo "<div class='forecast-temp'>";
                                echo html_entity_decode($forecasttemparray[$i] . "&deg") . "C";
                            echo "</div>";
                            echo "<div class='forecast-conditions'>";
                                echo $forecastcondarray[$i];
                            echo "</div>";
                        echo "</div>";
                        echo "<div class='forecast-icon'>";
                            if (strpos($forecastcondarray[$i], 'Snow') !== false || strpos($forecastcondarray[$i], 'snow') !== false) {
                                    echo "<i class=\"fas fa-snowflake\"></i>";
                                }
                                else if (strpos($forecastcondarray[$i], 'Rain') !== false || strpos($forecastcondarray[$i], 'rain') !== false) {
                                    echo "<i class=\"fas fa-tint\"></i>";
                                }
                                else if (strpos($forecastcondarray[$i], 'Cloud') !== false || strpos($forecastcondarray[$i], 'cloud') !== false || strpos($forecastcondarray[$i], 'Dreary') !== false) {
                                    echo "<i class=\"fas fa-cloud\"></i>";
                                }
                                else if (strpos($forecastcondarray[$i], 'Sun') !== false || strpos($forecastcondarray[$i], 'sun') !== false) {
                                    echo "<i class=\"fas fa-sun\"></i>";
                                }
                                else if (strpos($forecastcondarray[$i], 'Clear') !== false || strpos($forecastcondarray[$i], 'clear') !== false) {
                                    echo "<i class=\"fas fa-moon\"></i>";
                                }
                                else {
                                    echo 'Default';
                                }
                                $hour = $hour + 1;
                        echo "</div>";
                    echo "</div>";
                }
                ?>
            <a href="https://developer.accuweather.com/packages" >
                <img src="library/accuweather.png" style="width:60%; height 20px;" />
            </a>
        </div>
    </div>

    <div class = "col-sm-7">
        <div class = "category-wrap">
            <div class="chart-container" id="<?php echo $chart?>">Temp chart renders here</div>
            <div class="data-container" style="height: <?php echo $height; ?>px;">
                <div class = 'data-container-datum'>
                    <div class = 'data-container-datum-label'>Now:</div>
                    <div class = 'data-container-datum-value'style="<?php if($lobound > $currentgraphedval){echo 'color:#b5d5ff';} else if($hibound < $currentgraphedval){echo 'color:#d01d1d';}?>"><?php echo number_format($currentgraphedval, 1); ?></div>
                </div>
                <div class = 'data-container-datum'>
                    <div class = 'data-container-datum-label'>Avg:</div>
                    <div class = 'data-container-datum-value' style="<?php if($lobound > getAverage($array)){echo 'color:#b5d5ff';} else if($hibound < getAverage($array)){echo 'color:#d01d1d';}?>"><?php echo number_format(getAverage($array), 1); ?></div>
                </div>
                <div class = 'data-container-datum'>
                    <div class = 'data-container-datum-label'>Trend:</div>
                    <div class = 'data-container-datum-value'><?php echo number_format(getTrend($array), 1); ?></div>
                </div>
                <div class = 'data-container-datum'>
                    <div class = 'data-container-datum-label'>High:</div>
                    <div class = 'data-container-datum-value' style="<?php if($lobound > getMax($array)){echo 'color:#b5d5ff';} else if($hibound < getMax($array)){echo 'color:#d01d1d';}?>"><?php echo number_format(getMax($array),1); ?></div>
                </div>
                <div class = 'data-container-datum'>
                    <div class = 'data-container-datum-label'>Low:</div>
                    <div class = 'data-container-datum-value' style="<?php if($lobound > getMin($array)){echo 'color:#b5d5ff';} else if($hibound < getMin($array)){echo 'color:#d01d1d';}?>"><?php echo number_format(getMin($array), 1); ?></div>
                </div>
                <div class="status-bar-label-container" style="vertical-align: top;">
                    <form id="form1" method="get" href="dashboard.php?chart=<?php echo $chart?>" style="margin-top: 5px;">
                        Num readings: <?php echo $num_readings; ?>
                        <input type="hidden" name="chart" value="<?php echo $_GET['chart'];?>" />
                        <input name="readings" id="readings" type="text" class="form-control form-parameter form-parameter form-parameter form-parameter form-parameter" style="width: 50px;">
                        <br>
                        <button class="btn btn-primary" style="background-color:#5cb85c; border-color: #ffffff; margin-top: 5px; margin-bottom: 25px; font-size: 80%;" type="submit">Change number of readings shown</button>
                    </form>
                    Current read interval: <?php echo $interval ;?> min

                </div>
            </div>

        </div>

    </div>
    <div class = "col-sm-3">

        <form class="form-search" id="searchform" name="searchform" method="get" action="view_data.php" style="margin-left:3%; width: 95%;">
            <h2 class="form-signup-heading" style="color:white; margin-bottom: 0;">Search Center</h2>
            <div class="form-signup-subheading" style="margin-left: 5%; margin-right: 15%; margin-bottom: 5%;">Creates a customized view of your data from time x to time y</div>

            <div class="earlywrap">
                <label for="xmonth">Month X:</label>
                <select name="xmonth" id="xmonth" class="form-control form-search">
                    <option value="1">January</option>
                    <option value="2">February</option>
                    <option value="3">March</option>
                    <option value="4">April</option>
                    <option value="5">May</option>
                    <option value="6">June</option>
                    <option value="7">July</option>
                    <option value="8">August</option>
                    <option value="9">September</option>
                    <option value="10">October</option>
                    <option value="11">November</option>
                    <option value="12">December</option>
                </select>
                <label for="xday">Day X:</label>
                <select name="xday" id="xday" class="form-control form-search">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                    <option value="9">9</option>
                    <option value="10">10</option>
                    <option value="11">11</option>
                    <option value="12">12</option>
                    <option value="13">13</option>
                    <option value="14">14</option>
                    <option value="15">15</option>
                    <option value="16">16</option>
                    <option value="17">17</option>
                    <option value="18">18</option>
                    <option value="19">19</option>
                    <option value="20">20</option>
                    <option value="21">21</option>
                    <option value="22">22</option>
                    <option value="23">23</option>
                    <option value="24">24</option>
                    <option value="25">25</option>
                    <option value="26">26</option>
                    <option value="27">27</option>
                    <option value="28">28</option>
                    <option value="29">29</option>
                    <option value="30">30</option>
                    <option value="31">31</option>
                </select>
                <label for="xday">Year X:</label>

                <select name="xyear" id="xyear" class="form-control form-search">
                    <?PHP for($i=date("Y"); $i<=date("Y")+4; $i++)
                        if($year == $i)
                            echo "<option value='$i' selected>$i</option>";
                        else
                            echo "<option value='$i'>$i</option>";
                    ?>
                </select>
                <label for="xhour">Hour X:</label>
                <select name="xhour" id="xhour" class="form-control form-search">
                    <option value="0" <?PHP if($month==12) echo "selected";?>>12 a.m.</option>
                    <option value="1"  <?PHP if($month==1) echo "selected";?>>1 a.m.</option>
                    <option value="2"  <?PHP if($month==2) echo "selected";?>>2 a.m.</option>
                    <option value="3"  <?PHP if($month==3) echo "selected";?>>3 a.m.</option>
                    <option value="4"  <?PHP if($month==4) echo "selected";?>>4 a.m.</option>
                    <option value="5"  <?PHP if($month==5) echo "selected";?>>5 a.m.</option>
                    <option value="6"  <?PHP if($month==6) echo "selected";?>>6 a.m.</option>
                    <option value="7"  <?PHP if($month==7) echo "selected";?>>7 a.m.</option>
                    <option value="8"  <?PHP if($month==8) echo "selected";?>>8 a.m.</option>
                    <option value="9"  <?PHP if($month==9) echo "selected";?>>9 a.m.</option>
                    <option value="10" <?PHP if($month==10) echo "selected";?>>10 a.m.</option>
                    <option value="11" <?PHP if($month==11) echo "selected";?>>11 a.m.</option>
                    <option value="12" <?PHP if($month==12) echo "selected";?>>12 p.m.</option>
                    <option value="13"  <?PHP if($month==1) echo "selected";?>>1 p.m.</option>
                    <option value="14"  <?PHP if($month==2) echo "selected";?>>2 p.m.</option>
                    <option value="15"  <?PHP if($month==3) echo "selected";?>>3 p.m.</option>
                    <option value="16"  <?PHP if($month==4) echo "selected";?>>4 p.m.</option>
                    <option value="17"  <?PHP if($month==5) echo "selected";?>>5 p.m.</option>
                    <option value="18"  <?PHP if($month==6) echo "selected";?>>6 p.m.</option>
                    <option value="19"  <?PHP if($month==7) echo "selected";?>>7 p.m.</option>
                    <option value="20"  <?PHP if($month==8) echo "selected";?>>8 p.m.</option>
                    <option value="21"  <?PHP if($month==9) echo "selected";?>>9 p.m.</option>
                    <option value="22" <?PHP if($month==10) echo "selected";?>>10 p.m.</option>
                    <option value="23" <?PHP if($month==11) echo "selected";?>>11 p.m.</option>
                </select>
                <label for="xminute">Minute X:</label>
                <select name="xminute" id="xminute" class="form-control form-search">
                    <option value="0" <?PHP if($month==12) echo "selected";?>>0</option>
                    <option value="1"  <?PHP if($month==1) echo "selected";?>>1</option>
                    <option value="2"  <?PHP if($month==2) echo "selected";?>>2</option>
                    <option value="3"  <?PHP if($month==3) echo "selected";?>>3</option>
                    <option value="4"  <?PHP if($month==4) echo "selected";?>>4</option>
                    <option value="5"  <?PHP if($month==5) echo "selected";?>>5</option>
                    <option value="6"  <?PHP if($month==6) echo "selected";?>>6</option>
                    <option value="7"  <?PHP if($month==7) echo "selected";?>>7</option>
                    <option value="8"  <?PHP if($month==8) echo "selected";?>>8</option>
                    <option value="9"  <?PHP if($month==9) echo "selected";?>>9</option>
                    <option value="10" <?PHP if($month==10) echo "selected";?>>10</option>
                    <option value="11" <?PHP if($month==11) echo "selected";?>>11</option>
                    <option value="12" <?PHP if($month==12) echo "selected";?>>12</option>
                    <option value="13"  <?PHP if($month==1) echo "selected";?>>13</option>
                    <option value="14"  <?PHP if($month==2) echo "selected";?>>14</option>
                    <option value="15"  <?PHP if($month==3) echo "selected";?>>15</option>
                    <option value="16"  <?PHP if($month==4) echo "selected";?>>16</option>
                    <option value="17"  <?PHP if($month==5) echo "selected";?>>17</option>
                    <option value="18"  <?PHP if($month==6) echo "selected";?>>18</option>
                    <option value="19"  <?PHP if($month==7) echo "selected";?>>19</option>
                    <option value="20"  <?PHP if($month==8) echo "selected";?>>20</option>
                    <option value="21"  <?PHP if($month==9) echo "selected";?>>21</option>
                    <option value="22" <?PHP if($month==10) echo "selected";?>>22</option>
                    <option value="23" <?PHP if($month==11) echo "selected";?>>23</option>
                    <option value="24" <?PHP if($month==12) echo "selected";?>>24</option>
                    <option value="25"  <?PHP if($month==1) echo "selected";?>>25</option>
                    <option value="26"  <?PHP if($month==2) echo "selected";?>>26</option>
                    <option value="27"  <?PHP if($month==3) echo "selected";?>>27</option>
                    <option value="28"  <?PHP if($month==4) echo "selected";?>>28</option>
                    <option value="29"  <?PHP if($month==5) echo "selected";?>>29</option>
                    <option value="30"  <?PHP if($month==6) echo "selected";?>>30</option>
                    <option value="31"  <?PHP if($month==7) echo "selected";?>>31</option>
                    <option value="32"  <?PHP if($month==8) echo "selected";?>>32</option>
                    <option value="33"  <?PHP if($month==9) echo "selected";?>>33</option>
                    <option value="34" <?PHP if($month==10) echo "selected";?>>34</option>
                    <option value="35" <?PHP if($month==11) echo "selected";?>>35</option>
                    <option value="36" <?PHP if($month==12) echo "selected";?>>36</option>
                    <option value="37"  <?PHP if($month==1) echo "selected";?>>37</option>
                    <option value="38"  <?PHP if($month==2) echo "selected";?>>38</option>
                    <option value="39"  <?PHP if($month==3) echo "selected";?>>39</option>
                    <option value="40"  <?PHP if($month==4) echo "selected";?>>40</option>
                    <option value="41"  <?PHP if($month==5) echo "selected";?>>41</option>
                    <option value="42"  <?PHP if($month==6) echo "selected";?>>42</option>
                    <option value="43"  <?PHP if($month==7) echo "selected";?>>43</option>
                    <option value="44"  <?PHP if($month==8) echo "selected";?>>44</option>
                    <option value="45"  <?PHP if($month==9) echo "selected";?>>45</option>
                    <option value="46" <?PHP if($month==10) echo "selected";?>>46</option>
                    <option value="47" <?PHP if($month==11) echo "selected";?>>47</option>
                    <option value="48" <?PHP if($month==12) echo "selected";?>>48</option>
                    <option value="49"  <?PHP if($month==1) echo "selected";?>>49</option>
                    <option value="50"  <?PHP if($month==2) echo "selected";?>>50</option>
                    <option value="51"  <?PHP if($month==3) echo "selected";?>>51</option>
                    <option value="52"  <?PHP if($month==4) echo "selected";?>>52</option>
                    <option value="53"  <?PHP if($month==5) echo "selected";?>>53</option>
                    <option value="54"  <?PHP if($month==6) echo "selected";?>>54</option>
                    <option value="55"  <?PHP if($month==7) echo "selected";?>>55</option>
                    <option value="56"  <?PHP if($month==8) echo "selected";?>>56</option>
                    <option value="57"  <?PHP if($month==9) echo "selected";?>>57</option>
                    <option value="58" <?PHP if($month==10) echo "selected";?>>58</option>
                    <option value="59" <?PHP if($month==11) echo "selected";?>>59</option>
                </select>
            </div>

            <div class="earlywrap">
                <label for="ymonth">Day Y:</label>
                <select name="ymonth" id="ymonth" class="form-control form-search">
                    <option value="1"  <?PHP if($month==1) echo "selected";?>>January</option>
                    <option value="2"  <?PHP if($month==2) echo "selected";?>>February</option>
                    <option value="3"  <?PHP if($month==3) echo "selected";?>>March</option>
                    <option value="4"  <?PHP if($month==4) echo "selected";?>>April</option>
                    <option value="5"  <?PHP if($month==5) echo "selected";?>>May</option>
                    <option value="6"  <?PHP if($month==6) echo "selected";?>>June</option>
                    <option value="7"  <?PHP if($month==7) echo "selected";?>>July</option>
                    <option value="8"  <?PHP if($month==8) echo "selected";?>>August</option>
                    <option value="9"  <?PHP if($month==9) echo "selected";?>>September</option>
                    <option value="10" <?PHP if($month==10) echo "selected";?>>October</option>
                    <option value="11" <?PHP if($month==11) echo "selected";?>>November</option>
                    <option value="12" <?PHP if($month==12) echo "selected";?>>December</option>
                </select>

                <label for="yday">Day Y:</label>
                <select name="yday" id="yday" class="form-control form-search">
                    <option value="1"  <?PHP if($day==1) echo "selected";?>>1</option>
                    <option value="2"  <?PHP if($day==2) echo "selected";?>>2</option>
                    <option value="3"  <?PHP if($day==3) echo "selected";?>>3</option>
                    <option value="4"  <?PHP if($day==4) echo "selected";?>>4</option>
                    <option value="5"  <?PHP if($day==5) echo "selected";?>>5</option>
                    <option value="6"  <?PHP if($day==6) echo "selected";?>>6</option>
                    <option value="7"  <?PHP if($day==7) echo "selected";?>>7</option>
                    <option value="8"  <?PHP if($day==8) echo "selected";?>>8</option>
                    <option value="9"  <?PHP if($day==9) echo "selected";?>>9</option>
                    <option value="10" <?PHP if($day==10) echo "selected";?>>10</option>
                    <option value="11" <?PHP if($day==11) echo "selected";?>>11</option>
                    <option value="12" <?PHP if($day==12) echo "selected";?>>12</option>
                    <option value="13" <?PHP if($day==13) echo "selected";?>>13</option>
                    <option value="14" <?PHP if($day==14) echo "selected";?>>14</option>
                    <option value="15" <?PHP if($day==15) echo "selected";?>>15</option>
                    <option value="16" <?PHP if($day==16) echo "selected";?>>16</option>
                    <option value="17" <?PHP if($day==17) echo "selected";?>>17</option>
                    <option value="18" <?PHP if($day==18) echo "selected";?>>18</option>
                    <option value="19" <?PHP if($day==19) echo "selected";?>>19</option>
                    <option value="20" <?PHP if($day==20) echo "selected";?>>20</option>
                    <option value="21" <?PHP if($day==21) echo "selected";?>>21</option>
                    <option value="22" <?PHP if($day==22) echo "selected";?>>22</option>
                    <option value="23" <?PHP if($day==23) echo "selected";?>>23</option>
                    <option value="24" <?PHP if($day==24) echo "selected";?>>24</option>
                    <option value="25" <?PHP if($day==25) echo "selected";?>>25</option>
                    <option value="26" <?PHP if($day==26) echo "selected";?>>26</option>
                    <option value="27" <?PHP if($day==27) echo "selected";?>>27</option>
                    <option value="28" <?PHP if($day==28) echo "selected";?>>28</option>
                    <option value="29" <?PHP if($day==29) echo "selected";?>>29</option>
                    <option value="30" <?PHP if($day==30) echo "selected";?>>30</option>
                    <option value="31" <?PHP if($day==31) echo "selected";?>>31</option>
                </select>

                <label for="yyear">Year Y:</label>
                <select name="yyear" id="yyear" class="form-control form-search">
                    <?PHP for($i=date("Y"); $i<=date("Y")+4; $i++)
                        if($year == $i)
                            echo "<option value='$i' selected>$i</option>";
                        else
                            echo "<option value='$i'>$i</option>";
                    ?>
                </select>

            <label for="yhour">Hour Y:</label>
            <select name="yhour" id="yhour" class="form-control form-search">
                <option value="0" <?PHP if($month==12) echo "selected";?>>12 a.m.</option>
                <option value="1"  <?PHP if($month==1) echo "selected";?>>1 a.m.</option>
                <option value="2"  <?PHP if($month==2) echo "selected";?>>2 a.m.</option>
                <option value="3"  <?PHP if($month==3) echo "selected";?>>3 a.m.</option>
                <option value="4"  <?PHP if($month==4) echo "selected";?>>4 a.m.</option>
                <option value="5"  <?PHP if($month==5) echo "selected";?>>5 a.m.</option>
                <option value="6"  <?PHP if($month==6) echo "selected";?>>6 a.m.</option>
                <option value="7"  <?PHP if($month==7) echo "selected";?>>7 a.m.</option>
                <option value="8"  <?PHP if($month==8) echo "selected";?>>8 a.m.</option>
                <option value="9"  <?PHP if($month==9) echo "selected";?>>9 a.m.</option>
                <option value="10" <?PHP if($month==10) echo "selected";?>>10 a.m.</option>
                <option value="11" <?PHP if($month==11) echo "selected";?>>11 a.m.</option>
                <option value="12" <?PHP if($month==12) echo "selected";?>>12 p.m.</option>
                <option value="13"  <?PHP if($month==1) echo "selected";?>>1 p.m.</option>
                <option value="14"  <?PHP if($month==2) echo "selected";?>>2 p.m.</option>
                <option value="15"  <?PHP if($month==3) echo "selected";?>>3 p.m.</option>
                <option value="16"  <?PHP if($month==4) echo "selected";?>>4 p.m.</option>
                <option value="17"  <?PHP if($month==5) echo "selected";?>>5 p.m.</option>
                <option value="18"  <?PHP if($month==6) echo "selected";?>>6 p.m.</option>
                <option value="19"  <?PHP if($month==7) echo "selected";?>>7 p.m.</option>
                <option value="20"  <?PHP if($month==8) echo "selected";?>>8 p.m.</option>
                <option value="21"  <?PHP if($month==9) echo "selected";?>>9 p.m.</option>
                <option value="22" <?PHP if($month==10) echo "selected";?>>10 p.m.</option>
                <option value="23" <?PHP if($month==11) echo "selected";?>>11 p.m.</option>
            </select>
            <label for="yminute">Minute Y:</label>
            <select name="yminute" id="yminute" class="form-control form-search">
                <option value="0" <?PHP if($month==12) echo "selected";?>>0</option>
                <option value="1"  <?PHP if($month==1) echo "selected";?>>1</option>
                <option value="2"  <?PHP if($month==2) echo "selected";?>>2</option>
                <option value="3"  <?PHP if($month==3) echo "selected";?>>3</option>
                <option value="4"  <?PHP if($month==4) echo "selected";?>>4</option>
                <option value="5"  <?PHP if($month==5) echo "selected";?>>5</option>
                <option value="6"  <?PHP if($month==6) echo "selected";?>>6</option>
                <option value="7"  <?PHP if($month==7) echo "selected";?>>7</option>
                <option value="8"  <?PHP if($month==8) echo "selected";?>>8</option>
                <option value="9"  <?PHP if($month==9) echo "selected";?>>9</option>
                <option value="10" <?PHP if($month==10) echo "selected";?>>10</option>
                <option value="11" <?PHP if($month==11) echo "selected";?>>11</option>
                <option value="12" <?PHP if($month==12) echo "selected";?>>12</option>
                <option value="13"  <?PHP if($month==1) echo "selected";?>>13</option>
                <option value="14"  <?PHP if($month==2) echo "selected";?>>14</option>
                <option value="15"  <?PHP if($month==3) echo "selected";?>>15</option>
                <option value="16"  <?PHP if($month==4) echo "selected";?>>16</option>
                <option value="17"  <?PHP if($month==5) echo "selected";?>>17</option>
                <option value="18"  <?PHP if($month==6) echo "selected";?>>18</option>
                <option value="19"  <?PHP if($month==7) echo "selected";?>>19</option>
                <option value="20"  <?PHP if($month==8) echo "selected";?>>20</option>
                <option value="21"  <?PHP if($month==9) echo "selected";?>>21</option>
                <option value="22" <?PHP if($month==10) echo "selected";?>>22</option>
                <option value="23" <?PHP if($month==11) echo "selected";?>>23</option>
                <option value="24" <?PHP if($month==12) echo "selected";?>>24</option>
                <option value="25"  <?PHP if($month==1) echo "selected";?>>25</option>
                <option value="26"  <?PHP if($month==2) echo "selected";?>>26</option>
                <option value="27"  <?PHP if($month==3) echo "selected";?>>27</option>
                <option value="28"  <?PHP if($month==4) echo "selected";?>>28</option>
                <option value="29"  <?PHP if($month==5) echo "selected";?>>29</option>
                <option value="30"  <?PHP if($month==6) echo "selected";?>>30</option>
                <option value="31"  <?PHP if($month==7) echo "selected";?>>31</option>
                <option value="32"  <?PHP if($month==8) echo "selected";?>>32</option>
                <option value="33"  <?PHP if($month==9) echo "selected";?>>33</option>
                <option value="34" <?PHP if($month==10) echo "selected";?>>34</option>
                <option value="35" <?PHP if($month==11) echo "selected";?>>35</option>
                <option value="36" <?PHP if($month==12) echo "selected";?>>36</option>
                <option value="37"  <?PHP if($month==1) echo "selected";?>>37</option>
                <option value="38"  <?PHP if($month==2) echo "selected";?>>38</option>
                <option value="39"  <?PHP if($month==3) echo "selected";?>>39</option>
                <option value="40"  <?PHP if($month==4) echo "selected";?>>40</option>
                <option value="41"  <?PHP if($month==5) echo "selected";?>>41</option>
                <option value="42"  <?PHP if($month==6) echo "selected";?>>42</option>
                <option value="43"  <?PHP if($month==7) echo "selected";?>>43</option>
                <option value="44"  <?PHP if($month==8) echo "selected";?>>44</option>
                <option value="45"  <?PHP if($month==9) echo "selected";?>>45</option>
                <option value="46" <?PHP if($month==10) echo "selected";?>>46</option>
                <option value="47" <?PHP if($month==11) echo "selected";?>>47</option>
                <option value="48" <?PHP if($month==12) echo "selected";?>>48</option>
                <option value="49"  <?PHP if($month==1) echo "selected";?>>49</option>
                <option value="50"  <?PHP if($month==2) echo "selected";?>>50</option>
                <option value="51"  <?PHP if($month==3) echo "selected";?>>51</option>
                <option value="52"  <?PHP if($month==4) echo "selected";?>>52</option>
                <option value="53"  <?PHP if($month==5) echo "selected";?>>53</option>
                <option value="54"  <?PHP if($month==6) echo "selected";?>>54</option>
                <option value="55"  <?PHP if($month==7) echo "selected";?>>55</option>
                <option value="56"  <?PHP if($month==8) echo "selected";?>>56</option>
                <option value="57"  <?PHP if($month==9) echo "selected";?>>57</option>
                <option value="58" <?PHP if($month==10) echo "selected";?>>58</option>
                <option value="59" <?PHP if($month==11) echo "selected";?>>59</option>
            </select>
            </div>
            <div class="checkbox-wrap">
                <label for="tempbox" style="font-size: larger; width: 50%;">Temperature</label>
                <input type="checkbox" name="graphtemp" id="graphtemp" value="Y" style="margin-left: 10%; vertical-align: middle;">
            </div>
            <div class="checkbox-wrap">
                <label for="tempbox" style="font-size: larger; width: 50%;">Humidity</label>
                <input type="checkbox" name="graphhumid" id="graphhumid" value="Y" style="margin-left: 10%; vertical-align: middle;">
            </div>
            <div class="checkbox-wrap">
                <label for="tempbox" style="font-size: larger; width: 50%;">Pressure</label>
                <input type="checkbox" name="graphpres" id="graphpres" value="Y" style="margin-left: 10%; vertical-align: middle;">
            </div>
            <div class="checkbox-wrap">
                <label for="tempbox" style="font-size: larger; width: 50%;">Soil Moisture</label>
                <input type="checkbox" name="graphmoist" id="graphmoist" value="Y" style="margin-left: 10%; vertical-align: middle;">
            </div>
            <div class="checkbox-wrap">
                <label for="tempbox" style="font-size: larger; width: 50%;">Light</label>
                <input type="checkbox" name="graphlight" id="graphlight" value="Y" style="margin-left: 10%; vertical-align: middle;">
            </div>
            <button name="signup_btn" id="signup_btn" class="btn btn-primary" style="background-color:#5cb85c; border-color: #ffffff; margin: 5% auto; font-size: 125%;" type="submit">Search</button>
        </form>

    </div>
</div>


</body>
 <?php /*
<script>

    $( document ).ready(function() {
        var object1 = .get( "http://dataservice.accuweather.com/locations/v1/cities/search?q=97333&apikey=42chrUuGeePyvQGvwJGZ2bKGoCGTvGx5", function() {
            alert( "success" );
            var jsonData = JSON.parse(object1);
            for (var i = 0; i < 3; i++) {
                var counter = jsonData;
                alert(counter);
            }
        })
            .done(function() {
                alert( "second success" );
            })
            .fail(function() {
                alert( "error" );
            })
            .always(function() {
                alert( "finished" );
            });
    });

</script>
*/
?>

</html>