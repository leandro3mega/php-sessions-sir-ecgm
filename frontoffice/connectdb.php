<?php

$userDB = "sir";
$passDB = "sir";
$hostDB = "localhost";
$nameDB = "php_sir";

// conection
$connectDB = new mysqli($hostDB, $userDB, $passDB, $nameDB);

//teste for connection errors
if ($connectDB->connect_errno) {
    die("error : " . $connectDB->connect_error);
}
//echo "Connected";

$connectDB->set_charset("utf8");