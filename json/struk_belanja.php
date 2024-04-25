<?php //session_start();
include ("../config/koneksi.php");
include ("../config/lock.php");

error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

$today = date('Y-m-d H:i:s');
$todayZ = date('Ymd');
$detik = date("s");
$date = date("YmdHis");

$op=isset($_GET['op'])?$_GET['op']:null;
if($op=='proses'){
  $no_transaksi = $_GET['notrans'];

  $sql="SELECT
            `d`.`qty`
            , `d`.`nama_barang`
            , `d`.`kode_barang`
            , `d`.`harga`
            , `d`.`total`
            , `t`.`subtotal`
            , `t`.`qty` as total_qty
            , `t`.`diskon`
            , `t`.`total_akhir`
            , `t`.`total_non_cash`
            , `t`.`total_cash`
            , `t`.`total_pembayaran`
            , `t`.`total_bayar`
            , `t`.`kembalian`
            , `t`.`lokasi`
            , `t`.`updatedate`
            , `t`.`id_kasir`
        FROM
            `pos`.`tbl_transaksi_detail` AS `d`
            INNER JOIN `pos`.`tbl_transaksi` AS `t` 
                ON (`d`.`no_transaksi` = `t`.`no_transaksi`)
        WHERE `t`.`no_transaksi` = '$no_transaksi'";
    $res = mysqli_query($connect,$sql);
  echo "<thead>
          <tr>
            <th>QTY</th>
            <th>Nama Barang</th>
            <th>Kode Barang</th>
            <th>Harga</th>
            <th>Total</th>
          </tr>
        </thead>";
  while($data=mysqli_fetch_array($res)){
    echo "
      <tr>
        <td id='qty_p'>$data[qty]</td>
        <td id='nama_barang_p'>$data[nama_barang]</td>
        <td id='harga_p'>$data[harga]</td>
        <td id='total_p'>$data[total]</td>
      </tr>";
  }

    $sukses = "sukses";
    $error = "error";

}else if($op=='struk_belanja'){
  // $nama = str_replace(" ", "_", strtolower($_POST['nama']));
  $no_transaksi = $_POST['no_transaksi'];

  require_once("dompdf/dompdf_config.inc.php");

  $html =
    '<html>
    <body>'.
      '<div align="center">KANTIN ABBA</div>'.
      '<br><div align="center">Jl. Cisaranten No.5</div>'.
      '<div>'.$no_transaksi.'</div><br>'.
      '<table class="table">'.
      '<tr>'.
      '<td></td>'.
      '</tr>'.
      '</table>'.
      // '<p>Alamat lengkap Anda adalah : '.$alamat.'</p>'.
    '</body>
    </html>';

  $dompdf = new DOMPDF();
  $dompdf->load_html($html);
  $dompdf->render();
  $dompdf->stream('print_out'.$no_transaksi.'.pdf');
}
?>