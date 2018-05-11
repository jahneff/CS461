<?php
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