<?php session_start();
  include("config/koneksi.php");
  include("config/lock.php");
  
  $today = date('Y-m-d H:i:s');
  $todayZ = date('Y-m-d');

  if(isset($_REQUEST['action'])){
      $nama_barang = $_POST['nama_barang'];
      $lokasi = $_POST['lokasi'];
      $kd_brg = $_POST['kd_brg'];
  } else {

  }

  if($nama_barang!=''){
    $cari_nama_barang = " AND s.nama_barang like '%$nama_barang%'";
  }else{
    $cari_nama_barang = "";
  }

  if($lokasi!=''){
    $cari_lokasi = " AND s.lokasi = '$lokasi'";
    // if($lokasi=='GDG'){
    //   $filter = "FROM `tbl_stok_gudang`";
    // }else{
    //   $filter = "FROM `tbl_stok`";
    // }
  }else{
    $cari_lokasi = "";
  }

  if($kd_brg!=''){
    $cari_kd_brg = " AND kd_barang like '%$kd_brg%'";
  }else{
    $cari_kd_brg = "";
  }
?>

<script type="text/javascript" src="assets/js/jquery.min.js"></script>
<script type="text/javascript">
  function cari(){
    var isLoad = 1;
  }

  function reset(){
    $("#nama_barang").val('');
    $("#kd_brg").val('');
  }
</script>
<section class="section">
  <div class="row">
    <div class="col-lg-12">

      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Daftar Stok Barang</h5>
        </div>
      </div>
    </div>

    <div class="col-lg-12" id="table_master">
      <div class="card">
        <div class="card-body">
          <div class="box-body table-responsive no-padding">
            <!-- <h5 class="card-title">Daftar Stok Barang</h5> -->
            <br>
            <table class="table table-bordered datatable">
              <thead>
                <tr align="center">
                  <th scope="col">#</th>
                  <th scope="col">Kode Barang</th>
                  <th scope="col">Nama Barang</th>
                  <th scope="col">Stok</th>
                  <th scope="col">Satuan</th>
                  <th scope="col">Lokasi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                  // if(isset($_REQUEST['action'])){
                    $sql_stok = "SELECT
                                            `s`.`kd_barang`,
                                            `s`.`nama_barang`,
                                            `s`.`id_jenis`,
                                            `s`.`stok`,
                                            `s`.`harga_pokok`,
                                            `s`.`harga_jual`,
                                            `s`.`lokasi`,
                                            `l`.`nama_lokasi`,
                                            `sat`.`satuan`
                                          FROM `tbl_stok` as s
                                          LEFT JOIN mst_lokasi as l ON s.lokasi=l.id
                                          LEFT JOIN tbl_satuan as sat ON s.satuan=sat.id
                                          WHERE s.kd_barang!='' AND s.is_aktif = 1
                                          $cari_nama_barang $cari_kd_brg
                                          ORDER BY s.updatedate desc";
                    // echo $sql_stok;
                    $res_stok = mysqli_query($connect,$sql_stok)or die($sql_stok);
                    while($data=mysqli_fetch_array($res_stok)){
                      $no++;
                      // echo $sql_stok;
                ?>
                <tr>
                  <td><?php echo $no;?></td>
                  <td><?php echo $data['kd_barang'];?></td>
                  <td><?php echo $data['nama_barang'];?></td>
                  <td align="center"><?php echo $data['stok'];?></td>
                  <td align="center"><?php echo $data['satuan'];?></td>
                  <td><?php echo $data['nama_lokasi'];?></td>
                </tr>
                <?php }  ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    </div>
  </div>
</section>

<div class="modal fade" id="konfirmasi_edit" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">
        Jika Yakin Klik tombol Proses!.</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" align="center">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th scope="col">Kode Barang</th>
              <th scope="col">Nama Barang</th>
              <th scope="col">Satuan</th>
              <th scope="col">Harga Pokok</th>
              <th scope="col">Harga Jual</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td><input type="text" id="kode_barang_edit" class="form-control"></td>
              <td><input type="text" id="nama_barang_edit" class="form-control"></td>
              <td id="satuan_edit"></td>
              <td>
               <!--  <select class="form-select" name="satuan_edit" id="satuan_edit">
                  <option value=""></option>
                  <?php         
                    $qrylokasi = "SELECT id, satuan FROM tbl_satuan WHERE status ='1'";
                    eval("\$sql_cari_lokasi=\"$qrylokasi\";");
                    $result = mysqli_query($connect,$sql_cari_lokasi);
                    while($r=mysqli_fetch_array($result)){
                  ?>
                    <option value="<?php echo $r['id']?>">
                      <?php 
                        echo $r['satuan'];
                      ?>
                    </option>
                  <?php
                    }
                  ?>
                </select> -->
              </td>
              <td><input type="text" id="harga_pokok_edit" class="form-control"></td>
              <td><input type="text" id="harga_jual_edit" class="form-control"></td>
            </tr>
          </tbody>
        </table>
        <span id="button_simpan" name="button_simpan" class="btn btn-block btn-primary" onclick="proses_edit()">Proses</span>
        <span id="batal" name="batal" class="btn btn-block btn-danger" onclick="modalTutup()">Batal</span>

      </div>
    </div>
  </div>
</div>

<script>
  var satuan_edit="<?php echo $satuan_?>";
</script>