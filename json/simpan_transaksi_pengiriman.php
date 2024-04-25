<?php //session_start();
include ("../config/koneksi.php");
include ("../config/lock.php");
include ("update_data_terima.php");
// $session_lokasi = 'UBR';
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

$todayNow = date('Y-m-d H:i:s');
$todayZ = date('Y-m-d');
$detik = date("s");
$date = date("YmdHis");

$op=isset($_GET['op'])?$_GET['op']:null;
if($op=='tambah'){
	$invoice = $_GET['invoice'];
	$kode_barang = $_GET['kode_barang'];
    $nama_barang = $_GET['nama_barang'];
    $harga_pokok = $_GET['harga_pokok'];
    $harga_jual = $_GET['harga_jual'];
    $stok = $_GET['stok'];
    $id_jenis = $_GET['id_jenis'];
    $satuan = $_GET['satuan'];
    $qty = $_GET['qty'];

		mysqli_query($connect,"BEGIN");
			
			$sql_select = "SELECT invoice,kd_barang,qty FROM tbl_do_temp WHERE kd_barang='$kode_barang' AND updateby='$session_nik'";
			$res_select = mysqli_query($connect,$sql_select);
			list($kode_barang_exist,$qty_exist)=mysqli_fetch_array($res_select);
			$jml_akhir = $qty_exist + $qty;

			$strSQL1 = "INSERT INTO `tbl_do_temp`";
			$strSQL1 .="(invoice, kd_barang, nama_barang, id_jenis, satuan, stok, harga_pokok, harga_jual, qty, tgl_input, updatedate, updateby) ";
			$strSQL1 .="VALUES (";
			$strSQL1 .="'$invoice',";
			$strSQL1 .="'$kode_barang',";
			$strSQL1 .="'$nama_barang',";
			$strSQL1 .="'$id_jenis',";
			$strSQL1 .="'$satuan',";
			$strSQL1 .="'$stok',";
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
		
			$strSQL1 = "UPDATE `tbl_do_temp`";
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
	$sql_del = "DELETE FROM tbl_do_temp WHERE updateby='$session_nik'";
	$res_del = mysqli_query($connect,$sql_del);

	if($res_del){
		echo "sukses";
	}else{
		echo "gagal";
	}
}elseif($op=='hapus_list'){
	$invoice = $_GET['invoice'];
	$kode_barang = $_GET['kode_barang'];

	$sql_del = "DELETE FROM tbl_do_temp WHERE updateby='$session_nik' AND invoice='$invoice' AND kd_barang='$kode_barang'";
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
	$querys = "SELECT MAX(no_transaksi)AS `last` FROM tbl_do WHERE YEAR(tgl_transaksi)='$year'";
	$hasil = mysqli_query($connect,$querys);
	$data  = mysqli_fetch_array($hasil);
	$lastNo = $data['last'];
	$lastthn = substr($lastNo, 3,2);
	$lastNoUrut = substr($lastNo, 15, 6);
	if($tahun>$lastthn){
	$nextNoUrut = '000001';
	}else{
	$nextNoUrut = $lastNoUrut + '1';
	}


	$no_transaksi = 'DO'.'_'.$tahun.$bulan.$tanggal.$jam.sprintf('%06s', $nextNoUrut);

    $lokasi = $_GET['lokasi'];

	mysqli_query($connect,"BEGIN");
    
    $sql="SELECT `invoice`,
				`kd_barang`,
				`nama_barang`,
				`id_jenis`,
				`satuan`,
				`stok`,
				`harga_pokok`,
				`harga_jual`,
				`qty`
		FROM tbl_do_temp 
		WHERE updateby ='$session_nik'
		ORDER BY updatedate DESC";
    $res=mysqli_query($connect,$sql);
    while ($data = mysqli_fetch_row($res)) {
    	$totalqty += $data[8];
    	$totalhpp += $data[6];
    	$totalhpj += $data[7];
    	// $id_barang = $data[0];
			$strSQL1 = "INSERT INTO `tbl_do_detail`";
			$strSQL1 .="(`no_transaksi`,`invoice`,`kode_barang`,`nama_barang`,`id_jenis`,`satuan`,`stok`,`harga_pokok`,`harga_jual`,`qty`,`updatedate`,`updateby`) ";
			$strSQL1 .="VALUES (";
			$strSQL1 .="'$no_transaksi',";
			$strSQL1 .="'$data[0]',";
			$strSQL1 .="'$data[1]',";
			$strSQL1 .="'$data[2]',";
			$strSQL1 .="'$data[3]',";
			$strSQL1 .="'$data[4]',";
			$strSQL1 .="'$data[5]',";
			$strSQL1 .="'$data[6]',";
			$strSQL1 .="'$data[7]',";
			$strSQL1 .="'$data[8]',";
			$strSQL1 .="NOW(),";
			$strSQL1 .="'$session_nik'";
			$strSQL1 .=") ";
			$objQuery1 = mysqli_query($connect,$strSQL1) or die($strSQL1);

			$sql_stok_gudang = "SELECT stok FROM tbl_stok_gudang WHERE kd_barang='$data[1]' AND invoice ='$data[0]'";
			$res_stok_gudang = mysqli_query($connect,$sql_stok_gudang);
			list($stok_gudang)=mysqli_fetch_array($res_stok_gudang);
			$sisa_stok = $stok_gudang - $data[8];

			$sql_up_stok_gudang = "UPDATE tbl_stok_gudang SET stok = '$sisa_stok', tgl_kirim='NOW()', updateby='$session_nik' WHERE kd_barang='$data[1]' AND invoice='$data[0]'";
			$res_up_stok_gudang = mysqli_query($connect,$sql_up_stok_gudang)or die($sql_up_stok_gudang);

			$stok_card = -$data[8];
			$sisa_stok_card = $stok_gudang + $stok_card;
			$strSQL2 = "INSERT INTO `tbl_stok_card_gudang`";
			$strSQL2 .="(`kd_gudang`,`kd_barang`,`stok_awal`,`qty`,`stok_akhir`,`updateby`,`updatedate`,`proses`,`no_proses`) ";
			$strSQL2 .="VALUES(";
			$strSQL2 .="'$lokasi',";
			$strSQL2 .="'$data[1]',";
			$strSQL2 .="'$stok_gudang',";
			$strSQL2 .="'$stok_card',";
			$strSQL2 .="'$sisa_stok_card',";
			$strSQL2 .="'$session_nik',";
			$strSQL2 .="NOW(),";
			$strSQL2 .="'kirim',";
			$strSQL2 .="'$no_transaksi'";
			$strSQL2 .=") ";
			$objQuery2 = mysqli_query($connect,$strSQL2) or die($strSQL2);

	}

	if(($objQuery1)&&($res_up_stok_gudang)&&($objQuery2)){
	// if($objQuery1){
		$strSQL3 = "INSERT INTO `tbl_do`";
		$strSQL3 .="(`no_transaksi`,`tgl_transaksi`,`qty`,`total_harga_pokok`,`total_harga_jual`,`lokasi`,`updatedate`,`updateby`,`is_aktif`) ";
		$strSQL3 .="VALUES (";
		$strSQL3 .="'$no_transaksi',";
		$strSQL3 .="'$tgl_transaksi',";
		$strSQL3 .="'$totalqty',";
		$strSQL3 .="'$totalhpp',";
		$strSQL3 .="'$totalhpj',";
		$strSQL3 .="'$lokasi',";
		$strSQL3 .="NOW(),";
		$strSQL3 .="'$session_nik',";
		$strSQL3 .="'1'";
		$strSQL3 .=") ";
		$objQuery3 = mysqli_query($connect,$strSQL3) or die($strSQL3);
	}

	$sukses = "sukses";
    $error = "error $sql $strSQL1 $strSQL3";

	// if(($objQuery1) && ($objQuery2) && ($objQuery3)){
	if(($objQuery1) && ($res_up_stok_gudang) &&($objQuery2) && ($objQuery3)){
	
		$sql_del = "DELETE FROM tbl_do_temp WHERE updateby='$session_nik' AND updatedate like '%$tgl_transaksi%'";
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
	$notrans = $_GET['notrans'];

	mysqli_query($connect,"BEGIN");

	$sql_update_stat = "UPDATE tbl_do SET tgl_batal = '$today', user_pembatal='$session_nik', stat_terima='2', is_aktif='2' WHERE no_transaksi='$notrans'";
	$res_update_stat = mysqli_query($connect,$sql_update_stat)or die($sql_update_stat);

	$sukses = "sukses";
    $error = "error stat: $sql_update_stat";

	if($res_update_stat){
		$sql="SELECT `no_transaksi`,`invoice`,`kode_barang`,`qty` FROM tbl_do_detail WHERE no_transaksi='$notrans'";
		$res=mysqli_query($connect,$sql);
		while($d=mysqli_fetch_array($res)){
			$nomor_transaksi = $d['no_transaksi'];
			$invoice = $d['invoice'];
			$kode_barang = $d['kode_barang'];
			$qty = $d['qty'];

			// $sql_stok_gudang = "SELECT kd_barang, stok, invoice FROM tbl_stok_gudang WHERE invoice='$invoice'";
			// $res_stok_gudang = mysqli_query($connect,$sql_stok_gudang);
			// list($kd_barang,$stok_gudang,$invoice_gudang)=mysqli_fetch_array($res_stok_gudang);
			// $ambil_stok = $stok_gudang + $qty;

			$sql_cari_stok = "SELECT kd_barang, stok, invoice FROM tbl_stok_gudang WHERE kd_barang='$kode_barang' AND invoice='$invoice'";
			$res_stok_gudang = mysqli_query($connect,$sql_cari_stok);
			while($up=mysqli_fetch_array($res_stok_gudang)){
				$kd_barang = $up['kd_barang'];
				$stok_gudang = $up['stok'];
				$invoice_gudang = $up['invoice'];

				$ambil_stok = $stok_gudang + $qty;
		
				$sql_up_stok_gudang = "UPDATE tbl_stok_gudang SET stok = '$ambil_stok', tgl_batal = '$today', user_pembatal='$session_nik'
										WHERE kd_barang = '$kd_barang' ";
				$res_up_stok_gudang = mysqli_query($connect,$sql_up_stok_gudang)or die($sql_up_stok_gudang);

			}
		}

		mysqli_query($connect,"COMMIT");
		echo $sukses;
	}else{

		mysqli_query($connect,"ROLLBACK");
		echo $error;
	}
	mysqli_close($connect);
}elseif($op=='terima'){
	$today = date('Y-m-d H:i:s');
	$notrans = $_GET['notrans'];

	mysqli_query($connect,"BEGIN");

	$sql_update_stat = "UPDATE tbl_do SET tgl_terima = '$today', penerima='$session_nik', stat_terima='1', is_aktif='1' WHERE no_transaksi='$notrans'";
	$res_update_stat = mysqli_query($connect,$sql_update_stat);

	$sukses = "sukses";
    $error = "error stat: $sql_update_stat";

	$sql_detail="SELECT 
			dd.`no_transaksi`,
			dd.`invoice`,
			dd.`kode_barang`,
			dd.`nama_barang`,
			dd.`id_jenis`,
			dd.`satuan`,
			dd.`stok`,
			dd.`harga_pokok`,
			dd.`harga_jual`,
			dd.`qty`,
			dd.`stat`,
			dd.`updatedate`,
			dd.`updateby`,
			d.`lokasi`
		FROM tbl_do_detail AS dd
		LEFT JOIN tbl_do AS d ON dd.no_transaksi=d.no_transaksi
		WHERE dd.no_transaksi='$notrans'";
	$res_detail=mysqli_query($connect,$sql_detail);
	while($d=mysqli_fetch_array($res_detail)){
		$nomor_transaksi = $d['no_transaksi'];
		$invoice = $d['invoice'];
		$kode_barang = $d['kode_barang'];
		$nama_barang = $d['nama_barang'];
		$id_jenis = $d['id_jenis'];
		$satuan = $d['satuan'];
		$stok = $d['stok'];
		$harga_pokok = $d['harga_pokok'];
		$harga_jual = $d['harga_jual'];
		$qty = $d['qty'];
		$lokasi = $d['lokasi'];

		$sql_cari = "SELECT stok FROM tbl_stok WHERE kd_barang = '$kode_barang'";
		$res_cari = mysqli_query($connect,$sql_cari);
		list($stok_sisa)=mysqli_fetch_array($res_cari);

		$tambah_stok = $qty + $stok_sisa;

		$strSQL1 = "INSERT INTO `tbl_stok`";
		$strSQL1 .= "(`kd_barang`,`nama_barang`,`id_jenis`,`satuan`,`stok`,`harga_pokok`,`ppn`,`harga_jual`,`lokasi`,`updatedate`)";
		$strSQL1 .= "VALUES (";
		$strSQL1 .= "'$kode_barang',";
		$strSQL1 .= "'$nama_barang',";
		$strSQL1 .= "'$id_jenis',";
		$strSQL1 .= "'$satuan',";
		$strSQL1 .= "'$qty',";
		$strSQL1 .= "'$harga_pokok',";
		$strSQL1 .= "'0',";
		$strSQL1 .= "'$harga_jual',";
		$strSQL1 .= "'$lokasi',";
		$strSQL1 .= "NOW()";
		$strSQL1 .= ") ON DUPLICATE KEY UPDATE stok = '$tambah_stok', harga_pokok = '$harga_pokok', harga_jual = '$harga_jual', updatedate = '$today'";
		$objQuery1 = mysqli_query($connect,$strSQL1) or die($strSQL1);

		$strSQL2 = "INSERT INTO `tbl_stok_card_kantin`";
		$strSQL2 .= "(`kd_gudang`,`kd_barang`,`stok_awal`,`qty`,`stok_akhir`,`updateby`,`proses`,`no_proses`)";
		$strSQL2 .= "VALUES (";
		$strSQL2 .= "'$lokasi',";
		$strSQL2 .= "'$kode_barang',";
		$strSQL2 .= "'0',";
		$strSQL2 .= "'$qty',";
		$strSQL2 .= "'$qty',";
		$strSQL2 .= "'$session_nik',";
		$strSQL2 .= "'kirim_dari_gudang',";
		$strSQL2 .= "'$nomor_transaksi'";
		$strSQL2 .= ") ";
		$objQuery2 = mysqli_query($connect,$strSQL2) or die($strSQL2);

	
	}
	
	mysqli_query($connect,"COMMIT");
    
    if(($res_update_stat)&&($objQuery1)&&($objQuery2)&&($res_detail)){
    	send_update($notrans,$session_nik,$session_lokasi);
		echo $sukses;
	}else{

		mysqli_query($connect,"ROLLBACK");
		echo "$error $sql_update_stat $sql $sql_cari $strSQL2";
	}
	mysqli_close($connect);
}elseif($op=='tolak'){
	$today = date('Y-m-d H:i:s');
	$notrans = $_GET['notrans'];

	mysqli_query($connect,"BEGIN");

	$sql_update_stat = "UPDATE tbl_do SET tgl_batal = '$today', user_pembatal='$session_nik', stat_terima='2', is_aktif='2' WHERE no_transaksi='$notrans'";
	$res_update_stat = mysqli_query($connect,$sql_update_stat)or die($sql_update_stat);

	$sukses = "sukses";
    $error = "error stat: $sql_update_stat";

	if($res_update_stat){
		send_tolak($notrans,$session_nik,$session_lokasi);
		mysqli_query($connect,"COMMIT");
		echo $sukses;
	}else{

		mysqli_query($connect,"ROLLBACK");
		echo $error;
	}
	mysqli_close($connect);
}
?>