<?php
  include("../config/koneksi.php");
  include("../config/lock.php");
  $today = date('Y-m-d H:i:s');
  $todayZ = date('Y-m-d');
?>
<div class="card" id="tbl_jenis">
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