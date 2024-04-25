<?php //session_start();
include ("../config/koneksi.php");
include ("../config/lock.php");
// include ("request_hasil_upload.php");
include ("get_services_transaksi_pembelanjaan.php");
include ("get_services_transaksi_pembelanjaan_detail.php");
// $session_lokasi = 'UBR';
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

$today = date('Y-m-d H:i:s');
$todayZ = date('Ymd');
$detik = date("s");
$date = date("YmdHis");



$op=isset($_GET['op'])?$_GET['op']:null;
if($op=='proses_upload'){
	$no = $_GET['no'];
	$invoice = $_GET['invoice'];
	$tgl_invoice = $_GET['tgl_invoice'];
	$tgl_input = $_GET['tgl_input'];
	$updateby = $_GET['updateby'];
	$total_harga_pokok = $_GET['total_harga_pokok'];
	$total_harga_jual = $_GET['total_harga_jual'];
	$total_qty = $_GET['total_qty'];
	$lokasi = $_GET['lokasi'];
	$updatedate = $_GET['updatedate'];
	$tgl_batal = $_GET['tgl_batal'];
	$user_pembatal = $_GET['user_pembatal'];
	$is_aktif = $_GET['is_aktif'];

	if($tgl_batal == ''){
	    $ambil_tgl_batal = "0000-00-00";
	}else{
	    $ambil_tgl_batal = $tgl_batal;
	}

	if($user_pembatal == ''){
	    $ambil_user_pembatal = "-";
	}else{
	    $ambil_user_pembatal = $user_pembatal;
	}

	// mysqli_query($connect,"BEGIN");

	$sql = "UPDATE tbl_pembelian SET is_upload = 1, tgl_upload = '$today' WHERE invoice = '$invoice'";
	$res = mysqli_query($connect,$sql)or die($sql);

	$sql_detail_trans = "SELECT 
								`id`,
								`invoice`,
							  `kode_barang`,
							  `nama_barang`,
							  `harga_pokok`,
							  `harga_jual`,
							  `qty`,
							  `updatedate`,
							  `updateby`,
							  `is_aktif`
						FROM tbl_pembelian_detail 
						WHERE invoice='$invoice'";
	$res_detail_trans = mysqli_query($connect,$sql_detail_trans)or die($sql_detail_trans);
	while(list($id_detail,$invoice_detail,$kode_barang_detail,$nama_barang_detail,$harga_pokok_detail,$harga_jual_detail,$qty_detail,$updatedate_detail,$updateby_detail,$is_aktif_detail)=mysqli_fetch_array($res_detail_trans)){

		send_data_detail($id_detail,$invoice_detail,$kode_barang_detail,$nama_barang_detail,$harga_pokok_detail,$harga_jual_detail,$qty_detail,$updatedate_detail,$updateby_detail,$is_aktif_detail);
	}

	$sukses = "sukses";
	$error = "error";
	if(($res) && ($res_detail_trans)){
		
    	//kirim data ke database qlp
		send_data($no,$invoice,$tgl_invoice,$tgl_input,$updateby,$total_harga_pokok,$total_harga_jual,$total_qty,$lokasi,$updatedate,$ambil_tgl_batal,$ambil_user_pembatal,$is_aktif);
		//end kirim data ke database qlp
		

		echo $sukses;
		mysqli_query($connect,"COMMIT");

			// echo $result[status]=='sukses';
		
	}else{
	
		echo $error;
		mysqli_query($connect,"ROLLBACK");	
	}

	mysqli_close($connect);

}