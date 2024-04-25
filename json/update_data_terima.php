<?php
//fungsi kirim data ke qlp system
	function send_update($no_transaksi,$session_nik,$session_lokasi){
	    $curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'https://harmetgarment.web.id/sistem_penjualan/api/update_data_terima_pengiriman.php',
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'POST',
		  CURLOPT_SSL_VERIFYPEER => false,
		  CURLOPT_SSL_VERIFYHOST => false,
		  CURLOPT_POSTFIELDS => array('no_transaksi' => $no_transaksi, 'id_kasir' => $session_nik, 'session_lokasi' => $session_lokasi),
		));

		$response = curl_exec($curl);

		// echo json_encode($response);
		curl_close($curl);

	}

	function send_tolak($no_transaksi,$session_nik,$session_lokasi){
	    $curl2 = curl_init();

		curl_setopt_array($curl2, array(
		  CURLOPT_URL => 'https://harmetgarment.web.id/sistem_penjualan/api/update_data_tolak_pengiriman.php',
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'POST',
		  CURLOPT_SSL_VERIFYPEER => false,
		  CURLOPT_SSL_VERIFYHOST => false,
		  CURLOPT_POSTFIELDS => array('no_transaksi' => $no_transaksi, 'id_kasir' => $session_nik, 'session_lokasi' => $session_lokasi),
		));

		$response2 = curl_exec($curl2);

		// echo json_encode($response);
		curl_close($curl2);

	}

	function send_id_batal($no_transaksi,$id_kasir,$tgl_batal,$lokasi){
	    $curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'https://harmetgarment.web.id/sistem_penjualan/api/batalkan_transaksi_harian.php',
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
			'no_transaksi' => $no_transaksi,
			'id_kasir' => $id_kasir,
			'tgl_batal' => $tgl_batal,
			'lokasi' => $lokasi),
		));

		$response = curl_exec($curl);
		// echo $response;
		curl_close($curl);
	}

//end fungsi kirim data ke qlp system

?>