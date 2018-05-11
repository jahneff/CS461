<?php
include_once 'functions.php';
$conn = gs2_database_connect();

$query = "UPDATE `gs2_database`.`Parameters` SET";
?>

<head>
    <title>GS2 Dashboard</title>
    <link rel="stylesheet" type="text/css" href="library/bootstrap.css"/>
    <link rel="stylesheet" type="text/css" href="library/gs2styles.css"/>
    <script src="fusioncharts/js/fusioncharts.js"></script>
    <script src="fusioncharts/js/fusioncharts.theme.ocean.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.9/js/all.js" integrity="sha384-8iPTk2s/jMVj81dnzb/iFR2sdA7u06vHJyyLlAd4snFpCl/SnyUjRrbdJsw1pGIl" crossorigin="anonymous"></script>

    <nav class="navbar  navbar-dark bg-primary sticky-top" style="margin-bottom: 10px; background-color: #5cb85c;">
        <a class="navbar-brand" href="dashboard.php" style="color: white;"><b>My Smart Gardening System</b></a>
        <div class="gs2-button" style="float:right; margin-right: 10px;">
            <a class="btn btn-primary" href="parameters.php?temphi=40" role="button" style="background-color:#5cb85c; border-color: #4cae4c; margin: 5% auto; ">Set system parameters</a>
        </div>
    </nav>
</head>

<?php


$table = array(array());
$name = "Timeslice";
$table = get_table($conn, $name, 8);
$num_rows = get_num_rows($conn, $name);



$xdate = "";

$ydate = "";

if ($_GET['xyear']!=""){
    $xdate = $xdate . $_GET['xyear'];
    if ($_GET['xmonth']!=""){
        $xdate = $xdate . "-" . $_GET['xmonth'];
        if ($_GET['xday']!=""){
            $xdate = $xdate . "-" . $_GET['xday'];
        }
        else {
            $xdate = $xdate . "-1";
        }
        if ($_GET['xhour']!=""){
            $xdate = $xdate . " " . $_GET['xhour'];
        }
        else {
            $xdate = $xdate . "-1";
        }
        if ($_GET['xminute']!=""){
            $xdate = $xdate . ":". $_GET['xminute'] . ":00";
        }
        else {
            $xdate = $xdate;
        }
    }
    else {
        $xdate = $xdate . "-1";
        if ($_GET['xday']!=""){
            $xdate = $xdate . "-" . $_GET['xday'];
        }
        else {
            $xdate = $xdate . "-1";
        }
        if ($_GET['xhour']!=""){
            $xdate = $xdate . " ". $_GET['xhour'];
        }
        else {
            $xdate = $xdate . "-1";
        }
        if ($_GET['xminute']!=""){
            $xdate = $xdate . ":". $_GET['xminute'] . ":00";
        }
        else {
            $xdate = $xdate;
        }
    }
}

if ($_GET['yyear']!=""){
    $ydate = $ydate . $_GET['yyear'];
    if ($_GET['ymonth']!=""){
        $ydate = $ydate . "-" . $_GET['ymonth'];
        if ($_GET['yday']!=""){
            $ydate = $ydate . "-" . $_GET['yday'];
        }
        else {
            $ydate = $ydate . "-1";
        }
        if ($_GET['yhour']!=""){
            $ydate = $ydate . " " . $_GET['yhour'];
        }
        else {
            $ydate = $ydate . "-1";
        }
        if ($_GET['yminute']!=""){
            $ydate = $ydate . ":". $_GET['yminute'] . ":00";
        }
        else {
            $ydate = $ydate;
        }
    }
    else {
        $ydate = $ydate . "-1";
        if ($_GET['yday']!=""){
            $ydate = $ydate . "-" . $_GET['yday'];
        }
        else {
            $ydate = $ydate . "-1";
        }
        if ($_GET['yhour']!=""){
            $ydate = $ydate . " ". $_GET['yhour'];
        }
        else {
            $ydate = $ydate . "-1";
        }
        if ($_GET['yminute']!=""){
            $ydate = $ydate . ":". $_GET['yminute'] . ":00";
        }
        else {
            $ydate = $ydate;
        }
    }
}

//echo $xdate;
//echo $ydate;
//echo strtotime($xdate);
//echo strtotime($ydate);

$time_lo_bound = strtotime($xdate);
$time_hi_bound = strtotime($ydate);
echo "<br>";

$j = 0;
while($time_lo_bound > strtotime($table[$j]['1']) && $j < $num_rows) {
    /*
    echo "j" . $j;
    echo "<br>";
    echo "Epochtime: " . strtotime($table[$j]['1']);
    echo "<br>";
    echo strtotime($table[$j]['1']) . "-" . $time_lo_bound . "=" . (strtotime($table[$j]['1'])-$time_lo_bound);
    echo "<br>";
    echo "<br>";
*/
    $j++;
}
//echo strtotime($table[$j]['1']);
//echo "J" . $j;


$k = $num_rows - 1;
while($time_hi_bound < strtotime($table[$k]['1']) && $k > 0) {

    $k--;
}

//echo strtotime($table[$k]['1']);
//echo "K" . $k;


$tempArray = array();
$timeArray = array();

for ($l = $j; $l < $k; $l++){
    //echo "<br>";
    //echo strtotime($table[$l]['1']);
    $timeArray[($l - $j)] = date('H:i:s', strtotime($table[$l]['1']));
    $tempArray[($l - $j)] = $table[$l]['2'];
}




$temp_time_Array = array_combine($timeArray, $tempArray);

$chart = makeNewBarGraph("Temperature", "Last 12 hours", $temp_time_Array, "chart-1", $height, $currentDay);
$chart->render();




?>
<div class = "col-sm-2">
</div>
<div class = "col-sm-8">
    <div class = "category-wrap">
        <div class="chart-container" id="chart-1">chart renders here</div>
    </div>
</div>
<div class = "col-sm-2">
</div>

