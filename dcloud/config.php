<?php
$host ="localhost"; 
$user_db = "root";
$con_password = "";
$database = "dcloud";
date_default_timezone_set('Asia/Kolkata');

$con = mysqli_connect($host,$user_db,$con_password,$database);

if (mysqli_connect_errno())
{
    echo "Error ganarate :".mysqli_connect_error();
}

?>