<?php session_start();
  include("../config/koneksi.php");
  include("../config/lock.php");

  $today = date('Y-m-d H:i:s');
  $todayZ = date('Y-m-d');

// if(isset($_REQUEST['action'])){
    $awal=$_REQUEST['awal'];
    $akhir=$_REQUEST['akhir'];
    $no_trans=$_REQUEST['no_trans'];
// } else {

// }

if($awal==''){
  $awal = date("Y-m-d");
}

if($akhir==''){
  $akhir = date("Y-m-d");
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

<table class="table table-bordered">
  <thead>
    <tr align="center">
      <th scope="col">#</th>
      <th scope="col">Tanggal</th>
      <th scope="col">Nomor Transaksi</th>
      <th scope="col">ID Kasir</th>
      <th scope="col">Total<br>QTY</th>
      <th scope="col">Total<br>HPP</th>
      <th scope="col">Total<br>HPJ</th>
      <th scope="col">Status</th>
      <th scope="col">Tanggal Batal</th>
      <th scope="col">Status<br>Upload<br><span class="btn btn-success btn-sm" onclick="checkAll()" id="btn_upload">Force Upload <i class="bi bi-upload"></i></span></th>
      <th></th>
    </tr>
  </thead>
  <tbody>
    <?php
      // if(isset($_REQUEST['action'])){
        $sql_daftar_penjualan = "SELECT
                                    `p`.`invoice`
                                    , `p`.`tgl_invoice`
                                    , `p`.`tgl_input`
                                    , `p`.`total_qty`
                                    , `p`.`total_harga_pokok`
                                    , `p`.`total_harga_jual`
                                    , `p`.`lokasi`
                                    , `p`.`updatedate`
                                    , `p`.`updateby`
                                    , `p`.`tgl_batal`
                                    , `p`.`user_pembatal`
                                    , `p`.`is_aktif`
                                    , `l`.`nama_lokasi`
                                    , `p`.`is_upload`
                                    , `p`.`tgl_upload`
                                FROM
                                    `tbl_pembelian` AS `p`
                                    LEFT JOIN `mst_lokasi` AS `l` 
                                        ON (`p`.`lokasi` = `l`.`id`)
                                WHERE p.invoice != '' $cari_tgl $cari_invoice
                                ORDER BY p.updatedate DESC";
        if($session_id_group==1){
          // echo $sql_daftar_penjualan;
        }

        $res_mst_barang = mysqli_query($connect,$sql_daftar_penjualan)or die($sql_daftar_penjualan);
        while($data=mysqli_fetch_array($res_mst_barang)){
          $no++;
          $invoice = $data['invoice'];
          $tgl_input = $data['tgl_input'];
            $ambil_tgl_input = date("d M Y H:i:s",strtotime($tgl_input));
          $tgl_invoice = $data['tgl_invoice'];
            $ambil_tgl_invoice = date("d M Y",strtotime($tgl_invoice));
          $updateby = $data['updateby'];
          $total_harga_pokok = $data['total_harga_pokok'];
          $total_harga_jual = $data['total_harga_jual'];
          $total_qty = $data['total_qty'];
          $lokasi = $data['lokasi'];
          $updatedate = $data['updatedate'];
          $tgl_batal = $data['tgl_batal'];
          $user_pembatal = $data['user_pembatal'];
          $is_aktif = $data['is_aktif'];
          $is_upload = $data['is_upload'];
          $tgl_upload = $data['tgl_upload'];
            $tgl_upload = date("d M Y H:i:s",strtotime($tgl_upload));

          if($is_aktif==1){
            $status_penjualan = "Approved";
            $warna = "#FFFFFF";
          }else{
            $status_penjualan = "Batal";
            $warna = "#FF1493";
          }

          if($is_upload==1){
            $status_upload = "Approved";
            $warna = "#FFFFFF";
            $ambil_tgl_upload = $tgl_upload;
          }else{
            $status_upload = "Batal";
            $warna = "#FF1493";
            $ambil_tgl_upload =  "";
          }
    ?>
    <tr>
      <td id="nomor_awal<?php echo $no;?>"><?php echo $no;?></td>
      <td align="center">
        <input type='hidden' id="tgl_invoice<?php echo $no;?>" value='<?php echo $tgl_invoice;?>'>
        <input type='hidden' id="tgl_input<?php echo $no;?>" value='<?php echo $tgl_input;?>'>
        <?php echo $ambil_tgl_invoice;?>
      </td>
      <td align="center"><input type='hidden' id="invoice<?php echo $no;?>" value='<?php echo $invoice;?>'><?php echo $invoice;?></td>
      <td align="center"><input type='hidden' id="updateby<?php echo $no;?>" value='<?php echo $updateby;?>'><?php echo $updateby;?></td>
      <td align="center">
        <input type='hidden' id="total_qty<?php echo $no;?>" value='<?php echo $total_qty;?>'>
        <input type='hidden' id="lokasi<?php echo $no;?>" value='<?php echo $lokasi;?>'>
        <?php echo $total_qty;?>
      </td>
      <td align="left">
        <input type='hidden' id="total_harga_pokok<?php echo $no;?>" value='<?php echo $total_harga_pokok;?>'>
        Rp. <span style="float: right;"><?php echo number_format($total_harga_pokok);?></span>
      </td>
      <td align="left">
        <input type='hidden' id="total_harga_jual<?php echo $no;?>" value='<?php echo $total_harga_jual;?>'>
        Rp. <span style="float: right;"><?php echo number_format($total_harga_jual);?></span>
      </td>
      <td align="center">
        <input type='hidden' id="is_aktif<?php echo $no;?>" value='<?php echo $is_aktif;?>'>
        <input type='hidden' id="updatedate<?php echo $no;?>" value='<?php echo $updatedate;?>'>
        <?php echo $status_penjualan;?>
      </td>
      <td align="center">
        <input type='hidden' id="tgl_upload<?php echo $no;?>" value='<?php echo $tgl_upload;?>'>
        <input type='hidden' id="tgl_batal<?php echo $no;?>" value='<?php echo $tgl_batal;?>'>
        <input type='hidden' id="user_pembatal<?php echo $no;?>" value='<?php echo $user_pembatal;?>'>
        <?php echo $tgl_batal;?>
      </td>
      <td align="center">
        <?php if($is_aktif==1){ ?>
          <?php if($is_upload==1){ ?>
            <p><?php echo $status_upload.'<br>'.$ambil_tgl_upload;?></p>
          <?php }else{ ?>
            <input name='checkbox[]' type='checkbox' id='checkbox<?php echo $no;?>' onClick='klik(<?php echo $no;?>,<?php echo $no;?>)'>
          <?php } ?>
        <?php } ?>
      </td>
      <td align="center">
        <span class='btn btn-warning btn-sm' onclick="getDetail('<?php echo $invoice;?>','<?php echo $ambil_tgl_input;?>')"><i class="bi bi-search"></i></span>
        <!-- <span class="btn btn-warning btn-sm" id="edit" name="edit"><i class="bi bi-pencil-square"></i></span>
        <span class="btn btn-danger btn-sm" id="hapus" name="hapus"><i class="bi bi-trash-fill"></i></span> -->
      </td>
    </tr>
  <?php } //} ?>
  </tbody>
</table>