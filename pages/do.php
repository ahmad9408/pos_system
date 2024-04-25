<?php session_start();
  include("config/koneksi.php");
  include("config/lock.php");
  
  $today = date('Y-m-d H:i:s');
  $todayZ = date('Y-m-d');
  $tgl_pertama = date('Y-m-01', strtotime($todayZ));
  $tgl_terakhir = date('Y-m-t', strtotime($todayZ));

  if(isset($_REQUEST['action'])){
      $lokasi = $_POST['lokasi'];
      $awal=$_POST['awal'];
      $akhir=$_POST['akhir'];
      $no_transaksi=$_POST['no_transaksi'];
  } else {

  }

  if($lokasi!=''){
    $cari_lokasi = " AND lokasi = '$lokasi'";
  }else{
    $cari_lokasi = "";
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


  if($no_transaksi != ""){
    $cari_no_transaksi = " AND no_transaksi = '$no_transaksi'";
  }else{
    $cari_no_transaksi = "";
  }

?>

<!-- <script type="text/javascript" src="assets/js/jquery.min.js"></script> -->
<script type="text/javascript" src="assets/js/do.js?d=<?php echo date('YmdHis');?>"></script>
<!-- <script type="text/javascript" src="assets/js/format.20110630-1100.min.js"></script>
<script type="text/javascript" src="assets/js/jquery_currency_input.js"></script> -->
<script type="text/javascript" src="assets/js/notifikasi.js?d=<?php echo date('YmdHis');?>"></script>
<style type="text/css">
  .loader {
    content:" ";
    display:block;
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
  <div class="row">
    <div class="col-lg-6">
      <div class="loader"></div>
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Daftar Pengiriman Barang</h5>
          <form class="row g-3" name="text" id="tabel_transaksi" enctype="multipart/form-data" class="form-vertical" method="post" action="?menu=do&action=anyeurydbdxnjy">
            <table>
            <tr>
              <td width="150">Range Tanggal</td>
              <td width="15">:</td>
              <td width="300" colspan="6">
                <div class="input-group mb-3 class row g-3">
                  <div class="col-md-5">
                    <input type="text" class="form-control" id="awal" name="awal" value="<?php echo $awal;?>">
                  </div>
                  <div class="col-md-2" align="center">
                    s / d
                  </div>
                  <div class="col-md-5">
                    <input type="text" class="form-control" id="akhir" name="akhir" value="<?php echo $akhir;?>">
                    <input type="hidden" class="form-control" id="notrans" name="notrans">
                    <input type="hidden" class="form-control" id="tgl" name="tgl">
                    <input type="hidden" class="form-control" id="nama_lokasi" name="nama_lokasi">
                    <input type="hidden" class="form-control" id="id_lokasi" name="id_lokasi" value="<?php echo $session_lokasi;?>">
                  </div>
                </div>
              </td>
            </tr>
            <tr>
              <td width="150">No. Transaksi</td>
              <td width="15">:</td>
              <td width="300">
                <div class="input-group mb-3">
                  <input type="text" class="form-control" id="no_transaksi" name="no_transaksi" value="<?php echo $no_transaksi;?>">
                </div>
              </td>
            </tr>
            <tr>
              <td width="150">Lokasi</td>
              <td width="15">:</td>
              <td width="300">
                <div class="input-group mb-3">
                  <select id="lokasi" name="lokasi" class="form-select" value="<?php echo $lokasi;?>">
                    <option value=""></option>
                      <?php         
                        $qrylokasi = "SELECT id, nama_lokasi FROM mst_lokasi WHERE status !='0'";
                        eval("\$sql_cari_lokasi=\"$qrylokasi\";");
                        $result = mysqli_query($connect,$sql_cari_lokasi);
                        while($r=mysqli_fetch_array($result)){
                      ?>
                        <option value="<?php echo $r['id']?>">
                          <?php 
                            echo $r['nama_lokasi'] 
                          ?>
                        </option>
                      <?php
                        }
                      ?>
                  </select>
                </div>
              </td>
            </tr>
            <tr>
              <td colspan="3" align="left">
                <input type="submit" name="cari" id="cari" value="Cari" class="btn btn-primary btn-sm">
                <span class="btn btn-danger btn-sm" onclick="reset()">Reset</span> 
                  <span style="float: right;" class="btn btn-success btn-sm" onclick="buka_form_pencarian_pengiriman()"> Download Pengiriman <i class="bi bi-download"></i></span>
              </td>
            </tr>
          </table>
            
          </form>
        </div>
      </div>
    </div>

    <div class="col-lg-12" id="table_master">
      <div class="card">
        <div class="card-body">
          <div class="box-body table-responsive no-padding">
            <br>
            
              
            
            <br>
            <br>
            <?php if(isset($_REQUEST['action'])){ ?> 
              <div id="tbl_do"></div>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>
    </div>
    <div id="notifikasi"></div>
  </div>
</section>

<div class="modal fade" id="konfirmasi_edit" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">
        Jika Yakin Klik tombol Proses!.</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" align="center">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th scope="col">Kode Barang</th>
              <th scope="col">Nama Barang</th>
              <th scope="col">Satuan</th>
              <th scope="col">Harga Pokok</th>
              <th scope="col">Harga Jual</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td><input type="text" id="kode_barang_edit" class="form-control"></td>
              <td><input type="text" id="nama_barang_edit" class="form-control"></td>
              <td id="satuan_edit"></td>
              <td>
               <!--  <select class="form-select" name="satuan_edit" id="satuan_edit">
                  <option value=""></option>
                  <?php         
                    $qrylokasi = "SELECT id, satuan FROM tbl_satuan WHERE status ='1'";
                    eval("\$sql_cari_lokasi=\"$qrylokasi\";");
                    $result = mysqli_query($connect,$sql_cari_lokasi);
                    while($r=mysqli_fetch_array($result)){
                  ?>
                    <option value="<?php echo $r['id']?>">
                      <?php 
                        echo $r['satuan'];
                      ?>
                    </option>
                  <?php
                    }
                  ?>
                </select> -->
              </td>
              <td><input type="text" id="harga_pokok_edit" class="form-control"></td>
              <td><input type="text" id="harga_jual_edit" class="form-control"></td>
            </tr>
          </tbody>
        </table>
        <span id="button_simpan" name="button_simpan" class="btn btn-block btn-primary" onclick="proses_edit()">Proses</span>
        <span id="batal" name="batal" class="btn btn-block btn-danger" onclick="modalTutup()">Batal</span>

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
            <td colspan="6">
              <div class="input-group mb-3 class row col-md-12">
                <div class="col-md-5">
                  <input type="text" class="form-control" id="awal_download" name="awal_download" style="width: 250px;">
                </div>
                <div class="col-md-2" align="center">
                  <p>s / d</p>
                </div>
                <div class="col-md-5">
                  <input type="text" class="form-control" id="akhir_download" name="akhir_download" style="width: 250px;">
                </div>
              </div>
            </td>
          </tr>
        </table>
        <br><br>
      </div>
      <div class="modal-footer">
        <span id="download_pengiriman" onclick="cari_pengiriman()" class="btn btn-primary btn-sm">Proses</span>
      </div>
  </div>
</div>

<script>
  var satuan_edit="<?php echo $satuan_?>";
</script>