<?php
include_once 'functions.php';

$conn = gs2_database_connect();
?>

<head>
    <title>GS2 Dashboard</title>
    <link rel="stylesheet" type="text/css" href="library/bootstrap.css"/>
    <link rel="stylesheet" type="text/css" href="library/gs2styles.css"/>
    <script src="fusioncharts/js/fusioncharts.js"></script>
    <script src="fusioncharts/js/fusioncharts.theme.ocean.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.9/js/all.js" integrity="sha384-8iPTk2s/jMVj81dnzb/iFR2sdA7u06vHJyyLlAd4snFpCl/SnyUjRrbdJsw1pGIl" crossorigin="anonymous"></script>

    <nav class="navbar  navbar-dark bg-primary sticky-top" style="margin-bottom: 10px; background-color: #5cb85c;">
        <a class="navbar-brand" href="dashboard.php" style="color: white;"><b>My Smart Gardening System</b></a>
        <div class="gs2-button" style="float:right; margin-right: 10px;">
            <a class="btn btn-primary" href="parameters.php" role="button" style="background-color:#5cb85c; border-color: #ffffff; margin: 5% auto; font-size: 125%; ">Set system parameters</a>
        </div>
    </nav>
</head>

<?php


$xdate = "";
$ydate = "";

if ($_GET['xyear']!=""){
    $xdate = $xdate . $_GET['xyear'];
    if ($_GET['xmonth']!=""){
        $xdate = $xdate . "-" . $_GET['xmonth'];
        if ($_GET['xday']!=""){
            $xdate = $xdate . "-" . $_GET['xday'];
        }
        else {
            $xdate = $xdate . "-1";
        }
        if ($_GET['xhour']!=""){
            $xdate = $xdate . " " . $_GET['xhour'];
        }
        else {
            $xdate = $xdate . "-1";
        }
        if ($_GET['xminute']!=""){
            $xdate = $xdate . ":". $_GET['xminute'] . ":00";
        }
        else {
            $xdate = $xdate;
        }
    }
    else {
        $xdate = $xdate . "-1";
        if ($_GET['xday']!=""){
            $xdate = $xdate . "-" . $_GET['xday'];
        }
        else {
            $xdate = $xdate . "-1";
        }
        if ($_GET['xhour']!=""){
            $xdate = $xdate . " ". $_GET['xhour'];
        }
        else {
            $xdate = $xdate . "-1";
        }
        if ($_GET['xminute']!=""){
            $xdate = $xdate . ":". $_GET['xminute'] . ":00";
        }
        else {
            $xdate = $xdate;
        }
    }
}

if ($_GET['yyear']!=""){
    $ydate = $ydate . $_GET['yyear'];
    if ($_GET['ymonth']!=""){
        $ydate = $ydate . "-" . $_GET['ymonth'];
        if ($_GET['yday']!=""){
            $ydate = $ydate . "-" . $_GET['yday'];
        }
        else {
            $ydate = $ydate . "-1";
        }
        if ($_GET['yhour']!=""){
            $ydate = $ydate . " " . $_GET['yhour'];
        }
        else {
            $ydate = $ydate . "-1";
        }
        if ($_GET['yminute']!=""){
            $ydate = $ydate . ":". $_GET['yminute'] . ":00";
        }
        else {
            $ydate = $ydate;
        }
    }
    else {
        $ydate = $ydate . "-1";
        if ($_GET['yday']!=""){
            $ydate = $ydate . "-" . $_GET['yday'];
        }
        else {
            $ydate = $ydate . "-1";
        }
        if ($_GET['yhour']!=""){
            $ydate = $ydate . " ". $_GET['yhour'];
        }
        else {
            $ydate = $ydate . "-1";
        }
        if ($_GET['yminute']!=""){
            $ydate = $ydate . ":". $_GET['yminute'] . ":00";
        }
        else {
            $ydate = $ydate;
        }
    }
}

$temp = 0;
$humid = 0;
$pres = 0;
$moist = 0;
$light = 0;

if (isset($_GET['graphtemp']) && $_GET['graphtemp']=="Y"){
    $temp = 1;
}
if (isset($_GET['graphhumid']) && $_GET['graphhumid']=="Y"){
    $humid = 1;
}
if (isset($_GET['graphpres']) && $_GET['graphpres']=="Y"){
    $pres = 1;
}
if (isset($_GET['graphmoist']) && $_GET['graphmoist']=="Y"){
    $moist = 1;
}
if (isset($_GET['graphlight']) && $_GET['graphlight']=="Y"){
    $light = 1;
}

//echo $xdate;
//echo $ydate;
//echo strtotime($xdate);
//echo strtotime($ydate);

$time_lo_bound = strtotime($xdate);
$time_hi_bound = strtotime($ydate);
$table1 = get_table($conn, 'Timeslice', 8);
$num_rows = get_num_rows($conn, 'Timeslice');


$j = 0;
while($time_lo_bound > strtotime($table1[$j]['1']) && $j < $num_rows) {
    $j++;
}

$k = $num_rows - 1;
while($time_hi_bound < strtotime($table1[$k]['1']) && $k > 0) {
    $k--;
}

$name = "Timeslice";
$table = get_raw_table($conn, $name, $k, $j);
$chart = makeNewCustomBarGraph("Testting Graph Render", "PASSED", $table, "chart-1", 300, date("Y/m/d"), $temp, $humid, $pres, $moist, $light);
$chart->render();
?>
<div class="row">
    <div class = "col-sm-2">
    </div>
    <div class = "col-sm-8" style="text-align: center;">
        <?php
        if($j == 0 && ($k == 0 || $k == -1)){
        echo "<h2>Sorry, no data could be found between the interval of " . $xdate . " and " . $ydate . ", please try a new interval";
            }
        ?>
        <div class = "category-wrap">
            <div class="chart-container" id="chart-1">chart renders here</div>
        </div>
        <div class="gs2-button" style="margin-left: 5%;">
            <a class="btn btn-primary" href="dashboard.php?" role="button" style="background-color:#5cb85c; border-color: #ffffff; margin: 5% auto; font-size: 110%">Back to dashboard</a>
        </div>
    </div>
    <div class = "col-sm-2">
    </div>
</div>
<div class="row">
    <div class = "col-sm-4">
    </div>
    <div class = "col-sm-4" style="text-align: center;">
        <form class="form-search" id="searchform" name="searchform" method="get" action="view_data.php" style="margin-left:2.5%;">
            <h2 class="form-signup-heading" style="color:white; margin-bottom: 0;">Search</h2>
            <div class="form-signup-subheading">Creates a customized view of your data from time x to time y</div>

            <div class="earlywrap">
                <label for="xmonth">Month X:</label>
                <select name="xmonth" id="xmonth" class="form-control form-search">
                    <option value="1">January</option>
                    <option value="2">February</option>
                    <option value="3">March</option>
                    <option value="4">April</option>
                    <option value="5">May</option>
                    <option value="6">June</option>
                    <option value="7">July</option>
                    <option value="8">August</option>
                    <option value="9">September</option>
                    <option value="10">October</option>
                    <option value="11">November</option>
                    <option value="12">December</option>
                </select>
                <label for="xday">Day X:</label>
                <select name="xday" id="xday" class="form-control form-search">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                    <option value="9">9</option>
                    <option value="10">10</option>
                    <option value="11">11</option>
                    <option value="12">12</option>
                    <option value="13">13</option>
                    <option value="14">14</option>
                    <option value="15">15</option>
                    <option value="16">16</option>
                    <option value="17">17</option>
                    <option value="18">18</option>
                    <option value="19">19</option>
                    <option value="20">20</option>
                    <option value="21">21</option>
                    <option value="22">22</option>
                    <option value="23">23</option>
                    <option value="24">24</option>
                    <option value="25">25</option>
                    <option value="26">26</option>
                    <option value="27">27</option>
                    <option value="28">28</option>
                    <option value="29">29</option>
                    <option value="30">30</option>
                    <option value="31">31</option>
                </select>
                <label for="xday">Year X:</label>

                <select name="xyear" id="xyear" class="form-control form-search">
                    <?PHP for($i=date("Y"); $i<=date("Y")+4; $i++)
                        if($year == $i)
                            echo "<option value='$i' selected>$i</option>";
                        else
                            echo "<option value='$i'>$i</option>";
                    ?>
                </select>
                <label for="xhour">Hour X:</label>
                <select name="xhour" id="xhour" class="form-control form-search">
                    <option value="0" <?PHP if($month==12) echo "selected";?>>12 a.m.</option>
                    <option value="1"  <?PHP if($month==1) echo "selected";?>>1 a.m.</option>
                    <option value="2"  <?PHP if($month==2) echo "selected";?>>2 a.m.</option>
                    <option value="3"  <?PHP if($month==3) echo "selected";?>>3 a.m.</option>
                    <option value="4"  <?PHP if($month==4) echo "selected";?>>4 a.m.</option>
                    <option value="5"  <?PHP if($month==5) echo "selected";?>>5 a.m.</option>
                    <option value="6"  <?PHP if($month==6) echo "selected";?>>6 a.m.</option>
                    <option value="7"  <?PHP if($month==7) echo "selected";?>>7 a.m.</option>
                    <option value="8"  <?PHP if($month==8) echo "selected";?>>8 a.m.</option>
                    <option value="9"  <?PHP if($month==9) echo "selected";?>>9 a.m.</option>
                    <option value="10" <?PHP if($month==10) echo "selected";?>>10 a.m.</option>
                    <option value="11" <?PHP if($month==11) echo "selected";?>>11 a.m.</option>
                    <option value="12" <?PHP if($month==12) echo "selected";?>>12 p.m.</option>
                    <option value="13"  <?PHP if($month==1) echo "selected";?>>1 p.m.</option>
                    <option value="14"  <?PHP if($month==2) echo "selected";?>>2 p.m.</option>
                    <option value="15"  <?PHP if($month==3) echo "selected";?>>3 p.m.</option>
                    <option value="16"  <?PHP if($month==4) echo "selected";?>>4 p.m.</option>
                    <option value="17"  <?PHP if($month==5) echo "selected";?>>5 p.m.</option>
                    <option value="18"  <?PHP if($month==6) echo "selected";?>>6 p.m.</option>
                    <option value="19"  <?PHP if($month==7) echo "selected";?>>7 p.m.</option>
                    <option value="20"  <?PHP if($month==8) echo "selected";?>>8 p.m.</option>
                    <option value="21"  <?PHP if($month==9) echo "selected";?>>9 p.m.</option>
                    <option value="22" <?PHP if($month==10) echo "selected";?>>10 p.m.</option>
                    <option value="23" <?PHP if($month==11) echo "selected";?>>11 p.m.</option>
                </select>
                <label for="xminute">Minute X:</label>
                <select name="xminute" id="xminute" class="form-control form-search">
                    <option value="0" <?PHP if($month==12) echo "selected";?>>0</option>
                    <option value="1"  <?PHP if($month==1) echo "selected";?>>1</option>
                    <option value="2"  <?PHP if($month==2) echo "selected";?>>2</option>
                    <option value="3"  <?PHP if($month==3) echo "selected";?>>3</option>
                    <option value="4"  <?PHP if($month==4) echo "selected";?>>4</option>
                    <option value="5"  <?PHP if($month==5) echo "selected";?>>5</option>
                    <option value="6"  <?PHP if($month==6) echo "selected";?>>6</option>
                    <option value="7"  <?PHP if($month==7) echo "selected";?>>7</option>
                    <option value="8"  <?PHP if($month==8) echo "selected";?>>8</option>
                    <option value="9"  <?PHP if($month==9) echo "selected";?>>9</option>
                    <option value="10" <?PHP if($month==10) echo "selected";?>>10</option>
                    <option value="11" <?PHP if($month==11) echo "selected";?>>11</option>
                    <option value="12" <?PHP if($month==12) echo "selected";?>>12</option>
                    <option value="13"  <?PHP if($month==1) echo "selected";?>>13</option>
                    <option value="14"  <?PHP if($month==2) echo "selected";?>>14</option>
                    <option value="15"  <?PHP if($month==3) echo "selected";?>>15</option>
                    <option value="16"  <?PHP if($month==4) echo "selected";?>>16</option>
                    <option value="17"  <?PHP if($month==5) echo "selected";?>>17</option>
                    <option value="18"  <?PHP if($month==6) echo "selected";?>>18</option>
                    <option value="19"  <?PHP if($month==7) echo "selected";?>>19</option>
                    <option value="20"  <?PHP if($month==8) echo "selected";?>>20</option>
                    <option value="21"  <?PHP if($month==9) echo "selected";?>>21</option>
                    <option value="22" <?PHP if($month==10) echo "selected";?>>22</option>
                    <option value="23" <?PHP if($month==11) echo "selected";?>>23</option>
                    <option value="24" <?PHP if($month==12) echo "selected";?>>24</option>
                    <option value="25"  <?PHP if($month==1) echo "selected";?>>25</option>
                    <option value="26"  <?PHP if($month==2) echo "selected";?>>26</option>
                    <option value="27"  <?PHP if($month==3) echo "selected";?>>27</option>
                    <option value="28"  <?PHP if($month==4) echo "selected";?>>28</option>
                    <option value="29"  <?PHP if($month==5) echo "selected";?>>29</option>
                    <option value="30"  <?PHP if($month==6) echo "selected";?>>30</option>
                    <option value="31"  <?PHP if($month==7) echo "selected";?>>31</option>
                    <option value="32"  <?PHP if($month==8) echo "selected";?>>32</option>
                    <option value="33"  <?PHP if($month==9) echo "selected";?>>33</option>
                    <option value="34" <?PHP if($month==10) echo "selected";?>>34</option>
                    <option value="35" <?PHP if($month==11) echo "selected";?>>35</option>
                    <option value="36" <?PHP if($month==12) echo "selected";?>>36</option>
                    <option value="37"  <?PHP if($month==1) echo "selected";?>>37</option>
                    <option value="38"  <?PHP if($month==2) echo "selected";?>>38</option>
                    <option value="39"  <?PHP if($month==3) echo "selected";?>>39</option>
                    <option value="40"  <?PHP if($month==4) echo "selected";?>>40</option>
                    <option value="41"  <?PHP if($month==5) echo "selected";?>>41</option>
                    <option value="42"  <?PHP if($month==6) echo "selected";?>>42</option>
                    <option value="43"  <?PHP if($month==7) echo "selected";?>>43</option>
                    <option value="44"  <?PHP if($month==8) echo "selected";?>>44</option>
                    <option value="45"  <?PHP if($month==9) echo "selected";?>>45</option>
                    <option value="46" <?PHP if($month==10) echo "selected";?>>46</option>
                    <option value="47" <?PHP if($month==11) echo "selected";?>>47</option>
                    <option value="48" <?PHP if($month==12) echo "selected";?>>48</option>
                    <option value="49"  <?PHP if($month==1) echo "selected";?>>49</option>
                    <option value="50"  <?PHP if($month==2) echo "selected";?>>50</option>
                    <option value="51"  <?PHP if($month==3) echo "selected";?>>51</option>
                    <option value="52"  <?PHP if($month==4) echo "selected";?>>52</option>
                    <option value="53"  <?PHP if($month==5) echo "selected";?>>53</option>
                    <option value="54"  <?PHP if($month==6) echo "selected";?>>54</option>
                    <option value="55"  <?PHP if($month==7) echo "selected";?>>55</option>
                    <option value="56"  <?PHP if($month==8) echo "selected";?>>56</option>
                    <option value="57"  <?PHP if($month==9) echo "selected";?>>57</option>
                    <option value="58" <?PHP if($month==10) echo "selected";?>>58</option>
                    <option value="59" <?PHP if($month==11) echo "selected";?>>59</option>
                </select>
            </div>

            <div class="earlywrap">
                <label for="ymonth">Day Y:</label>
                <select name="ymonth" id="ymonth" class="form-control form-search">
                    <option value="1"  <?PHP if($month==1) echo "selected";?>>January</option>
                    <option value="2"  <?PHP if($month==2) echo "selected";?>>February</option>
                    <option value="3"  <?PHP if($month==3) echo "selected";?>>March</option>
                    <option value="4"  <?PHP if($month==4) echo "selected";?>>April</option>
                    <option value="5"  <?PHP if($month==5) echo "selected";?>>May</option>
                    <option value="6"  <?PHP if($month==6) echo "selected";?>>June</option>
                    <option value="7"  <?PHP if($month==7) echo "selected";?>>July</option>
                    <option value="8"  <?PHP if($month==8) echo "selected";?>>August</option>
                    <option value="9"  <?PHP if($month==9) echo "selected";?>>September</option>
                    <option value="10" <?PHP if($month==10) echo "selected";?>>October</option>
                    <option value="11" <?PHP if($month==11) echo "selected";?>>November</option>
                    <option value="12" <?PHP if($month==12) echo "selected";?>>December</option>
                </select>

                <label for="yday">Day Y:</label>
                <select name="yday" id="yday" class="form-control form-search">
                    <option value="1"  <?PHP if($day==1) echo "selected";?>>1</option>
                    <option value="2"  <?PHP if($day==2) echo "selected";?>>2</option>
                    <option value="3"  <?PHP if($day==3) echo "selected";?>>3</option>
                    <option value="4"  <?PHP if($day==4) echo "selected";?>>4</option>
                    <option value="5"  <?PHP if($day==5) echo "selected";?>>5</option>
                    <option value="6"  <?PHP if($day==6) echo "selected";?>>6</option>
                    <option value="7"  <?PHP if($day==7) echo "selected";?>>7</option>
                    <option value="8"  <?PHP if($day==8) echo "selected";?>>8</option>
                    <option value="9"  <?PHP if($day==9) echo "selected";?>>9</option>
                    <option value="10" <?PHP if($day==10) echo "selected";?>>10</option>
                    <option value="11" <?PHP if($day==11) echo "selected";?>>11</option>
                    <option value="12" <?PHP if($day==12) echo "selected";?>>12</option>
                    <option value="13" <?PHP if($day==13) echo "selected";?>>13</option>
                    <option value="14" <?PHP if($day==14) echo "selected";?>>14</option>
                    <option value="15" <?PHP if($day==15) echo "selected";?>>15</option>
                    <option value="16" <?PHP if($day==16) echo "selected";?>>16</option>
                    <option value="17" <?PHP if($day==17) echo "selected";?>>17</option>
                    <option value="18" <?PHP if($day==18) echo "selected";?>>18</option>
                    <option value="19" <?PHP if($day==19) echo "selected";?>>19</option>
                    <option value="20" <?PHP if($day==20) echo "selected";?>>20</option>
                    <option value="21" <?PHP if($day==21) echo "selected";?>>21</option>
                    <option value="22" <?PHP if($day==22) echo "selected";?>>22</option>
                    <option value="23" <?PHP if($day==23) echo "selected";?>>23</option>
                    <option value="24" <?PHP if($day==24) echo "selected";?>>24</option>
                    <option value="25" <?PHP if($day==25) echo "selected";?>>25</option>
                    <option value="26" <?PHP if($day==26) echo "selected";?>>26</option>
                    <option value="27" <?PHP if($day==27) echo "selected";?>>27</option>
                    <option value="28" <?PHP if($day==28) echo "selected";?>>28</option>
                    <option value="29" <?PHP if($day==29) echo "selected";?>>29</option>
                    <option value="30" <?PHP if($day==30) echo "selected";?>>30</option>
                    <option value="31" <?PHP if($day==31) echo "selected";?>>31</option>
                </select>

                <label for="yyear">Year Y:</label>
                <select name="yyear" id="yyear" class="form-control form-search">
                    <?PHP for($i=date("Y"); $i<=date("Y")+4; $i++)
                        if($year == $i)
                            echo "<option value='$i' selected>$i</option>";
                        else
                            echo "<option value='$i'>$i</option>";
                    ?>
                </select>

                <label for="yhour">Hour Y:</label>
                <select name="yhour" id="yhour" class="form-control form-search">
                    <option value="0" <?PHP if($month==12) echo "selected";?>>12 a.m.</option>
                    <option value="1"  <?PHP if($month==1) echo "selected";?>>1 a.m.</option>
                    <option value="2"  <?PHP if($month==2) echo "selected";?>>2 a.m.</option>
                    <option value="3"  <?PHP if($month==3) echo "selected";?>>3 a.m.</option>
                    <option value="4"  <?PHP if($month==4) echo "selected";?>>4 a.m.</option>
                    <option value="5"  <?PHP if($month==5) echo "selected";?>>5 a.m.</option>
                    <option value="6"  <?PHP if($month==6) echo "selected";?>>6 a.m.</option>
                    <option value="7"  <?PHP if($month==7) echo "selected";?>>7 a.m.</option>
                    <option value="8"  <?PHP if($month==8) echo "selected";?>>8 a.m.</option>
                    <option value="9"  <?PHP if($month==9) echo "selected";?>>9 a.m.</option>
                    <option value="10" <?PHP if($month==10) echo "selected";?>>10 a.m.</option>
                    <option value="11" <?PHP if($month==11) echo "selected";?>>11 a.m.</option>
                    <option value="12" <?PHP if($month==12) echo "selected";?>>12 p.m.</option>
                    <option value="13"  <?PHP if($month==1) echo "selected";?>>1 p.m.</option>
                    <option value="14"  <?PHP if($month==2) echo "selected";?>>2 p.m.</option>
                    <option value="15"  <?PHP if($month==3) echo "selected";?>>3 p.m.</option>
                    <option value="16"  <?PHP if($month==4) echo "selected";?>>4 p.m.</option>
                    <option value="17"  <?PHP if($month==5) echo "selected";?>>5 p.m.</option>
                    <option value="18"  <?PHP if($month==6) echo "selected";?>>6 p.m.</option>
                    <option value="19"  <?PHP if($month==7) echo "selected";?>>7 p.m.</option>
                    <option value="20"  <?PHP if($month==8) echo "selected";?>>8 p.m.</option>
                    <option value="21"  <?PHP if($month==9) echo "selected";?>>9 p.m.</option>
                    <option value="22" <?PHP if($month==10) echo "selected";?>>10 p.m.</option>
                    <option value="23" <?PHP if($month==11) echo "selected";?>>11 p.m.</option>
                </select>
                <label for="yminute">Minute Y:</label>
                <select name="yminute" id="yminute" class="form-control form-search">
                    <option value="0" <?PHP if($month==12) echo "selected";?>>0</option>
                    <option value="1"  <?PHP if($month==1) echo "selected";?>>1</option>
                    <option value="2"  <?PHP if($month==2) echo "selected";?>>2</option>
                    <option value="3"  <?PHP if($month==3) echo "selected";?>>3</option>
                    <option value="4"  <?PHP if($month==4) echo "selected";?>>4</option>
                    <option value="5"  <?PHP if($month==5) echo "selected";?>>5</option>
                    <option value="6"  <?PHP if($month==6) echo "selected";?>>6</option>
                    <option value="7"  <?PHP if($month==7) echo "selected";?>>7</option>
                    <option value="8"  <?PHP if($month==8) echo "selected";?>>8</option>
                    <option value="9"  <?PHP if($month==9) echo "selected";?>>9</option>
                    <option value="10" <?PHP if($month==10) echo "selected";?>>10</option>
                    <option value="11" <?PHP if($month==11) echo "selected";?>>11</option>
                    <option value="12" <?PHP if($month==12) echo "selected";?>>12</option>
                    <option value="13"  <?PHP if($month==1) echo "selected";?>>13</option>
                    <option value="14"  <?PHP if($month==2) echo "selected";?>>14</option>
                    <option value="15"  <?PHP if($month==3) echo "selected";?>>15</option>
                    <option value="16"  <?PHP if($month==4) echo "selected";?>>16</option>
                    <option value="17"  <?PHP if($month==5) echo "selected";?>>17</option>
                    <option value="18"  <?PHP if($month==6) echo "selected";?>>18</option>
                    <option value="19"  <?PHP if($month==7) echo "selected";?>>19</option>
                    <option value="20"  <?PHP if($month==8) echo "selected";?>>20</option>
                    <option value="21"  <?PHP if($month==9) echo "selected";?>>21</option>
                    <option value="22" <?PHP if($month==10) echo "selected";?>>22</option>
                    <option value="23" <?PHP if($month==11) echo "selected";?>>23</option>
                    <option value="24" <?PHP if($month==12) echo "selected";?>>24</option>
                    <option value="25"  <?PHP if($month==1) echo "selected";?>>25</option>
                    <option value="26"  <?PHP if($month==2) echo "selected";?>>26</option>
                    <option value="27"  <?PHP if($month==3) echo "selected";?>>27</option>
                    <option value="28"  <?PHP if($month==4) echo "selected";?>>28</option>
                    <option value="29"  <?PHP if($month==5) echo "selected";?>>29</option>
                    <option value="30"  <?PHP if($month==6) echo "selected";?>>30</option>
                    <option value="31"  <?PHP if($month==7) echo "selected";?>>31</option>
                    <option value="32"  <?PHP if($month==8) echo "selected";?>>32</option>
                    <option value="33"  <?PHP if($month==9) echo "selected";?>>33</option>
                    <option value="34" <?PHP if($month==10) echo "selected";?>>34</option>
                    <option value="35" <?PHP if($month==11) echo "selected";?>>35</option>
                    <option value="36" <?PHP if($month==12) echo "selected";?>>36</option>
                    <option value="37"  <?PHP if($month==1) echo "selected";?>>37</option>
                    <option value="38"  <?PHP if($month==2) echo "selected";?>>38</option>
                    <option value="39"  <?PHP if($month==3) echo "selected";?>>39</option>
                    <option value="40"  <?PHP if($month==4) echo "selected";?>>40</option>
                    <option value="41"  <?PHP if($month==5) echo "selected";?>>41</option>
                    <option value="42"  <?PHP if($month==6) echo "selected";?>>42</option>
                    <option value="43"  <?PHP if($month==7) echo "selected";?>>43</option>
                    <option value="44"  <?PHP if($month==8) echo "selected";?>>44</option>
                    <option value="45"  <?PHP if($month==9) echo "selected";?>>45</option>
                    <option value="46" <?PHP if($month==10) echo "selected";?>>46</option>
                    <option value="47" <?PHP if($month==11) echo "selected";?>>47</option>
                    <option value="48" <?PHP if($month==12) echo "selected";?>>48</option>
                    <option value="49"  <?PHP if($month==1) echo "selected";?>>49</option>
                    <option value="50"  <?PHP if($month==2) echo "selected";?>>50</option>
                    <option value="51"  <?PHP if($month==3) echo "selected";?>>51</option>
                    <option value="52"  <?PHP if($month==4) echo "selected";?>>52</option>
                    <option value="53"  <?PHP if($month==5) echo "selected";?>>53</option>
                    <option value="54"  <?PHP if($month==6) echo "selected";?>>54</option>
                    <option value="55"  <?PHP if($month==7) echo "selected";?>>55</option>
                    <option value="56"  <?PHP if($month==8) echo "selected";?>>56</option>
                    <option value="57"  <?PHP if($month==9) echo "selected";?>>57</option>
                    <option value="58" <?PHP if($month==10) echo "selected";?>>58</option>
                    <option value="59" <?PHP if($month==11) echo "selected";?>>59</option>
                </select>
            </div>
            <div class="checkbox-wrap">
                <label for="tempbox" style="font-size: larger; width: 50%;">Temperature</label>
                <input type="checkbox" name="graphtemp" id="graphtemp" value="Y" style="margin-left: 10%; vertical-align: middle;">
            </div>
            <div class="checkbox-wrap">
                <label for="tempbox" style="font-size: larger; width: 50%;">Humidity</label>
                <input type="checkbox" name="graphhumid" id="graphhumid" value="Y" style="margin-left: 10%; vertical-align: middle;">
            </div>
            <div class="checkbox-wrap">
                <label for="tempbox" style="font-size: larger; width: 50%;">Pressure</label>
                <input type="checkbox" name="graphpres" id="graphpres" value="Y" style="margin-left: 10%; vertical-align: middle;">
            </div>
            <div class="checkbox-wrap">
                <label for="tempbox" style="font-size: larger; width: 50%;">Soil Moisture</label>
                <input type="checkbox" name="graphmoist" id="graphmoist" value="Y" style="margin-left: 10%; vertical-align: middle;">
            </div>
            <div class="checkbox-wrap">
                <label for="tempbox" style="font-size: larger; width: 50%;">Light</label>
                <input type="checkbox" name="graphlight" id="graphlight" value="Y" style="margin-left: 10%; vertical-align: middle;">
            </div>
            <button name="signup_btn" id="signup_btn" class="btn btn-primary" style ="background-color:#5cb85c; border-color: #ffffff; margin: 5% 2%; font-size: 125%" type="submit">Search</button>
        </form>
    </div>
    <div class = "col-sm-4">
    </div>
</div>

