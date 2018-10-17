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

//This very long sections formats from the get request, a datetime string that can be numerically compared to the ones stored in the database. This allows us to set a low and high time bound and fetch all rows within it.
$xdate = "";
$ydate = "";

$xdatehour = "";
$xdateday = "";
$xdatemonth = "";

$ydatehour = "";
$ydateday = "";
$ydatemonth = "";

if ($_GET['xyear']!=""){
    $xdate = $xdate . $_GET['xyear'];
    if ($_GET['xmonth']!=""){
        $xdate = $xdate . "-" . $_GET['xmonth'];
        $xdatemonth = $_GET['xmonth'];
        if ($_GET['xday']!=""){
            $xdate = $xdate . "-" . $_GET['xday'];
            $xdateday = $_GET['xday'];
        }
        else {
            $xdate = $xdate . "-1";
        }
        if ($_GET['xhour']!=""){
            $xdate = $xdate . " " . $_GET['xhour'];
            $xdatehour = $_GET['xhour'];
        }
        else {
            $xdate = $xdate . "-1";
        }
        if ($_GET['xminute']!=""){
            if($_GET['xminute']=="0"){
                $xdate = $xdate . ":0". $_GET['xminute'] . ":00";
            }
            else {
                $xdate = $xdate . ":" . $_GET['xminute'] . ":00";
            }
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
            if($_GET['xminute']=="0"){
                $xdate = $xdate . ":0". $_GET['xminute'] . ":00";
            }
            else {
                $xdate = $xdate . ":" . $_GET['xminute'] . ":00";
            }
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
        $ydatemonth = $_GET['ymonth'];
        if ($_GET['yday']!=""){
            $ydate = $ydate . "-" . $_GET['yday'];
            $ydateday = $_GET['yday'];

        }
        else {
            $ydate = $ydate . "-1";
        }
        if ($_GET['yhour']!=""){
            $ydate = $ydate . " " . $_GET['yhour'];
            $ydatehour = $_GET['yhour'];

        }
        else {
            $ydate = $ydate . "-1";
        }
        if ($_GET['yminute']!=""){
            if($_GET['yminute']=="0"){
                $ydate = $ydate . ":0". $_GET['yminute'] . ":00";
            }
            else {
                $ydate = $ydate . ":" . $_GET['yminute'] . ":00";
            }        }
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
            if($_GET['yminute']=="0"){
                $ydate = $ydate . ":0". $_GET['yminute'] . ":00";
            }
            else {
                $ydate = $ydate . ":" . $_GET['yminute'] . ":00";
            }
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
$table = get_raw_table($conn, $name, $table1[$k][0], $table1[$j][0]);
$label = $xdate . " -- " . $ydate;
$chart = makeNewCustomBarGraph("Combination Graph", "Custom time period", $table, "chart-1", 300, $label, $temp, $humid, $pres, $moist, $light);
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
        else {
            echo "<h2>From " . $xdate . " to " . $ydate      . "</h2>";
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
                    <option value="1"<?php if($xdatemonth == 1){echo "selected=\"selected\"";}?>>January</option>
                    <option value="2"<?php if($xdatemonth == 2){echo "selected=\"selected\"";}?>>February</option>
                    <option value="3"<?php if($xdatemonth == 3){echo "selected=\"selected\"";}?>>March</option>
                    <option value="4" <?php if($xdatemonth == 4){echo "selected=\"selected\"";}?>>April</option>
                    <option value="5"<?php if($xdatemonth == 5){echo "selected=\"selected\"";}?>>May</option>
                    <option value="6"<?php if($xdatemonth == 6){echo "selected=\"selected\"";}?>>June</option>
                    <option value="7"<?php if($xdatemonth == 7){echo "selected=\"selected\"";}?>>July</option>
                    <option value="8"<?php if($xdatemonth == 8){echo "selected=\"selected\"";}?>>August</option>
                    <option value="9"<?php if($xdatemonth == 9){echo "selected=\"selected\"";}?>>September</option>
                    <option value="10"<?php if($xdatemonth == 10){echo "selected=\"selected\"";}?>>October</option>
                    <option value="11"<?php if($xdatemonth == 11){echo "selected=\"selected\"";}?>>November</option>
                    <option value="12"<?php if($xdatemonth == 12){echo "selected=\"selected\"";}?>>December</option>
                </select>
                <label for="xday">Day X:</label>
                <select name="xday" id="xday" class="form-control form-search">
                    <option value="1"  <?PHP if($xdateday==1) echo "selected=\"selected\"";?>>1</option>
                    <option value="2"  <?PHP if($xdateday==2) echo "selected=\"selected\"";?>>2</option>
                    <option value="3"  <?PHP if($xdateday==3) echo "selected=\"selected\"";?>>3</option>
                    <option value="4"  <?PHP if($xdateday==4) echo "selected=\"selected\"";?>>4</option>
                    <option value="5"  <?PHP if($xdateday==5) echo "selected=\"selected\"";?>>5</option>
                    <option value="6"  <?PHP if($xdateday==6) echo "selected=\"selected\"";?>>6</option>
                    <option value="7"  <?PHP if($xdateday==7) echo "selected=\"selected\"";?>>7</option>
                    <option value="8"  <?PHP if($xdateday==8) echo "selected=\"selected\"";?>>8</option>
                    <option value="9"  <?PHP if($xdateday==9) echo "selected=\"selected\"";?>>9</option>
                    <option value="10" <?PHP if($xdateday==10) echo "selected=\"selected\"";?>>10</option>
                    <option value="11" <?PHP if($xdateday==11) echo "selected=\"selected\"";?>>11</option>
                    <option value="12" <?PHP if($xdateday==12) echo "selected=\"selected\"";?>>12</option>
                    <option value="13" <?PHP if($xdateday==13) echo "selected=\"selected\"";?>>13</option>
                    <option value="14" <?PHP if($xdateday==14) echo "selected=\"selected\"";?>>14</option>
                    <option value="15" <?PHP if($xdateday==15) echo "selected=\"selected\"";?>>15</option>
                    <option value="16" <?PHP if($xdateday==16) echo "selected=\"selected\"";?>>16</option>
                    <option value="17" <?PHP if($xdateday==17) echo "selected=\"selected\"";?>>17</option>
                    <option value="18" <?PHP if($xdateday==18) echo "selected=\"selected\"";?>>18</option>
                    <option value="19" <?PHP if($xdateday==19) echo "selected=\"selected\"";?>>19</option>
                    <option value="20" <?PHP if($xdateday==20) echo "selected=\"selected\"";?>>20</option>
                    <option value="21" <?PHP if($xdateday==21) echo "selected=\"selected\"";?>>21</option>
                    <option value="22" <?PHP if($xdateday==22) echo "selected=\"selected\"";?>>22</option>
                    <option value="23" <?PHP if($xdateday==23) echo "selected=\"selected\"";?>>23</option>
                    <option value="24" <?PHP if($xdateday==24) echo "selected=\"selected\"";?>>24</option>
                    <option value="25" <?PHP if($xdateday==25) echo "selected=\"selected\"";?>>25</option>
                    <option value="26" <?PHP if($xdateday==26) echo "selected=\"selected\"";?>>26</option>
                    <option value="27" <?PHP if($xdateday==27) echo "selected=\"selected\"";?>>27</option>
                    <option value="28" <?PHP if($xdateday==28) echo "selected=\"selected\"";?>>28</option>
                    <option value="29" <?PHP if($xdateday==29) echo "selected=\"selected\"";?>>29</option>
                    <option value="30" <?PHP if($xdateday==30) echo "selected=\"selected\"";?>>30</option>
                    <option value="31" <?PHP if($xdateday==31) echo "selected=\"selected\"";?>>31</option>
                </select>
                <label for="xday">Year X:</label>

                <select name="xyear" id="xyear" class="form-control form-search">
                    <?PHP for($i=date("Y"); $i>=date("Y")-4; $i--)
                        if($year == $i)
                            echo "<option value='$i' selected>$i</option>";
                        else
                            echo "<option value='$i'>$i</option>";
                    ?>
                </select>
                <label for="xhour">Hour X:</label>
                <select name="xhour" id="xhour" class="form-control form-search">
                    <option value="0" <?php if($xdatehour==0) { echo "selected=\"selected\""; }?>>12 a.m.</option>
                    <option value="1"  <?php if($xdatehour==1) { echo "selected=\"selected\""; }?>>1 a.m.</option>
                    <option value="2"  <?php if($xdatehour==2) { echo "selected=\"selected\""; }?>>2 a.m.</option>
                    <option value="3"  <?php if($xdatehour==3) { echo "selected=\"selected\""; }?>>3 a.m.</option>
                    <option value="4"  <?php if($xdatehour==4) { echo "selected=\"selected\""; }?>>4 a.m.</option>
                    <option value="5"  <?php if($xdatehour==5) { echo "selected=\"selected\""; }?>>5 a.m.</option>
                    <option value="6"  <?php if($xdatehour==6) { echo "selected=\"selected\""; }?>>6 a.m.</option>
                    <option value="7"  <?php if($xdatehour==7) { echo "selected=\"selected\""; }?>>7 a.m.</option>
                    <option value="8"  <?php if($xdatehour==8) { echo "selected=\"selected\""; }?>>8 a.m.</option>
                    <option value="9"  <?php if($xdatehour==9) { echo "selected=\"selected\""; }?>>9 a.m.</option>
                    <option value="10" <?php if($xdatehour==10) { echo "selected=\"selected\""; }?>>10 a.m.</option>
                    <option value="11" <?php if($xdatehour==11) { echo "selected=\"selected\""; }?>>11 a.m.</option>
                    <option value="12" <?php if($xdatehour==12) { echo "selected=\"selected\""; }?>>12 p.m.</option>
                    <option value="13"  <?php if($xdatehour==13) { echo "selected=\"selected\""; }?>>1 p.m.</option>
                    <option value="14"  <?php if($xdatehour==14) { echo "selected=\"selected\""; }?>>2 p.m.</option>
                    <option value="15"  <?php if($xdatehour==15) { echo "selected=\"selected\""; }?>>3 p.m.</option>
                    <option value="16"  <?php if($xdatehour==16) { echo "selected=\"selected\""; }?>>4 p.m.</option>
                    <option value="17"  <?php if($xdatehour==17) { echo "selected=\"selected\""; }?>>5 p.m.</option>
                    <option value="18"  <?php if($xdatehour==18) { echo "selected=\"selected\""; }?>>6 p.m.</option>
                    <option value="19"  <?php if($xdatehour==19) { echo "selected=\"selected\""; }?>>7 p.m.</option>
                    <option value="20"  <?php if($xdatehour==20) { echo "selected=\"selected\""; }?>>8 p.m.</option>
                    <option value="21"  <?php if($xdatehour==21) { echo "selected=\"selected\""; }?>>9 p.m.</option>
                    <option value="22" <?php if($xdatehour==22) { echo "selected=\"selected\""; }?>>10 p.m.</option>
                    <option value="23" <?php if($xdatehour==23) { echo "selected=\"selected\""; }?>>11 p.m.</option>
                </select>
                <label for="xminute">Minute X:</label>
                <select name="xminute" id="xminute" class="form-control form-search">
                    <option value="0">0</option>
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
                    <option value="32">32</option>
                    <option value="33">33</option>
                    <option value="34">34</option>
                    <option value="35">35</option>
                    <option value="36">36</option>
                    <option value="37">37</option>
                    <option value="38">38</option>
                    <option value="39">39</option>
                    <option value="40">40</option>
                    <option value="41">41</option>
                    <option value="42">42</option>
                    <option value="43">43</option>
                    <option value="44">44</option>
                    <option value="45">45</option>
                    <option value="46">46</option>
                    <option value="47">47</option>
                    <option value="48">48</option>
                    <option value="49">49</option>
                    <option value="50">50</option>
                    <option value="51">51</option>
                    <option value="52">52</option>
                    <option value="53">53</option>
                    <option value="54">54</option>
                    <option value="55">55</option>
                    <option value="56">56</option>
                    <option value="57">57</option>
                    <option value="58">58</option>
                    <option value="59">59</option>
                </select>
            </div>

            <div class="earlywrap">
                <label for="ymonth">Day Y:</label>
                <select name="ymonth" id="ymonth" class="form-control form-search">
                    <option value="1"<?php if($ydatemonth == 1){echo "selected=\"selected\"";}?>>January</option>
                    <option value="2"<?php if($ydatemonth == 2){echo "selected=\"selected\"";}?>>February</option>
                    <option value="3"<?php if($ydatemonth == 3){echo "selected=\"selected\"";}?>>March</option>
                    <option value="4" <?php if($ydatemonth == 4){echo "selected=\"selected\"";}?>>April</option>
                    <option value="5"<?php if($ydatemonth == 5){echo "selected=\"selected\"";}?>>May</option>
                    <option value="6"<?php if($ydatemonth == 6){echo "selected=\"selected\"";}?>>June</option>
                    <option value="7"<?php if($ydatemonth == 7){echo "selected=\"selected\"";}?>>July</option>
                    <option value="8"<?php if($ydatemonth == 8){echo "selected=\"selected\"";}?>>August</option>
                    <option value="9"<?php if($ydatemonth == 9){echo "selected=\"selected\"";}?>>September</option>
                    <option value="10"<?php if($ydatemonth == 10){echo "selected=\"selected\"";}?>>October</option>
                    <option value="11"<?php if($ydatemonth == 11){echo "selected=\"selected\"";}?>>November</option>
                    <option value="12"<?php if($ydatemonth == 12){echo "selected=\"selected\"";}?>>December</option>
                </select>

                <label for="yday">Day Y:</label>
                <select name="yday" id="yday" class="form-control form-search">
                    <option value="1"  <?PHP if($ydateday==1) echo "selected=\"selected\"";?>>1</option>
                    <option value="2"  <?PHP if($ydateday==2) echo "selected=\"selected\"";?>>2</option>
                    <option value="3"  <?PHP if($ydateday==3) echo "selected=\"selected\"";?>>3</option>
                    <option value="4"  <?PHP if($ydateday==4) echo "selected=\"selected\"";?>>4</option>
                    <option value="5"  <?PHP if($ydateday==5) echo "selected=\"selected\"";?>>5</option>
                    <option value="6"  <?PHP if($ydateday==6) echo "selected=\"selected\"";?>>6</option>
                    <option value="7"  <?PHP if($ydateday==7) echo "selected=\"selected\"";?>>7</option>
                    <option value="8"  <?PHP if($ydateday==8) echo "selected=\"selected\"";?>>8</option>
                    <option value="9"  <?PHP if($ydateday==9) echo "selected=\"selected\"";?>>9</option>
                    <option value="10" <?PHP if($ydateday==10) echo "selected=\"selected\"";?>>10</option>
                    <option value="11" <?PHP if($ydateday==11) echo "selected=\"selected\"";?>>11</option>
                    <option value="12" <?PHP if($ydateday==12) echo "selected=\"selected\"";?>>12</option>
                    <option value="13" <?PHP if($ydateday==13) echo "selected=\"selected\"";?>>13</option>
                    <option value="14" <?PHP if($ydateday==14) echo "selected=\"selected\"";?>>14</option>
                    <option value="15" <?PHP if($ydateday==15) echo "selected=\"selected\"";?>>15</option>
                    <option value="16" <?PHP if($ydateday==16) echo "selected=\"selected\"";?>>16</option>
                    <option value="17" <?PHP if($ydateday==17) echo "selected=\"selected\"";?>>17</option>
                    <option value="18" <?PHP if($ydateday==18) echo "selected=\"selected\"";?>>18</option>
                    <option value="19" <?PHP if($ydateday==19) echo "selected=\"selected\"";?>>19</option>
                    <option value="20" <?PHP if($ydateday==20) echo "selected=\"selected\"";?>>20</option>
                    <option value="21" <?PHP if($ydateday==21) echo "selected=\"selected\"";?>>21</option>
                    <option value="22" <?PHP if($ydateday==22) echo "selected=\"selected\"";?>>22</option>
                    <option value="23" <?PHP if($ydateday==23) echo "selected=\"selected\"";?>>23</option>
                    <option value="24" <?PHP if($ydateday==24) echo "selected=\"selected\"";?>>24</option>
                    <option value="25" <?PHP if($ydateday==25) echo "selected=\"selected\"";?>>25</option>
                    <option value="26" <?PHP if($ydateday==26) echo "selected=\"selected\"";?>>26</option>
                    <option value="27" <?PHP if($ydateday==27) echo "selected=\"selected\"";?>>27</option>
                    <option value="28" <?PHP if($ydateday==28) echo "selected=\"selected\"";?>>28</option>
                    <option value="29" <?PHP if($ydateday==29) echo "selected=\"selected\"";?>>29</option>
                    <option value="30" <?PHP if($ydateday==30) echo "selected=\"selected\"";?>>30</option>
                    <option value="31" <?PHP if($ydateday==31) echo "selected=\"selected\"";?>>31</option>
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
                    <option value="0" <?php if($ydatehour==0) { echo "selected=\"selected\""; }?>>12 a.m.</option>
                    <option value="1"  <?php if($ydatehour==1) { echo "selected=\"selected\""; }?>>1 a.m.</option>
                    <option value="2"  <?php if($ydatehour==2) { echo "selected=\"selected\""; }?>>2 a.m.</option>
                    <option value="3"  <?php if($ydatehour==3) { echo "selected=\"selected\""; }?>>3 a.m.</option>
                    <option value="4"  <?php if($ydatehour==4) { echo "selected=\"selected\""; }?>>4 a.m.</option>
                    <option value="5"  <?php if($ydatehour==5) { echo "selected=\"selected\""; }?>>5 a.m.</option>
                    <option value="6"  <?php if($ydatehour==6) { echo "selected=\"selected\""; }?>>6 a.m.</option>
                    <option value="7"  <?php if($ydatehour==7) { echo "selected=\"selected\""; }?>>7 a.m.</option>
                    <option value="8"  <?php if($ydatehour==8) { echo "selected=\"selected\""; }?>>8 a.m.</option>
                    <option value="9"  <?php if($ydatehour==9) { echo "selected=\"selected\""; }?>>9 a.m.</option>
                    <option value="10" <?php if($ydatehour==10) { echo "selected=\"selected\""; }?>>10 a.m.</option>
                    <option value="11" <?php if($ydatehour==11) { echo "selected=\"selected\""; }?>>11 a.m.</option>
                    <option value="12" <?php if($ydatehour==12) { echo "selected=\"selected\""; }?>>12 p.m.</option>
                    <option value="13"  <?php if($ydatehour==13) { echo "selected=\"selected\""; }?>>1 p.m.</option>
                    <option value="14"  <?php if($ydatehour==14) { echo "selected=\"selected\""; }?>>2 p.m.</option>
                    <option value="15"  <?php if($ydatehour==15) { echo "selected=\"selected\""; }?>>3 p.m.</option>
                    <option value="16"  <?php if($ydatehour==16) { echo "selected=\"selected\""; }?>>4 p.m.</option>
                    <option value="17"  <?php if($ydatehour==17) { echo "selected=\"selected\""; }?>>5 p.m.</option>
                    <option value="18"  <?php if($ydatehour==18) { echo "selected=\"selected\""; }?>>6 p.m.</option>
                    <option value="19"  <?php if($ydatehour==19) { echo "selected=\"selected\""; }?>>7 p.m.</option>
                    <option value="20"  <?php if($ydatehour==20) { echo "selected=\"selected\""; }?>>8 p.m.</option>
                    <option value="21"  <?php if($ydatehour==21) { echo "selected=\"selected\""; }?>>9 p.m.</option>
                    <option value="22" <?php if($ydatehour==22) { echo "selected=\"selected\""; }?>>10 p.m.</option>
                    <option value="23" <?php if($ydatehour==23) { echo "selected=\"selected\""; }?>>11 p.m.</option>
                </select>
                <label for="yminute">Minute Y:</label>
                <select name="yminute" id="yminute" class="form-control form-search">
                    <option value="0">0</option>
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
                    <option value="32">32</option>
                    <option value="33">33</option>
                    <option value="34">34</option>
                    <option value="35">35</option>
                    <option value="36">36</option>
                    <option value="37">37</option>
                    <option value="38">38</option>
                    <option value="39">39</option>
                    <option value="40">40</option>
                    <option value="41">41</option>
                    <option value="42">42</option>
                    <option value="43">43</option>
                    <option value="44">44</option>
                    <option value="45">45</option>
                    <option value="46">46</option>
                    <option value="47">47</option>
                    <option value="48">48</option>
                    <option value="49">49</option>
                    <option value="50">50</option>
                    <option value="51">51</option>
                    <option value="52">52</option>
                    <option value="53">53</option>
                    <option value="54">54</option>
                    <option value="55">55</option>
                    <option value="56">56</option>
                    <option value="57">57</option>
                    <option value="58">58</option>
                    <option value="59">59</option>
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
        edit test
    </div>
</div>

