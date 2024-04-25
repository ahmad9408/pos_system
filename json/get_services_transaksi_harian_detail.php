<?php
	function send_data_detail($id_detail, $no_transaksi_detail, $kode_barang_detail, $nama_barang_detail, $hpp_detail, $harga_detail, $stok_detail, $qty_detail, $diskon_detail, $total_detail, $id_lokasi_detail, $stat_detail, $updatedate_detail, $updateby_detail){
	    $curl = curl_init();

		curl_setopt_array($curl, array(
		  // CURLOPT_URL => 'https://harmetgarment.web.id/sistem_penjualan/api/simpan_data_upload_transaksi_harian_detail.php',
		  CURLOPT_URL => 'https://harmetgarment.web.id/sistem_penjualan/api/simpan_data_upload_transaksi_harian_detail.php',
		  CURLOPT_RETURNTRANSFER => true,
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
?>