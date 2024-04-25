<?php session_start();
  include("config/koneksi.php");
  include("config/lock.php");
  $today = date('Y-m-d H:i:s');
  $todayZ = date('Y-m-d');

  if(isset($_REQUEST['action'])){
      $nama_jenis = $_POST['nama_jenis'];
  } else {

  }

  if($nama_jenis!=''){
    $cari_nama_jenis = " AND nama_jenis like '%$nama_jenis%'";
  }else{
    $cari_nama_barang = "";
  }

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
          <h5 class="card-title">Master Jenis Barang</h5>
          <span style="float: left;" class="btn btn-success btn-sm" onclick="buka_form_pencarian_jenis()"> Download Jenis Baru <i class="bi bi-download"></i></span>
          <!-- <span id="but_input" style="float: right" class="btn btn-warning btn-sm" onclick="buka_form_input()">Tambah Master Barang</span> -->
          <!-- <span id="but_cancel" style="float: right" class="btn btn-danger btn-sm" onclick="tutup_form_input()">Tutup Inputan</span> -->
        </div>
      </div>
    </div>

    <!-- untuk aplikasi offline -->
    <!-- <div class="col-lg-4">

      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Master Jenis Barang</h5>

            <div class="row mb-3">
              <label for="inputEmail" class="col-sm-3 col-form-label">Jenis</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" id="nama_jenis" name="nama_jenis">
              </div>
            </div>
            
            <div class="mb-3">
              <div class="col-sm-12">
                <span id="submit" name="submit" class="btn btn-block btn-primary" onclick="simpan()">Tambah</span>
              </div>
            </div>
        </div>
      </div>

    </div> -->

    <div class="col-lg-12">
      <div class="card" >
        <div class="card-body">
          <h5 class="card-title"></h5>
          <table class="table datatable">
            <thead>
              <tr>
                <!-- <th scope="col">#</th> -->
                <th scope="col">ID</th>
                <th scope="col">Jenis Barang</th>
              </tr>
            </thead>
            <tbody>
              <?php
                $sql_master_barang = "SELECT
                                        `id`,
                                        `jenis_barang`,
                                        `is_aktif`,
                                        `updatedate`,
                                        `updateby`
                                      FROM `tbl_mst_jenis_barang`
                                      WHERE id!=''";
                $res_master_barang = mysqli_query($connect,$sql_master_barang);
                while($data=mysqli_fetch_array($res_master_barang)){
                  $no++;
                  // echo $sql_master_barang;
              ?>
              <tr>
                <!-- <td><?php echo $no;?></td> -->
                <td><?php echo $data['id'];?></td>
                <td><?php echo $data['jenis_barang'];?></td>
                <!-- <td colspan="2">
                  <span class="btn btn-warning btn-sm" id="edit" name="edit" onclick="edit_data('<?php echo $data[id];?>','<?php echo $data['jenis_barang'];?>')"><i class="bi bi-pencil-square"></i></span>
                  <span class="btn btn-danger btn-sm" id="hapus" name="hapus"><i class="bi bi-trash-fill"></i></span>
                </td> -->
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

<div class="modal fade" id="konfirmasi_edit_jenis" tabindex="-1">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">
        Jika  Yakin Klik tombol Proses!.</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" align="center">
        <input type="hidden" class="form-control" id="id_edit" name="id_edit">
        <input type="text" class="form-control" id="nama_jenis_edit" name="nama_jenis_edit">

      </div>
      <div class="modal-footer">
        <span id="button_simpan" name="button_simpan" class="btn btn-block btn-primary" onclick="proses_edit_jenis()">Proses</span>
        <span id="batal" name="batal" class="btn btn-block btn-danger" onclick="tutup_edit()">Batal</span>
      </div>
    </div>
  </div>
</div>

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