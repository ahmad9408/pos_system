<?php
	function send_data_detail($id_detail,$invoice_detail,$kode_barang_detail,$nama_barang_detail,$harga_pokok_detail,$harga_jual_detail,$qty_detail,$updatedate_detail,$updateby_detail,$is_aktif_detail){
	    $curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'https://harmetgarment.web.id/sistem_penjualan/api/simpan_data_upload_transaksi_pembelanjaan_detail.php',
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'POST',
		  // CURLOPT_SSL_VERIFYPEER => false,
		  // CURLOPT_SSL_VERIFYHOST => false,
		  CURLOPT_POSTFIELDS => array(
		  	'id_detail' => $id_detail,
		  	'invoice_detail' => $invoice_detail,
			'kode_barang_detail' => $kode_barang_detail,
			'nama_barang_detail' => $nama_barang_detail,
			'harga_pokok_detail' => $harga_pokok_detail,
			'harga_jual_detail' => $harga_jual_detail,
			'qty_detail' => $qty_detail,
			'updatedate_detail' => $updatedate_detail,
			'updateby_detail' => $updateby_detail,
			'is_aktif_detail' => $is_aktif_detail),
		));

		$response = curl_exec($curl);

		// echo $response;
		curl_close($curl);
	    // return ($response);
	}
?>