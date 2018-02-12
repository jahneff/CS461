<?php
include_once 'functions.php';
$conn = gs2_database_connect();
if($conn){
    echo "Connection Successful";
}
else {
    echo "Connection to database failed";
}
?>

<html>
<body>
    <div>Enter a row into the database here:</div>
    <div>gs2_database: Timeslice table</div>
    <?php
        $table = array(array());
        $name = "Timeslice";
        $table = get_table($conn, $name);
    ?>
    <div> ID: <?php echo $table['0']['0']; ?></div>
    <div> Timestamp <?php echo $table['0']['1']; ?></div>
    <div> Temp: <?php echo $table['0']['2']; ?></div>
    <div> Pressure: <?php echo $table['0']['3']; ?></div>
    <div> Humidity: <?php echo $table['0']['4']; ?></div>

</body>
</html>