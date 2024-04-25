<?php //session_start();
include ("../config/koneksi.php");
include ("../config/lock.php");
// $session_lokasi = 'UBR';

//kirim id pembatalan ke file update_data_terima.php function(send_id_batal)
include ("update_data_terima.php");

error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

$today = date('Y-m-d H:i:s');
$todayZ = date('Ymd');
$detik = date("s");
$date = date("YmdHis");

$op=isset($_GET['op'])?$_GET['op']:null;
if($op=='proses'){
	$kode_barang = $_GET['kode_barang'];
    $nama_barang = $_GET['nama_barang'];
    $harga = $_GET['harga'];
    $stok = $_GET['stok'];
    $jml = $_GET['jml'];
    $diskon = $_GET['diskon'];
    $total = $_GET['total'];
    $id_lokasi = $_GET['id_lokasi'];

		mysqli_query($connect,"BEGIN");
			
			$sql_select = "SELECT kode_barang,qty,total FROM tbl_transaksi_detail_temp WHERE kode_barang='$kode_barang' AND updateby='$session_nik'";
			$res_select = mysqli_query($connect,$sql_select);
			list($kode_barang_exist,$qty_exist,$total_exist)=mysqli_fetch_array($res_select);
			$jml_akhir = $qty_exist + $jml;
			$harga_akhir = $total + $total_exist;

			$sql_stok = "SELECT stok FROM tbl_stok WHERE kd_barang='$kode_barang'";
			$res_stok = mysqli_query($connect,$sql_stok);
			list($stok_barang)=mysqli_fetch_array($res_stok);
			if($jml_akhir > $stok_barang){
				echo "over";
				mysqli_query($connect,"ROLLBACK");
				die();
			}

			$strSQL1 = "INSERT INTO `tbl_transaksi_detail_temp`";
			$strSQL1 .="(`id_lokasi`,`kode_barang`,`nama_barang`,`harga`,`stok`,`qty`,`diskon`,`total`,`updateby`) ";
			$strSQL1 .="VALUES (";
			$strSQL1 .="'$id_lokasi',";
			$strSQL1 .="'$kode_barang',";
			$strSQL1 .="'$nama_barang',";
			$strSQL1 .="'$harga',";
			$strSQL1 .="'$stok',";
			$strSQL1 .="'$jml',";
			$strSQL1 .="'$diskon',";
			$strSQL1 .="'$total',";
			$strSQL1 .="'$session_nik'";
			$strSQL1 .=") ON DUPLICATE KEY UPDATE qty = '$jml_akhir', total = '$harga_akhir'";
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
    $harga = $_GET['harga'];
    $stok = $_GET['stok'];
    $jml_update = $_GET['jml_update'];
    $diskon_update = $_GET['diskon_update'];
    $total = $_GET['total'];
    $id_lokasi = $_GET['id_lokasi'];

		mysqli_query($connect,"BEGIN");
		
			$strSQL1 = "UPDATE `tbl_transaksi_detail_temp`";
			$strSQL1 .="SET `kode_barang` = '$kode_barang', ";
			$strSQL1 .=" `nama_barang` = '$nama_barang', ";
			$strSQL1 .=" `harga` = '$harga', ";
			$strSQL1 .=" `qty` = '$jml_update', ";
			$strSQL1 .=" `diskon` = '$diskon_update', ";
			$strSQL1 .=" `total` = '$total',";
			$strSQL1 .=" `id_lokasi` = '$id_lokasi'";
			$strSQL1 .=" WHERE `kode_barang` = '$kode_barang' AND `updateby` = '$session_nik'";
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
	$sql_del = "DELETE FROM tbl_transaksi_detail_temp WHERE updateby='$session_nik'";
	$res_del = mysqli_query($connect,$sql_del);

	if($res_del){
		echo "sukses";
	}else{
		echo "gagal";
	}
}elseif($op=='hapus_list'){
	$kode_barang = $_GET['kode_barang'];

	$sql_del = "DELETE FROM tbl_transaksi_detail_temp WHERE updateby='$session_nik' AND kode_barang='$kode_barang'";
	$res_del = mysqli_query($connect,$sql_del);

	if($res_del){
		echo "sukses";
	}else{
		echo "gagal";
	}
}elseif($op=='simpan_sementara'){
	$tgl_transaksi = date('Y-m-d');
	$id_jenis_bayar = $_GET['id_jenis_bayar'];
    $jenis_bayar = $_GET['jenis_bayar'];
    $seq = $_GET['seq'];
    $no_kartu = $_GET['no_kartu'];
    $nilai_non_cash = $_GET['nilai_non_cash'];
        $nilai_non_cash2 = str_replace(',','',$nilai_non_cash);
    $nis = $_GET['nis'];
    	$explode_nis = explode("-", $nis);
    	$ambil_nis = $explode_nis[0];
    $total_non_cash = $_GET['total_non_cash'];
        $total_non_cash2 = str_replace(',','',$total_non_cash);

    mysqli_query($connect,"BEGIN");
	//jika total non cash terisi maka masukan data ke tabel tbl_transaksi_non_cash
	if($total_non_cash2 > 0){

		$sql_tabungan = "SELECT
						  `no_rekening`,
						  `saldo`
						FROM `tbl_mst_tabungan`
						WHERE nis='$ambil_nis'";
		$res_tabungan = mysqli_query($connect,$sql_tabungan)or die($sql_tabungan);
		list($no_rekening,$saldo_awal)=mysqli_fetch_array($res_tabungan);
		
		if($no_rekening != ''){
			$no_kartu = $no_rekening;
		}else{
			$no_kartu = 0;
		}

		if($id_jenis_bayar==1){
			$ambil_no_kartu = $no_kartu;
		}else{
			$ambil_no_kartu = 0;
		}

		$strSQL1 ="INSERT INTO `tbl_transaksi_non_cash_temp`";
		$strSQL1 .="(`jenis_bayar`,`urutan`,`no_kartu`,`nilai`,`updateby`)";
		$strSQL1 .="VALUES(";
		$strSQL1 .="'$id_jenis_bayar',";
		$strSQL1 .="'$seq',";
		$strSQL1 .="'$ambil_no_kartu',";
		$strSQL1 .="'$nilai_non_cash2',";
		$strSQL1 .="'$session_nik'";
		$strSQL1 .=") ON DUPLICATE KEY UPDATE nilai='$nilai_non_cash2', updatedate=NOW()";
		$objQuery1 = mysqli_query($connect,$strSQL1)or die($strSQL1);

		//jika jenis bayar adalah tabungan, maka masukan ke tabel tbl_proses_tabungan dan update tabel tbl_master_tabungan
		$nilai = -$nilai_non_cash2;
		$saldo_akhir = $saldo_awal + $nilai;

		if($id_jenis_bayar == 1){
			$strSQL2 ="INSERT INTO `tbl_proses_tabungan_temp`";
			$strSQL2 .="(`jenis`,`tgl_proses`,`saldo_awal`,`nilai`,`saldo_akhir`,`updatedate`,`updateby`)";
			$strSQL2 .="VALUES(";
			$strSQL2 .="'$id_jenis_bayar',";
			$strSQL2 .="'$tgl_transaksi',";
			$strSQL2 .="'$saldo_awal',";
			$strSQL2 .="'$nilai',";
			$strSQL2 .="'$saldo_akhir',";
			$strSQL2 .="NOW(),";
			$strSQL2 .="'$session_nik'";
			$strSQL2 .=") ON DUPLICATE KEY UPDATE tgl_proses='$tgl_transaksi', saldo_akhir='$saldo_awal', nilai = '$nilai', saldo_akhir='$saldo_akhir', updatedate = NOW(), updateby='$session_nik'";
			$objQuery2 = mysqli_query($connect,$strSQL2)or die($strSQL2);

			// $strSQL5 ="UPDATE tbl_mst_tabungan SET saldo = '$saldo_akhir' WHERE nis = '$ambil_nis'";
			// $objQuery5 = mysqli_query($connect,$strSQL5);
		}

	}

	$sukses = "sukses";
    $error = "error";

	if($objQuery1){

		mysqli_query($connect,"COMMIT");

		echo $sukses;

	}else{
	
		mysqli_query($connect,"ROLLBACK");

		echo $error.'|'.$strSQL1.'|'.$strSQL2;
	}
	mysqli_close($connect);
}elseif($op=='simpan'){
	$tgl_transaksi = date('Y-m-d');
	$year = date('Y');
	$today = date('Y-m-d H:i:s');
	$tahun = date('y');
	$bulan = date('m');
	$tanggal = date('d');
	$jam = date('His');
	$querys = "SELECT MAX(no_transaksi)AS `last` FROM tbl_transaksi WHERE YEAR(tgl_transaksi)='$year'";
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

	$no_transaksi = 'TRANS'.'_'.$tahun.$bulan.$tanggal.$jam.sprintf('%06s', $nextNoUrut);

    $total_bayar = $_GET['total_bayar'];
    $diskon_total = $_GET['diskon_total'];
    $hasil_diskon_total = $_GET['hasil_diskon_total'];
        $hasil_diskon_total2 = str_replace(',','',$hasil_diskon_total);
    $harga_akhir = $_GET['harga_akhir'];
        $harga_akhir2 = str_replace(',','',$harga_akhir);
    $bayar = $_GET['bayar'];
        $total_cash = str_replace(',','',$bayar);
    $kembalian = $_GET['kembalian'];
        $kembalian2 = str_replace(',','',$kembalian);
    $id_jenis_bayar = $_GET['id_jenis_bayar'];
    $jenis_bayar = $_GET['jenis_bayar'];
    $seq = $_GET['seq'];
    $no_kartu = $_GET['no_kartu'];
    $nilai_non_cash = $_GET['nilai_non_cash'];
        $nilai_non_cash2 = str_replace(',','',$nilai_non_cash);

    $total_non_cash = $_GET['total_non_cash'];
        $total_non_cash2 = str_replace(',','',$total_non_cash);
	
	$tot_pembayaran = $_GET['tot_pembayaran'];
        $tot_pembayaran2 = str_replace(',','',$tot_pembayaran);

    $nis = $_GET['nis'];
    	$explode_nis = explode("-", $nis);
    	$ambil_nis = $explode_nis[0];

	mysqli_query($connect,"BEGIN");
    
    $sql="SELECT kode_barang, nama_barang, harga, stok, qty, diskon, total, id_lokasi FROM tbl_transaksi_detail_temp WHERE updateby ='$session_nik' ORDER BY id DESC";
    $res=mysqli_query($connect,$sql);
    while ($data = mysqli_fetch_row($res)) {
    	$totalqty += $data[4];

    	$sql_cari_stok_produk="SELECT stok,harga_pokok FROM tbl_stok where kd_barang='$data[0]' AND lokasi='$data[7]'";
		$cari_stok=mysqli_query($connect,$sql_cari_stok_produk);
		list($stok_awal,$harga_pokok)=mysqli_fetch_array($cari_stok);

			$strSQL1 = "INSERT INTO `tbl_transaksi_detail`";
			$strSQL1 .="(`no_transaksi`,`kode_barang`,`nama_barang`,`hpp`,`harga`,`stok`,`qty`,`diskon`,`total`,`id_lokasi`,`updatedate`,`updateby`) ";
			$strSQL1 .="VALUES (";
			$strSQL1 .="'$no_transaksi',";
			$strSQL1 .="'$data[0]',";
			$strSQL1 .="'$data[1]',";
			$strSQL1 .="'$harga_pokok',";
			$strSQL1 .="'$data[2]',";
			$strSQL1 .="'$stok_awal',";
			$strSQL1 .="'$data[4]',";
			$strSQL1 .="'$data[5]',";
			$strSQL1 .="'$data[6]',";
			$strSQL1 .="'$data[7]',";
			$strSQL1 .="NOW(),";
			$strSQL1 .="'$session_nik'";
			$strSQL1 .=") ";
			$objQuery1 = mysqli_query($connect,$strSQL1) ;

		$ambil_qty = -$data[4];
		$stok_akhir_update = ($stok_awal + $ambil_qty);
		$sql_produk="INSERT INTO tbl_stok_card_kantin (kd_gudang,kd_barang,stok_awal,qty,stok_akhir,updateby,proses,no_proses)VALUES('$data[6]','$data[0]','$stok_awal','$ambil_qty','$stok_akhir_update','$session_nik','jual','$no_transaksi')";
		$res_produk=mysqli_query($connect,$sql_produk);

		$sql_update_produk="UPDATE tbl_stok SET stok='$stok_akhir_update' where kd_barang='$data[0]' AND lokasi='$data[6]'";
		$res_stok=mysqli_query($connect,$sql_update_produk);
	}

	if(($objQuery1) && ($res_produk) && ($res_stok)){
		$strSQL2 = "INSERT INTO `tbl_transaksi`";
		$strSQL2 .="(`no_transaksi`,`tgl_transaksi`,`id_kasir`,`subtotal`,`qty`,`diskon`,`total_akhir`,`total_non_cash`,`total_cash`,`total_pembayaran`,`total_bayar`,`kembalian`,`lokasi`,`updatedate`)";
		$strSQL2 .="VALUES (";
		$strSQL2 .="'$no_transaksi',";
		$strSQL2 .="'$tgl_transaksi',";
		$strSQL2 .="'$session_nik',";
		$strSQL2 .="'$total_bayar',";
		$strSQL2 .="'$totalqty',";
		$strSQL2 .="'$hasil_diskon_total2',";
		$strSQL2 .="'$harga_akhir2',";
		$strSQL2 .="'$total_non_cash2',";
		$strSQL2 .="'$total_cash',";
		$strSQL2 .="'$harga_akhir2',";
		$strSQL2 .="'$tot_pembayaran2',";
		$strSQL2 .="'$kembalian2',";
		$strSQL2 .="'$session_lokasi',";
		$strSQL2 .="NOW()";
		$strSQL2 .=") ";
		$objQuery2 = mysqli_query($connect,$strSQL2) ;

		//jika total non cash terisi maka masukan data ke tabel tbl_transaksi_non_cash
		if($total_non_cash2 > 0){

			$sql_tabungan = "SELECT
							  `no_rekening`,
							  `saldo`
							FROM `tbl_mst_tabungan`
							WHERE nis='$ambil_nis'";
			$res_tabungan = mysqli_query($connect,$sql_tabungan);
			list($no_rekening,$saldo_awal)=mysqli_fetch_array($res_tabungan);
			
			if($no_rekening != ''){
				$no_kartu = $no_rekening;
			}else{
				$no_kartu = 0;
			}
			
			$sql_trans_non_cash = "SELECT `jenis_bayar`,`urutan`,`no_kartu`,`nilai`,`updateby` 
							FROM `tbl_transaksi_non_cash_temp`
							WHERE updateby='$session_nik' and updatedate like '%$tgl_transaksi%'";
			$res_trans_non_cash = mysqli_query($connect,$sql_trans_non_cash);
			while($tnc=mysqli_fetch_array($res_trans_non_cash)){
				$strSQL3 ="INSERT INTO `tbl_transaksi_non_cash`";
				$strSQL3 .="(`no_transaksi`,`jenis_bayar`,`urutan`,`no_kartu`,`nilai`)";
				$strSQL3 .="VALUES(";
				$strSQL3 .="'$no_transaksi',";
				$strSQL3 .="'$tnc[0]',";
				$strSQL3 .="'$tnc[1]',";
				$strSQL3 .="'$tnc[2]',";
				$strSQL3 .="'$tnc[3]'";
				$strSQL3 .=") ";
				$objQuery3 = mysqli_query($connect,$strSQL3) ;
			}

			//jika jenis bayar adalah tabungan, maka masukan ke tabel tbl_proses_tabungan dan update tabel tbl_master_tabungan
			$sql_trans_non_cash = "SELECT `nilai`
									FROM `tbl_transaksi_non_cash_temp`
									WHERE jenis_bayar = 1 and updateby='$session_nik' and updatedate like '%$tgl_transaksi%'";
			$res_trans_non_cash = mysqli_query($connect,$sql_trans_non_cash);
			list($nilai_tab)=mysqli_fetch_array($res_trans_non_cash);

			$nilai = -$nilai_tab;
			$saldo_akhir = $saldo_awal + $nilai;

			$sql_tabungan_temp = "SELECT `jenis`,`tgl_proses`,`saldo_awal`,`nilai`,`saldo_akhir`,`updatedate`,`updateby`
							FROM `tbl_proses_tabungan_temp`
							WHERE jenis= '1' and updateby='$session_nik' and updatedate like '%$tgl_transaksi%'";
			$res_tabungan_temp = mysqli_query($connect,$sql_tabungan_temp);
			while($tab_temp=mysqli_fetch_array($res_tabungan_temp)){

				// if($id_jenis_bayar == 1){
					$strSQL4 ="INSERT INTO `tbl_proses_tabungan`";
					$strSQL4 .="(`id_proses`,`jenis`,`tgl_proses`,`saldo_awal`,`nilai`,`saldo_akhir`,`updatedate`,`updateby`)";
					$strSQL4 .="VALUES(";
					$strSQL4 .="'$no_transaksi',";
					$strSQL4 .="'$tab_temp[0]',";
					$strSQL4 .="'$tab_temp[1]',";
					$strSQL4 .="'$saldo_awal',";
					$strSQL4 .="'$tab_temp[3]',";
					$strSQL4 .="'$saldo_akhir',";
					$strSQL4 .="NOW(),";
					$strSQL4 .="'$session_nik'";
					$strSQL4 .=") ";
					$objQuery4 = mysqli_query($connect,$strSQL4) ;

					$strSQL5 ="UPDATE tbl_mst_tabungan SET saldo = '$saldo_akhir' WHERE nis = '$ambil_nis'";
					$objQuery5 = mysqli_query($connect,$strSQL5);
				// }
			}

		}

		
	}

	$sukses = "sukses";
    $error = "error";

	if(($objQuery1) && ($res_produk) && ($res_stok) && ($objQuery2)){

		$sql="SELECT id,kode_barang, nama_barang, harga, stok, qty, diskon, total FROM tbl_transaksi_detail_temp WHERE updateby ='$session_nik' ORDER BY id DESC";
	    $res=mysqli_query($connect,$sql);
	    while ($data = mysqli_fetch_array($res)) {

	    	$hasil_qty = $data['stok'] - $data['qty'];
	    	$sql_update = "UPDATE tbl_stok SET stok='$hasil_qty' WHERE kd_barang='$data[kode_barang]'";
	    	$res_update = mysqli_query($connect,$sql_update);

			$sql_del = "DELETE FROM tbl_transaksi_detail_temp WHERE updateby='$session_nik'";
			$res_del = mysqli_query($connect,$sql_del);

			$sql_del2 = "DELETE FROM tbl_transaksi_non_cash_temp where updateby='$session_nik'";
			$res_del2 = mysqli_query($connect,$sql_del2);

			$sql_del3 = "DELETE FROM tbl_proses_tabungan_temp where updateby='$session_nik'";
			$res_del3 = mysqli_query($connect,$sql_del3);

		}

		mysqli_query($connect,"COMMIT");

		$sql_cari_data = "SELECT tgl_transaksi, no_transaksi, id_kasir, qty, subtotal, diskon, total_akhir, total_non_cash, 
								total_cash, total_pembayaran, total_bayar, kembalian, lokasi, is_aktif, tgl_batal, updatedate, user_pembatal
								FROM tbl_transaksi
								WHERE no_transaksi = '$no_transaksi'";
		$res_cari_data = mysqli_query($connect,$sql_cari_data);
		while($data=mysqli_fetch_array($res_cari_data)){
			$tgl_transaksi = $data['tgl_transaksi'];
			$no_transaksi = $data['no_transaksi'];
			$id_kasir = $data['id_kasir'];
			$qty = $data['qty'];
			$subtotal = $data['subtotal'];
			$diskon = $data['diskon'];
			$total_akhir = $data['total_akhir'];
			$total_non_cash = $data['total_non_cash'];
			$total_cash = $data['total_cash'];
			$total_pembayaran = $data['total_pembayaran'];
			$total_bayar = $data['total_bayar'];
			$kembalian = $data['kembalian'];
			$lokasi = $data['lokasi'];
			$is_aktif = $data['is_aktif'];
			$tgl_batal = $data['tgl_batal'];
			$updatedate = $data['updatedate'];
			$user_pembatal = $data['user_pembatal'];
		}
		echo $sukses."|".$no_transaksi."|".$session_nik."|".$tgl_transaksi."|".$id_kasir."|".$qty."|".$subtotal."|".$diskon."|".$total_akhir."|".$total_non_cash."|".$total_cash."|".$total_pembayaran."|".$total_bayar."|".$kembalian."|".$lokasi."|".$is_aktif."|".$tgl_batal."|".$updatedate."|".$user_pembatal;


	}else{
	
		mysqli_query($connect,"ROLLBACK");

		echo $error.'|'.$sql_cari_stok_produk.'|'.$strSQL1.'|'.$strSQL2.'|'.$strSQL3.'|'.$sql_produk.'|'.$sql_update_produk;
	}
	mysqli_close($connect);
}elseif($op=='batal'){
	$today = date('Y-m-d H:i:s');
	$no_transaksi = $_GET['notrans'];

	mysqli_query($connect,"BEGIN");

	$sql_update_stat = "UPDATE tbl_transaksi SET tgl_batal = '$today', user_pembatal='$session_nik', is_aktif='2' WHERE no_transaksi='$no_transaksi'";
	$res_update_stat = mysqli_query($connect,$sql_update_stat)or die($sql_update_stat);

	$sql="SELECT `no_transaksi`,`kode_barang`,`nama_barang`,`harga`,`stok`,`qty`,`total`,`id_lokasi`,`updatedate`,`updateby` FROM tbl_transaksi_detail WHERE no_transaksi='$no_transaksi'";
    $res=mysqli_query($connect,$sql);
    while ($data = mysqli_fetch_array($res)) {
		$qty = $data['qty'];
		$id_lokasi = $data['id_lokasi'];

		$sql_stok = "SELECT kd_barang, stok FROM tbl_stok WHERE kd_barang='$data[kode_barang]'";
		$res_stok = mysqli_query($connect,$sql_stok);
		list($kd_barang,$stok_barang) = mysqli_fetch_array($res_stok);

		//update tabel tbl_stok
    	$hasil_qty = $stok_barang + $qty;
    	$sql_update_stok = "UPDATE tbl_stok SET stok='$hasil_qty' WHERE kd_barang='$data[kode_barang]'";
    	$res_update_stok = mysqli_query($connect,$sql_update_stok)or die($sql_update_stok);

    	//input ke tabel stok card
    	$sql_input_stok_card="INSERT INTO tbl_stok_card_kantin (kd_gudang,kd_barang,stok_awal,qty,stok_akhir,updateby,proses,no_proses)VALUES('$data[6]','$data[0]','$stok_awal','$ambil_qty','$stok_akhir_update','$session_nik','jual','$no_transaksi')";
		$res_input_stok_card=mysqli_query($connect,$sql_input_stok_card);
	
	}

	$sukses = "sukses";
    $error = "error stat: $sql_update_stat, stok: $sql_update_stok, tabungan : $sql_up_tab";

	if(($res_update_stat) && ($res_update_stok)){
		$sql_c="SELECT total_non_cash FROM tbl_transaksi WHERE no_transaksi='$no_transaksi'";
		$res_c=mysqli_query($connect,$sql_c);
		list($total_non_cash)=mysqli_fetch_array($res_c);
			//kembalikan nilai tabungan jika transaksi menggunakan tabungan
			if($total_non_cash>0){
				$sql_tab = "SELECT pt.id_proses, pt.saldo_awal, pt.nilai, pt.saldo_akhir, tnc.no_kartu, tnc.nilai as nilai_belanja
							FROM tbl_proses_tabungan AS pt
							LEFT JOIN tbl_transaksi_non_cash AS tnc ON pt.id_proses=tnc.no_transaksi
							WHERE pt.id_proses='$no_transaksi'";
				$res_tab = mysqli_query($connect,$sql_tab);
				while($up=mysqli_fetch_array($res_tab)){
					$sql_up_tab = "UPDATE tbl_mst_tabungan SET saldo +='$up[nilai_belanja]' WHERE no_rekening = '$up[no_kartu]'";
					$res_up_tab = mysqli_query($connect,$sql_up_tab);
				}
			}

		send_id_batal($no_transaksi,$session_nik,$today,$id_lokasi);

		mysqli_query($connect,"COMMIT");
		echo $sukses;
	}else{

		mysqli_query($connect,"ROLLBACK");
		echo $error;
	}
	mysqli_close($connect);
}elseif($op=='clear_temp_trans_non_cash'){
	$sql_del = "DELETE FROM tbl_transaksi_non_cash_temp where updateby='$session_nik'";
	$res_del = mysqli_query($connect,$sql_del);

	$sql_del2 = "DELETE FROM tbl_proses_tabungan_temp where updateby='$session_nik'";
	$res_del2 = mysqli_query($connect,$sql_del2);

	$sukses = "sukses";
    $error = "error sql_del: $sql_del; sql_del2: $sql_del2";
	if(($res_del) && ($res_del2)){
		echo $sukses;
	}else{
		echo $error;
	}
}
?>