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
if($conn){
    echo "PASSED <br>";
    $successfultests++;
}
else {
    echo "FAILED <br>";
}

echo "Testing get_table... ";
$table = get_table($conn, "Timeslice", 8);
if($table!=-1){
    echo "PASSED <br>";
    $successfultests++;
}
else{
    echo "FAILED <br>";
}

echo "Testing insert row... ";
$num_rows = get_num_rows($conn, "Timeslice");

$row = array(9999, date("Y-m-d H:i:s"), 10, 20, 30, 40, 50, 60);
$query = "INSERT INTO `gs2_database`.`Timeslice` (`timesliceID`, `timestamp`, `temperature`, `humidity`, `pressure`, `soil_moisture`, `light`, `battery_percent`) VALUES ('$row[0]', '$row[1]', '$row[2]', '$row[3]', '$row[4]', '$row[5]', '$row[6]', '$row[7]')";

if (mysqli_query($conn, $query) && get_num_rows($conn, "Timeslice") == ($num_rows + 1)) {
    echo "PASSED <br>";
    $successfultests++;

} else {
    echo "PASSED <br>";
}

echo "Testing delete row...";
$query = "DELETE FROM `gs2_database`.`Timeslice` WHERE `timesliceID` = 9999";
if (mysqli_query($conn, $query) && get_num_rows($conn, "Timeslice") == $num_rows) {
    echo "PASSED <br>";
    $successfultests++;

} else {
    echo "FAILED <br>";
}

$array = array(10, 20, 30, 40, 50, 60, 70, 80);
array_unshift($array, "phoney");
unset($array[0]);

echo "Testing get max... ";
echo "Expected: 80, Actual: " . getMax($array);
if (getMax($array) == 80) {
    echo " PASSED <br>";
    $successfultests++;

} else {
    echo " FAILED <br>";
}

echo "Testing get min... ";
echo "Expected: 10, Actual: " . getMin($array);
if (getMin($array) == 10) {
    echo " PASSED <br>";
    $successfultests++;

} else {
    echo " FAILED <br>";
}

echo "Testing get avg... ";
echo "Expected: 35, Actual: " . getAverage($array);

if (getAverage($array) == 35) {
    echo " PASSED <br>";
    $successfultests++;

} else {
    echo " FAILED <br>";
    echo getAverage($array);
}

echo "Testing get trend... ";
echo "Expected: 8.75, Actual: " . getTrend($array);
if (getTrend($array) == 8.75) {

    echo " PASSED <br>";
    $successfultests++;

} else {
    echo " FAILED <br>";
    echo getTrend($array);
}

$table = array(array());
$table = get_table($conn, "Timeslice", 8);
$tempArray = array();
$timeArray = array();
$num_rows = get_num_rows($conn, "Timeslice");
for ($i = 1; $i <= 10; $i++){
    $timeArray[$i] = $table[$num_rows - $i]['1'];
    $tempArray[$i] = $table[$num_rows - $i]['2'];
}
$temp_time_Array = array_combine($timeArray, $tempArray);
$charter = makeNewBarGraph("Testting Graph Render", "PASSED", $temp_time_Array, "chart-1", 300, date("Y/m/d"));
$charter->render();

?>
<div class="chart-container" id="chart-1">Fusion Charts will render here</div>
<?php
echo "Testing change parameter...";
$interval = rand(1, 10);
$query = "UPDATE `gs2_database`.`Parameters` SET `interval` = " . $interval . " WHERE `Parameters`.`ID` = 1";
$query2 = "SELECT `interval` FROM `gs2_database`.`Parameters` WHERE `Parameters`.`ID` = 1";

if (mysqli_query($conn, $query) && $result=mysqli_query($conn, $query2)) {
    $interval_from_db = mysqli_fetch_row($result);
    echo "Expected: " . $interval . ", Actual: " . $interval_from_db;
    if($interval_from_db[0] == $interval){
        echo " PASSED <br>";
        $successfultests++;
    }
    else {
        echo " FAILED <br>";
    }
}
else {
    echo "Parameter change failure <br>";
}

echo "Test Suite Summary: " . $successfultests . " (" . ($successfultests+1) . " if graph rendered) / 10 ==> " . ($successfultests*10) . "% success, " . (($successfultests+1)*10) . "% if graph rendered correctly";

?>
</body>
</html>