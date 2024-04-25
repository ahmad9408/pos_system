<?php //session_start();
include ("../config/koneksi.php");
include ("../config/lock.php");
// include ("request_hasil_upload.php");
include ("get_services_transaksi_harian.php");
// include ("get_services_transaksi_harian_detail.php");
// include ("get_services_pembatalan.php");
// $session_lokasi = 'UBR';
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

$today = date('Y-m-d H:i:s');
$todayZ = date('Ymd');
$detik = date("s");
$date = date("YmdHis");



$op=isset($_GET['op'])?$_GET['op']:null;
if($op=='proses_upload'){
    $no = $_GET['no'];
    $tgl_transaksi = $_GET['tgl_transaksi'];
    $tgl_transaksi_update = $_GET['tgl_transaksi_update'];
    $no_transaksi = $_GET['no_transaksi'];
	$id_kasir = $_GET['id_kasir'];
	$qty = $_GET['qty'];
	$subtotal = $_GET['subtotal'];
	$diskon = $_GET['diskon'];
	$total_akhir = $_GET['total_akhir'];
	$total_non_cash = $_GET['total_non_cash'];
	$total_cash = $_GET['total_cash'];
	$total_pembayaran = $_GET['total_pembayaran'];
	$total_bayar = $_GET['total_bayar'];
	$kembalian = $_GET['kembalian'];
	$lokasi = $_GET['lokasi'];
	$status_penjualan = $_GET['status_penjualan'];
	$tgl_batal = $_GET['tgl_batal'];
	$user_pembatal = $_GET['user_pembatal'];
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

	mysqli_query($connect,"BEGIN");

	$sql_detail_trans = "SELECT id, no_transaksi, kode_barang, nama_barang, hpp, harga, stok, qty, diskon, total, id_lokasi, stat, updatedate, updateby FROM tbl_transaksi_detail WHERE no_transaksi='$no_transaksi'";
	$res_detail_trans = mysqli_query($connect,$sql_detail_trans)or die($sql_detail_trans);
	while(list($id_detail, $no_transaksi_detail, $kode_barang_detail, $nama_barang_detail, $hpp_detail, $harga_detail, $stok_detail, $qty_detail, $diskon_detail, $total_detail, $id_lokasi_detail, $stat_detail, $updatedate_detail, $updateby_detail)=mysqli_fetch_array($res_detail_trans)){

		send_data_detail($id_detail, $no_transaksi_detail, $kode_barang_detail, $nama_barang_detail, $hpp_detail, $harga_detail, $stok_detail, $qty_detail, $diskon_detail, $total_detail, $id_lokasi_detail, $stat_detail, $updatedate_detail, $updateby_detail);
	}

	// $postdata = http_build_query(
	// 	array(
	// 		'no_transaksi'	=> $no_transaksi,
	// 	)
	// );

	// $opts = array('http'	=>
	// 	array(
	// 		'method'	=>	"POST",
	// 		'header'	=>	"Content-Type: application/x-www-form-urlencoded",
	// 		'content'	=>	$postdata
	// 	)
	// );

	// $context=stream_context_create($opts);
	// $response=file_get_contents('https://harmetgarment.web.id/sistem_penjualan/api/download_data_per_transaksi.php',false,$context);
	// $result=json_decode($response,true);

	// if(!empty($result)){
	//   //looping data menggunakan foreach
	//   foreach ($result as $value) {
	   
	// 	$status = $value['status'];
	// 	$no_transaksi = $value['no_transaksi'];

	//    	$sql_update = "UPDATE tbl_transaksi SET is_upload = 1, tgl_upload = '$today' WHERE no_transaksi = '$no_transaksi'";
	// 	$res_update = mysqli_query($connect,$sql_update);

	//   }
	// }

	$sukses = "sukses";
	$error = "error";
	if($res_detail_trans){
		
    	//kirim data ke database online
		send_data($no,$no_transaksi,$tgl_transaksi,$id_kasir,$subtotal,$qty,$diskon,$total_akhir,$total_non_cash,$total_cash,$total_pembayaran,$total_bayar,$kembalian,$lokasi,$status_penjualan,$tgl_transaksi_update,$ambil_tgl_batal,$ambil_user_pembatal);
		//end kirim data ke database online
		
	   	$sql_update = "UPDATE tbl_transaksi SET is_upload = 1, tgl_upload = '$today' WHERE no_transaksi = '$no_transaksi'";
		$res_update = mysqli_query($connect,$sql_update);

		echo $sukses;
		mysqli_query($connect,"COMMIT");

			// echo $result[status]=='sukses';
		
	}else{
	
		echo $error;
		mysqli_query($connect,"ROLLBACK");	
	}

	mysqli_close($connect);

}elseif($op=='pembatalan'){
    $tgl_transaksi = $_GET['tgl_transaksi'];
    $no_transaksi = $_GET['no_transaksi'];
	$id_kasir = $_GET['id_kasir'];
	$lokasi = $_GET['lokasi'];
	$tgl_batal = $today;

	mysqli_query($connect,"BEGIN");

	$sql = "UPDATE tbl_transaksi SET is_upload = 0, tgl_batal='$tgl_batal', user_pembatal='$id_kasir' WHERE no_transaksi = '$no_transaksi'";
	$res = mysqli_query($connect,$sql);

	$sukses = "sukses";
	$error = "error";
	if($res){
		
    	//kirim data ke database online
		send_id_batal($no_transaksi,$tgl_transaksi,$id_kasir,$tgl_batal,$lokasi);
		//end kirim data ke database online
		

		echo $sukses;
		mysqli_query($connect,"COMMIT");

			// echo $result[status]=='sukses';
		
	}else{
	
		echo $error;
		mysqli_query($connect,"ROLLBACK");	
	}

	mysqli_close($connect);
}