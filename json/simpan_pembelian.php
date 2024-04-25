<?php //session_start();
include ("../config/koneksi.php");
include ("../config/lock.php");
// $session_lokasi = 'UBR';
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

$todayNow = date('Y-m-d H:i:s');
$todayZ = date('Y-m-d');
$detik = date("s");
$date = date("YmdHis");

$op=isset($_GET['op'])?$_GET['op']:null;
if($op=='proses'){
	$kode_barang = $_GET['kode_barang'];
    $nama_barang = $_GET['nama_barang'];
    $harga_pokok = $_GET['harga_pokok'];
    $harga_jual = $_GET['harga_jual'];
    $id_jenis = $_GET['id_jenis'];
    $satuan = $_GET['satuan'];
    $qty = $_GET['qty'];

		mysqli_query($connect,"BEGIN");
			
			$sql_select = "SELECT kd_barang,qty FROM tbl_pembelian_temp WHERE kd_barang='$kode_barang' AND updateby='$session_nik'";
			$res_select = mysqli_query($connect,$sql_select);
			list($kode_barang_exist,$qty_exist)=mysqli_fetch_array($res_select);
			$jml_akhir = $qty_exist + $qty;

			$strSQL1 = "INSERT INTO `tbl_pembelian_temp`";
			$strSQL1 .="(kd_barang, nama_barang, id_jenis, satuan, harga_pokok, harga_jual, qty, tgl_input, updatedate, updateby) ";
			$strSQL1 .="VALUES (";
			$strSQL1 .="'$kode_barang',";
			$strSQL1 .="'$nama_barang',";
			$strSQL1 .="'$id_jenis',";
			$strSQL1 .="'$satuan',";
			$strSQL1 .="'$harga_pokok',";
			$strSQL1 .="'$harga_jual',";
			$strSQL1 .="'$qty',";
			$strSQL1 .="'$todayZ',";
			$strSQL1 .="'$todayNow',";
			$strSQL1 .="'$session_nik'";
			$strSQL1 .=") ON DUPLICATE KEY UPDATE qty = '$jml_akhir'";
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

}elseif($op=='update'){
	// $id_urutan = $_GET['id_urutan'];
	$kode_barang = $_GET['kode_barang'];
    $nama_barang = $_GET['nama_barang'];
    $harga_pokok = $_GET['harga_pokok'];
    $harga_jual = $_GET['harga_jual'];
    $stok = $_GET['stok'];
    $qty = $_GET['qty'];

		mysqli_query($connect,"BEGIN");
		
			$strSQL1 = "UPDATE `tbl_pembelian_temp`";
			$strSQL1 .="SET `kd_barang` = '$kode_barang', ";
			$strSQL1 .=" `nama_barang` = '$nama_barang', ";
			$strSQL1 .=" `harga_pokok` = '$harga_pokok', ";
			$strSQL1 .=" `harga_jual` = '$harga_jual', ";
			$strSQL1 .=" `qty` = '$qty'";
			$strSQL1 .=" WHERE `kd_barang` = '$kode_barang' AND `updateby` = '$session_nik'";
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

}elseif($op=='clear'){
	$sql_del = "DELETE FROM tbl_pembelian_temp WHERE updateby='$session_nik'";
	$res_del = mysqli_query($connect,$sql_del);

	if($res_del){
		echo "sukses";
	}else{
		echo "gagal";
	}
}elseif($op=='hapus_list'){
	$kode_barang = $_GET['kode_barang'];

	$sql_del = "DELETE FROM tbl_pembelian_temp WHERE updateby='$session_nik' AND kd_barang='$kode_barang'";
	$res_del = mysqli_query($connect,$sql_del);

	if($res_del){
		echo "sukses";
	}else{
		echo "gagal";
	}
}elseif($op=='simpan'){
	$tgl_transaksi = date('Y-m-d');
	$year = date("Y");
	$tahun = date('y');
	$bulan = date('m');
	$tanggal = date('d');
	$jam = date('His');
	$querys = "SELECT MAX(invoice)AS `last` FROM tbl_pembelian WHERE YEAR(tgl_invoice)='$year'";
	$hasil = mysqli_query($connect,$querys);
	$data  = mysqli_fetch_array($hasil);
	$lastNo = $data['last'];
	$lastthn = substr($lastNo, 6,2);
	$lastNoUrut = substr($lastNo, 18, 6);
	if($tahun>$lastthn){
	$nextNoUrut = '000001';
	}else{
	$nextNoUrut = $lastNoUrut + '1';
	}


	$no_transaksi = 'INVPB'.'_'.$tahun.$bulan.$tanggal.$jam.sprintf('%06s', $nextNoUrut);

    $lokasi = $_GET['lokasi'];

	mysqli_query($connect,"BEGIN");
    
    $sql="SELECT kd_barang, nama_barang, harga_pokok, harga_jual, qty, id_jenis, satuan FROM tbl_pembelian_temp WHERE updateby ='$session_nik' ORDER BY id DESC";
    $res=mysqli_query($connect,$sql);
    while ($data = mysqli_fetch_row($res)) {
    	$totalqty += $data[4];
    	$totalhpp += $data[2];
    	$totalhpj += $data[3];
    	// $id_barang = $data[0];
			$strSQL1 = "INSERT INTO `tbl_pembelian_detail`";
			$strSQL1 .="(`invoice`,`kode_barang`,`nama_barang`,`harga_pokok`,`harga_jual`,`qty`,`updatedate`,`updateby`) ";
			$strSQL1 .="VALUES (";
			$strSQL1 .="'$no_transaksi',";
			$strSQL1 .="'$data[0]',";
			$strSQL1 .="'$data[1]',";
			$strSQL1 .="'$data[2]',";
			$strSQL1 .="'$data[3]',";
			$strSQL1 .="'$data[4]',";
			$strSQL1 .="NOW(),";
			$strSQL1 .="'$session_nik'";
			$strSQL1 .=") ";
			$objQuery1 = mysqli_query($connect,$strSQL1) or die($strSQL1);

			$strSQL2 = "INSERT INTO `tbl_stok_gudang`";
			$strSQL2 .="(`kd_barang`,`nama_barang`,`id_jenis`,`satuan`,`stok`,`harga_pokok`,`harga_jual`,`lokasi`,`tgl_input`,`invoice`,`updatedate`,`updateby`) ";
			$strSQL2 .="VALUES(";
			$strSQL2 .="'$data[0]',";
			$strSQL2 .="'$data[1]',";
			$strSQL2 .="'$data[5]',";
			$strSQL2 .="'$data[6]',";
			$strSQL2 .="'$data[4]',";
			$strSQL2 .="'$data[2]',";
			$strSQL2 .="'$data[3]',";
			$strSQL2 .="'$lokasi',";
			$strSQL2 .="'$tgl_transaksi',";
			$strSQL2 .="'$no_transaksi',";
			$strSQL2 .="NOW(),";
			$strSQL2 .="'$session_nik'";
			$strSQL2 .=") ";
			$objQuery2 = mysqli_query($connect,$strSQL2) or die($strSQL2);

			$strSQL3 = "INSERT INTO `tbl_stok_card_gudang`";
            $strSQL3 .="(`kd_gudang`,`kd_barang`,`stok_awal`,`qty`,`stok_akhir`,`updateby`,`updatedate`,`proses`,`no_proses`)";
            $strSQL3 .="VALUES (";
            $strSQL3 .="'$lokasi',";
            $strSQL3 .="'$data[0]',";
            $strSQL3 .="'0',";
            $strSQL3 .="'$data[4]',";
            $strSQL3 .="'$data[4]',";
			$strSQL3 .="'$session_nik',";
			$strSQL3 .="NOW(),";
			$strSQL3 .="'pembelian',";
			$strSQL3 .="'$no_transaksi'";
			$strSQL3 .=") ";
			$objQuery3 = mysqli_query($connect,$strSQL3) or die($strSQL3);

	}

	if(($objQuery1)&&($objQuery2)&&($objQuery3)){
		$strSQL4 = "INSERT INTO `tbl_pembelian`";
		$strSQL4 .="(`invoice`,`tgl_invoice`,`tgl_input`,`total_qty`,`total_harga_pokok`,`total_harga_jual`,`lokasi`,`updatedate`,`updateby`) ";
		$strSQL4 .="VALUES (";
		$strSQL4 .="'$no_transaksi',";
		$strSQL4 .="'$tgl_transaksi',";
		$strSQL4 .="NOW(),";
		$strSQL4 .="'$totalqty',";
		$strSQL4 .="'$totalhpp',";
		$strSQL4 .="'$totalhpj',";
		$strSQL4 .="'$lokasi',";
		$strSQL4 .="NOW(),";
		$strSQL4 .="'$session_nik'";
		$strSQL4 .=") ";
		$objQuery4 = mysqli_query($connect,$strSQL4) or die($strSQL4);
	}

	$sukses = "sukses";
    $error = "error $strSQL1 $strSQL2 $strSQL3";

	if(($objQuery1) && ($objQuery2) && ($objQuery3) && ($objQuery4)){
	
		$sql_del = "DELETE FROM tbl_pembelian_temp WHERE updateby='$session_nik' AND updatedate like '%$tgl_transaksi%'";
		$res_del = mysqli_query($connect,$sql_del);

		mysqli_query($connect,"COMMIT");

		echo $sukses;

	}else{
	
		mysqli_query($connect,"ROLLBACK");

		echo $error;
	}
	mysqli_close($connect);
}elseif($op=='batal'){
	$today = date('Y-m-d H:i:s');
	$invoice = $_GET['notrans'];

	mysqli_query($connect,"BEGIN");

	$sql_update_stat = "UPDATE tbl_pembelian SET tgl_batal = '$today', user_pembatal='$session_nik', is_aktif='2' WHERE invoice='$invoice'";
	$res_update_stat = mysqli_query($connect,$sql_update_stat)or die($sql_update_stat);

	$sukses = "sukses";
    $error = "error stat: $sql_update_stat";

	if($res_update_stat){
		$sql_up_stok_gudang = "UPDATE tbl_stok_gudang SET tgl_batal = '$today', user_pembatal='$session_nik', is_aktif='3' WHERE invoice='$invoice'";
		$res_up_stok_gudang = mysqli_query($connect,$sql_up_stok_gudang)or die($sql_up_stok_gudang);

		mysqli_query($connect,"COMMIT");
		echo $sukses;
	}else{

		mysqli_query($connect,"ROLLBACK");
		echo $error;
	}
	mysqli_close($connect);
}
?>