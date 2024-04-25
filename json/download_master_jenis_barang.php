<?php
include ("../config/koneksi.php");
include ("../config/lock.php");
include ("post_request_master_jenis_barang.php");
// include ("post_update_master_data_jenis_barang.php");

error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

$today = date('Y-m-d H:i:s');
$todayZ = date('Ymd');
$detik = date("s");
$date = date("YmdHis");

// $sql_link = "SELECT id, link FROM tbl_link where nama_aturan='download_jenis_barang' AND stat='1'";
// $res_link = mysqli_query($connect,$sql_link);
// list($id,$link)=mysqli_fetch_array($res_link);

$op=isset($_GET['op'])?$_GET['op']:null;
if($op=='proses_download'){
	$awal = $_GET['awal'];
	$akhir = $_GET['akhir'];
	$link = "https://harmetgarment.web.id/sistem_penjualan/api/download_data_master_jenis_barang.php";
	
	send_data($awal,$akhir,$link);
	send_data_kategori($awal,$akhir);
	send_data_size($awal,$akhir);
	send_data_warna($awal,$akhir);

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
	$response=file_get_contents($link,false,$context);
	//mengubah data json menjadi data array asosiatif
	$result=json_decode($response,true);

	if(!empty($result)){
	  //looping data menggunakan foreach
	  foreach ($result as $value) {
	  	$id_jenis = $value['id'];
		$jenis_barang = $value['jenis_barang'];
		$updatedate = $value['updatedate'];
		$updateby = $value['updateby'];
		$is_aktif = $value['is_aktif'];

	   	$sql_update_barang = " INSERT INTO `tbl_mst_jenis_barang` (`id`,`jenis_barang`,`is_aktif`,`updatedate`,`updateby`)
	   							VALUES('$id_jenis','$jenis_barang','$is_aktif','$updatedate','$updateby')
	   							ON DUPLICATE KEY UPDATE
														`id` = '$id_jenis',
														`jenis_barang` = '$jenis_barang',
														`is_aktif` = '$is_aktif',
														`updatedate` = '$updatedate',
														`updateby` = '$updateby'";
		$res_update_barang= mysqli_query($connect,$sql_update_barang);

		//ambil link update
		$sql_link_update = "SELECT link FROM tbl_link where nama_aturan='download_jenis_barang' AND stat='1'";
		$res_link_update = mysqli_query($connect,$sql_link_update);
		list($link_update)=mysqli_fetch_array($res_link_update);

		//tidak menggunakan update online karena supaya bisa di download oleh toko-toko lain
		// send_update($id_jenis,$link_update);
	  }
	}

	//simpan ke tabel master kateogri
	$postdata2 = http_build_query(
		array(
			'awal'	=> $awal,
			'akhir'	=> $akhir,
		)
	);

	$opts2 = array('http'	=>
		array(
			'method'	=>	"POST",
			'header'	=>	"Content-Type: application/x-www-form-urlencoded",
			'content'	=>	$postdata2
		)
	);

	$context2=stream_context_create($opts2);
	$response2=file_get_contents('https://harmetgarment.web.id/sistem_penjualan/api/download_data_master_kategori.php',false,$context2);
	$result2=json_decode($response2,true);
	if(!empty($result2)){
	  foreach ($result2 as $value2) {
	  	$id_kategori = $value2['id_kategori'];
		$nama_kategori = $value2['nama_kategori'];

		$sql_input_kateogri = "INSERT INTO `tbl_mst_kategori_barang` (`id_kategori`,`nama_kategori`,`updatedate`,`updateby`)
					VALUES ('$id_kategori','$nama_kategori',NOW(),'$session_nik')
					ON DUPLICATE KEY UPDATE
						`id_kategori` = '$id_kategori',
						`nama_kategori` = '$nama_kategori',
						`updatedate` = '$updatedate',
						`updateby` = '$updateby'";
		$res_kateogri= mysqli_query($connect,$sql_input_kateogri);
	  }
	}
	//end simpan ke tabel kategori

	//simpan ke tabel size
	$postdata3 = http_build_query(
		array(
			'awal'	=> $awal,
			'akhir'	=> $akhir,
		)
	);

	$opts3 = array('http'	=>
		array(
			'method'	=>	"POST",
			'header'	=>	"Content-Type: application/x-www-form-urlencoded",
			'content'	=>	$postdata3
		)
	);

	$context3=stream_context_create($opts3);
	$response3=file_get_contents('https://harmetgarment.web.id/sistem_penjualan/api/download_data_master_size.php',false,$context3);
	$result3=json_decode($response3,true);
	if(!empty($result3)){
	  foreach ($result3 as $value3) {
	  	$id_size = $value3['id_size'];
		$nama_size = $value3['nama_size'];

		$sql_input_size = "INSERT INTO `tbl_mst_size` (`id_size`,`nama_size`,`updatedate`,`updateby`)
					VALUES ('$id_size','$nama_size',NOW(),'$session_nik')
					ON DUPLICATE KEY UPDATE
						`id_size` = '$id_size',
						`nama_size` = '$nama_size',
						`updatedate` = '$updatedate',
						`updateby` = '$updateby'";
		$res_size= mysqli_query($connect,$sql_input_size);
	  }
	}
	//end simpan ke tabel size

	//simpan ke tabel warna
	$postdata4 = http_build_query(
		array(
			'awal'	=> $awal,
			'akhir'	=> $akhir,
		)
	);

	$opts4 = array('http'	=>
		array(
			'method'	=>	"POST",
			'header'	=>	"Content-Type: application/x-www-form-urlencoded",
			'content'	=>	$postdata4
		)
	);

	$context4=stream_context_create($opts4);
	$response4=file_get_contents('https://harmetgarment.web.id/sistem_penjualan/api/download_data_master_warna.php',false,$context4);
	$result4=json_decode($response4,true);
	if(!empty($result4)){
	  foreach ($result4 as $value4) {
	  	$id_warna = $value4['id_warna'];
		$nama_warna = $value4['nama_warna'];

		$sql_input_warna = "INSERT INTO `tbl_mst_warna` (`id_warna`,`nama_warna`,`updatedate`,`updateby`)
					VALUES ('$id_warna','$nama_warna',NOW(),'$session_nik')
					ON DUPLICATE KEY UPDATE
						`id_warna` = '$id_warna',
						`nama_warna` = '$nama_warna',
						`updatedate` = '$updatedate',
						`updateby` = '$updateby'";
		$res_warna= mysqli_query($connect,$sql_input_warna);
	  }
	}
	//end simpan ke tabel warna

	if(empty($result)&&empty($res_update_barang)){
		echo "kosong $result";
	}elseif($res_update_barang){
		echo "sukses";
	}else{
		echo "gagal $sql_update_barang ";
	}
}
?>