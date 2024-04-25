<?php session_start();
  include("config/koneksi.php");
  include("config/lock.php");
  $today = date('Y-m-d H:i:s');
  $todayZ = date('Y-m-d');

?>

<script type="text/javascript" src="assets/js/jquery.min.js"></script>
<script type="text/javascript" src="assets/js/mst_jenis_barang.js?d=<?php echo date('YmdHis');?>"></script>
<script type="text/javascript" src="assets/js/format.20110630-1100.min.js"></script>
<script type="text/javascript" src="assets/js/jquery_currency_input.js"></script>
<script type="text/javascript" src="assets/js/notifikasi.js?d=<?php echo date('YmdHis');?>"></script>

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
    background: url('img/double-ring.gif') 50% 50% no-repeat;
    opacity: 0.8;
    animation: spin 2s linear infinite;
  }
</style>

<section class="section">
  <div id="loader" class="loader"></div>
  <!-- <div class="row"> -->
    <div class="col-lg-12">

      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Master Warna</h5>
          <span style="float: left;" class="btn btn-success btn-sm" onclick="buka_form_pencarian_jenis()"> Download Warna Baru <i class="bi bi-download"></i></span>
        </div>
      </div>
    </div>

    <div class="col-lg-12">
      <div class="card" >
        <div class="card-body">
          <h5 class="card-title"></h5>
          <table class="table datatable">
            <thead>
              <tr>
                <th scope="col">ID</th>
                <th scope="col">Warna</th>
              </tr>
            </thead>
            <tbody>
              <?php
                $sql_master_barang = "SELECT
                                        `id_warna`,
                                        `nama_warna`,
                                        `is_aktif`,
                                        `updatedate`,
                                        `updateby`
                                      FROM `tbl_mst_warna`
                                      WHERE id_warna!=''";
                $res_master_barang = mysqli_query($connect,$sql_master_barang);
                while($data=mysqli_fetch_array($res_master_barang)){
                  $no++;
                  // echo $sql_master_barang;
              ?>
              <tr>
                <td><?php echo $data['id_warna'];?></td>
                <td><?php echo $data['nama_warna'];?></td>
                
              </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <div align="center" id="notifikasi"></div>
  <!-- </div> -->
</section>

<div class="modal fade" id="form_pencarian" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop='static'>
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Pilih tanggal untuk proses pencarian</h5>
        <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
      </div>
      <div class="modal-body">
        <table>
          <tr>
            <td width="150">Range Tanggal</td>
            <td width="15">:</td>
            <td colspan="4">
              <div class="input-group mb-3 class row col-md-12">
                <div class="col-md-5">
                  <input type="text" class="form-control" id="awal_download" name="awal_download" placeholder="tanggal awal" style="width: 250px;">
                </div>
                <div class="col-md-2" align="center">
                  s / d
                </div>
                <div class="col-md-5">
                  <input type="text" class="form-control" id="akhir_download" name="akhir_download" placeholder="tanggal akhir" style="width: 250px;">
                </div>
              </div>
            </td>
          </tr>
        </table>
        <br><br>
      </div>
      <div class="modal-footer">
        <span id="download_pengiriman" onclick="cari_jenis_baru()" class="btn btn-primary btn-sm">Proses</span>
      </div>
  </div>
</div>