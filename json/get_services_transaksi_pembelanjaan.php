<?php
	function send_data($no,$invoice,$tgl_invoice,$tgl_input,$updateby,$total_harga_pokok,$total_harga_jual,$total_qty,$lokasi,$updatedate,$ambil_tgl_batal,$ambil_user_pembatal,$is_aktif){
	    $curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'https://harmetgarment.web.id/sistem_penjualan/api/simpan_data_upload_transaksi_pembelanjaan.php',
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
		  	'no' => $no,
			'invoice' => $invoice,
			'tgl_invoice' => $tgl_invoice,
			'tgl_input' => $tgl_input,
			'updateby' => $updateby,
			'total_harga_pokok' => $total_harga_pokok,
			'total_harga_jual' => $total_harga_jual,
			'total_qty' => $total_qty,
			'lokasi' => $lokasi,
			'updatedate' => $updatedate,
			'tgl_batal' => $ambil_tgl_batal,
			'user_pembatal' => $ambil_user_pembatal,
			'is_aktif' => $is_aktif),
		));

		$response = curl_exec($curl);

		// echo $response;
		curl_close($curl);
	    // return ($response);
	}
?>