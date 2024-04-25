<?php session_start();
include ("../config/koneksi.php");
include ("../config/lock.php");
include ("post_request_data_pengiriman.php");
// include ("post_request_detail_data_pengiriman.php");
// include ("update_master_data_pengiriman.php");

error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

$today = date('Y-m-d H:i:s');
$todayZ = date('Ymd');
$detik = date("s");
$date = date("YmdHis");

// $sql_link = "SELECT id, link FROM tbl_link where nama_aturan='download' AND stat='1'";
// $res_link = mysqli_query($connect,$sql_link);
// list($id,$link)=mysqli_fetch_array($res_link);

$op=isset($_GET['op'])?$_GET['op']:null;
if($op=='proses_download'){
	$awal = $_GET['awal'];
	$akhir = $_GET['akhir'];
	$lokasi = $_GET['id_lokasi'];
	
	send_data($awal,$akhir,$lokasi);

	$postdata = http_build_query(
		array(
			'awal'	=> $awal,
			'akhir'	=> $akhir,
			'lokasi'	=> $lokasi,
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
	$response=file_get_contents('https://harmetgarment.web.id/sistem_penjualan/api/download_data_pengiriman.php',false,$context);
	//mengubah data json menjadi data array asosiatif
	$result=json_decode($response,true);

	if(!empty($result)){
	  //looping data menggunakan foreach
	  foreach ($result as $value) {
	   
		$status = $value['status'];
		$no_transaksi = $value['no_transaksi'];
		$tgl_transaksi = $value['tgl_transaksi'];
		$qty = $value['qty'];
		$total_harga_pokok = $value['total_harga_pokok'];
		$total_harga_jual = $value['total_harga_jual'];
		$lokasi = $value['lokasi'];
		$updatedate = $value['updatedate'];
		$updateby = $value['updateby'];
		$tgl_batal = $value['tgl_batal'];
		$user_pembatal = $value['user_pembatal'];
		$penerima = $value['penerima'];
		$tgl_terima = $value['tgl_terima'];
		$stat_terima = $value['stat_terima'];
		$is_aktif = $value['is_aktif'];

	   	$sql_input_do = "INSERT INTO `tbl_do` (`no_transaksi`,`tgl_transaksi`,`qty`,`total_harga_pokok`,`total_harga_jual`,`lokasi`,`updatedate`,`updateby`,`penerima`,`tgl_terima`)
					VALUES ('$no_transaksi','$tgl_transaksi','$qty','$total_harga_pokok','$total_harga_jual','$lokasi','$updatedate','$session_nik','$session_nik','$today')";
		$res_do= mysqli_query($connect,$sql_input_do);

	  }
		send_data2($awal,$akhir,$lokasi);
	}

	$context2=stream_context_create($opts);
	$response2=file_get_contents('https://harmetgarment.web.id/sistem_penjualan/api/download_detail_data_pengiriman.php',false,$context2);
	//mengubah data json menjadi data array asosiatif
	$result2=json_decode($response2,true);
	if(!empty($result2)){
	  //looping data menggunakan foreach
	  foreach ($result2 as $value2) {
	  	$no_transaksi_detail = $value2['no_transaksi_detail'];
		$invoice = $value2['invoice'];
		$kode_barang = $value2['kode_barang'];
		$nama_barang = $value2['nama_barang'];
		$id_jenis = $value2['id_jenis'];
		$satuan = $value2['satuan'];
		$stok = $value2['stok'];
		$harga_pokok = $value2['harga_pokok'];
		$harga_jual = $value2['harga_jual'];
		$qty_detail = $value2['qty_detail'];
		$stat = $value2['stat'];
		$updatedate_detail = $value2['updatedate_detail'];
		$updateby_detail = $value2['updateby_detail'];

		$sql_input_detail = "INSERT INTO `tbl_do_detail` (`no_transaksi`,`invoice`,`kode_barang`,`nama_barang`,`id_jenis`,`satuan`,`stok`,`harga_pokok`,`harga_jual`,`qty`,`updatedate`,`updateby`)
					VALUES ('$no_transaksi_detail','$invoice','$kode_barang','$nama_barang','$id_jenis','$satuan','$stok','$harga_pokok','$harga_jual','$qty_detail','$updatedate_detail','$session_nik')";
		$res_detail= mysqli_query($connect,$sql_input_detail);
		send_update($no_transaksi_detail,$session_nik,$lokasi);
	  }
	}

	if(empty($result)&&empty($result2)){
		echo "kosong";
	}elseif(($res_do)&&($res_detail)){
		echo "sukses";
	}else{
		echo "gagal $lokasi $sql_input_do $sql_input_detail ";
	}
}
?>