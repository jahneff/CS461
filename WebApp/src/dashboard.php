<!DOCTYPE html>
<html>

<?php
include_once '../library/functions.php';
include_once '../fusioncharts/fusioncharts.php';
$conn = gs2_database_connect();
?>

<head>
    <title>GS2 Dashboard</title>
    <link rel="stylesheet" type="text/css" href="../library/bootstrap.css"/>
    <link rel="stylesheet" type="text/css" href="../library/gs2styles.css"/>
    <script src="../fusioncharts/js/fusioncharts.js"></script>
    <script src="../fusioncharts/js/fusioncharts.theme.ocean.js"></script>
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

//The following blocks parses the forecast into arrays from the string received from Accuweather API.
//$weather=file_get_contents("http://dataservice.accuweather.com/locations/v1/cities/search?q=97333&apikey=42chrUuGeePyvQGvwJGZ2bKGoCGTvGx5&metric=true");
$weather = "string(1064) \"[{\"Version\":1,\"Key\":\"40973_PC\",\"Type\":\"PostalCode\",\"Rank\":55,\"LocalizedName\":\"Corvallis\",\"EnglishName\":\"Corvallis\",\"PrimaryPostalCode\":\"97333\",\"Region\":{\"ID\":\"NAM\",\"LocalizedName\":\"North America\",\"EnglishName\":\"North America\"},\"Country\":{\"ID\":\"US\",\"LocalizedName\":\"United States\",\"EnglishName\":\"United States\"},\"AdministrativeArea\":{\"ID\":\"OR\",\"LocalizedName\":\"Oregon\",\"EnglishName\":\"Oregon\",\"Level\":1,\"LocalizedType\":\"State\",\"EnglishType\":\"State\",\"CountryID\":\"US\"},\"TimeZone\":{\"Code\":\"PDT\",\"Name\":\"America/Los_Angeles\",\"GmtOffset\":-7.0,\"IsDaylightSaving\":true,\"NextOffsetChange\":\"2018-11-04T09:00:00Z\"},\"GeoPosition\":{\"Latitude\":44.471,\"Longitude\":-123.313,\"Elevation\":{\"Metric\":{\"Value\":71.0,\"Unit\":\"m\",\"UnitType\":5},\"Imperial\":{\"Value\":232.0,\"Unit\":\"ft\",\"UnitType\":0}}},\"IsAlias\":false,\"ParentCity\":{\"Key\":\"330142\",\"LocalizedName\":\"Corvallis\",\"EnglishName\":\"Corvallis\"},\"SupplementalAdminAreas\":[{\"Level\":2,\"LocalizedName\":\"Benton\",\"EnglishName\":\"Benton\"}],\"DataSets\":[\"Alerts\",\"DailyAirQualityForecast\",\"DailyPollenForecast\",\"ForecastConfidence\",\"MinuteCast\"]}]\"";
$pos = strpos($weather, "\"Key\":\"");
$begin = $pos + 7;
$pos = strpos($weather, "\"Type\":\"");
$end = $pos - 2;
$length = $end - $begin;
$substr = substr($weather, $begin, $length);
$current=file_get_contents("http://dataservice.accuweather.com/forecasts/v1/hourly/12hour/" . $substr. "?apikey=42chrUuGeePyvQGvwJGZ2bKGoCGTvGx5&metric=true");
if (strlen($current) < 10) {
    $current = '[{"DateTime":"2018-05-18T02:00:00-07:00","EpochDateTime":1526079600,"WeatherIcon":2,"IconPhrase":"Mostly sunny","IsDaylight":true,"Temperature":{"Value":17.9,"Unit":"C","UnitType":17},"PrecipitationProbability":0,"MobileLink":"http://m.accuweather.com/en/us/corvallis-or/97330/hourly-weather-forecast/40973_pc?day=1&unit=c&lang=en-us","Link":"http://www.accuweather.com/en/us/corvallis-or/97330/hourly-weather-forecast/40973_pc?day=1&hbhhour=16&unit=c&lang=en-us"},{"DateTime":"2018-05-11T17:00:00-07:00","EpochDateTime":1526083200,"WeatherIcon":2,"IconPhrase":"Mostly sunny","IsDaylight":true,"Temperature":{"Value":18.5,"Unit":"C","UnitType":17},"PrecipitationProbability":0,"MobileLink":"http://m.accuweather.com/en/us/corvallis-or/97330/hourly-weather-forecast/40973_pc?day=1&unit=c&lang=en-us","Link":"http://www.accuweather.com/en/us/corvallis-or/97330/hourly-weather-forecast/40973_pc?day=1&hbhhour=17&unit=c&lang=en-us"},{"DateTime":"2018-05-11T18:00:00-07:00","EpochDateTime":1526086800,"WeatherIcon":2,"IconPhrase":"Mostly sunny","IsDaylight":true,"Temperature":{"Value":17.9,"Unit":"C","UnitType":17},"PrecipitationProbability":0,"MobileLink":"http://m.accuweather.com/en/us/corvallis-or/97330/hourly-weather-forecast/40973_pc?day=1&unit=c&lang=en-us","Link":"http://www.accuweather.com/en/us/corvallis-or/97330/hourly-weather-forecast/40973_pc?day=1&hbhhour=18&unit=c&lang=en-us"},{"DateTime":"2018-05-11T19:00:00-07:00","EpochDateTime":1526090400,"WeatherIcon":2,"IconPhrase":"Mostly sunny","IsDaylight":true,"Temperature":{"Value":16.7,"Unit":"C","UnitType":17},"PrecipitationProbability":0,"MobileLink":"http://m.accuweather.com/en/us/corvallis-or/97330/hourly-weather-forecast/40973_pc?day=1&unit=c&lang=en-us","Link":"http://www.accuweather.com/en/us/corvallis-or/97330/hourly-weather-forecast/40973_pc?day=1&hbhhour=19&unit=c&lang=en-us"},{"DateTime":"2018-05-11T20:00:00-07:00","EpochDateTime":1526094000,"WeatherIcon":2,"IconPhrase":"Mostly sunny","IsDaylight":true,"Temperature":{"Value":15.5,"Unit":"C","UnitType":17},"PrecipitationProbability":0,"MobileLink":"http://m.accuweather.com/en/us/corvallis-or/97330/hourly-weather-forecast/40973_pc?day=1&unit=c&lang=en-us","Link":"http://www.accuweather.com/en/us/corvallis-or/97330/hourly-weather-forecast/40973_pc?day=1&hbhhour=20&unit=c&lang=en-us"},{"DateTime":"2018-05-11T21:00:00-07:00","EpochDateTime":1526097600,"WeatherIcon":34,"IconPhrase":"Mostly clear","IsDaylight":false,"Temperature":{"Value":13.6,"Unit":"C","UnitType":17},"PrecipitationProbability":0,"MobileLink":"http://m.accuweather.com/en/us/corvallis-or/97330/hourly-weather-forecast/40973_pc?day=1&unit=c&lang=en-us","Link":"http://www.accuweather.com/en/us/corvallis-or/97330/hourly-weather-forecast/40973_pc?day=1&hbhhour=21&unit=c&lang=en-us"},{"DateTime":"2018-05-11T22:00:00-07:00","EpochDateTime":1526101200,"WeatherIcon":34,"IconPhrase":"Mostly clear","IsDaylight":false,"Temperature":{"Value":12.2,"Unit":"C","UnitType":17},"PrecipitationProbability":0,"MobileLink":"http://m.accuweather.com/en/us/corvallis-or/97330/hourly-weather-forecast/40973_pc?day=1&unit=c&lang=en-us","Link":"http://www.accuweather.com/en/us/corvallis-or/97330/hourly-weather-forecast/40973_pc?day=1&hbhhour=22&unit=c&lang=en-us"},{"DateTime":"2018-05-11T23:00:00-07:00","EpochDateTime":1526104800,"WeatherIcon":34,"IconPhrase":"Mostly clear","IsDaylight":false,"Temperature":{"Value":11.1,"Unit":"C","UnitType":17},"PrecipitationProbability":0,"MobileLink":"http://m.accuweather.com/en/us/corvallis-or/97330/hourly-weather-forecast/40973_pc?day=1&unit=c&lang=en-us","Link":"http://www.accuweather.com/en/us/corvallis-or/97330/hourly-weather-forecast/40973_pc?day=1&hbhhour=23&unit=c&lang=en-us"},{"DateTime":"2018-05-12T00:00:00-07:00","EpochDateTime":1526108400,"WeatherIcon":34,"IconPhrase":"Mostly clear","IsDaylight":false,"Temperature":{"Value":10.5,"Unit":"C","UnitType":17},"PrecipitationProbability":0,"MobileLink":"http://m.accuweather.com/en/us/corvallis-or/97330/hourly-weather-forecast/40973_pc?day=2&unit=c&lang=en-us","Link":"http://www.accuweather.com/en/us/corvallis-or/97330/hourly-weather-forecast/40973_pc?day=2&hbhhour=0&unit=c&lang=en-us"},{"DateTime":"2018-05-12T01:00:00-07:00","EpochDateTime":1526112000,"WeatherIcon":34,"IconPhrase":"Mostly clear","IsDaylight":false,"Temperature":{"Value":9.9,"Unit":"C","UnitType":17},"PrecipitationProbability":0,"MobileLink":"http://m.accuweather.com/en/us/corvallis-or/97330/hourly-weather-forecast/40973_pc?day=2&unit=c&lang=en-us","Link":"http://www.accuweather.com/en/us/corvallis-or/97330/hourly-weather-forecast/40973_pc?day=2&hbhhour=1&unit=c&lang=en-us"},{"DateTime":"2018-05-12T02:00:00-07:00","EpochDateTime":1526115600,"WeatherIcon":34,"IconPhrase":"Mostly clear","IsDaylight":false,"Temperature":{"Value":9.2,"Unit":"C","UnitType":17},"PrecipitationProbability":0,"MobileLink":"http://m.accuweather.com/en/us/corvallis-or/97330/hourly-weather-forecast/40973_pc?day=2&unit=c&lang=en-us","Link":"http://www.accuweather.com/en/us/corvallis-or/97330/hourly-weather-forecast/40973_pc?day=2&hbhhour=2&unit=c&lang=en-us"},{"DateTime":"2018-05-12T03:00:00-07:00","EpochDateTime":1526119200,"WeatherIcon":34,"IconPhrase":"Mostly clear","IsDaylight":false,"Temperature":{"Value":8.8,"Unit":"C","UnitType":17},"PrecipitationProbability":0,"MobileLink":"http://m.accuweather.com/en/us/corvallis-or/97330/hourly-weather-forecast/40973_pc?day=2&unit=c&lang=en-us","Link":"http://www.accuweather.com/en/us/corvallis-or/97330/hourly-weather-forecast/40973_pc?day=2&hbhhour=3&unit=c&lang=en-us"}]';
}
$temp = $current;
$begin = strpos($temp, "hbhhour=");
$end = strpos($temp, "&unit=c&lang=en-us\"},{\"DateTime\"");
$begin = $begin + 8;
$hour = substr($temp, $begin, ($end - $begin));

for ($i = 0; $i < 12; $i++) {
    $forecastcondarray[$i] = parseTemp($current, "\"IconPhrase\":\"", ",\"IsDaylight\"");
    $current = parseString($current, ",\"IsDaylight\"");

    $forecasttemparray[$i] = parseTemp($current, "{\"Value\":", "\"Unit\":\"C\"");
    $current = parseString($current, "\"Unit\":\"C\"");
}


//Gets high and low bounds, and read time interval, from database
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



//If a get request specifies a number of data points to graph, use that number. Otherwise graph 10 points
if(isset($_GET['readings']) && $_GET['readings']!=""){
    $num_readings = $_GET['readings'];
}
else {
    $num_readings = 10;
}


$height = 400;
$name = "Timeslice";
$table = get_table($conn, $name, 8);
$num_rows = get_num_rows($conn, $name);
for ($i = 1; $i <= $num_readings; $i++){
    $timeArray[$i] = date('d M Y H:i:s', strtotime($table[$num_rows - ($num_readings - $i + 1)]['1']));
    $tempArray[$i] = $table[$num_rows - ($num_readings - $i + 1)]['2'];
    $humidityArray[$i] = $table[$num_rows - ($num_readings - $i + 1)]['3'];
    $pressureArray[$i] = $table[$num_rows - ($num_readings - $i + 1)]['4'];
    $soilmoistureArray[$i] = $table[$num_rows - ($num_readings - $i + 1)]['5'];
    $soilphArray[$i] = $table[$num_rows - ($num_readings - $i + 1)]['6'];
    $batteryArray[$i] = $table[$num_rows - ($num_readings - $i + 1)]['7'];
}


$temp_time_Array = array_combine($timeArray, $tempArray);
$humidity_time_Array = array_combine($timeArray, $humidityArray);
$pressure_time_Array = array_combine($timeArray, $pressureArray);
$soilmoisture_time_Array = array_combine($timeArray, $soilmoistureArray);
$soilph_time_Array = array_combine($timeArray, $soilphArray);
$subtitle = "Last " . $num_readings . " readings";
$tempChart = makeNewBarGraph("Temperature", $subtitle, $temp_time_Array, "chart-1", $height, $num_readings);
$tempChart->render();
$humidityChart = makeNewBarGraph("Humidity", $subtitle, $humidity_time_Array, "chart-2", $height, $num_readings);
$humidityChart->render();
$pressureChart = makeNewBarGraph("Pressure", $subtitle, $pressure_time_Array, "chart-3", $height, $num_readings);
$pressureChart->render();
$soilmoistureChart = makeNewBarGraph("Soil Moisture", $subtitle, $soilmoisture_time_Array, "chart-4", $height, $num_readings);
$soilmoistureChart->render();
$soilphChart = makeNewBarGraph("Light Intensity", $subtitle, $soilph_time_Array, "chart-5", $height, $num_readings);
$soilphChart->render();




//Gets the Day, Month, and Year of most recent measurement. This becomes the default value for the "Search Center" dropdowns.

$recentDay = date('d', strtotime($table[$num_rows-1][1]));
$recentMonth = date('M', strtotime($table[$num_rows-1][1]));
$recentYear = date('Y', strtotime($table[$num_rows-1][1]));


//Formats the most recent readings so they fit inside the panels above the graph.

$current_temperature = number_format($tempArray[$num_readings], 1);
$current_humidity = number_format($humidityArray[$num_readings], 1);
$current_pressure = number_format($pressureArray[$num_readings], 1);
$current_moisture = number_format($soilmoistureArray[$num_readings], 1);
$current_pH = number_format($soilphArray[$num_readings], 1);


//Decides which chart to display

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
            <!--This is a placeholder column-->
        </div>
        <div class = "col-sm-10">
            <div class="status-bar-label-container">
                Below are the current conditions. Click to see graph.
            </div>
            <div class="status-bar">
                <!-- The line below outputs the current temperature, in blue if it is below the $lotempbound and in red if it is above $hitempbound -->
                <div class="status-bar-section" title="Temperature (Click to view graph)" style="<?php if($lotempbound > $current_temperature){echo 'color:#b5d5ff';} else if($hitempbound < $current_temperature){echo 'color:#d01d1d';}?>">
                    <a href="dashboard.php?chart=1&readings=<?php echo $num_readings ?>">
                        <span class="link-spanner"></span>
                    </a>
                    <div class="status-bar-section-left">
                        <i class="fas fa-thermometer-full"></i>
                        <?php echo html_entity_decode($current_temperature . "&deg"); ?>
                    </div>
                    <div class="status-bar-section-right">
                        <span class="status-bar-units">Temperature (C)</span>
                    </div>
                </div>
                <!-- See line 191-->
                <div class="status-bar-section" style="<?php if($lohumidbound > $current_humidity){echo 'color:#b5d5ff';} else if($hihumidbound < $current_humidity){echo 'color:#d01d1d';}?>">
                    <a href="dashboard.php?chart=2&readings=<?php echo $num_readings ?>">
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
                    <a href="dashboard.php?chart=3&readings=<?php echo $num_readings ?>">
                        <span class="link-spanner"></span>
                    </a>
                    <div class="status-bar-section-left">
                    <i class="fas fa-weight"></i>
                    <?php echo $current_pressure ?>
                    </div>
                    <div class="status-bar-section-right">
                        <span class="status-bar-units">Pressure (kPa)</span>
                    </div>
                </div>
                <div class="status-bar-section" style="<?php if($lomoistbound > $current_moisture){echo 'color:#b5d5ff';} else if($himoistbound < $current_moisture){echo 'color:#d01d1d';}?>">
                    <a href="dashboard.php?chart=4&readings=<?php echo $num_readings ?>">
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
                    <a href="dashboard.php?chart=5&readings=<?php echo $num_readings ?>">
                        <span class="link-spanner"></span>
                    </a>
                    <div class="status-bar-section-left">

                    <i class="fas fa-lightbulb"></i>
                    <?php echo $current_pH ?>
                    </div>
                    <div class="status-bar-section-right">
                        <span class="status-bar-units">Light (dalx)</span>
                    </div>
                </div>

            </div>
        </div>
        <div class = "col-sm-1">
            <!--This is a placeholder column-->
        </div>
    </div>
    <div class = "row">

        <!--The following section is the weather forecast. PHP is used to choose between a.m. and p.m. as well as to match the condition string to the correct icon. -->
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


        <!--This is the main graph section. Like the Icon/CurrentReading boxes above the graph, min, max, average, and current values are compared to their respective bounds, and outputted in blue, red, or green. -->
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


        <!-- The following section is the search center. PHP is used to set the default values for the Day, Month, and Year inputs. -->
        </div>
        <div class = "col-sm-3">
            <form class="form-search" id="searchform" name="searchform" method="get" action="view_data.php" style="margin-left:3%; width: 95%;">
                <h2 class="form-signup-heading" style="color:white; margin-bottom: 0;">Search Center</h2>
                <div class="form-signup-subheading" style="margin-left: 5%; margin-right: 15%; margin-bottom: 5%;">Creates a customized view of your data from time x to time y</div>

                <div class="earlywrap">
                    <label for="xmonth">Month X:</label>
                    <select name="xmonth" id="xmonth" class="form-control form-search">
                        <option value="1"<?php if($recentMonth == "January"){echo "selected=\"selected\"";}?>>January</option>
                        <option value="2"<?php if($recentMonth == "February"){echo "selected=\"selected\"";}?>>February</option>
                        <option value="3"<?php if($recentMonth == "March"){echo "selected=\"selected\"";}?>>March</option>
                        <option value="4" <?php if($recentMonth == "April"){echo "selected=\"selected\"";}?>>April</option>
                        <option value="5"<?php if($recentMonth == "May"){echo "selected=\"selected\"";}?>>May</option>
                        <option value="6"<?php if($recentMonth == "June"){echo "selected=\"selected\"";}?>>June</option>
                        <option value="7"<?php if($recentMonth == "July"){echo "selected=\"selected\"";}?>>July</option>
                        <option value="8"<?php if($recentMonth == "August"){echo "selected=\"selected\"";}?>>August</option>
                        <option value="9"<?php if($recentMonth == "September"){echo "selected=\"selected\"";}?>>September</option>
                        <option value="10"<?php if($recentMonth == "October"){echo "selected=\"selected\"";}?>>October</option>
                        <option value="11"<?php if($recentMonth == "November"){echo "selected=\"selected\"";}?>>November</option>
                        <option value="12"<?php if($recentMonth == "December"){echo "selected=\"selected\"";}?>>December</option>
                    </select>
                    <label for="xday">Day X:</label>
                    <select name="xday" id="xday" class="form-control form-search">
                        <option value="1"  <?PHP if($recentDay==1) echo "selected=\"selected\"";?>>1</option>
                        <option value="2"  <?PHP if($recentDay==2) echo "selected=\"selected\"";?>>2</option>
                        <option value="3"  <?PHP if($recentDay==3) echo "selected=\"selected\"";?>>3</option>
                        <option value="4"  <?PHP if($recentDay==4) echo "selected=\"selected\"";?>>4</option>
                        <option value="5"  <?PHP if($recentDay==5) echo "selected=\"selected\"";?>>5</option>
                        <option value="6"  <?PHP if($recentDay==6) echo "selected=\"selected\"";?>>6</option>
                        <option value="7"  <?PHP if($recentDay==7) echo "selected=\"selected\"";?>>7</option>
                        <option value="8"  <?PHP if($recentDay==8) echo "selected=\"selected\"";?>>8</option>
                        <option value="9"  <?PHP if($recentDay==9) echo "selected=\"selected\"";?>>9</option>
                        <option value="10" <?PHP if($recentDay==10) echo "selected=\"selected\"";?>>10</option>
                        <option value="11" <?PHP if($recentDay==11) echo "selected=\"selected\"";?>>11</option>
                        <option value="12" <?PHP if($recentDay==12) echo "selected=\"selected\"";?>>12</option>
                        <option value="13" <?PHP if($recentDay==13) echo "selected=\"selected\"";?>>13</option>
                        <option value="14" <?PHP if($recentDay==14) echo "selected=\"selected\"";?>>14</option>
                        <option value="15" <?PHP if($recentDay==15) echo "selected=\"selected\"";?>>15</option>
                        <option value="16" <?PHP if($recentDay==16) echo "selected=\"selected\"";?>>16</option>
                        <option value="17" <?PHP if($recentDay==17) echo "selected=\"selected\"";?>>17</option>
                        <option value="18" <?PHP if($recentDay==18) echo "selected=\"selected\"";?>>18</option>
                        <option value="19" <?PHP if($recentDay==19) echo "selected=\"selected\"";?>>19</option>
                        <option value="20" <?PHP if($recentDay==20) echo "selected=\"selected\"";?>>20</option>
                        <option value="21" <?PHP if($recentDay==21) echo "selected=\"selected\"";?>>21</option>
                        <option value="22" <?PHP if($recentDay==22) echo "selected=\"selected\"";?>>22</option>
                        <option value="23" <?PHP if($recentDay==23) echo "selected=\"selected\"";?>>23</option>
                        <option value="24" <?PHP if($recentDay==24) echo "selected=\"selected\"";?>>24</option>
                        <option value="25" <?PHP if($recentDay==25) echo "selected=\"selected\"";?>>25</option>
                        <option value="26" <?PHP if($recentDay==26) echo "selected=\"selected\"";?>>26</option>
                        <option value="27" <?PHP if($recentDay==27) echo "selected=\"selected\"";?>>27</option>
                        <option value="28" <?PHP if($recentDay==28) echo "selected=\"selected\"";?>>28</option>
                        <option value="29" <?PHP if($recentDay==29) echo "selected=\"selected\"";?>>29</option>
                        <option value="30" <?PHP if($recentDay==30) echo "selected=\"selected\"";?>>30</option>
                        <option value="31" <?PHP if($recentDay==31) echo "selected=\"selected\"";?>>31</option>
                    </select>
                    <label for="xday">Year X:</label>

                    <select name="xyear" id="xyear" class="form-control form-search">
                        <?PHP for($i=date("Y"); $i>=date("Y")-4; $i--)
                            if($year == $i)
                                echo "<option value='$i' selected>$i</option>";
                            else
                                echo "<option value='$i'>$i</option>";
                        ?>
                    </select>
                    <label for="xhour">Hour X:</label>
                    <select name="xhour" id="xhour" class="form-control form-search">
                        <option value="0">12 a.m.</option>
                        <option value="1">1 a.m.</option>
                        <option value="2">2 a.m.</option>
                        <option value="3">3 a.m.</option>
                        <option value="4">4 a.m.</option>
                        <option value="5">5 a.m.</option>
                        <option value="6">6 a.m.</option>
                        <option value="7">7 a.m.</option>
                        <option value="8">8 a.m.</option>
                        <option value="9">9 a.m.</option>
                        <option value="10">10 a.m.</option>
                        <option value="11">11 a.m.</option>
                        <option value="12">12 p.m.</option>
                        <option value="13">1 p.m.</option>
                        <option value="14">2 p.m.</option>
                        <option value="15">3 p.m.</option>
                        <option value="16">4 p.m.</option>
                        <option value="17">5 p.m.</option>
                        <option value="18">6 p.m.</option>
                        <option value="19">7 p.m.</option>
                        <option value="20">8 p.m.</option>
                        <option value="21">9 p.m.</option>
                        <option value="22">10 p.m.</option>
                        <option value="23">11 p.m.</option>
                    </select>
                    <label for="xminute">Minute X:</label>
                    <select name="xminute" id="xminute" class="form-control form-search">
                        <option value="0">0</option>
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
                        <option value="32">32</option>
                        <option value="33">33</option>
                        <option value="34">34</option>
                        <option value="35">35</option>
                        <option value="36">36</option>
                        <option value="37">37</option>
                        <option value="38">38</option>
                        <option value="39">39</option>
                        <option value="40">40</option>
                        <option value="41">41</option>
                        <option value="42">42</option>
                        <option value="43">43</option>
                        <option value="44">44</option>
                        <option value="45">45</option>
                        <option value="46">46</option>
                        <option value="47">47</option>
                        <option value="48">48</option>
                        <option value="49">49</option>
                        <option value="50">50</option>
                        <option value="51">51</option>
                        <option value="52">52</option>
                        <option value="53">53</option>
                        <option value="54">54</option>
                        <option value="55">55</option>
                        <option value="56">56</option>
                        <option value="57">57</option>
                        <option value="58">58</option>
                        <option value="59">59</option>
                    </select>
                </div>

                <div class="earlywrap">
                    <label for="ymonth">Month Y:</label>
                    <select name="ymonth" id="ymonth" class="form-control form-search">
                        <option value="1"<?php if($recentMonth == "January"){echo "selected=\"selected\"";}?>>January</option>
                        <option value="2"<?php if($recentMonth == "February"){echo "selected=\"selected\"";}?>>February</option>
                        <option value="3"<?php if($recentMonth == "March"){echo "selected=\"selected\"";}?>>March</option>
                        <option value="4" <?php if($recentMonth == "April"){echo "selected=\"selected\"";}?>>April</option>
                        <option value="5"<?php if($recentMonth == "May"){echo "selected=\"selected\"";}?>>May</option>
                        <option value="6"<?php if($recentMonth == "June"){echo "selected=\"selected\"";}?>>June</option>
                        <option value="7"<?php if($recentMonth == "July"){echo "selected=\"selected\"";}?>>July</option>
                        <option value="8"<?php if($recentMonth == "August"){echo "selected=\"selected\"";}?>>August</option>
                        <option value="9"<?php if($recentMonth == "September"){echo "selected=\"selected\"";}?>>September</option>
                        <option value="10"<?php if($recentMonth == "October"){echo "selected=\"selected\"";}?>>October</option>
                        <option value="11"<?php if($recentMonth == "November"){echo "selected=\"selected\"";}?>>November</option>
                        <option value="12"<?php if($recentMonth == "December"){echo "selected=\"selected\"";}?>>December</option>
                    </select>

                    <label for="yday">Day Y:</label>
                    <select name="yday" id="yday" class="form-control form-search">
                        <option value="1"  <?PHP if($recentDay==1) echo "selected=\"selected\"";?>>1</option>
                        <option value="2"  <?PHP if($recentDay==2) echo "selected=\"selected\"";?>>2</option>
                        <option value="3"  <?PHP if($recentDay==3) echo "selected=\"selected\"";?>>3</option>
                        <option value="4"  <?PHP if($recentDay==4) echo "selected=\"selected\"";?>>4</option>
                        <option value="5"  <?PHP if($recentDay==5) echo "selected=\"selected\"";?>>5</option>
                        <option value="6"  <?PHP if($recentDay==6) echo "selected=\"selected\"";?>>6</option>
                        <option value="7"  <?PHP if($recentDay==7) echo "selected=\"selected\"";?>>7</option>
                        <option value="8"  <?PHP if($recentDay==8) echo "selected=\"selected\"";?>>8</option>
                        <option value="9"  <?PHP if($recentDay==9) echo "selected=\"selected\"";?>>9</option>
                        <option value="10" <?PHP if($recentDay==10) echo "selected=\"selected\"";?>>10</option>
                        <option value="11" <?PHP if($recentDay==11) echo "selected=\"selected\"";?>>11</option>
                        <option value="12" <?PHP if($recentDay==12) echo "selected=\"selected\"";?>>12</option>
                        <option value="13" <?PHP if($recentDay==13) echo "selected=\"selected\"";?>>13</option>
                        <option value="14" <?PHP if($recentDay==14) echo "selected=\"selected\"";?>>14</option>
                        <option value="15" <?PHP if($recentDay==15) echo "selected=\"selected\"";?>>15</option>
                        <option value="16" <?PHP if($recentDay==16) echo "selected=\"selected\"";?>>16</option>
                        <option value="17" <?PHP if($recentDay==17) echo "selected=\"selected\"";?>>17</option>
                        <option value="18" <?PHP if($recentDay==18) echo "selected=\"selected\"";?>>18</option>
                        <option value="19" <?PHP if($recentDay==19) echo "selected=\"selected\"";?>>19</option>
                        <option value="20" <?PHP if($recentDay==20) echo "selected=\"selected\"";?>>20</option>
                        <option value="21" <?PHP if($recentDay==21) echo "selected=\"selected\"";?>>21</option>
                        <option value="22" <?PHP if($recentDay==22) echo "selected=\"selected\"";?>>22</option>
                        <option value="23" <?PHP if($recentDay==23) echo "selected=\"selected\"";?>>23</option>
                        <option value="24" <?PHP if($recentDay==24) echo "selected=\"selected\"";?>>24</option>
                        <option value="25" <?PHP if($recentDay==25) echo "selected=\"selected\"";?>>25</option>
                        <option value="26" <?PHP if($recentDay==26) echo "selected=\"selected\"";?>>26</option>
                        <option value="27" <?PHP if($recentDay==27) echo "selected=\"selected\"";?>>27</option>
                        <option value="28" <?PHP if($recentDay==28) echo "selected=\"selected\"";?>>28</option>
                        <option value="29" <?PHP if($recentDay==29) echo "selected=\"selected\"";?>>29</option>
                        <option value="30" <?PHP if($recentDay==30) echo "selected=\"selected\"";?>>30</option>
                        <option value="31" <?PHP if($recentDay==31) echo "selected=\"selected\"";?>>31</option>
                    </select>

                    <label for="yyear">Year Y:</label>
                    <select name="yyear" id="yyear" class="form-control form-search">
                        <?PHP for($i=date("Y"); $i>=date("Y")-4; $i--)
                            if($year == $i)
                                echo "<option value='$i' selected>$i</option>";
                            else
                                echo "<option value='$i'>$i</option>";
                        ?>
                    </select>

                <label for="yhour">Hour Y:</label>
                <select name="yhour" id="yhour" class="form-control form-search">
                    <option value="0">12 a.m.</option>
                    <option value="1">1 a.m.</option>
                    <option value="2">2 a.m.</option>
                    <option value="3">3 a.m.</option>
                    <option value="4">4 a.m.</option>
                    <option value="5">5 a.m.</option>
                    <option value="6">6 a.m.</option>
                    <option value="7">7 a.m.</option>
                    <option value="8">8 a.m.</option>
                    <option value="9">9 a.m.</option>
                    <option value="10">10 a.m.</option>
                    <option value="11">11 a.m.</option>
                    <option value="12">12 p.m.</option>
                    <option value="13">1 p.m.</option>
                    <option value="14">2 p.m.</option>
                    <option value="15">3 p.m.</option>
                    <option value="16">4 p.m.</option>
                    <option value="17">5 p.m.</option>
                    <option value="18">6 p.m.</option>
                    <option value="19">7 p.m.</option>
                    <option value="20">8 p.m.</option>
                    <option value="21">9 p.m.</option>
                    <option value="22">10 p.m.</option>
                    <option value="23">11 p.m.</option>
                </select>
                <label for="yminute">Minute Y:</label>
                <select name="yminute" id="yminute" class="form-control form-search">
                    <option value="0">0</option>
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
                    <option value="32">32</option>
                    <option value="33">33</option>
                    <option value="34">34</option>
                    <option value="35">35</option>
                    <option value="36">36</option>
                    <option value="37">37</option>
                    <option value="38">38</option>
                    <option value="39">39</option>
                    <option value="40">40</option>
                    <option value="41">41</option>
                    <option value="42">42</option>
                    <option value="43">43</option>
                    <option value="44">44</option>
                    <option value="45">45</option>
                    <option value="46">46</option>
                    <option value="47">47</option>
                    <option value="48">48</option>
                    <option value="49">49</option>
                    <option value="50">50</option>
                    <option value="51">51</option>
                    <option value="52">52</option>
                    <option value="53">53</option>
                    <option value="54">54</option>
                    <option value="55">55</option>
                    <option value="56">56</option>
                    <option value="57">57</option>
                    <option value="58">58</option>
                    <option value="59">59</option>
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

</html>