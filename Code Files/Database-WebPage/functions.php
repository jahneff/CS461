<?php
include_once 'fusioncharts/fusioncharts.php';

function gs2_database_connect(){
    define('DB_HOST', 'localhost');
    define('DB_USER', 'root');
    define('DB_PASS', 'Capstone18');
    define('DB_NAME', 'gs2_database');

    $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if (!$conn) {
        die('Could not connect to database' . mysqli_connect_error());
    }
    else {
        return $conn;
    }
};

function get_table($conn, $tablename){
    $count = 0;
    $query =  "SELECT * FROM $tablename";
    if($result=mysqli_query($conn, $query)){

        while($favor_row = mysqli_fetch_row($result)) {   //puts table of nearby favors in favor_array
            for ($i = 0; $i < 8; $i++){
                $array[$count][$i] = $favor_row[$i];
            }
            $count = $count+1;
        }
    return $array;
    }
    else {
        return false;
    }
};

function get_num_rows($conn, $tablename){
    $count = 0;
    $query =  "SELECT * FROM $tablename";
    if($result=mysqli_query($conn, $query)){
        while($favor_row = mysqli_fetch_row($result)) {   //puts table of nearby favors in favor_array
            $count = $count+1;
        }
        return $count;
    }
    else {
        return 0;
    }
};

function makeNewBarGraph($title, $subtitle, $dataArray, $renderAt, $height){
    $arrData = array(
        "chart" => array(
            "caption"=> $title,
            "subCaption"=> $subtitle,
            "enableSmartLabels"=> "0",
            "showValues"=> "0",
            "showPercentValues"=> "1",
            "showLegend"=> "1",
            "decimals"=> "1",
            "theme"=> "zune",
            "chartBottomMargin"=> "20",
            "labelstep" => "3"
        )
    );
    $arrData['data'] = array();
    // Iterate through the data in `$actualData` and insert in to the `$arrData` array.
    foreach ($dataArray as $key => $value) {
        array_push($arrData['data'],
            array(
                'label' => $key,
                'value' => $value
            )
        );
    }
    $jsonEncodedData = json_encode($arrData);
    $tempChart = new FusionCharts("line", $title , "100%", $height, $renderAt, "json", $jsonEncodedData);
    return $tempChart;
}

function getAverage($dataArray){
    $sum = 0;
    $numItems = count($dataArray);
    for ($x = 0; $x < $numItems; $x++){
        $sum = $sum + $dataArray[$x];
    }
    return ($sum/$numItems);
}

function getMin($dataArray){
    $min = 1000;
    $numItems = count($dataArray);
    for ($x = 1; $x <= $numItems; $x++){
        $num = (float) $dataArray[$x];
        $min = min($num, $min);
    }
    return $min;
}

function getMax($dataArray){
    $min = -1000;
    $numItems = count($dataArray);
    for ($x = 1; $x <= $numItems; $x++){
        $num = (float) $dataArray[$x];
        $min = max($num, $min);
    }
    return $min;
}

function getTrend($dataArray){
    $numItems = count($dataArray);
    $trend = ($dataArray[$numItems]-$dataArray[1])/$numItems;
    return $trend;
}
/*  2d Array print function
    <table id="timeslice-table">
        <tr>
            <th>ID</th>
            <th>Time</th>
            <th>Temperature</th>
            <th>Humidity</th>
            <th>Pressure</th>
            <th>Soil Moisture</th>
            <th>Soil pH</th>
            <th>Battery</th>
        </tr>

    </table>
        $col = 0;
        for ($row = 0; $row < get_num_rows($conn, $name); $row++) {
            echo "<tr>";
            for ($col = 0; $col < 8; $col++) {
                    echo "<td>" . $table[$row][$col] . "</td>";
            }
            echo "</tr>";
        }
 */
?>