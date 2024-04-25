<?php session_start();
  include("config/koneksi.php");
  include("config/lock.php");
  $today = date('Y-m-d H:i:s');
  $todayZ = date('Y-m-d');
  $tgl_pertama = date('Y-m-01', strtotime($todayZ));
  $tgl_terakhir = date('Y-m-t', strtotime($todayZ));
  
if(isset($_REQUEST['action'])){
    $tgl_awal=$_POST['tgl_awal'];
    $tgl_akhir=$_POST['tgl_akhir'];
    $no_transaksi=$_POST['no_transaksi'];
} else {

}

if($tgl_awal==''){
  $tgl_awal = $tgl_pertama;
}

if($tgl_akhir==''){
  $tgl_akhir = $tgl_terakhir;
}

if($tgl_awal!='' AND $tgl_akhir!=''){
  $cari_tgl = " AND tgl_transaksi BETWEEN '$tgl_awal' AND '$tgl_akhir'";
}else{
  $cari_tgl = "";
}

// if($awal!=''){
//   $cari_tgl = " AND tgl_transaksi = '$awal'";
// }


if($no_transaksi != ""){
  $cari_no_transaksi = " AND no_transaksi = '$no_transaksi'";
}else{
  $cari_no_transaksi = "";
}

?>

<script type="text/javascript" src="assets/js/jquery.min.js"></script>
<!-- <script src="//cdn.rawgit.com/rainabba/jquery-table2excel/1.1.0/dist/jquery.table2excel.min.js"></script> -->
<script type="text/javascript" src="assets/js/force_upload.js?d=<?php echo date('YmdHis');?>"></script>
<script type="text/javascript" src="assets/js/notifikasi.js?d=<?php echo date('YmdHis');?>"></script>
<script src="assets/js/jquery.table2excel.min.js"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.3/moment.min.js"></script> -->

<!-- datepicker -->


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

  .tm {
        position: relative;
        /*width: 150px; height: 20px;*/
        /*color: white;*/
        
        display: block;
        width: 100%;
        height: 2.4rem;
        padding: .375rem .75rem;
        font-size: 1rem;
        line-height: 1.5;
        color: #495057;
        background-color: #fff;
        background-clip: padding-box;
        border: 1px solid #ced4da;
        border-radius: .25rem;
        box-shadow: inset 0 0 0 transparent;
        transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
        align-content: center;
    }

    .tm:before {
        position: absolute;
        top: 10px; left: 3px;
        content: attr(data-date);
        display: block;
        color: #495057;
    }

    .tm::-webkit-datetime-edit, .tm::-webkit-inner-spin-button, .tm::-webkit-clear-button {
        display: none;
    }

    .tm::-webkit-calendar-picker-indicator {
        position: absolute;
        top: 10px;
        right: 0;
        color: #495057;
    }
</style>
<section class="section">
  <div id="loader" class="loader"></div>
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          <br>
            <form class="row g-3" name="text" id="tabel_transaksi" enctype="multipart/form-data" class="form-vertical" method="post" action="?menu=force_upload&action=yaynesbhsyver">
              <table>
                <tr>
                  <td width="150">Range Tanggal</td>
                  <td width="15">:</td>
                  <td width="300" colspan="6">
                    <div class="class row g-3">
                      <div class="col-md-2">
                        <input type="text" class="form-control" placeholder="yyyy-dd-mm" id="tgl_awal" name="tgl_awal" value="<?php echo $tgl_awal;?>" value="<?php echo $awal;?>">
                      </div>
                      <div class="col-md-1" align="center">
                        s/d
                      </div>
                      <div class="col-md-2">
                        <input type="text" class="form-control" placeholder="yyyy-dd-mm" id="tgl_akhir" name="tgl_akhir" value="<?php echo $tgl_akhir;?>">
                        <input type="hidden" class="form-control" id="notrans" name="notrans">
                      </div>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td align="left"><input type="submit" name="cari" id="cari" value="Cari" class="btn btn-primary btn-sm">
                  </td>
                </tr>
              </table>
            </form>
        </div>
      </div>
    </div>
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          <div class="box-body table-responsive no-padding">
            <h5 class="card-title">Daftar Transaksi Penjualan (FORCE UPLOAD)</h5>
            <?php if(isset($_REQUEST['action'])){ ?>
              <div id="tbl_trans_upload"></div>
            <?php } ?>
          </div>
        </div>
      </div>

    </div>
  </div>
  <span id="notifikasi"></span>
</section>