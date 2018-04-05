<?php
include_once 'functions.php';
$conn = gs2_database_connect();
if($conn){
    echo "Connection Successful";
}
else {
    echo "Connection to database failed";
}

$query = "SELECT MAX(`timesliceID`) FROM `gs2_database`.`Timeslice`";
if($result = mysqli_query($conn, $query)){
    echo "Success, inserting dummy data, process may take several minutes";
    sleep(5);
    $testy = array();
    $testy = mysqli_fetch_row($result);
    $id = $testy['0'] + 1;
    echo $id;
}
else {
    echo "Failure, could not allocate ID";
}
$x = 0;
while ($x < 50) {
    sleep(10);

    $timestamp = date("Y-m-d H:i:s");
    $humidity = (mt_rand(1, 10000) / 100);
    sleep(1);
    $temperature = (mt_rand(1, 10000) / 120);
    sleep(1);
    $pressure = (mt_rand(1, 10000) / 100);
    sleep(1);
    $moisture = (mt_rand(1, 10000) / 100);
    sleep(1);
    $ph = (mt_rand(1, 140) / 10);
    sleep(1);
    $battery = (mt_rand(1, 10000) / 100);
    $query = "INSERT INTO `gs2_database`.`Timeslice` (`timesliceID`, `timestamp`, `temperature`, `humidity`, `pressure`, `soil_moisture`, `soil_ph`, `battery_percent`) VALUES ('$id', '$timestamp', '$temperature', '$humidity', '$pressure', '$moisture', '$ph', '$battery')";
    if (mysqli_query($conn, $query)) {
        echo "Success";
    } else {
        echo "Failure";
    }
    $id++;
    $x++;
}
?>
