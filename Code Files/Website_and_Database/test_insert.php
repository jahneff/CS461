<?php
include_once 'functions.php';
$conn = gs2_database_connect();
if($conn){
    echo "Connection Successful";
}
else {
    echo "Connection to database failed";
}
if ($_GET['Int1'] && $_GET['Int2'] && $_GET['Int3'] && $_GET['Str1']){
        echo "Data recieved\n";
        $test_data1 = $_GET['Int1'];
        $test_data2 = $_GET['Int2'];
        $test_data3 = $_GET['Int3'];
	$test_data4 = $_GET['Str1'];
}
else {
        echo "Data not recieved, using default value\n";
        $test_data1 = 0;
        $test_data2 = 0;
        $test_data3 = 0;
        $test_data4 = 0;
}
$query = "INSERT INTO `gs2_database`.`Test` (`Integer`, `Integer2`, `Integer3`, `String`) VALUES ('$test_data1', '$test_data2', '$test_data3', '$test_data4')";
if(mysqli_query($conn, $query)){
        echo "Success";
}
else {
        echo "Failure";
}
?>
