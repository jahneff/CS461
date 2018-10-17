<?php
//This page has one function: to display the value of the current interval.
//The microcontroller queries this page to check and reset its interval. 
include_once 'functions.php';

$conn = gs2_database_connect();

$query = "SELECT `interval` FROM `Parameters` WHERE `ID` = 1";

if($result = mysqli_query($conn, $query)) {
    $interval = mysqli_fetch_row($result);
    $intervalms = $interval[0] * 60000;
    echo "#" . $intervalms;
}
else {
    echo "fail";
}
?>