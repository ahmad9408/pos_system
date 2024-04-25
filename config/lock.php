<?php
session_start();

include ("koneksi.php");
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

$user_check = $_SESSION['login_user'];
$session_nama = $_SESSION['nama'];
$session_nik = $_SESSION['nik'];
$session_nama_lokasi = $_SESSION['nama_lokasi'];
$session_id_group = $_SESSION['id_group'];
$session_lokasi = $_SESSION['lokasi'];
$session_is_koreksi = $_SESSION['is_koreksi'];
$session_is_purchase = $_SESSION['is_purchase'];

// echo $session_nik."<br>";
// echo $session_kontrak."<br>";
// die();

if($session_nik == ""){
	header("location:login.php");
	die();
}
//echo $login_session;
if(!isset($user_check)){
	$timeout = 3;
	$_session["expires_by"] = time() + $timeout;
	header("location:login.php");
	die();
}

?>