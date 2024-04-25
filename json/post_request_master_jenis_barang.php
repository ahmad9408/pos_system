<?php
//fungsi kirim data ke qlp system

	//download master jenis barang
	function send_data($awal,$akhir){
	    $curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'https://harmetgarment.web.id/sistem_penjualan/api/download_data_master_jenis_barang.php',
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

		$response = curl_exec($curl);

		// echo json_encode($response);
		curl_close($curl);

	}
	//end download master jenis barang

	//download master kategori
	function send_data_kategori($awal,$akhir){
	    $curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'https://harmetgarment.web.id/sistem_penjualan/api/download_data_master_kategori.php',
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

		$response = curl_exec($curl);

		// echo json_encode($response);
		curl_close($curl);

	}
	//end download master kategori

	//download master size
	function send_data_size($awal,$akhir){
	    $curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'https://harmetgarment.web.id/sistem_penjualan/api/download_data_master_size.php',
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

		$response = curl_exec($curl);

		// echo json_encode($response);
		curl_close($curl);

	}
	//end download master size

		//download master warna
	function send_data_warna($awal,$akhir){
	    $curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'https://harmetgarment.web.id/sistem_penjualan/api/download_data_master_warna.php',
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

		$response = curl_exec($curl);

		// echo json_encode($response);
		curl_close($curl);

	}
	//end download master warna

	// function send_update($id_jenis){
	//     $curl = curl_init();

	// 	curl_setopt_array($curl, array(
	// 	  CURLOPT_URL => 'https://harmetgarment.web.id/sistem_penjualan/api/update_data_master_jenis_barang.php',
	// 	  CURLOPT_RETURNTRANSFER => true,
	// 	  CURLOPT_ENCODING => '',
	// 	  CURLOPT_MAXREDIRS => 10,
	// 	  CURLOPT_TIMEOUT => 0,
	// 	  CURLOPT_FOLLOWLOCATION => true,
	// 	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	// 	  CURLOPT_CUSTOMREQUEST => 'POST',
	// 	  CURLOPT_SSL_VERIFYPEER => false,
	// 	  CURLOPT_SSL_VERIFYHOST => false,
	// 	  CURLOPT_POSTFIELDS => array('id_jenis' => $id_jenis),
	// 	));

	// 	$response = curl_exec($curl);

	// 	curl_close($curl);

	// }

//end fungsi kirim data ke qlp system

?>