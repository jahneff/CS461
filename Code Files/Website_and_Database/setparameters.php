<?php

//<<Setparameters.php>>
//  This page constructs and executed a mySQLi query based on the post request sent from Parameters.php

include_once 'functions.php';
$conn = gs2_database_connect();

$query = "UPDATE `gs2_database`.`Parameters` SET";
$message = "";
if ($_POST['templo']!=""){
        $query = $query . " `temp_Lo` = " . $_POST['templo'] . ",";
}
if ($_POST['temphi']!="") {
    $query = $query . " `temp_Hi` = " . $_POST['temphi'] . ",";
}
if ($_POST['humidlo']!=""){
    $query = $query . " `hum_Lo` = " . $_POST['humidlo'] . ",";

}
if ($_POST['humidhi']!=""){
    $query = $query . " `hum_Hi` = " . $_POST['humidhi'] . ",";
}
if ($_POST['preslo']!=""){
    $query = $query . " `pres_Lo` = " . $_POST['preslo'] . ",";

}
if ($_POST['preshi']!=""){
    $query = $query . " `pres_Hi` = " . $_POST['preshi'] . ",";
}

if ($_POST['moistlo']!=""){
    $query = $query . " `moist_Lo` = " . $_POST['moistlo'] . ",";

}
if ($_POST['moisthi']!=""){
    $query = $query . " `moist_Hi` = " . $_POST['moisthi'] . ",";
}

if ($_POST['interval']!=""){
    if($_POST['interval'] >= 1 && $_POST['interval'] <= 720) {
        $query = $query . " `interval` = " . $_POST['interval'] . ",";
    }
    else {
        echo "Please enter a number between one and ten to update the interval";
    }
}

$query = chop($query, ", ");
$query = $query . " WHERE `Parameters`.`ID` = 1";

if ($result=mysqli_query($conn, $query)) {
    echo "Values updated";
}
else {
    echo "Value update failed!";
}

?>

