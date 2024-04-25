<?php session_start();
  include("config/koneksi.php");
  include("config/lock.php");
  $today = date('Y-m-d H:i:s');
  $todayZ = date('Y-m-d');

  // Tanggal pertama dan terakhir pada bulan ini
  //============================================
  $tgl_pertama = date('Y-m-01', strtotime($todayZ));
  $tgl_terakhir = date('Y-m-t', strtotime($todayZ));
  //============================================

if(isset($_REQUEST['action'])){
    $awal=$_POST['awal'];
    $akhir=$_POST['akhir'];
} else {

}

if($awal==''){
  $awal = $tgl_pertama;
}

if($akhir==''){
  $akhir = $tgl_terakhir;
}

if($awal!='' AND $akhir!=''){
  $cari_tgl = " AND tgl_transaksi BETWEEN '$awal' AND '$akhir'";
}else{
  $cari_tgl = "";
}

?>

<script type="text/javascript" src="assets/js/jquery.min.js"></script>
<!-- <script type="text/javascript" src="assets/js/lap_penjualan.js?d=<?php echo date('YmdHis');?>"></script> -->

<section class="section">
  <div class="row">
    <div class="col-lg-6">
      <div class="card-body">
        <form class="row g-3" name="text" id="tabel_transaksi" enctype="multipart/form-data" class="form-vertical" method="post" action="?menu=lap_penjualan&action=paiegjvagjbekigk">
          <table>
            <tr>
              <td width="150">Range Tanggal</td>
              <td width="15">:</td>
              <td width="300" colspan="6">
                <div class="class row g-3">
                  <div class="col-md-6">
                    <input type="date" class="form-control" id="awal" name="awal" value="<?php echo $awal;?>">
                  </div>
                  <div class="col-md-6">
                    <input type="date" class="form-control" id="akhir" name="akhir" value="<?php echo $akhir;?>">
                  </div>
                </div>
              </td>
              <td colspan="3" align="center"><input type="submit" name="cari" id="cari" value="Cari" class="btn btn-primary btn-sm"></td>
            </tr>
          </table>
        </form>
      </div>
    </div>
    <div class="col-lg-12">

      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Laporan Penjualan Periode Oktober 2022</h5>

          <table class="table">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Tanggal</th>
                <th scope="col">Nomor Transaksi</th>
                <th scope="col">ID Kasir</th>
                <th scope="col">Lokasi</th>
                <!-- <th scope="col">Harga Satuan</th> -->
                <th scope="col">Total</th>
                <th scope="col">QTY</th>
                <th scope="col">Diskon</th>
                <th scope="col">Total Akhir</th>
                <th scope="col">Bayar</th>
                <th scope="col">Kembalian</th>
                <td></td>
              </tr>
            </thead>
            <tbody>
              <?php
                if(isset($_REQUEST['action'])){
                  $sql_daftar_penjualan = "SELECT SUBSTRING(t.no_transaksi,7,3) AS lokasi
                                              , `t`.`no_transaksi`
                                              , `t`.`tgl_transaksi`
                                              , `t`.`id_kasir`
                                              , `t`.`subtotal`
                                              , `t`.`qty`
                                              , `t`.`diskon`
                                              , `t`.`total_akhir`
                                              , `t`.`total_non_cash` 
                                              , `t`.`total_cash`
                                              , `t`.`total_pembayaran`
                                              , `t`.`total_bayar`
                                              , `t`.`kembalian`
                                              , `l`.`nama_lokasi`
                                          FROM `tbl_transaksi` as `t`
                                          LEFT JOIN mst_lokasi as `l` ON SUBSTRING(t.no_transaksi,7,3) = l.id
                                          WHERE tgl_transaksi !='' $cari_tgl";
                    $res_mst_barang = mysqli_query($connect,$sql_daftar_penjualan)or die($sql_daftar_penjualan);
                    while($data=mysqli_fetch_array($res_mst_barang)){
                      $no++;
                      $no_transaksi = $data['no_transaksi'];
                      $nama_lokasi = $data['nama_lokasi'];
                      $total_penjualan = $data['total_penjualan'];
                      $tgl_transaksi = $data['tgl_transaksi'];
                      $id_kasir = $data['id_kasir'];
                      $harga = $data['harga'];
                      $subtotal = $data['subtotal'];
                      $qty = $data['qty'];
                      $diskon = $data['diskon'];
                      $total_akhir = $data['total_akhir'];
                      $bayar = $data['bayar'];
                      $kembalian = $data['kembalian'];
                      $is_aktif = $data['is_aktif'];
                      if($is_aktif==1){
                        $status_penjualan = "Approved";
                      }else{
                        $status_penjualan = "Batal";
                      }
              ?>
              <tr>
                <td><?php echo $no;?></td>
                <td><?php echo $tgl_transaksi;?></td>
                <td><?php echo $no_transaksi;?></td>
                <td><?php echo $id_kasir;?></td>
                <td><?php echo $nama_lokasi;?></td>
                <!-- <td><?php echo number_format($harga);?></td> -->
                <td><?php echo number_format($subtotal);?></td>
                <td><?php echo $qty;?></td>
                <td><?php echo $diskon;?></td>
                <td><?php echo number_format($total_akhir);?></td>
                <td><?php echo number_format($bayar);?></td>
                <td><?php echo number_format($kembalian);?></td>
                <td><span class='btn btn-success btn-sm' onclick="getDetail('<?php echo $no_transaksi;?>')"><i class="bi bi-search"></i></span></td>
              </tr>
              <?php } } ?>
            </tbody>
          </table>
        </div>
      </div>

    </div>
  </div>
</section>