<?php
//fungsi kirim data ke qlp system
	function send_data($no,$no_transaksi,$tgl_transaksi,$id_kasir,$subtotal,$qty,$diskon,$total_akhir,$total_non_cash,$total_cash,$total_pembayaran,$total_bayar,$kembalian,$lokasi,$status_penjualan,$tgl_transaksi_update,$ambil_tgl_batal,$ambil_user_pembatal){
	
	    $curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'https://harmetgarment.web.id/sistem_penjualan/api/simpan_data_upload_transaksi_harian.php',
		  // CURLOPT_URL => 'https://harmetgarment.web.id/sistem_penjualan/api/simpan_data_upload_transaksi_harian.php',
		  CURLOPT_RETURNTRANSFER => 1,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'POST',
		  CURLOPT_SSL_VERIFYPEER => false,
		  CURLOPT_SSL_VERIFYHOST => false,
		  CURLOPT_POSTFIELDS => array(
		  	// 'no' => $no,
			'no_transaksi' => $no_transaksi,
			'tgl_transaksi' => $tgl_transaksi,
			'id_kasir' => $id_kasir,
			'subtotal' => $subtotal,
			'qty' => $qty,
			'diskon' => $diskon,
			'total_akhir' => $total_akhir,
			'total_non_cash' => $total_non_cash,
			'total_cash' => $total_cash,
			'total_pembayaran' => $total_pembayaran,
			'total_bayar' => $total_bayar,
			'kembalian' => $kembalian,
			'lokasi' => $lokasi,
			'status_penjualan' => $status_penjualan,
			'tgl_transaksi_update' => $tgl_transaksi_update,
			'tgl_batal' => $ambil_tgl_batal,
			'user_pembatal' => $ambil_user_pembatal),
		));

		$response = curl_exec($curl);

		// echo $response;
		curl_close($curl);

	}

	
//end fungsi kirim data ke qlp system

	function send_data_detail($id_detail, $no_transaksi_detail, $kode_barang_detail, $nama_barang_detail, $hpp_detail, $harga_detail, $stok_detail, $qty_detail, $diskon_detail, $total_detail, $id_lokasi_detail, $stat_detail, $updatedate_detail, $updateby_detail){
	    $curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'https://harmetgarment.web.id/sistem_penjualan/api/simpan_data_upload_transaksi_harian_detail.php',
		  // CURLOPT_URL => 'https://harmetgarment.web.id/sistem_penjualan/api/simpan_data_upload_transaksi_harian_detail.php',
		  CURLOPT_RETURNTRANSFER => 1,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'POST',
		  CURLOPT_SSL_VERIFYPEER => false,
		  CURLOPT_SSL_VERIFYHOST => false,
		  CURLOPT_POSTFIELDS => array(
		  	'id_detail' => $id_detail,
			'no_transaksi_detail' => $no_transaksi_detail,
			'kode_barang_detail' => $kode_barang_detail,
			'nama_barang_detail' => $nama_barang_detail,
			'hpp_detail' => $hpp_detail,
			'harga_detail' => $harga_detail,
			'stok_detail' => $stok_detail,
			'qty_detail' => $qty_detail,
			'diskon_detail' => $diskon_detail,
			'total_detail' => $total_detail,
			'id_lokasi_detail' => $id_lokasi_detail,
			'updatedate_detail' => $updatedate_detail,
			'updateby_detail' => $updateby_detail),
		));

		$response = curl_exec($curl);

		// echo $response;
		curl_close($curl);
	    // return ($response);
	}
	
	function send_id_batal($no_transaksi,$tgl_transaksi,$id_kasir,$tgl_batal,$lokasi){
	    $curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'https://harmetgarment.web.id/sistem_penjualan/api/batalkan_transaksi_harian.php',
		  CURLOPT_RETURNTRANSFER => 1,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'POST',
		  CURLOPT_SSL_VERIFYPEER => false,
		  CURLOPT_SSL_VERIFYHOST => false,
		  CURLOPT_POSTFIELDS => array(
			'no_transaksi' => $no_transaksi,
			'tgl_transaksi' => $tgl_transaksi,
			'id_kasir' => $id_kasir,
			'tgl_batal' => $tgl_batal,
			'lokasi' => $lokasi),
		));

		$response = curl_exec($curl);
		// echo $response;
		curl_close($curl);
	}
?>