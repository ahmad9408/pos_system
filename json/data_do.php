<?php session_start();
  include("../config/koneksi.php");
  include("../config/lock.php");
  
  $today = date('Y-m-d H:i:s');
  $todayZ = date('Y-m-d');
  $tgl_pertama = date('Y-m-01', strtotime($todayZ));
  $tgl_terakhir = date('Y-m-t', strtotime($todayZ));

  $lokasi = $_REQUEST['lokasi'];
  $awal=$_REQUEST['awal'];
  $akhir=$_REQUEST['akhir'];
  $no_transaksi=$_REQUEST['no_transaksi'];

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


<table class="table table-bordered table-hover table-striped">
  <thead>
    <tr align="center">
      <th scope="col">#</th>
      <th scope="col">Tgl Kirim</th>
      <th scope="col">No. Pengiriman</th>
      <th scope="col">Total Harga Pokok</th>
      <th scope="col">Total Harga Jual</th>
      <th scope="col">Total QTY</th>
      <th scope="col">Lokasi</th>
      <th scope="col">Status<br>DO</th>
      <th></th>
    </tr>
  </thead>
  <tbody>
    <?php
        $sql_stok = "SELECT
                        `d`.`no_transaksi`
                        , `d`.`tgl_transaksi`
                        , `d`.`qty`
                        , `d`.`total_harga_pokok`
                        , `d`.`total_harga_jual`
                        , `l`.`nama_lokasi`
                        , `d`.`updatedate`
                        , `d`.`updateby`
                        , `d`.`tgl_batal`
                        , `d`.`user_pembatal`
                        , `d`.`penerima`
                        , `d`.`tgl_terima`
                        , `d`.`stat_terima`
                        , `d`.`is_aktif`
                    FROM
                        `tbl_do` AS `d`
                        INNER JOIN `mst_lokasi` AS `l` 
                            ON (`d`.`lokasi` = `l`.`id`)
                    WHERE d.no_transaksi!='' $cari_lokasi $cari_tgl $cari_no_transaksi
                    ORDER BY d.updatedate DESC";
        // echo $sql_stok;
        $res_stok = mysqli_query($connect,$sql_stok)or die($sql_stok);
        while($data=mysqli_fetch_array($res_stok)){
          $no++;
          if($data['stat_terima']==0){
            $status_pengiriman = "Belum Approved Kasir";
          }elseif($data['stat_terima']==1){
            $status_pengiriman = "Approved";
          }elseif($data['stat_terima']==2){
            $status_pengiriman = "Tolak";
          }

          $tgl_transaksi = $data['tgl_transaksi'];
            $ambil_tgl_transaksi = date("d M Y",strtotime($tgl_transaksi));
    ?>
    <tr>
      <td align="center"><?php echo $no;?></td>
      <td align="center"><?php echo $ambil_tgl_transaksi;?></td>
      <td><?php echo $data['no_transaksi'];?></td>
      <td align="left">Rp. <span style="float: right"><?php echo number_format($data['total_harga_pokok']);?></span></td>
      <td align="left">Rp. <span style="float: right"><?php echo number_format($data['total_harga_jual']);?></span></td>
      <td align="center"><?php echo $data['qty'];?></td>
      <td align="center"><?php echo $data['nama_lokasi'];?></td>
      <td align="center">
        <?php echo $status_pengiriman;?>
        <?php if($data['stat_terima']==2){ ?>
          <?php echo "<br>".$data['tgl_batal']."<br>Oleh ".$data['user_pembatal'];?>
        <?php } ?>
      </td>
      <!-- <td align="left">Rp. <span style="float: right;"><?php echo number_format($data['harga_pokok']);?></span></td> -->
      <!-- <td align="left">Rp. <span style="float: right;"><?php echo number_format($data['harga_jual']);?></span></td> -->
      <td colspan="2" align="center">
        <!-- <span class="btn btn-warning btn-sm" id="edit" name="edit" onclick="edit_data('<?php echo $data['kd_barang'];?>','<?php echo $data['nama_barang'];?>','<?php echo $data['id_jenis'];?>','<?php echo $data['satuan'];?>','<?php echo $data['harga_pokok'];?>','<?php echo $data['harga_jual'];?>')"><i class="bi bi-pencil-square"></i></span> -->
        <span class='btn btn-success btn-sm' onclick="getDetail('<?php echo $data['no_transaksi'];?>','<?php echo $ambil_tgl_transaksi;?>','<?php echo $data['nama_lokasi'];?>')"><i class="bi bi-search"></i></span>
      </td>
    </tr>
    <?php } ?>
  </tbody>
</table>