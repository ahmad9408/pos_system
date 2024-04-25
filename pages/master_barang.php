<?php session_start();
  include("config/koneksi.php");
  include("config/lock.php");
  
  $today = date('Y-m-d H:i:s');
  $todayZ = date('Y-m-d');

  if(isset($_REQUEST['action'])){
      $nama_barang = $_POST['nama_barang'];
      // echo cari();
  } else {

  }

  if($nama_barang!=''){
    $cari_nama_barang = " AND nama_barang like '%$nama_barang%'";
  }else{
    $cari_nama_barang = "";
  }

$satuan_="<option value=''></option>";
$sql_s = "SELECT id, satuan FROM tbl_satuan WHERE status ='1'";
$result = mysqli_query($connect,$sql_s);
while(list($id,$satuan)=mysqli_fetch_array($result)){
  $satuan_.="<option value='$id'>$satuan</option>";
}

?>

<script type="text/javascript" src="assets/js/jquery.min.js"></script>
<script type="text/javascript" src="assets/js/master_barang.js?d=<?php echo date('YmdHis');?>"></script>
<script type="text/javascript" src="assets/js/format.20110630-1100.min.js"></script>
<script type="text/javascript" src="assets/js/jquery_currency_input.js"></script>
<script type="text/javascript" src="assets/js/notifikasi.js?d=<?php echo date('YmdHis');?>"></script>
<script type="text/javascript">
  function cari(){
    var isLoad = 1;
  }
</script>

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
    <div class="col-lg-12">

      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Master Data Barang</h5>
          <span style="float: left;" class="btn btn-success btn-sm" onclick="buka_form_pencarian_pengiriman()"> Download Master Barang <i class="bi bi-download"></i></span>
          <!-- <span id="but_input" style="float: right" class="btn btn-warning btn-sm" onclick="buka_form_input()">Tambah Master Barang</span> -->
          <!-- <span id="but_cancel" style="float: right" class="btn btn-danger btn-sm" onclick="tutup_form_input()">Tutup Inputan</span> -->
        </div>
      </div>
    </div>

    <div id="form_tambah_master_barang">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <div class="box-body table-responsive no-padding">
              <h5 class="card-title">Form Tambah Master Barang</h5>
          
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th scope="col">Kode Barang</th>
                      <th scope="col">Nama Barang</th>
                      <th scope="col">Jenis Barang</th>
                      <th scope="col">Satuan</th>
                      <th scope="col">Harga Pokok</th>
                      <th scope="col">Harga Jual</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td><input type="text" id="kode_barang" class="form-control"></td>
                      <td><input type="text" id="nm_barang" class="form-control"></td>
                      <td>
                        <select class="form-select" name="id_jenis" id="id_jenis">
                          <option value=""></option>
                          <?php
                            $qrylokasi = "SELECT id, jenis_barang FROM tbl_mst_jenis_barang WHERE is_aktif ='1'";
                            eval("\$sql_cari_lokasi=\"$qrylokasi\";");
                            $result = mysqli_query($connect,$sql_cari_lokasi);
                            while($r=mysqli_fetch_array($result)){
                          ?>
                            <option value="<?php echo $r['id']?>">
                              <?php 
                                echo $r['jenis_barang'];
                              ?>
                            </option>
                          <?php
                            }
                          ?>
                        </select>
                      </td>
                      <td>
                        <select class="form-select" name="satuan" id="satuan">
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
                        </select>
                      </td>
                      <td><input type="text" id="harga_pokok" class="form-control currInput" onkeyup="CurrFormat();" onvolumechange="CurrFormat()" onchange="CurrFormat()"></td>
                      <td><input type="text" id="harga_jual" class="form-control currInput" onkeyup="CurrFormat();" onvolumechange="CurrFormat()" onchange="CurrFormat()"></td>
                    </tr>
                  </tbody>
                </table>

              <div id="data_master"></div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-12" id="table_master">
      <div class="card">
        <div class="card-body">
          <!-- <h5 class="card-title">Daftar Jenis Barang</h5> -->
          <div class="box-body table-responsive no-padding">
            <br>
            <br>
            <table class="table table-bordered datatable">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Kode Barang</th>
                  <th scope="col">Kategori</th>
                  <th scope="col">Jenis</th>
                  <th scope="col">Size</th>
                  <th scope="col">Warna</th>
                  <th scope="col">Nama Barang</th>
                  <th scope="col">Satuan</th>
                  <th scope="col">Harga Pokok</th>
                  <th scope="col">Harga Jual</th>
                </tr>
              </thead>
              <tbody>
                  
                <?php
                    $sql_master_barang = "SELECT
                                            m.`kd_barang`,
                                            m.`nama_barang`,
                                            m.`harga_pokok`,
                                            m.`harga_jual`,
                                            s.`satuan`,
                                            k.`nama_kategori`,
                                            j.`jenis_barang`,
                                            z.`nama_size`,
                                            w.`nama_warna`
                                          FROM `tbl_mst_barang` AS m
                                          LEFT JOIN tbl_satuan AS s ON m.satuan=s.id
                                          LEFT JOIN tbl_mst_jenis_barang AS j ON m.id_jenis=j.id
                                          LEFT JOIN tbl_mst_kategori_barang AS k ON m.id_kategori=k.id_kategori
                                          LEFT JOIN tbl_mst_size AS z ON m.id_size=z.id_size
                                          LEFT JOIN tbl_mst_warna AS w ON m.id_warna=w.id_warna
                                          WHERE m.kd_barang!='' $cari_nama_barang ORDER BY m.updatedate DESC";
                    // echo $sql_master_barang;
                    $res_master_barang = mysqli_query($connect,$sql_master_barang);
                    while($data=mysqli_fetch_array($res_master_barang)){
                      $no++;
                ?>
                <tr>
                  <td><?php echo $no;?></td>
                  <td><?php echo $data['kd_barang'];?></td>
                  <td><?php echo $data['nama_kategori'];?></td>
                  <td><?php echo $data['nama_size'];?></td>
                  <td><?php echo $data['nama_kategori'];?></td>
                  <td><?php echo $data['nama_warna'];?></td>
                  <td><?php echo $data['nama_barang'];?></td>
                  <td><?php echo $data['satuan'];?></td>
                  <td align="left">Rp. <span style="float: right;"><?php echo number_format($data['harga_pokok']);?></span></td>
                  <td align="left">Rp. <span style="float: right;"><?php echo number_format($data['harga_jual']);?></span></td>
                  
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
    <div align="center" id="notifikasi"></div>
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

<div class="modal fade" id="form_pencarian" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop='static'>
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Pilih tanggal untuk proses pencarian</h5>
        <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
      </div>
      <div class="modal-body">
        <table>
          <tr>
            <td width="150">Range Tanggal</td>
            <td width="15">:</td>
            <td colspan="6">
              <div class="input-group mb-3 class row col-md-12">
                <div class="col-md-5">
                  <input type="text" class="form-control" id="awal_download" name="awal_download" placeholder="tanggal awal" style="width: 250px;">
                </div>
                <div class="col-md-2" align="center">
                  s / d
                </div>
                <div class="col-md-5">
                  <input type="text" class="form-control" id="akhir_download" name="akhir_download" placeholder="tanggal akhir" style="width: 250px;">
                </div>
              </div>
            </td>
          </tr>
        </table>
        <br><br>
      </div>
      <div class="modal-footer">
        <span id="download_pengiriman" onclick="cari_pengiriman()" class="btn btn-primary btn-sm">Proses</span>
      </div>
  </div>
</div>

<script>
  var satuan_edit="<?php echo $satuan_?>";
</script>