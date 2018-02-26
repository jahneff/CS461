<?php
include_once 'functions.php';
$conn = gs2_database_connect();
if($conn){
    echo "Connection Successful";
}
else {
    echo "Connection to database failed";
}

if ($_REQUEST['yourdata']){
	echo "Data recieved\n";
	$test_data = $_POST['yourdata'];
}
else {
	echo "Data not recieved, using default value\n";
	$test_data = 5;
}
$query = "INSERT INTO `gs2_database`.`Test` (`Integer`) VALUES ('$test_data')";
if(mysqli_query($conn, $query)){
	echo "Success";
}
else {
	echo "Failure";
}
?>
