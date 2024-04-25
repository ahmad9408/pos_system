<?php
   error_reporting(0);
   set_time_limit(86400);// 24 jam 
   date_default_timezone_set("Asia/Jakarta"); 

$server= "localhost";
$user= "root";
$pass= "";

$db= "pos_db";
$connect = mysqli_connect($server, $user, $pass, $db) or die('DB Not Connect'.mysqli_error());
$dbselect= mysqli_select_db($connect,$db);

?>