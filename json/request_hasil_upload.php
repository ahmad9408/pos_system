<?php
$url = "http://103.135.214.11:81/qlp_system/api_bisnis/simpan_data_upload_transaksi_harian.php";
function http_request($url){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($ch);
    curl_close($ch);
    return $output;
}

$profile = http_request($url);

// ubah string JSON menjadi array
$profile = json_decode($profile, TRUE);
echo json_encode($profile);

// echo "<pre>";
// print_r($profile);
// echo "</pre>";
?>