<?php 
include ("../config/koneksi.php");
include ("../config/lock.php");
include ("post_request_master_barang.php");
// include ("post_update_master_data_barang.php");

error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

$today = date('Y-m-d H:i:s');
$todayZ = date('Ymd');
$detik = date("s");
$date = date("YmdHis");

$op=isset($_GET['op'])?$_GET['op']:null;
if($op=='proses_download'){
	$awal = $_GET['awal'];
	$akhir = $_GET['akhir'];
	$url = "https://harmetgarment.web.id/sistem_penjualan/api/download_data_master_barang.php";
	
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
	$response=file_get_contents($url,false,$context);
	//mengubah data json menjadi data array asosiatif
	$result=json_decode($response,true);

	if(!empty($result)){
	  //looping data menggunakan foreach
	  foreach ($result as $value) {

		$status = $value[status];
		$kd_barang = $value[kd_barang];
		$nama_barang = $value[nama_barang];
		$id_kategori = $value[id_kategori];
		$id_jenis = $value[id_jenis];
		$id_size = $value[id_size];
		$id_warna = $value[id_warna];
		$satuan = $value[satuan];
		$harga_pokok = $value[harga_pokok];
		$harga_jual = $value[harga_jual];
		$updatedate = $value[updatedate];
		$updateby = $value[updateby];
		$is_aktif = $value[is_aktif];

	   	$sql_update_barang = " INSERT INTO `tbl_mst_barang` (
													   		`kd_barang`,
												             `nama_barang`,
												             `id_kategori`,
												             `id_jenis`,
												             `id_size`,
												             `id_warna`,
												             `satuan`,
												             `harga_pokok`,
												             `harga_jual`,
												             `updatedate`,
												             `updateby`,
												             `is_aktif`)
	   							VALUES('$kd_barang','$nama_barang','$id_kategori','$id_jenis','$id_size','$id_warna','$satuan','$harga_pokok','$harga_jual','$updatedate','$updateby','$is_aktif')
	   							ON DUPLICATE KEY UPDATE
														`kd_barang` = '$kd_barang',
														`nama_barang` = '$nama_barang',
														`id_kategori` = '$id_kategori',
														`id_jenis` = '$id_jenis',
														`id_size` = '$id_size',
														`id_warna` = '$id_warna',
														`satuan` = '$satuan',
														`harga_pokok` = '$harga_pokok',
														`harga_jual` = '$harga_jual',
														`updatedate` = '$updatedate',
														`updateby` = '$updateby',
														`is_aktif` = '$is_aktif'";
		// $sql_update_barang = "REPLACE INTO `tbl_mst_barang` (`kd_barang`,`nama_barang`,`id_jenis`,`satuan`,`harga_pokok`,`harga_jual`,`updatedate`,`updateby`,`is_aktif`)VALUES('$kd_barang','$nama_barang','$id_jenis','$satuan','$harga_pokok','$harga_jual','$updatedate','$updateby','$is_aktif')";
		$res_update_barang= mysqli_query($connect,$sql_update_barang);

		//tidak menggunakan update online karena supaya bisa di download oleh toko-toko lain
		// send_update($value[kd_barang],$url);
	  }
	}

	$kosong = "kosong";
	$sukses = "sukses";
	$gagal = "gagal";

	if(empty($result)){
		echo $kosong."|".$sql_update_barang;
	}elseif($res_update_barang){
		echo $sukses."|".$sql_update_barang;
	}else{
		echo $gagal."|".$sql_update_barang;
	}

}
?>