<?php

    include_once 'functions.php';
    date_default_timezone_set('America/Los_Angeles');

    $conn = gs2_database_connect();
    if($conn){
        echo "Connection Successful";
    }
    else {
        echo "Connection to database failed";
    }
    $query = "SELECT MAX(`timesliceID`) FROM `gs2_database`.`Timeslice`";
    if($result = mysqli_query($conn, $query)){
        echo "Success";
        $temp = array();
        $temp = mysqli_fetch_row($result);
        $id = $temp['0'] + 1;
    }
    else {
        echo "Failure, could not allocate ID";
    }
    $temperature = (isset($_GET['temperature']) ? $_GET['temperature'] : -999);
    $humidity = (isset($_GET['humidity']) ? $_GET['humidity'] : -999);
    $pressure = (isset($_GET['pressure']) ? $_GET['pressure'] : -999);
    $moisture = (isset($_GET['moisture']) ? $_GET['moisture'] : -999);
    $battery = (isset($_GET['battery']) ? $_GET['battery'] : -999);
    $light = (isset($_GET['light']) ? $_GET['light'] : -999);
    $timestamp = date("Y-m-d H:i:s");

    $query = "INSERT INTO `gs2_database`.`Timeslice` (`timesliceID`, `timestamp`, `temperature`, `humidity`, `pressure`, `soil_moisture`, `light`, `battery_percent`) VALUES ('$id', '$timestamp', '$temperature', '$humidity', '$pressure', '$moisture', '$light', '$battery')";
    if (mysqli_query($conn, $query)) {
        echo "Success";
    } else {
        echo "Failure";
	echo $query;
    }
?>
