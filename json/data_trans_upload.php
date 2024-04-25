<?php session_start();
  include("../config/koneksi.php");
  include("../config/lock.php");

  $today = date('Y-m-d H:i:s');
  $todayZ = date('Y-m-d');

  // if(isset($_REQUEST['action'])){
      $awal=$_REQUEST['awal'];
      $akhir=$_REQUEST['akhir'];
      // $no_transaksi=$_POST['no_transaksi'];
  // } else {
// 
  // }

  if($awal==''){
    // $awal = date("Y-m-d");
  }

  if($akhir==''){
    // $akhir = date("Y-m-d");
  }

  if($awal!='' AND $akhir!=''){
    $cari_tgl = " AND tgl_transaksi BETWEEN '$awal' AND '$akhir'";
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

  $sql_daftar_penjualan2 = "SELECT
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
                            , `lokasi`
                            , `updatedate`
                            , `tgl_batal`
                            , `user_pembatal`
                            , `is_aktif`
                            , `is_upload`
                        FROM
                            `tbl_transaksi`
                        WHERE no_transaksi != '' AND is_aktif=1 AND is_upload=0 $cari_tgl $cari_no_transaksi
                        ORDER BY updatedate DESC";
  $res_mst_barang2 = mysqli_query($connect,$sql_daftar_penjualan2);
  $jml_data = mysqli_num_rows($res_mst_barang2);
  // echo $jml_data;
?>

<?php if($jml_data > 0){ ?>
  <span class="btn btn-success btn-sm" onclick="checkAll()" id="btn_upload">Force Upload <i class="bi bi-upload"></i></span>
<?php } ?>

<br><br>
<table class="table table-bordered table-hover table-striped">
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
      <th scope="col">Lokasi</th>
      <th scope="col">Status</th>
      <th scope="col">Tanggal Batal</th>
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
                                  , `lokasi`
                                  , `updatedate`
                                  , `tgl_batal`
                                  , `user_pembatal`
                                  , `is_aktif`
                                  , `is_upload`
                              FROM
                                  `tbl_transaksi`
                              WHERE no_transaksi != '' AND is_aktif=1 AND is_upload=0 $cari_tgl $cari_no_transaksi
                              ORDER BY updatedate DESC";
        $res_mst_barang = mysqli_query($connect,$sql_daftar_penjualan);
        $jml_data = mysqli_num_rows($res_mst_barang);
        // echo $jml_data;
        if($session_id_group==1){
          // echo $sql_daftar_penjualan;
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
          $lokasi = $data['lokasi'];
          $updatedate = $data['updatedate'];
          $tgl_batal = $data['tgl_batal'];
          $user_pembatal = $data['user_pembatal'];
          $is_aktif = $data['is_aktif'];
          $is_upload = $data['is_upload'];

          if($is_aktif==1){
            $status_penjualan = "Approved";
          }else{
            $status_penjualan = "Batal";
          }

          if($is_upload==1){
            $status_upload = "Sudah diupload";
          }else{
            $status_upload = "Belum diupload";
          }
    ?>
    <tr>
      <td id="nomor_awal<?php echo $no;?>"><?php echo $no;?></td>
      <td align="center">
        <input type='hidden' id="tgl_transaksi<?php echo $no;?>" value='<?php echo $tgl_transaksi;?>'>
        <input type='hidden' id="tgl_transaksi_update<?php echo $no;?>" value='<?php echo $updatedate;?>'>
        <?php echo $ambil_tgl_transaksi;?></td>
      <td align="center"><input type='hidden' id="no_transaksi<?php echo $no;?>" value='<?php echo $no_transaksi;?>'><?php echo $no_transaksi;?></td>
      <td align="center"><input type='hidden' id="id_kasir<?php echo $no;?>" value='<?php echo $id_kasir;?>'><?php echo $id_kasir;?></td>
      <td align="center"><input type='hidden' id="qty<?php echo $no;?>" value='<?php echo $qty;?>'><?php echo $qty;?></td>
      <td align="left"><input type='hidden' id="subtotal<?php echo $no;?>" value='<?php echo $subtotal;?>'>Rp. <span style="float: right"><?php echo number_format($subtotal);?></span></td>
      <td align="center"><input type='hidden' id="diskon<?php echo $no;?>" value='<?php echo $diskon;?>'><?php echo $diskon;?></td>
      <td align="left"><input type='hidden' id="total_akhir<?php echo $no;?>" value='<?php echo $total_akhir;?>'>Rp. <span style="float: right"><?php echo number_format($total_akhir);?></span></td>
      <td align="left"><input type='hidden' id="total_non_cash<?php echo $no;?>" value='<?php echo $total_non_cash;?>'>Rp. <span style="float: right"><?php echo number_format($total_non_cash);?></span></td>
      <td align="left"><input type='hidden' id="total_cash<?php echo $no;?>" value='<?php echo $total_cash;?>'>Rp. <span style="float: right"><?php echo number_format($total_cash);?></span></td>
      <td align="left"><input type='hidden' id="total_pembayaran<?php echo $no;?>" value='<?php echo $total_pembayaran;?>'>Rp. <span style="float: right"><?php echo number_format($total_pembayaran);?></span></td>
      <td align="left"><input type='hidden' id="total_bayar<?php echo $no;?>" value='<?php echo $total_bayar;?>'>Rp. <span style="float: right"><?php echo number_format($total_bayar);?></span></td>
      <td align="left"><input type='hidden' id="kembalian<?php echo $no;?>" value='<?php echo $kembalian;?>'>Rp. <span style="float: right"><?php echo number_format($kembalian);?></span></td>
      <td ><input type='hidden' id="lokasi<?php echo $no;?>" value='<?php echo $lokasi;?>'><?php echo $lokasi;?></td>
      <td align="center"><input type='hidden' id="status_penjualan<?php echo $no;?>" value='<?php echo $is_aktif;?>'><?php echo $status_penjualan;?></td>
      <td align="center">
        <input type='hidden' id="tgl_batal<?php echo $no;?>" value='<?php echo $tgl_batal;?>'>
        <input type='hidden' id="user_pembatal<?php echo $no;?>" value='<?php echo $user_pembatal;?>'>
        <?php echo $tgl_batal;?></td>
      <td>
        <?php if($is_upload==1){ ?>
          <p>Sudah di upload</p>
        <?php }else{ ?>
          <input name='checkbox[]' type='checkbox' id='checkbox<?php echo $no;?>' onClick='klik(<?php echo $no;?>,<?php echo $no;?>)'>
        <?php } ?>
      </td>
    </tr>
  <?php } ?>
  </tbody>
</table>

