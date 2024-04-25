<?php
include ("../config/koneksi.php");
// include ("config/style_config.php");
// include ("config/lock.php");

$op=isset($_GET['op'])?$_GET['op']:null;
if($op=='nama'){
	if ( !isset($_REQUEST['term']) )
		exit;
	$query = 'SELECT kd_barang, nama_barang FROM tbl_mst_barang where kode_barang like "%'. mysqli_real_escape_string($connect,$_REQUEST['term']) .'%" AND stok=1 order by nama_barang asc';
	$rs = mysqli_query($connect,$query);
	
	$data = array();
	if ( $rs && mysqli_num_rows($rs) )
	{
		while( $row = mysqli_fetch_array($rs, MYSQL_ASSOC) )
		{
			$data[] = array(
				'label' => $row['kd_barang'].' - '. $row['nama_barang'],
				'value' => $row['kd_barang']
			);
		}
	}
	
	echo json_encode($data);
	flush();
}

?>
