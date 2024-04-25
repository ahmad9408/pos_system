<?php session_start();
  include("config/koneksi.php");
  include("config/lock.php");
  $today = date('Y-m-d H:i:s');
  $todayZ = date('Y-m-d');
  $tgl_pertama = date('Y-m-01', strtotime($todayZ));
  $tgl_terakhir = date('Y-m-t', strtotime($todayZ));

  if(isset($_REQUEST['action'])){
      $awal=$_POST['awal'];
      $akhir=$_POST['akhir'];
      $no_trans=$_POST['no_trans'];
  } else {

  }

  if($awal==''){
    $awal = $tgl_pertama;
  }

  if($akhir==''){
    $akhir = $tgl_terakhir;
  }

  if($awal!='' AND $akhir!=''){
    $cari_tgl = " AND p.tgl_invoice BETWEEN '$awal' AND '$akhir'";
  }else{
    $cari_tgl = "";
  }


  if($no_trans != ""){
    $cari_no_trans = " AND p.invoice = '$no_trans'";
  }else{
    $cari_no_trans = "";
  }

?>

<script type="text/javascript" src="assets/js/jquery.min.js"></script>
<script type="text/javascript" src="assets/js/daftar_pembelian.js?d=<?php echo date('YmdHis');?>"></script>
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
    <div id="loader" class="loader"></div>
    <div class="col-lg-6">
      <div class="card-body">
        <form class="row g-3" name="text" id="tabel_transaksi" enctype="multipart/form-data" class="form-vertical" method="post" action="?menu=daftar_pembelian&action=lagh86253nyvtehr">
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
                    <input type="hidden" class="form-control" id="notrans" name="notrans">
                    <input type="hidden" class="form-control" id="tgl_input" name="tgl_input">
                  </div>
                </div>
              </td>
            </tr>
            <tr>
              <td width="150">No. Transaksi</td>
              <td width="15">:</td>
              <td width="300">
                <div class="input-group mb-3">
                  <input type="text" class="form-control" id="no_trans" name="no_trans" value="<?php echo $no_trans;?>">
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
            <h5 class="card-title">Daftar Pembelanjaan</h5>
            <?php if(isset($_REQUEST['action'])){ ?>
              <div id="tbl_trans_upload_pembelian"></div>
            <?php } ?>

          </div>
        </div>
      </div>
    </div>
  </div>
      <span id="notifikasi"></span>
</section>