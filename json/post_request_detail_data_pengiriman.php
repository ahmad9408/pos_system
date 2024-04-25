<?php
//fungsi kirim data ke qlp system
	function send_data2($awal,$akhir){
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
		  CURLOPT_POSTFIELDS => array('awal' => $awal,'akhir' => $akhir),
		));

		$response2 = curl_exec($curl2);

		// echo json_encode($response);
		curl_close($curl2);

	}
?>