<?php session_start();
  include("config/koneksi.php");
  include("config/lock.php");
  $today = date('Y-m-d H:i:s');
  $todayZ = date('Y-m-d');

  $invoice = $_REQUEST['notrans'];
  $tgl_input = $_REQUEST['tgl_input'];

?>
<script type="text/javascript" src="assets/js/detail_pembelian.js?d=<?php echo date('YmdHis');?>"></script>

<section class="section">
  <div class="row">
    <div class="col-lg-6">
      <div class="card-body">
        
      </div>
    </div>
    <div class="col-lg-12">

      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Daftar Transaksi Pembelanjaan</h5>
          <h5>Nomor Invoice : <strong><?php echo $invoice;?></strong></h5>
          <h5>Tanggal : <strong><?php echo $tgl_input;?></strong></h5>
          <table class="table table-bordered">
            <thead>
              <tr align="center">
                <th scope="col">#</th>
                <!-- <th scope="col">Nomor Transaksi</th> -->
                <th scope="col">Kode Barang</th>
                <th scope="col">Nama Barang</th>
                <th scope="col">Qty</th>
                <th scope="col">Harga Pokok</th>
                <th scope="col">Harga Jual</th>
              </tr>
            </thead>
            <tbody>
              <?php
                  $sql_daftar_pembelian = "SELECT
                                              `d`.`invoice`
                                              , `d`.`kode_barang`
                                              , `d`.`nama_barang`
                                              , `d`.`harga_pokok`
                                              , `d`.`harga_jual`
                                              , `d`.`qty`
                                              , `d`.`updatedate`
                                              , `d`.`updateby`
                                              , `p`.`tgl_batal`
                                              , `p`.`user_pembatal`
                                              , `p`.`is_aktif`
                                          FROM
                                              `tbl_pembelian` AS `p`
                                          INNER JOIN `tbl_pembelian_detail` AS `d` ON (`p`.`invoice` = `d`.`invoice`)
                                          WHERE `d`.`invoice` = '$invoice'";
                  $res_mst_barang = mysqli_query($connect,$sql_daftar_pembelian)or die($sql_daftar_pembelian);
                  while($data=mysqli_fetch_array($res_mst_barang)){
                    $no++;
                    $invoice = $data['invoice'];
                    $kode_barang = $data['kode_barang'];
                    $nama_barang = $data['nama_barang'];
                    $harga_pokok = $data['harga_pokok'];
                    $sum_harga_pokok += $data['harga_pokok'];
                    $harga_jual = $data['harga_jual'];
                    $sum_harga_jual += $data['harga_jual'];
                    $qty = $data['qty'];
                    $sum_qty += $data['qty'];
                    $sumqty += $qty;
                    $updatedate = $data['updatedate'];
                    $updateby = $data['updateby'];
                    $tgl_batal = $data['tgl_batal'];
                    $user_pembatal = $data['user_pembatal'];
                    $is_aktif = $data['is_aktif'];
                    if($is_aktif==1){
                      $status_pembelian = "Approved";
                    }else{
                      $status_pembelian = "Batal";
                    }
              ?>
              <tr>
                <td align="center"><?php echo $no;?></td>
                <!-- <td><?php echo $invoice;?></td> -->
                <td><?php echo $kode_barang;?></td>
                <td><?php echo $nama_barang;?></td>
                <td align="center"><?php echo $qty;?></td>
                <td align="left">Rp. <span style="float: right"><?php echo number_format($harga_pokok);?></span></td>
                <td align="left">Rp. <span style="float: right"><?php echo number_format($harga_jual);?></span></td>
              </tr>
            <?php } ?>
            </tbody>
            <tfoot>
              <tr>
                <td colspan="3" align="center"><strong>Total</strong></td>
                <td align="center"><strong><?php echo $sum_qty;?></strong></td>
                <td align="left"><strong>Rp. <span style="float: right;"><?php echo number_format($sum_harga_pokok);?></span></strong></td>
                <td align="left"><strong>Rp. <span style="float: right;"><?php echo number_format($sum_harga_jual);?></span></strong></td>
              </tr>
            </tfoot>
          </table>

          <div class="class row g-3">
            <div class="text-center">
              <?php
                $sql_stok_gudang = "SELECT SUM(stok) AS jumlah_stok_gudang FROM `tbl_stok_gudang` 
                                    WHERE `invoice` = '$invoice'";
                $res_stok_gudang = mysqli_query($connect,$sql_stok_gudang)or die($sql_stok_gudang);
                list($jumlah_stok_gudang)=mysqli_fetch_array($res_stok_gudang);
              ?>
              <?php if(($is_aktif==1)&&($jumlah_stok_gudang==$sumqty)){ ?>
                <!-- <?php echo $sql_stok_gudang.'-'.$jumlah_stok_gudang.'-'.$sumqty;?> -->
              <span id="btn_batal" onclick="batal_pembelian()" class="btn btn-danger">Batal</span>
              <?php }else{ ?>
                Dibatalkan tanggal : <?php echo $tgl_batal.' <br>Oleh : '. $user_pembatal;?>
              <?php } ?>
            </div>
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
        <span id="button_simpan" name="button_simpan" class="btn btn-block btn-primary" onclick="proses_pembatalan('<?php echo $invoice;?>')">Proses</span>
        <span id="batal" name="batal" class="btn btn-block btn-danger" onclick="modalTutup()">Kembali</span>

      </div>
    </div>
  </div>
</div>