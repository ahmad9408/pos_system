<?php session_start();
  include("config/koneksi.php");
  include("config/lock.php");
  $today = date('Y-m-d H:i:s');
  $todayZ = date('Y-m-d');

if(isset($_REQUEST['action'])){
    $nis=$_POST['nis'];
    $nama=$_POST['nama'];
} else {

}


if($nis!=''){
  $cari_nis = " AND nis='$nis'";
}else{
  $cari_nis = "";
}


if($nama != ""){
  $cari_nama = " AND nama like '%$nama%'";
}else{
  $cari_nama = "";
}

?>

<script type="text/javascript" src="assets/js/jquery.min.js"></script>
<script src="//cdn.rawgit.com/rainabba/jquery-table2excel/1.1.0/dist/jquery.table2excel.min.js"></script>
<script type="text/javascript" src="assets/js/dana_tabungan.js?d=<?php echo date('YmdHis');?>"></script>
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
    background: url('assets/img/double-ring.gif') 50% 50% no-repeat rgb(249,249,249);
    opacity: .8;
    animation: spin 2s linear infinite;
  }
</style>

<section class="section">
  <div class="row">
    <div class="col-lg-6">
      <div class="card-body">
        <form class="row g-3" name="text" id="tabel_tabungan" enctype="multipart/form-data" class="form-vertical" method="post" action="?menu=dana_tabungan&action=lungvukgaxkbcsfd">
          <table>
            <tr>
              <td width="150">NIS</td>
              <td width="15">:</td>
              <td width="300">
                <div class="input-group mb-3">
                  <input type="text" class="form-control" id="nis" name="nis" value="<?php echo $nis;?>">
                  <input type="hidden" class="form-control" id="no_nis" name="no_nis">
                  <input type="hidden" class="form-control" id="nama_req" name="nama_req">
                  <input type="hidden" class="form-control" id="norek" name="norek">
                </div>
              </td>
            </tr>
            <tr>
              <td width="150">Nama</td>
              <td width="15">:</td>
              <td width="300">
                <div class="input-group mb-3">
                  <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $nama;?>">
                </div>
              </td>
            </tr>
            <tr>
              <td colspan="2" align="left"><input type="submit" name="cari" id="cari" value="Cari" class="btn btn-primary btn-sm">
                <span class="btn btn-danger btn-sm" onclick="reset()">Reset</span>
              </td>
            </tr>
          </table>
        </form>
      </div>
    </div>
    <div class="col-lg-12">

      <div class="card">
        <div class="card-body">
          <div class="box-body table-responsive no-padding">
            <h5 class="card-title">Daftar Transaksi Penjualan</h5>
            <?php if(isset($_REQUEST['action'])){ ?>
              <div id="data_master_tabungan"></div>
            <?php } ?>
          </div>
        </div>
      </div>

    </div>
  </div>
  <div id="notifikasi"></div>
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
              <div class="class row col-md-12">
                <div class="col-md-6">
                  <input type="date" class="form-control" id="awal" name="awal" style="width: 250px;">
                </div>
                <div class="col-md-6">
                  <input type="date" class="form-control" id="akhir" name="akhir" style="width: 250px;">
                </div>
              </div>
            </td>
          </tr>
        </table>
        <br><br>
      </div>
      <div class="modal-footer">
        <span id="download_tabungan" onclick="cari_tabungan()" class="btn btn-primary btn-sm">Proses</span>
      </div>
  </div>
</div>