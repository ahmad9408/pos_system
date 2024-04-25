<?php session_start();
  include("config/koneksi.php");
  include("config/lock.php");
  $today = date('Y-m-d H:i:s');
  $todayZ = date('Y-m-d');

  $notrans = $_REQUEST['notrans'];
  $ambil_tgl_transaksi = $_REQUEST['tgl'];
  $nama_lokasi = $_REQUEST['nama_lokasi'];

?>
<script type="text/javascript" src="assets/js/detail_do.js?d=<?php echo date('YmdHis');?>"></script>
<style type="text/css">
  .loader {
    content:" ";
/*    display:block;*/
    position: fixed;
    left: 0px;
    top: 0px;
    width: 100%;
    height: 100%;
    z-index: 9999;
    background: url('assets/img/double-ring.gif') 50% 50% no-repeat;
    opacity: .8;
    animation: spin 2s linear infinite;
  }
</style>

<section class="section">
  <div class="loader"></div>
  <div class="row">
    <div class="col-lg-6">
      <div class="card-body">
        
      </div>
    </div>
    <div class="col-lg-12">

      <div class="card">
        <div class="card-body">
          <!-- <h5 class="card-title">List Data Pengiriman</h5> -->
          <br>
          <table>
            <tr>
              <td width="150">Nomor Surat Jalan</td>
              <td width="15">:</td>
              <td><strong><?php echo $notrans;?></strong></td>
            </tr>
            <tr>
              <td width="150">Lokasi</td>
              <td width="15">:</td>
              <td><strong><?php echo $nama_lokasi;?></strong></td>
            </tr>
            <tr>
              <td width="150">Tanggal Kirim</td>
              <td width="15">:</td>
              <td><strong><?php echo $ambil_tgl_transaksi;?></strong></td>
            </tr>
          </table>
          <br>
          <table class="table table-bordered">
            <thead>
              <tr>
                <th scope="col">#</th>
                <!-- <th scope="col">Nomor Transaksi</th> -->
                <th scope="col">Kode Barang</th>
                <th scope="col">Nama Barang</th>
                <th scope="col">Harga Pokok</th>
                <th scope="col">Harga Jual</th>
                <th scope="col">Qty</th>
                <th scope="col">Tanggal Update</th>
                <th scope="col">Status Terima</th>
              </tr>
            </thead>
            <tbody>
              <?php
                  $sql_daftar_pengiriman = "SELECT
                                              `dd`.`kode_barang`
                                              , `dd`.`nama_barang`
                                              , `dd`.`id_jenis`
                                              , `dd`.`satuan`
                                              , `dd`.`stok`
                                              , `dd`.`harga_pokok`
                                              , `dd`.`harga_jual`
                                              , `dd`.`qty`
                                              , `dd`.`stat`
                                              , `d`.`updatedate`
                                              , `d`.`updateby`
                                              , `d`.`tgl_batal`
                                              , `d`.`user_pembatal`
                                              , `d`.`penerima`
                                              , `d`.`tgl_terima`
                                              , `d`.`stat_terima`
                                              , `l`.`nama_lokasi`
                                          FROM
                                              `tbl_do_detail` AS `dd`
                                              INNER JOIN `tbl_do` AS `d` 
                                                  ON (`dd`.`no_transaksi` = `d`.`no_transaksi`)
                                              INNER JOIN `mst_lokasi` AS `l`
                                                  ON (`d`.`lokasi` = `l`.`id`)
                                          WHERE `d`.`no_transaksi` = '$notrans'";
                  $res_mst_barang = mysqli_query($connect,$sql_daftar_pengiriman)or die($sql_daftar_pengiriman);
                  // echo $sql_daftar_pengiriman;
                  while($data=mysqli_fetch_array($res_mst_barang)){
                    $no++;
                    $invoice = $data['invoice'];
                    $kode_barang = $data['kode_barang'];
                    $nama_barang = $data['nama_barang'];
                    $harga_pokok = $data['harga_pokok'];
                    $harga_jual = $data['harga_jual'];
                    $qty = $data['qty'];
                    $sumqty += $qty;
                    $updatedate = $data['updatedate'];
                    $updateby = $data['updateby'];
                    $tgl_batal = $data['tgl_batal'];
                    $user_pembatal = $data['user_pembatal'];
                    $penerima = $data['penerima'];
                    $tgl_terima = $data['tgl_terima'];
                    $is_aktif = $data['is_aktif'];
                    if($is_aktif==1){
                      $status_pengiriman = "Approved";
                    }else{
                      $status_pengiriman = "Batal";
                    }

                    $stat_terima = $data['stat_terima'];
                    if($stat_terima==0){
                      $status_terima = "Belum diterima";
                    }elseif($stat_terima==1){
                      $status_terima = "Approved";
                    }else{
                      $status_terima = "Tolak";
                    }
              ?>
              <tr>
                <td><?php echo $no;?></td>
                <!-- <td><?php echo $invoice;?></td> -->
                <td><?php echo $kode_barang;?></td>
                <td><?php echo $nama_barang;?></td>
                <td align="left">Rp. <span style="float: right"><?php echo number_format($harga_pokok);?></span></td>
                <td align="left">Rp. <span style="float: right"><?php echo number_format($harga_jual);?></span></td>
                <td align="center"><?php echo $qty;?></td>
                <td><?php echo $updatedate;?></td>
                <td><?php echo $status_terima;?></td>
              </tr>
            <?php } ?>
            </tbody>
          </table>

          <div class="class row g-3">
            <div class="text-center">
              <?php if($stat_terima==0){ ?>
                <?php if($updateby==$session_nik){ ?>
                  <span id="btn_app" onclick="terima_pengiriman()" class="btn btn-primary">Terima</span>
                  <!-- <span id="btn_batal" onclick="batal_pengiriman()" class="btn btn-danger">Batal</span> -->
                  <span id="btn_tolak" onclick="tolak_pengiriman()" class="btn btn-danger">Tolak</span>
                <?php }else{ ?>
                <?php } ?>
              <?php }elseif($stat_terima==1){ ?>
                Diterima tanggal : <?php echo $tgl_terima.' <br>Oleh : '. $penerima;?>
              <?php }elseif($stat_terima==2){ ?>
                Ditolak tanggal : <?php echo $tgl_batal.' <br>Oleh : '. $user_pembatal;?>
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
        <span id="button_simpan" name="button_simpan" class="btn btn-block btn-primary" onclick="proses_pembatalan('<?php echo $notrans;?>')">Proses</span>
        <span id="batal" name="batal" class="btn btn-block btn-danger" onclick="modalTutup()">Kembali</span>

      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="form_terima" tabindex="-1">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">
        Jika Yakin Diterima Klik tombol Proses!.</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" align="center">
        <span id="button_app" name="button_simpan" class="btn btn-block btn-primary" onclick="proses_penerimaan('<?php echo $notrans;?>')">Proses</span>
        <span id="batal_app" name="batal" class="btn btn-block btn-danger" onclick="tutup_form_terima()">Kembali</span>

      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="form_tolak" tabindex="-1">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">
        Jika Yakin Diterima Klik tombol Proses!.</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" align="center">
        <span id="button_tolak" name="button_simpan" class="btn btn-block btn-primary" onclick="proses_penolakan('<?php echo $notrans;?>')">Simpan Penolakan</span>
        <span id="batal_tolak" name="batal" class="btn btn-block btn-danger" onclick="tutup_form_penolakan()">Kembali</span>

      </div>
    </div>
  </div>
</div>