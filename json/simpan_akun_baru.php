<?php //session_start();
include ("../config/koneksi.php");
include ("../config/lock.php");
// $session_lokasi = 'UBR';
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

$today = date('Y-m-d H:i:s');

$op=isset($_GET['op'])?$_GET['op']:null;
if($op=='proses'){
	$username = $_GET['username'];
	$pass = $_GET['pass'];
	$nama_user = $_GET['nama_user'];
	$group = $_GET['group'];
	$lokasi = $_GET['lokasi'];
	if($group =='2'){
		$is_koreksi = '1';
	}else{
		$is_koreksi = '0';
	}
		mysqli_query($connect,"BEGIN");
			$strSQL1 = "INSERT INTO `mst_user_login`";
            $strSQL1 .="(`nik`,`password`,`nama`,`status`,`id_group`,`lokasi`,`update_user`,`is_koreksi`)";
			$strSQL1 .="VALUES (";
			$strSQL1 .="'$username',";
			$strSQL1 .="'$pass',";
			$strSQL1 .="'$nama_user',";
			$strSQL1 .="'1',";
			$strSQL1 .="'$group',";
			$strSQL1 .="'$lokasi',";
			$strSQL1 .="'$session_nik',";
			$strSQL1 .="'$is_koreksi'";
			$strSQL1 .=")";
			$objQuery1 = mysqli_query($connect,$strSQL1) or die($strSQL1);

		mysqli_query($connect,"BEGIN");
			$strSQL2 = "INSERT INTO `mst_user_group`";
            $strSQL2 .="(`nik`,`id_group`,`update_user`)";
			$strSQL2 .="VALUES (";
			$strSQL2 .="'$username',";
			$strSQL2 .="'$group',";
			$strSQL2 .="'$session_nik'";
			$strSQL2 .=")";
			$objQuery2 = mysqli_query($connect,$strSQL2) or die($strSQL2);

		$sukses = "sukses";
	    $error = "error";

		if($objQuery1 && $objQuery2){

			mysqli_query($connect,"COMMIT");

			echo $sukses;

		}else{
		
			mysqli_query($connect,"ROLLBACK");

			echo $error;
		}
		mysqli_close($connect);

}elseif($op=='edit'){
	$username = $_GET['username'];
	$pass = $_GET['pass'];
	$nama_user = $_GET['nama_user'];
	$group = $_GET['group'];
	$status = $_GET['status'];
	if($group =='2'){
		$is_koreksi = '1';
	}else{
		$is_koreksi = '0';
	}

	$sql_update = "UPDATE mst_user_login SET nik='$username', password='$pass', nama='$nama_user', status='$status', id_group='$group' WHERE nik='$username'";
	$res_update = mysqli_query($connect,$sql_update);

	if($res_update){
		echo "sukses";
		$sql_update2 = "UPDATE mst_user_group SET nik='$username', id_group='$group' WHERE nik='$username'";
		$res_update2 = mysqli_query($connect,$sql_update2);
	}else{
		echo "gagal $sql_update";
	}
}
?>