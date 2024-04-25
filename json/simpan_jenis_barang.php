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
if($op=='nama'){
	$jenis_barang = $_GET['nama_jenis'];
		mysqli_query($connect,"BEGIN");
			$strSQL1 = "INSERT INTO `tbl_mst_jenis_barang`";
            $strSQL1 .="(`jenis_barang`,`updatedate`,`updateby`)";
			$strSQL1 .="VALUES (";
			$strSQL1 .="'$jenis_barang',";
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

}elseif($op=='edit'){
	$id_edit = $_GET['id_edit'];
	$nama_jenis_edit = $_GET['nama_jenis_edit'];
	$sql_update = "UPDATE tbl_mst_jenis_barang SET jenis_barang='$nama_jenis_edit' WHERE id='$id_edit'";
	$res_update = mysqli_query($connect,$sql_update);

	if($res_update){
		echo "sukses";
	}else{
		echo "gagal $sql_update";
	}
}
?>