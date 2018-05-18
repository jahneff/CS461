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

function get_table($conn, $tablename, $columns){
    $count = 0;
    $query =  "SELECT * FROM $tablename";
    $num_rows = get_num_rows($conn, $tablename);
    if($result=mysqli_query($conn, $query)){
        while($favor_row = mysqli_fetch_row($result)) {   //puts table of nearby favors in favor_array
            for ($i = 0; $i < $columns; $i++){
                $array[$count][$i] = $favor_row[$i];
            }
            $count = $count+1;
        }
    return $array;
    }
    else {
        return -1;
    }
};

function get_raw_table($conn, $tablename, $maxid, $minid){
    $count = 0;
    $query =  "SELECT DISTINCT timestamp, temperature, humidity, pressure, soil_moisture, light FROM $tablename WHERE (timesliceID >= $minid AND timesliceID <= $maxid); ";
    $num_rows = get_num_rows($conn, $tablename);
    if($result=mysqli_query($conn, $query)){
        return $result;
    }
    else {
        return -1;
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

function makeNewBarGraph($title, $subtitle, $dataArray, $renderAt, $height, $currentDay, $num_readings){
    switch ($title) {
        case 'Temperature':
            $yaxis = utf8_encode('C');
            break;
        case 'Humidity':
            $yaxis = utf8_encode('%');
            break;
        case 'Pressure':
            $yaxis = utf8_encode('kPa');
            break;
        case 'Soil Moisture':
            $yaxis = utf8_encode('%');
            break;
        case 'Light Intensity':
            $yaxis = utf8_encode('dalx');
            break;
        default:
            $yaxis = 'default';
            break;
    }
    $z = 0;
    $xaxis = "";
    $ymax = -100;
    foreach ($dataArray as $key => $value) {
        if ($z == 0) {
            $xaxis = $key;
        }
        else if ($z == ($num_readings-1)){
            $xaxis = $xaxis . " - " . $key;
        }
        $z++;
        if($value > $ymax){
            $ymax = $value;
        }
    }
    $i = -100;
    while ($i < 250){
        if($i > $ymax){
            $ymax = $i;
            $i = 250;
        }
        $i = $i + 50;
    }
    $xaxis = $xaxis . " (Military Time)";

    $arrData = array(
        "chart" => array(
            "caption"=> $title,
            "subCaption"=> $subtitle,
            "enableSmartLabels"=> "1",
            "showValues"=> "0",
            "showPercentValues"=> "1",
            "showLegend"=> "1",
            "decimals"=> "1",
            "theme"=> "zune",
            "chartBottomMargin"=> "20",
            "labelstep" => "3",
            "xaxisname" => $xaxis,
            "yaxisname" => $yaxis,
            "bgColor" => "97dd97, 202020",
            "yAxisMaxValue" => $ymax
        )
    );
    $arrData['data'] = array();
    // Iterate through the data in `$actualData` and insert in to the `$arrData` array.
    $x = 0;


    foreach ($dataArray as $key => $value) {
        $x++;
        if ($x == $num_readings){
            array_push($arrData['data'],
                array(
                    'label' => $key,
                    'value' => $value,
                    'anchorRadius' => "5"
                )
            );
        }
        else {
            array_push($arrData['data'],
                array(
                    'label' => $key,
                    'value' => $value,
                )
            );
        }
    }

    $jsonEncodedData = json_encode($arrData);
    $tempChart = new FusionCharts("line", $title , "100%", $height, $renderAt, "json", $jsonEncodedData);
    return $tempChart;
}

function makeNewCustomBarGraph($title, $subtitle, $dataArray, $renderAt, $height, $currentDay, $temp, $humid, $pres, $moist, $light)
{
    $yaxis = "";
    if ($temp != 0) {
        $yaxis = $yaxis . "C/";
    }
    if ($humid != 0) {
        $yaxis = $yaxis . "%/";
    }
    if ($pres != 0) {
        $yaxis = $yaxis . "kPa/";
    }
    if ($moist != 0) {
        $yaxis = $yaxis . "%/";
    }
    if ($light != 0) {
        $yaxis = $yaxis . "dalx/";
    }

    if ($yaxis == ""){
        $yaxis = "default";
    }
    else {
        $yaxis = substr($yaxis, 0, -1);
    }

    $xaxis = "Time (" . $currentDay . ")";

    $arrData = array(
        "chart" => array(
            "caption"=> $title,
            "subCaption"=> $subtitle,
            "enableSmartLabels"=> "1",
            "showValues"=> "0",
            "showPercentValues"=> "1",
            "showLegend"=> "1",
            "decimals"=> "1",
            "theme"=> "zune",
            "chartBottomMargin"=> "20",
            "labelstep" => "3",
            "xaxisname" => $xaxis,
            "yaxisname" => $yaxis,
            "bgColor" => "97dd97, 202020",
        )
    );
    $categoryArray=array();
    $dataseries1=array();
    $dataseries2=array();
    $dataseries3=array();
    $dataseries4=array();
    $dataseries5=array();

    while($row = mysqli_fetch_array($dataArray)) {
        array_push($categoryArray, array(
                "label" => $row[0]
            )
        );
        if ($temp != 0) {
            array_push($dataseries1, array(
                    "value" => $row[1]
                )
            );
        }
        if ($humid != 0) {
            array_push($dataseries2, array(
                    "value" => $row[2]
                )
            );
        }
        if ($pres != 0) {
            array_push($dataseries3, array(
                    "value" => ($row[3])
                )
            );
        }
        if ($moist != 0) {
            array_push($dataseries4, array(
                    "value" => $row[4]
                )
            );
        }
        if ($light != 0) {
            array_push($dataseries5, array(
                    "value" => $row[5]
                )
            );
        }
    }
    $arrData["categories"]=array(array("category"=>$categoryArray));
    $arrData["dataset"] = array(array("seriesName"=> "Temperature (C)", "renderAs"=>"line", "data"=>$dataseries1), array("seriesName"=> "Humidity (%)",  "renderAs"=>"line", "data"=>$dataseries2), array("seriesName"=> "Pressure (kPa)",  "renderAs"=>"line", "data"=>$dataseries3),array("seriesName"=> "Soil Moisture (%)",  "renderAs"=>"line", "data"=>$dataseries4),array("seriesName"=> "Light (dalx)",  "renderAs"=>"line", "data"=>$dataseries5));
    $jsonEncodedData = json_encode($arrData);
    $tempChart = new FusionCharts("mscombi2d", $title , "100%", $height, $renderAt, "json", $jsonEncodedData);
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

function parseTemp($string, $bookend1, $bookend2){
    $pos = strpos($string, $bookend1);
    $begin = $pos + strlen($bookend1);
    $pos = strpos($string, $bookend2);
    $end = $pos - 1;
    $length = $end - $begin;
    $sub = substr($string, $begin, $length);
    return $sub;
}

function parseString($string, $bookend1){
    $begin = strpos($string, $bookend1) + strlen($bookend1);
    $end = strlen($string);
    $length = $end - $begin;
    $sub = substr($string, $begin, $length);
    return $sub;
}

?>