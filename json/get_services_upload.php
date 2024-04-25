<?php
function send_data($tgl_transaksi, $no_transaksi, $id_kasir, $qty, $subtotal, $diskon, $total_akhir, $total_non_cash, $total_cash, $total_pembayaran, $total_bayar, $kembalian, $lokasi, $is_aktif, $tgl_batal, $updatedate, $user_pembatal){
    $curl = curl_init();
    $url = "upload_transaksi_harian.php";

    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    // curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($load_data) );
	curl_setopt($curl, CURLOPT_POSTFIELDS, "no=".'1'."&tgl_transaksi=".$tgl_transaksi."&tgl_transaksi_update=".$updatedate."&no_transaksi=".$no_transaksi."&id_kasir=".$id_kasir."&qty=".$qty."&subtotal=".$subtotal."&diskon=".$diskon."&total_akhir=".$total_akhir."&total_non_cash=".$total_non_cash."&total_cash=".$total_cash."&total_pembayaran=".$total_pembayaran."&total_bayar=".$total_bayar."&kembalian=".$kembalian."&lokasi=".$lokasi."&status_penjualan=".$is_aktif."&tgl_batal=".$tgl_batal."&user_pembatal=".$user_pembatal);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
    $result = curl_exec($curl);
    curl_close($curl);

    // echo "<pre>";
    return ($result);
}

?>