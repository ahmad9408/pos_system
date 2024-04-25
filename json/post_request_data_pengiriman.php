<?php
//fungsi kirim data ke qlp system
	function send_data($awal,$akhir,$lokasi){
	    $curl = curl_init();

		curl_setopt_array($curl, array(
		  // CURLOPT_URL => 'http://103.135.214.11:81/sistem_penjualan/api/download_data_pengiriman.php',
		  CURLOPT_URL => 'https://harmetgarment.web.id/sistem_penjualan/api/download_data_pengiriman.php',
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'POST',
		  CURLOPT_SSL_VERIFYPEER => false,
		  CURLOPT_SSL_VERIFYHOST => false,
		  CURLOPT_POSTFIELDS => array('awal' => $awal,'akhir' => $akhir,'lokasi' => $lokasi),
		));

		$response = curl_exec($curl);

		// echo json_encode($response);
		curl_close($curl);

	}

	function send_data2($awal,$akhir,$lokasi){
	    $curl2 = curl_init();

		curl_setopt_array($curl2, array(
		  CURLOPT_URL => 'https://harmetgarment.web.id/sistem_penjualan/api/download_detail_data_pengiriman.php',
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'POST',
		  CURLOPT_SSL_VERIFYPEER => false,
		  CURLOPT_SSL_VERIFYHOST => false,
		  CURLOPT_POSTFIELDS => array('awal' => $awal,'akhir' => $akhir,'lokasi' => $lokasi),
		));

		$response2 = curl_exec($curl2);

		// echo json_encode($response);
		curl_close($curl2);

	}

	function send_update($no_transaksi,$session_nik,$lokasi){
	    $curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'https://harmetgarment.web.id/sistem_penjualan/api/update_data_pengiriman.php',
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'POST',
		  CURLOPT_SSL_VERIFYPEER => false,
		  CURLOPT_SSL_VERIFYHOST => false,
		  CURLOPT_POSTFIELDS => array('no_transaksi' => $no_transaksi, 'id_kasir' => $session_nik,'lokasi' => $lokasi),
		));

		$response = curl_exec($curl);

		// echo json_encode($response);
		curl_close($curl);

	}

//end fungsi kirim data ke qlp system

?>