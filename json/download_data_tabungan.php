<?php
include ("../config/koneksi.php");
include ("../config/lock.php");
include ("post_master_tabungan.php");
include ("update_data_master_tabungan.php");

error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

$today = date('Y-m-d H:i:s');
$todayZ = date('Ymd');
$detik = date("s");
$date = date("YmdHis");

$op=isset($_GET['op'])?$_GET['op']:null;
if($op=='proses_download'){
	$awal = $_GET['awal'];
	$akhir = $_GET['akhir'];
	
	send_data($awal,$akhir);

	$postdata = http_build_query(
		array(
			'awal'	=> $awal,
			'akhir'	=> $akhir,
		)
	);

	$opts = array('http'	=>
		array(
			'method'	=>	"POST",
			'header'	=>	"Content-Type: application/x-www-form-urlencoded",
			'content'	=>	$postdata
		)
	);

	$context=stream_context_create($opts);

	//OpenthefileusingtheHTTPheaderssetabove
	$response=file_get_contents('http://103.135.214.11:81/sistem_penjualan/api/download_data_tabungan_siswa.php',false,$context);

	//mengubah data json menjadi data array asosiatif
	$result=json_decode($response,true);

	if(!empty($result)){
	  //looping data menggunakan foreach
	  foreach ($result as $value) {
	   
	   $status = $value['status'];
	   $nis = $value['nis'];
	   $id_jenis = $value['id_jenis'];
	   $no_rekening = $value['no_rekening'];
	   $nama = $value['nama'];
	   $saldo = $value['saldo'];
	   $tgl_input = $value['tgl_input'];
	   $updatedate = $value['updatedate'];
	   $updateby = $value['updateby'];
	   $is_aktif = $value['is_aktif'];
	   $is_download = $value['is_download'];


	   	$sql_input = "INSERT INTO `tbl_mst_tabungan` (`nis`,`id_jenis`,`no_rekening`,`nama`,`saldo`,`tgl_input`,`updatedate`,`updateby`,`is_aktif`)
					VALUES ('$nis','$id_jenis','$no_rekening','$nama','$saldo','$tgl_input','$updatedate','$updateby','$is_aktif')ON DUPLICATE KEY UPDATE saldo='$saldo', tgl_input='$tgl_input', updatedate='$updatedate', updateby='$updateby'";
		$res= mysqli_query($connect,$sql_input);
		send_update($nis);
	  }
	}

	if(empty($result)){
		echo "kosong";
	}elseif($res){
		echo "sukses";
	}else{
		echo "gagal";
	}
}
?>