<?php
  include("../config/koneksi.php");
  include("../config/lock.php");
  $today = date('Y-m-d H:i:s');
  $todayZ = date('Y-m-d');
?>

<script type="text/javascript" src="assets/js/akun.js?d=<?php echo date('YmdHis');?>"></script>
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

<div class="card" id="tbl_jenis">
  <div id="loader" class="loader"></div>
  <div class="card-body">
    <h5 class="card-title">User Akun</h5>
    <span id="but_input" style="float: right" class="btn btn-success btn-sm" onclick="tambah_user()">Tambah Akun Baru</span>
    <br><br>
      <table class="table table-bordered table-hover table-striped datatable">
        <thead>
          <tr>
            <th scope="col">ID User</th>
            <th scope="col">Nama User</th>
            <th scope="col">Status User</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <?php
            $sql_master_barang = "SELECT
                                    `nik`,
                                    `password`,
                                    `nama`,
                                    `status`,
                                    `id_group`,
                                    `update_date`,
                                    `update_user`
                                  FROM `mst_user_login`
                                  WHERE nik!=''";
            $res_master_barang = mysqli_query($connect,$sql_master_barang);
            while($data=mysqli_fetch_array($res_master_barang)){
              $no++;
              // echo $sql_master_barang;
              $status = $data['status'];
              if($status==1){
                $ambil_status='Aktif';
              }else{
                $ambil_status='Non Aktif';
              }
          ?>
          <tr>
            <!-- <td><?php echo $no;?></td> -->
            <td><?php echo $data['nik'];?></td>
            <td><?php echo $data['nama'];?></td>
            <td><?php echo $ambil_status;?></td>
            <td colspan="2">
              <span class="btn btn-warning btn-sm" id="edit" name="edit" onclick="edit_data('<?php echo $data['nik'];?>','<?php echo $data['password'];?>','<?php echo $data['nama'];?>','<?php echo $data['id_group'];?>','<?php echo $data['status'];?>')"><i class="bi bi-pencil-square"></i></span>
              <!-- <span class="btn btn-danger btn-sm" id="hapus" name="hapus"><i class="bi bi-trash-fill"></i></span> -->
            </td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
  </div>
</div>

<div class="modal fade" id="tambah_user" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop='static'>
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Silahkan masukkan username dan pilih grup untuk akun baru</h5>
      </div>
      <div class="modal-body">
        <table>
          <tr>
            <td width="150">Username</td>
            <td width="15">:</td>
            <td colspan="4">
              <div class="class row col-md-12">
                <div class="col-md-6">
                  <input type="text" class="form-control" id="username" name="username" style="width: 350px;">
                </div>
              </div>
            </td>
          </tr>
          <tr>
            <td width="150">Password</td>
            <td width="15">:</td>
            <td colspan="4">
              <div class="class row col-md-12">
                <div class="col-md-6">
                  <input type="text" class="form-control" id="pass" name="pass" style="width: 350px;">
                </div>
              </div>
            </td>
          </tr>
          <tr>
            <td width="150">Nama Kasir</td>
            <td width="15">:</td>
            <td colspan="4">
              <div class="class row col-md-12">
                <div class="col-md-6">
                  <input type="text" class="form-control" id="nama_user" name="nama_user" style="width: 350px;">
                </div>
              </div>
            </td>
          </tr>
          <tr>
            <td width="150">Grup Akun</td>
            <td width="15">:</td>
            <td colspan="4">
              <div class="class row col-md-12">
                <div class="col-md-6">
                  <select class="form-select" name="group" id="group" style="width: 350px;">
                    <option value=""></option>
                    <?php
                      $qry_g = "SELECT id_group, nama_group FROM mst_group where id_group!='1'";
                      eval("\$sql_cari_lokasi=\"$qry_g\";");
                      $result = mysqli_query($connect,$sql_cari_lokasi);
                      while($r=mysqli_fetch_array($result)){
                    ?>
                      <option value="<?php echo $r['id_group']?>">
                        <?php 
                          echo $r['nama_group'];
                        ?>
                      </option>
                    <?php
                      }
                    ?>
                  </select>
                </div>
              </div>
            </td>
          </tr>
          <tr>
            <td width="150">Lokasi</td>
            <td width="15">:</td>
            <td colspan="4">
              <div class="class row col-md-12">
                <div class="col-md-6">
                  <select class="form-select" name="lokasi" id="lokasi" style="width: 350px;">
                    <option value=""></option>
                    <?php
                      $qryl = "SELECT id, nama_lokasi FROM mst_lokasi WHERE `status`='1'";
                      eval("\$sql_cari_l=\"$qryl\";");
                      $result_l = mysqli_query($connect,$sql_cari_l);
                      while($r=mysqli_fetch_array($result_l)){
                    ?>
                      <option value="<?php echo $r['id']?>">
                        <?php 
                          echo $r['nama_lokasi'];
                        ?>
                      </option>
                    <?php
                      }
                    ?>
                  </select>
                </div>
              </div>
            </td>
          </tr>
        </table>
        <br><br>
      </div>
      <div class="modal-footer">
        <span id="submit" onclick="simpan_akun()" class="btn btn-primary btn-sm">Simpan</span>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="edit_user" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop='static'>
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Silahkan edit sesuai kebutuhan</h5>
      </div>
      <div class="modal-body">
        <table>
          <tr>
            <td width="150">Username</td>
            <td width="15">:</td>
            <td colspan="4">
              <div class="class row col-md-12">
                <div class="col-md-6">
                  <input type="text" class="form-control" id="username_edit" name="username_edit" style="width: 350px;">
                </div>
              </div>
            </td>
          </tr>
          <tr>
            <td width="150">Password</td>
            <td width="15">:</td>
            <td colspan="4">
              <div class="class row col-md-12">
                <div class="col-md-6">
                  <input type="text" class="form-control" id="pass_edit" name="pass_edit" style="width: 350px;">
                </div>
              </div>
            </td>
          </tr>
          <tr>
            <td width="150">Nama Kasir</td>
            <td width="15">:</td>
            <td colspan="4">
              <div class="class row col-md-12">
                <div class="col-md-6">
                  <input type="text" class="form-control" id="nama_user_edit" name="nama_user_edit" style="width: 350px;">
                </div>
              </div>
            </td>
          </tr>
          <tr>
            <td width="150">Grup Akun</td>
            <td width="15">:</td>
            <td colspan="4">
              <div class="class row col-md-12">
                <div class="col-md-6">
                  <select class="form-select" name="group_edit" id="group_edit" style="width: 350px;">
                    <option value=""></option>
                    <?php
                      $qry_g = "SELECT id_group, nama_group FROM mst_group";
                      eval("\$sql_cari__g=\"$qry_g\";");
                      $result = mysqli_query($connect,$sql_cari__g);
                      while($r=mysqli_fetch_array($result)){
                    ?>
                      <option value="<?php echo $r['id_group']?>">
                        <?php 
                          echo $r['nama_group'];
                        ?>
                      </option>
                    <?php
                      }
                    ?>
                  </select>
                </div>
              </div>
            </td>
          </tr>
          <tr>
            <td width="150">Status Akun</td>
            <td width="15">:</td>
            <td colspan="4">
              <div class="class row col-md-12">
                <div class="col-md-6">
                  <select class="form-select" name="status_edit" id="status_edit" style="width: 350px;">
                    <option value=""></option>
                    <?php
                      $qry = "SELECT id, nama FROM tbl_status";
                      eval("\$sql_cari_=\"$qry\";");
                      $result = mysqli_query($connect,$sql_cari_);
                      while($r=mysqli_fetch_array($result)){
                    ?>
                      <option value="<?php echo $r['id']?>">
                        <?php 
                          echo $r['nama'];
                        ?>
                      </option>
                    <?php
                      }
                    ?>
                  </select>
                </div>
              </div>
            </td>
          </tr>
        </table>
        <br><br>
      </div>
      <div class="modal-footer">
        <span id="submit" onclick="edit_akun()" class="btn btn-primary btn-sm">Simpan</span>
      </div>
    </div>
  </div>
</div>