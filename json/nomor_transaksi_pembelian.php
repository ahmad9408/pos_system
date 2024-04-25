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
	$querys = "SELECT MAX(invoice)AS `last` FROM tbl_pembelian WHERE YEAR(tgl_invoice)='$year'";
	$hasil = mysqli_query($connect,$querys);
	$data  = mysqli_fetch_array($hasil);
	$lastNo = $data['last'];
	$lastthn = substr($lastNo, 6,2);
	$lastNoUrut = substr($lastNo, 18, 6);
	if($tahun>$lastthn){
	$nextNoUrut = '000001';
	}else{
	$nextNoUrut = $lastNoUrut + '1';
	}


	$no_transaksi = 'INVPB'.'_'.$tahun.$bulan.$tanggal.$jam.sprintf('%06s', $nextNoUrut);

	echo $no_transaksi;
?>