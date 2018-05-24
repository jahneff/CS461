<?php
    //This simple script is what the microcontroller sends its data to, in the form of a GET rresuest. If this page is loaded without sending the request, it will insert a row with all fields except ID and date=-999
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
    //The 1000 and 10 divisions offset the units which the sensors gather so that everything remains within the -100 to 200 range where it can be graphed.
    $temperature = (isset($_GET['temperature']) ? $_GET['temperature'] : -999);
    $humidity = (isset($_GET['humidity']) ? $_GET['humidity'] : -999);
    $pressure = (isset($_GET['pressure']) ? ($_GET['pressure']/1000) : -999);
    $moisture = (isset($_GET['moisture']) ? ($_GET['moisture']/10) : -999);
    $battery = (isset($_GET['battery']) ? $_GET['battery'] : -999);
    $light = (isset($_GET['light']) ? ($_GET['light']/10) : -999);
    $timestamp = date("Y-m-d H:i:s");

    $query = "INSERT INTO `gs2_database`.`Timeslice` (`timesliceID`, `timestamp`, `temperature`, `humidity`, `pressure`, `soil_moisture`, `light`, `battery_percent`) VALUES ('$id', '$timestamp', '$temperature', '$humidity', '$pressure', '$moisture', '$light', '$battery')";
    if (mysqli_query($conn, $query)) {
        echo "Success";
    } else {
        echo "Failure";
	echo $query;
    }
?>
