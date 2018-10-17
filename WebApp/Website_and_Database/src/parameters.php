<!DOCTYPE html>
<html>

<?php
include_once '../library/functions.php';
include_once '../fusioncharts/fusioncharts.php';
$conn = gs2_database_connect();


//Get the current parameters and store them in variables
$name = "Parameters";
$table = get_table($conn, $name, 12);
$oldhitemp = $table[0][1];
$oldlotemp = $table[0][2];
$oldhihumid = $table[0][3];
$oldlohumid = $table[0][4];
$oldhipres = $table[0][5];
$oldlopres = $table[0][6];
$oldhimoist = $table[0][7];
$oldlomoist = $table[0][8];
$oldinterval = $table[0][11];
?>

<head>
    <title>GS2 Dashboard</title>
    <link rel="stylesheet" type="text/css" href="../library/bootstrap.css"/>
    <link rel="stylesheet" type="text/css" href="../library/gs2styles.css"/>
    <script src="../fusioncharts/js/fusioncharts.js"></script>
    <script src="../fusioncharts/js/fusioncharts.theme.ocean.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <nav class="navbar  navbar-dark bg-primary sticky-top" style="margin-bottom: 0px; background-color: #5cb85c;">
        <a class="navbar-brand" href="dashboard.php" style="color: white;"><b>My Smart Gardening System</b></a>
        <div class="gs2-button" style="float:right; margin-right: 10px;">
            <a class="btn btn-primary" href="parameters.php" role="button" style="background-color:#5cb85c; border-color: #ffffff; margin: 5% auto; font-size: 125%;"><b>Set system parameters</b></a>
        </div>
    </nav>

</head>

<body>
<div class = "col-sm-3">
</div>
<div class = "col-sm-6" style="font-weight: bold; text-align: center;">
    <form class="parameters_form" id="usersignin" name="usersignin" method="get" action="#" enctype="multipart/form-data">
        <h2 class="parameters_form_header" style="text-align: left; width: auto;">System Parameters</h2>
        <div class="gs2-button" style="margin-left: 3%;">
            <button id="helpbutton" name="helpbutton" class="btn btn-primary" type="button" style="background-color:#5cb85c; border-color: #ffffff; font-size: 100%; vertical-align: middle; margin-top: -10px;">Show Help</button>
            <a href="dashboard.php" id="backpbutton" name="backbutton" class="btn btn-primary" type="button" style="background-color:#5cb85c; border-color: #ffffff; font-size: 100%; vertical-align: middle; margin-top: -10px; margin-left: 20px">Back to dashboard</a>

        </div>

        <!-- This helpbox is not displayed on the page until the user hits the "Show Help" button -->
        <div id="helpbox" style="margin-bottom: 5%; display: none;">
            <div class="parameters_form_subheader">Welcome to the system parameters page! Here you can interact with the outdoor system directly.</div>
            <div class="parameters_form_subheader">There are two things you can do from here:</div>
            <div class="parameters_form_subheader">1. Update the system's read interval</div>
            <div class="parameters_form_subheader">This changes the amount of time between readings. You can manually set it in the top box of the form below.</div>
            <div class="parameters_form_subheader">2. Update the environment parameters</div>
            <div class="parameters_form_subheader">This changes the environment values range of your system. By default, all values fall within the safe range, but you can redefine the bounds of the safe range below. </div>
            <div class="parameters_form_subheader" style="margin-left: 6%;">Normally, values on this site display in green. </div>
            <div class="parameters_form_subheader" style="margin-left: 6%;">If value > high bound, it will display in <span style='color: #d01d1d;'>red</span></div>
            <div class="parameters_form_subheader" style="margin-left: 6%;">If value < low bound, it will display in <span style='color: #b5d5ff;'>blue</span> </div>

        </div>
        <script>
            document.getElementById('helpbutton').onclick = function hideshowfavorbox() {
                var x = document.getElementById("helpbox");
                if (x.style.display === "none") {
                    x.style.display = "block";
                } else {
                    x.style.display = "none";
                }
            };
        </script>

        <div class="parameters_line_wrap">
            <div class="parameter_type">
                Reading interval (min)
            </div>
            <div class="parameter_old">
                Current: <?php echo $oldinterval; ?>
            </div>
            <label class="parameter_label" for="interval">
                Update:
            </label>
            <input name="interval" id="interval" type="text" class="form-control form-parameter form-parameter form-parameter form-parameter form-parameter" placeholder="<?php echo html_entity_decode("min"); ?>">
        </div>
        <div class="parameters_line_wrap">
            <div class="parameter_type">
                High Temperature Bound
            </div>
            <div class="parameter_old">
                Current: <span id="hitempold" name="hitempold" data-value="<?php echo $oldhitemp; ?>"><?php echo $oldhitemp; ?></span>
            </div>
            <label class="parameter_label" for="temphi">
                Update:
            </label>
            <input name="temphi" id="temphi" type="text" class="form-control form-parameter form-parameter form-parameter form-parameter form-parameter" placeholder="<?php echo html_entity_decode("(C&deg)"); ?>">
        </div>
        <div class="parameters_line_wrap">
            <div class="parameter_type">
                Low Temperature Bound
            </div>
            <div class="parameter_old">
                Current: <span id="lotempold" name="lotempold" data-value="<?php echo $oldlotemp; ?>"><?php echo $oldlotemp; ?></span>
            </div>
            <label class="parameter_label" for="templo">
                Update:
            </label>
            <input name="templo" id="templo" type="text" class="form-control form-parameter form-parameter form-parameter form-parameter form-parameter" placeholder="<?php echo html_entity_decode("(C&deg)"); ?>">
        </div>
        <div class="parameters_line_wrap">
            <div class="parameter_type">
                High Humidity Bound
            </div>
            <div class="parameter_old">
                Current: <span id="hihumidold" name="hihumidold" data-value="<?php echo $oldhihumid; ?>"><?php echo $oldhihumid; ?></span>
            </div>
            <label class="parameter_label" for="humidhi">
                Update:
            </label>
            <input name="humidhi" id="humidhi" type="text" class="form-control form-parameter form-parameter form-parameter form-parameter form-parameter" placeholder="<?php echo html_entity_decode("%"); ?>">
        </div>
        <div class="parameters_line_wrap">
            <div class="parameter_type">
                Low Humidity Bound
            </div>
            <div class="parameter_old">
                Current: <span id="lohumidold" name="lohumidold" data-value="<?php echo $oldlohumid; ?>"><?php echo $oldlohumid; ?></span>
            </div>
            <label class="parameter_label" for="humidlo">
                Update:
            </label>
            <input name="humidlo" id="humidlo" type="text" class="form-control form-parameter form-parameter form-parameter form-parameter form-parameter" placeholder="<?php echo html_entity_decode("%"); ?>">
        </div>
        <div class="parameters_line_wrap">
            <div class="parameter_type">
                High Pressure Bound
            </div>
            <div class="parameter_old">
                Current: <span id="hipresold" name="hipresold" data-value="<?php echo $oldhipres; ?>"><?php echo $oldhipres; ?></span>
            </div>
            <label class="parameter_label" for="preshi">
                Update:
            </label>
            <input name="preshi" id="preshi" type="text" class="form-control form-parameter form-parameter form-parameter form-parameter form-parameter" placeholder="<?php echo html_entity_decode("kPa"); ?>">
        </div>
        <div class="parameters_line_wrap">
            <div class="parameter_type">
                Low Pressure Bound
            </div>
            <div class="parameter_old">
                Current: <span id="lopresold" name="lopresold" data-value="<?php echo $oldlopres; ?>"><?php echo $oldlopres; ?></span>
            </div>
            <label class="parameter_label" for="preslo">
                Update:
            </label>
            <input name="preslo" id="preslo" type="text" class="form-control form-parameter form-parameter form-parameter form-parameter form-parameter" placeholder="<?php echo html_entity_decode("kPa"); ?>">
        </div>
        <div class="parameters_line_wrap">
            <div class="parameter_type">
                High Moisture Bound
            </div>
            <div class="parameter_old">
                Current: <span id="himoistold" name="himoistold" data-value="<?php echo $oldhimoist; ?>"><?php echo $oldhimoist; ?></span>
            </div>
            <label class="parameter_label" for="moisthi">
                Update:
            </label>
            <input name="moisthi" id="moisthi" type="text" class="form-control form-parameter form-parameter form-parameter form-parameter form-parameter" placeholder="<?php echo html_entity_decode("%"); ?>">
        </div>
        <div class="parameters_line_wrap">
            <div class="parameter_type">
                Low Moisture Bound
            </div>
            <div class="parameter_old">
                Current: <span id="lomoistold" name="lomoistold" data-value="<?php echo $oldlomoist; ?>"><?php echo $oldlomoist; ?></span>
            </div>
            <label class="parameter_label" for="moistlo">
                Update:
            </label>
            <input name="moistlo" id="moistlo" type="text" class="form-control form-parameter form-parameter form-parameter form-parameter form-parameter" placeholder="<?php echo html_entity_decode("%"); ?>">
        </div>

        <div class="gs2-button" style="width=:100%; text-align: center;">
            <button id="submitbutton" name="submitbutton" class="btn btn-lg btn-primary" type="submit" style="background-color:#5cb85c; border-color: #ffffff; font-size: 125%; vertical-align: middle;">Save changes</button>
            <button id="resetbutton" name="resetbutton" class="btn btn-lg btn-primary" type="button" style="background-color:#f08080; border-color: #ffffff; font-size: 125%; vertical-align: right;">Reset Values</button>
        </div>
        <div id="message"></div>
    </form>
</div>
<div class = "col-sm-3">
</div>

</body>
<script>

//The following function executes when "Save Changes" is clicked, and makes sure that none of the maximums are less than the minimums and vice versa, and also makes sure a value has been changed
    document.getElementById('submitbutton').onclick = function submit() {submit:{
        var interval = $("#interval").val();
        var temphi = $("#temphi").val();
        var templo = $("#templo").val();
        var humidhi = $("#humidhi").val();
        var humidlo = $("#humidlo").val();
        var preshi = $("#preshi").val();
        var preslo = $("#preslo").val();
        var moisthi = $("#moisthi").val();
        var moistlo = $("#moistlo").val();

        var oldtemplo = document.getElementById("lotempold").getAttribute("data-value");
        var oldtemphi = document.getElementById("hitempold").getAttribute("data-value");
        var oldhumidlo = document.getElementById("lohumidold").getAttribute("data-value");
        var oldhumidhi = document.getElementById("hihumidold").getAttribute("data-value");
        var oldpreslo = document.getElementById("lopresold").getAttribute("data-value");
        var oldpreshi = document.getElementById("hipresold").getAttribute("data-value");
        var oldmoistlo = document.getElementById("lomoistold").getAttribute("data-value");
        var oldmoisthi = document.getElementById("himoistold").getAttribute("data-value");

        if(interval == "" && temphi == "" && templo == "" && humidhi == "" && humidlo == "" && preshi == "" && preslo == "" && moisthi == "" && moistlo == ""){
            alert("Enter a value if you want to change system parameters!");
            break submit;
        }

        if(temphi != "" && templo != ""){
            if(Number(temphi) <= Number(templo)){
                alert("High temperature bound must be greater than low temperature bound!");
                break submit;
            }
        }
        else if (temphi != "") {
            if (Number(temphi) <= Number(oldtemplo)) {
                alert("High temperature bound must be greater than low temperature bound!");
                break submit;
            }
        }
        else if (templo != "") {
            if (Number(templo) >= Number(oldtemphi)) {
                alert("High temperature bound must be greater than low temperature bound!");
                break submit;
            }
        }

        if(humidhi != "" && humidlo != ""){
            if(Number(humidhi) <= Number(humidlo)){
                alert("High humidity bound must be greater than low humidity bound!");
                break submit;
            }
        }
        else if (Number(humidhi) != "") {
            if (Number(humidhi) <= Number(oldhumidlo)) {
                alert("High humidity bound must be greater than low humidity bound!");
                break submit;
            }
        }
        else if (Number(humidlo) != "") {
            if (Number(humidlo) >= Number(oldhumidhi)) {
                alert("High humidity bound must be greater than low humidity bound!");
                break submit;
            }
        }

        if(preshi != "" && preslo != ""){
            if (Number(preshi) <= Number(preslo)){
                alert("High pressure bound must be greater than low pressure bound!");
                break submit;
            }
        }
        else if (preshi != "") {
            if (Number(preshi) <= Number(oldpreslo)) {
                alert("High pressure bound must be greater than low pressure bound!");
                break submit;

            }
        }
        else if (preslo != "") {
            if (Number(preslo) >= Number(oldpreshi)) {
                alert("High pressure bound must be greater than low pressure bound!");
                break submit;

            }
        }

        if(moisthi != "" && moistlo != ""){
            if(Number(moisthi) <= Number(moistlo)){
                alert("High moisture bound must be greater than low moisture bound!");
                break submit;
            }
        }
        else if (moisthi != "") {
            if (Number(moisthi) <= Number(oldmoistlo)) {
                alert("High moisture bound must be greater than low moisture bound!");
                break submit;

            }
        }
        else if (moistlo != "") {
            if (Number(moistlo) >= Number(oldmoisthi)) {
                alert("High moisture bound must be greater than low moisture bound!");
                break submit;

            }
        }

        $.post("setparameters.php", {
            interval: interval,
            temphi: temphi,
            templo: templo,
            humidhi: humidhi,
            humidlo: humidlo,
            preshi: preshi,
            preslo: preslo,
            moisthi: moisthi,
            moistlo: moistlo
            },
            function (data) {
                alert(data);
                window.location = "parameters.php";
            });

    }};

//The following function executes when "Reset Values" is pressed, and resets all the bounds to their default 999/-999 values.
document.getElementById('resetbutton').onclick = function reset() {reset:{

    $.post("setparameters.php", {
            temphi: 999,
            templo: -999,
            humidhi: 999,
            humidlo: -999,
            preshi: 999,
            preslo: -999,
            moisthi: 999,
            moistlo: -999
        },
        function (data) {
            alert(data);
            window.location = "parameters.php";
        });
}};
</script>

</html>