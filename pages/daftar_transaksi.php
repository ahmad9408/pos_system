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
    $no_transaksi=$_POST['no_transaksi'];
    $status_transaksi=$_POST['status_transaksi'];
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


if($no_transaksi != ""){
  $cari_no_transaksi = " AND no_transaksi = '$no_transaksi'";
}else{
  $cari_no_transaksi = "";
}

if($status_transaksi != ""){
  $cari_status_transaksi = " AND is_aktif = '$status_transaksi'";
}else{
  $cari_status_transaksi = "";
}

?>

<script type="text/javascript" src="assets/js/jquery.min.js"></script>
<!-- <script src="//cdn.rawgit.com/rainabba/jquery-table2excel/1.1.0/dist/jquery.table2excel.min.js"></script> -->
<script type="text/javascript" src="assets/js/daftar_transaksi.js?d=<?php echo date('YmdHis');?>"></script>
<script src="assets/js/jquery.table2excel.min.js"></script>
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
  <div class="row">
    <div class="col-lg-6">
      <div class="card">
        <div class="card-body">
          <br>
          <form class="row g-3" name="text" id="tabel_transaksi" enctype="multipart/form-data" class="form-vertical" method="post" action="?menu=daftar_transaksi&action=lagh86253nyvtehr">
            <table>
              <tr>
                <td width="150">Range Tanggal</td>
                <td width="15">:</td>
                <td width="300" colspan="6">
                  <div class="class row g-3">
                    <div class="col-md-4">
                      <input type="text" class="form-control" placeholder="yyyy-dd-mm" id="awal" name="awal" value="<?php echo $awal;?>">
                    </div>
                    <div class="col-md-4" align="center">
                      s/d
                    </div>
                    <div class="col-md-4">
                      <input type="text" class="form-control" placeholder="yyyy-dd-mm" id="akhir" name="akhir" value="<?php echo $akhir;?>">
                      <input type="hidden" class="form-control" id="notrans" name="notrans">
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
                <td width="150">Status Transaksi</td>
                <td width="15">:</td>
                <td width="300">
                  <div class="input-group mb-3">
                    <select id="status_transaksi" name="status_transaksi" class="form-select" value="<?php echo $status_transaksi;?>">
                      <option value=""></option>
                        <?php         
                          $qrystat = "SELECT id, nama FROM tbl_status_transaksi WHERE is_aktif = 1";
                          eval("\$sql_cari_stat=\"$qrystat\";");
                          $result = mysqli_query($connect,$sql_cari_stat);
                          while($r=mysqli_fetch_array($result)){
                        ?>
                          <option value="<?php echo $r['id']?>"
                            <?php 
                              if($status_transaksi==$r['id']){
                                echo"selected";}?>>
                            <?php 
                              echo $r['nama'];
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
                <td colspan="2" align="left"><input type="submit" name="cari" id="cari" value="Cari" class="btn btn-primary btn-sm">
                  <span class="btn btn-danger btn-sm" onclick="reset()">Reset</span>
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
            <h5 class="card-title">Daftar Transaksi Penjualan</h5>
            <?php if(isset($_REQUEST['action'])){ ?>
            <span id="p" name="p" class="btn btn-warning btn-sm" onclick="window.location.href='?menu=force_upload'">Force Upload <i class="bi bi-upload"></i></span>
            <span style="float: right;" id="export" class="btn btn-success"> ekspor excel <i class="bi bi-file-earmark-excel"></i></span>
            <br>
            <br>
            <table class="table table-bordered table-hover table-striped Table2Excel datatable" id="tbl_trans">
              <thead>
                <tr align="center">
                  <th scope="col">#</th>
                  <th scope="col">Tanggal</th>
                  <th scope="col">Nomor Transaksi</th>
                  <th scope="col">ID Kasir</th>
                  <th scope="col">Total<br>QTY</th>
                  <th scope="col">Total<br>Harga</th>
                  <th scope="col">Diskon</th>
                  <th scope="col">Total Akhir</th>
                  <th scope="col">Total Non Cash</th>
                  <th scope="col">Total Cash</th>
                  <th scope="col">Total Yang Harus di Bayar</th>
                  <th scope="col">Total Bayar</th>
                  <th scope="col">Kembalian</th>
                  <th scope="col">Status</th>
                  <th scope="col">Tanggal Batal</th>
                  <th scope="col">Status Upload</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <?php
                  
                    $sql_daftar_penjualan = "SELECT
                                              `no_transaksi`
                                              , `tgl_transaksi`
                                              , `id_kasir`
                                              , `subtotal`
                                              , `qty`
                                              , `diskon`
                                              , `total_akhir`
                                              , `total_non_cash` 
                                              , `total_cash`
                                              , `total_pembayaran`
                                              , `total_bayar`
                                              , `kembalian`
                                              , `updatedate`
                                              , `tgl_batal`
                                              , `is_aktif`
                                              , `is_upload`
                                              , `tgl_upload`
                                          FROM
                                              `tbl_transaksi`
                                          WHERE no_transaksi != '' $cari_tgl $cari_no_transaksi $cari_status_transaksi
                                          ORDER BY updatedate DESC";

                    $res_mst_barang = mysqli_query($connect,$sql_daftar_penjualan);
                    if($session_id_group==1){
                      // echo $sql_2;
                    }
                    while($data=mysqli_fetch_array($res_mst_barang)){
                      $no++;
                      $no_transaksi = $data['no_transaksi'];
                      $tgl_transaksi = $data['tgl_transaksi'];
                        $ambil_tgl_transaksi = date("d M Y",strtotime($tgl_transaksi));
                      $id_kasir = $data['id_kasir'];
                      $subtotal = $data['subtotal'];
                      $qty = $data['qty'];
                      $diskon = $data['diskon'];
                      $total_akhir = $data['total_akhir'];
                      $total_non_cash = $data['total_non_cash'];
                      $total_cash = $data['total_cash'];
                      $total_pembayaran = $data['total_pembayaran'];
                      $total_bayar = $data['total_bayar'];
                      $kembalian = $data['kembalian'];
                      $updatedate = $data['updatedate'];
                      $tgl_batal = $data['tgl_batal'];
                      $is_aktif = $data['is_aktif'];
                      $is_upload = $data['is_upload'];
                      $tgl_upload = $data['tgl_upload'];
                        $tgl_upload = date("d M Y H:i:s",strtotime($tgl_upload));
                      if($is_aktif==1){
                        $status_penjualan = "Approved";
                      }else{
                        $status_penjualan = "Batal";
                      }

                      if($is_upload==1){
                        $status_upload = "Sudah Upload";
                        $ambil_tgl_upload = $tgl_upload;
                      }else{
                        $status_upload = "Belum di Upload";
                        $ambil_tgl_upload = '';
                      }
                ?>
                <tr>
                  <td align="center"><?php echo $no;?></td>
                  <td align="center"><?php echo $ambil_tgl_transaksi;?></td>
                  <td align="center"><?php echo $no_transaksi;?></td>
                  <td align="center"><?php echo $id_kasir;?></td>
                  <td align="center"><?php echo $qty;?></td>
                  <td align="left">Rp. <span style="float: right"><?php echo number_format($subtotal);?></span></td>
                  <td align="center"><?php echo $diskon;?></td>
                  <td align="left">Rp. <span style="float: right"><?php echo number_format($total_akhir);?></span></td>
                  <td align="left">Rp. <span style="float: right"><?php echo number_format($total_non_cash);?></span></td>
                  <td align="left">Rp. <span style="float: right"><?php echo number_format($total_cash);?></span></td>
                  <td align="left">Rp. <span style="float: right"><?php echo number_format($total_pembayaran);?></span></td>
                  <td align="left">Rp. <span style="float: right"><?php echo number_format($total_bayar);?></span></td>
                  <td align="left">Rp. <span style="float: right"><?php echo number_format($kembalian);?></span></td>
                  <!-- <td><?php echo $updatedate;?></td> -->
                  <td align="center"><?php echo $status_penjualan;?></td>
                  <td align="center"><?php echo $tgl_batal;?></td>
                  <td align="center"><?php echo $status_upload.' <br> '.$ambil_tgl_upload;?></td>
                  <td colspan="2">
                    <span class='btn btn-success btn-sm' onclick="getDetail('<?php echo $no_transaksi;?>')" style="float: left;"><i class="bi bi-search"></i></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <!-- <a href="pages/print_out_trans.php?notrans=<?php echo $no_transaksi;?>&id_kasir=<?php echo $id_kasir;?>" class="btn btn-warning btn-sm" target="_blank"><i class="bi bi-printer"></i></a> -->

                    <span class="btn btn-warning btn-sm" id="print" name="print" style="float: right;" onclick="print_out('<?php echo $no_transaksi;?>','<?php echo $id_kasir;?>')"><i class="bi bi-printer"></i></span>
                    <!-- <span class="btn btn-danger btn-sm" id="hapus" name="hapus"><i class="bi bi-trash-fill"></i></span> -->
                  </td>
                </tr>
              <?php } ?>
              </tbody>
            </table>
            <?php } ?>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>
