<?php session_start();
  include("config/koneksi.php");
  include("config/lock.php");
  $today = date('Y-m-d H:i:s');
  $todayZ = date('Y-m-d');

  $no_transaksi = $_REQUEST['notrans'];

?>
<script type="text/javascript" src="assets/js/detail_transaksi.js?d=<?php echo date('YmdHis');?>"></script>

<section class="section">
  <div class="row">
    <div class="col-lg-6">
      <div class="card-body">
        
      </div>
    </div>
    <div class="col-lg-12">

      <div class="card">
        <div class="card-body">
          <div class="box-body table-responsive no-padding">
            <h5 class="card-title">Daftar Transaksi Penjualan</h5>

            <table class="table">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Nomor Transaksi</th>
                  <th scope="col">Tanggal</th>
                  <th scope="col">ID Kasir</th>
                  <th scope="col">Kode Barang</th>
                  <th scope="col">Nama Barang</th>
                  <th scope="col">Harga</th>
                  <th scope="col">Stok</th>
                  <th scope="col">Qty</th>
                  <th scope="col">Total</th>
                  <th scope="col">Tanggal Update</th>
                </tr>
              </thead>
              <tbody>
                <?php
                    $sql_daftar_penjualan = "SELECT
                                                    `t`.`no_transaksi`
                                                    , `t`.`tgl_transaksi`
                                                    , `t`.`id_kasir`
                                                    , `t`.`tgl_batal`
                                                    , `t`.`user_pembatal`
                                                    , `t`.`lokasi`
                                                    , `d`.`kode_barang`
                                                    , `d`.`nama_barang`
                                                    , `d`.`harga`
                                                    , `d`.`stok`
                                                    , `d`.`qty`
                                                    , `d`.`total`
                                                    , `d`.`stat`
                                                    , `d`.`updatedate`
                                                    , `d`.`updateby`
                                                    , `t`.`is_aktif`
                                                FROM
                                                    `tbl_transaksi` AS `t`
                                                    INNER JOIN `tbl_transaksi_detail` AS `d` 
                                                        ON (`t`.`no_transaksi` = `d`.`no_transaksi`)
                                                WHERE `t`.`no_transaksi` = '$no_transaksi'";
                    $res_mst_barang = mysqli_query($connect,$sql_daftar_penjualan)or die($sql_daftar_penjualan);
                    // echo $sql_daftar_penjualan;
                    while($data=mysqli_fetch_array($res_mst_barang)){
                      $no++;
                      $no_transaksi = $data['no_transaksi'];
                      $tgl_transaksi = $data['tgl_transaksi'];
                      $id_kasir = $data['id_kasir'];
                      $kode_barang = $data['kode_barang'];
                      $nama_barang = $data['nama_barang'];
                      $harga = $data['harga'];
                      $stok = $data['stok'];
                      $qty = $data['qty'];
                      $total = $data['total'];
                      $stat = $data['stat'];
                      $bayar = $data['bayar'];
                      $kembalian = $data['kembalian'];
                      $updatedate = $data['updatedate'];
                      $updateby = $data['updateby'];
                      $tgl_batal = $data['tgl_batal'];
                      $user_pembatal = $data['user_pembatal'];
                      $lokasi = $data['lokasi'];
                      $is_aktif = $data['is_aktif'];
                      if($is_aktif==1){
                        $status_penjualan = "Approved";
                      }else{
                        $status_penjualan = "Batal";
                      }
                ?>
                <tr>
                  <td><?php echo $no;?></td>
                  <td><?php echo $no_transaksi;?></td>
                  <td><?php echo $tgl_transaksi;?></td>
                  <td><?php echo $id_kasir;?></td>
                  <td><?php echo $kode_barang;?></td>
                  <td><?php echo $nama_barang;?></td>
                  <td><?php echo number_format($harga);?></td>
                  <td><?php echo $stok;?></td>
                  <td><?php echo $qty;?></td>
                  <td><?php echo number_format($total);?></td>
                  <td><?php echo $updatedate;?></td>
                </tr>
              <?php } ?>
              </tbody>
            </table>

            <div class="class row g-3">
              <div class="text-center">
                <?php if($is_aktif==1){ ?>
                <span id="btn_batal" onclick="batal_penjualan()" class="btn btn-danger">Batal</span>
                <?php }else{ ?>
                  Dibatalkan tanggal : <?php echo $tgl_batal.'<br> Oleh : '. $user_pembatal;?>
                <?php } ?>
              </div>
            </div>
            <br><br>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>

<div class="modal fade" id="form_pembatal" tabindex="-1">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">
        Jika  Yakin Klik tombol Proses!.</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" align="center">
        <span id="button_simpan" name="button_simpan" class="btn btn-block btn-primary" onclick="proses_pembatalan('<?php echo $no_transaksi;?>','<?php echo $tgl_transaksi;?>','<?php echo $session_nik;?>','<?php echo $today;?>','<?php echo $lokasi;?>')">Proses</span>
        <span id="batal" name="batal" class="btn btn-block btn-danger" onclick="modalTutup()">Kembali</span>

      </div>
    </div>
  </div>
</div>