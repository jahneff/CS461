<?php
function gs2_database_connect(){
    define('DB_HOST', 'localhost');
    define('DB_USER', 'root');
    define('DB_PASS', 'cWoh5DCX.mWeTu');
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

?>