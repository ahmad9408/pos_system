<?php //session_start();
include ("../config/koneksi.php");
include ("../config/lock.php");
// $session_lokasi = 'UBR';
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

$today = date('Y-m-d H:i:s');
$todayZ = date('Ymd');
$detik = date("s");
$date = date("YmdHis");

$op=isset($_GET['op'])?$_GET['op']:null;
if($op=='proses'){
	$kode_barang = $_GET['kode_barang'];
	$nama_barang = $_GET['nm_barang'];
	$id_jenis = $_GET['id_jenis'];
	$satuan = $_GET['satuan'];
	$harga_pokok = $_GET['harga_pokok'];
		$harga_pokok = str_replace(',','',$harga_pokok);
	$harga_jual = $_GET['harga_jual'];
		$harga_jual = str_replace(',','',$harga_jual);

		mysqli_query($connect,"BEGIN");
			$strSQL1 = "INSERT INTO `tbl_mst_barang`";
            $strSQL1 .="(`kd_barang`,`nama_barang`,`id_jenis`,`satuan`,`harga_pokok`,`harga_jual`,`updatedate`,`updateby`)";
			$strSQL1 .="VALUES (";
			$strSQL1 .="'$kode_barang',";
			$strSQL1 .="'$nama_barang',";
			$strSQL1 .="'$id_jenis',";
			$strSQL1 .="'$satuan',";
			$strSQL1 .="'$harga_pokok',";
			$strSQL1 .="'$harga_jual',";
			$strSQL1 .="NOW(),";
			$strSQL1 .="'$session_nik'";
			$strSQL1 .=")";
			$objQuery1 = mysqli_query($connect,$strSQL1) or die($strSQL1);


		$sukses = "sukses";
	    $error = "error";

		if($objQuery1){

			mysqli_query($connect,"COMMIT");

			echo $sukses;

		}else{
		
			mysqli_query($connect,"ROLLBACK");

			echo $error;
		}
		mysqli_close($connect);

}elseif($op=='hapus'){
	$kd_barang = $_GET['kd_barang'];
	$sql_del = "DELETE FROM tbl_mst_barang WHERE kd_barang='$kd_barang'";
	$res_del = mysqli_query($connect,$sql_del);

	if($res_del){
		echo "sukses";
	}else{
		echo "gagal";
	}
}
?>