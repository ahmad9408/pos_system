<?php session_start();
  include("../config/koneksi.php");
  include("../config/lock.php");
  $today = date('Y-m-d H:i:s');
  $todayZ = date('Y-m-d');

    $nis=$_REQUEST['nis'];
    $nama=$_REQUEST['nama'];
    $awal=$_REQUEST['awal'];
    $akhir=$_REQUEST['akhir'];


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

<span style="float: left;" class="btn btn-primary" onclick="buka_form_pencarian_tabungan()"> Download Tabungan <i class="bi bi-download"></i></span>
<span style="float: right;" id="export" onclick="ekspor_master_tabungan()" class="btn btn-success"> ekspor excel <i class="bi bi-file-earmark-excel"></i></span>
<br>
<br>
<table class="table table-bordered table-hover table-striped Table2Excel" id="tbl_tabungan">
  <thead>
    <tr align="center">
      <th scope="col">#</th>
      <th scope="col">NIS - Nama</th>
      <th scope="col">No. Rekening</th>
      <th scope="col">Saldo</th>
      <th scope="col">Tanggal Input</th>
      <th scope="col">Tanggal Update</th>
      <th scope="col">User Update</th>
      <th scope="col">Status Tabungan</th>
      <th></th>
    </tr>
  </thead>
  <tbody>
    <?php
      
        $sql_daftar_penjualan = "SELECT
                                `nis`,
                                `id_jenis`,
                                `no_rekening`,
                                `nama`,
                                `saldo`,
                                `tgl_input`,
                                `updatedate`,
                                `updateby`,
                                `is_aktif`
                              FROM `tbl_mst_tabungan`
                              WHERE nis != '' $cari_nis $cari_nama
                              ORDER BY updatedate DESC";
        $res_mst_barang = mysqli_query($connect,$sql_daftar_penjualan);
        if($session_id_group==1){
          // echo $sql_daftar_penjualan;
        }
        while($data=mysqli_fetch_array($res_mst_barang)){
          $no++;
          $nis = $data['nis'];
          $no_rekening = $data['no_rekening'];
          $nama = $data['nama'];
          $saldo = $data['saldo'];
          $tgl_input = $data['tgl_input'];
            $ambil_tgl_input = date("d M Y",strtotime($tgl_input));
          $updatedate = $data['updatedate'];
            $ambil_updatedate = date("d M Y H:i:s",strtotime($updatedate));
          $updateby = $data['updateby'];
          $is_aktif = $data['is_aktif'];
          if($is_aktif==1){
            $status_tabungan = "Aktif";
          }else{
            $status_tabungan = "Non-Aktif";
          }
    ?>
    <tr>
      <td align="center"><?php echo $no;?></td>
      <td align="left"><?php echo $nis.'-'.$nama;?></td>
      <td align="center"><?php echo $no_rekening;?></td>
      <td align="left">Rp. <span style="float: right"><?php echo number_format($saldo);?></span></td>
      <td align="center"><?php echo $ambil_tgl_input;?></td>
      <td align="center"><?php echo $ambil_updatedate;?></td>
      <td align="center"><?php echo $updateby;?></td>
      <td align="center"><?php echo $status_tabungan;?></td>
      <td colspan="2" align="center">
        <span class='btn btn-warning btn-sm' onclick="getDetail('<?php echo $nis;?>','<?php echo $nama;?>','<?php echo $no_rekening;?>')"><i class="bi bi-search"></i></span>
        <!-- <span class="btn btn-warning btn-sm" id="edit" name="edit"><i class="bi bi-pencil-square"></i></span>
        <span class="btn btn-danger btn-sm" id="hapus" name="hapus"><i class="bi bi-trash-fill"></i></span> -->
      </td>
    </tr>
  <?php } ?>
  </tbody>
</table>