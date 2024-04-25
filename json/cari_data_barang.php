<?php
include ("../config/koneksi.php");
// include ("config/style_config.php");
// include ("config/lock.php");

$op=isset($_GET['op'])?$_GET['op']:null;
if($op=='nama'){
	$kode_barang = $_GET['kode_barang'];
	$query = "SELECT nama_barang, stok, harga_jual, lokasi, satuan  FROM tbl_stok where kd_barang='$kode_barang' AND stok > 0 order by nama_barang asc";
	$rs = mysqli_query($connect,$query);
	$jml_data = mysqli_num_rows($rs);
	list($nama_barang,$stok,$harga_jual,$lokasi,$satuan)=mysqli_fetch_array($rs);

	$sukses = "sukses";
	$gagal = "gagal";

	if($jml_data>0){
		echo $sukses."|".$nama_barang."|".$stok."|".$harga_jual."|".$lokasi."|".$satuan;
	}else{
		echo $gagal;
	}

}elseif($op=='kode'){
	$kode_barang = $_GET['kode_barang'];
	$query = "SELECT t.nama_barang, t.harga_pokok, t.harga_jual, t.id_jenis, t.satuan, j.jenis_barang, s.satuan
				FROM tbl_mst_barang AS t
				LEFT JOIN tbl_mst_jenis_barang AS j ON t.id_jenis=j.id 
				LEFT JOIN tbl_satuan AS s ON t.satuan=s.id 
				WHERE t.kd_barang='$kode_barang' ORDER BY t.nama_barang asc";
	$rs = mysqli_query($connect,$query);
	$jml_data = mysqli_num_rows($rs);
	list($nama_barang,$harga_pokok,$harga_jual,$id_jenis,$satuan,$jenis_barang,$nama_satuan)=mysqli_fetch_array($rs);

	$sukses = "sukses";
	$gagal = "gagal $query";

	if($jml_data>0){
		echo $sukses."|".$nama_barang."|".number_format($harga_pokok)."|".number_format($harga_jual)."|".$id_jenis."|".$satuan."|".$jenis_barang."|".$nama_satuan;
	}else{
		echo $gagal;
	}

}elseif($op=='stok_gudang'){
	$kode_barang = $_GET['kode_barang'];
	$query = "SELECT t.invoice, t.nama_barang, t.stok, t.harga_pokok, t.harga_jual, t.id_jenis, t.satuan, j.jenis_barang, s.satuan
			FROM tbl_stok_gudang as t
			LEFT JOIN tbl_mst_jenis_barang AS j ON t.id_jenis=j.id
			LEFT JOIN tbl_satuan AS s ON t.satuan=s.id
			where t.kd_barang='$kode_barang' AND t.stok > 0
			ORDER BY t.nama_barang asc";
	$rs = mysqli_query($connect,$query);
	$jml_data = mysqli_num_rows($rs);
	list($invoice,$nama_barang,$stok,$harga_pokok,$harga_jual,$id_jenis,$satuan,$jenis_barang,$nama_satuan)=mysqli_fetch_array($rs);

	$sukses = "sukses";
	$gagal = "gagal";

	if($jml_data>0){
		echo $sukses."|".$invoice."|".$nama_barang."|".$stok."|".$harga_pokok."|".$harga_jual."|".$id_jenis."|".$satuan."|".$jenis_barang."|".$nama_satuan;
	}else{
		echo $gagal;
	}

}

?>
