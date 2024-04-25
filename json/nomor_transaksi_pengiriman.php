<?php session_start();
    include("../config/koneksi.php");
    include("../config/lock.php");
	$today = date('Y-m-d H:i:s');
	$todayZ = date('Y-m-d');

	$tahun = date("y");
	$year = date("Y");
	
	$tgl_transaksi = date('Y-m-d');
	$tahun = date('y');
	$bulan = date('m');
	$tanggal = date('d');
	$jam = date('His');
	$querys = "SELECT MAX(no_transaksi)AS `last` FROM tbl_do WHERE YEAR(tgl_transaksi)='$year'";
	$hasil = mysqli_query($connect,$querys);
	$data  = mysqli_fetch_array($hasil);
	$lastNo = $data['last'];
	$lastthn = substr($lastNo, 3,2);
	$lastNoUrut = substr($lastNo, 15, 6);
	if($tahun>$lastthn){
	$nextNoUrut = '000001';
	}else{
	$nextNoUrut = $lastNoUrut + '1';
	}


	$no_transaksi = 'DO'.'_'.$tahun.$bulan.$tanggal.$jam.sprintf('%06s', $nextNoUrut);

	echo $no_transaksi;
?>