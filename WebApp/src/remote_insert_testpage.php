<?php
include_once '../library/functions.php';
$conn = gs2_database_connect();
if(!$conn){
    echo "Connection to database failed";
}

echo "Data insert from microcontroller... <br>";

$query = "SELECT MAX(`timesliceID`) FROM `gs2_database`.`Timeslice`";
if($result = mysqli_query($conn, $query)){
    $temp = array();
    $temp = mysqli_fetch_row($result);
    $id = $temp['0'];
}
else {
    echo "Failure, could not get max Timeslice ID <br>";
}

$query = "SELECT * FROM `gs2_database`.`Timeslice` WHERE `timesliceID` = $id";

$successful_tests = 0;
if($result = mysqli_query($conn, $query)){
    $temp = array();
    $temp = mysqli_fetch_row($result);
    echo "Verifying temperature... ";
    echo "Expected: 30, Actual: " . $temp[2];
    if($temp[2] == 30){
        echo " PASSED <br>";
        $successful_tests++;
    }
    else {
        echo " FAILED <br>";
    }
    echo "Verifying humidity... ";
    echo "Expected: 40, Actual: " . $temp[3];
    if($temp[3] == 40){
        echo " PASSED <br>";
        $successful_tests++;
    }
    else {
        echo " FAILED <br>";
    }
    echo "Verifying pressure... ";
    echo "Expected: 50, Actual: " . $temp[4];

    if($temp[4] == 50){
        echo " PASSED <br>";
        $successful_tests++;
    }
    else {
        echo " FAILED <br>";
    }
    echo "Verifying soil_moisture... ";
    echo "Expected: 60, Actual: " . $temp[5];

    if($temp[5] == 60){
        echo " PASSED <br>";
        $successful_tests++;
    }
    else {
        echo " FAILED <br>";
    }
    echo "Verifying light... ";
    echo "Expected: 70, Actual: " . $temp[6];

    if($temp[6] == 70){
        echo " PASSED <br>";
        $successful_tests++;
    }
    else {
        echo " FAILED <br>";
    }

}
else {
    echo "Failure, could not select newly inserted row from database <br>";
}

echo "Successful tests: " . $successful_tests ."/5"

?>