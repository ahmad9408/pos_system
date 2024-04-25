<?php session_start();
  include("config/koneksi.php");
  include("config/lock.php");
  $today = date('Y-m-d H:i:s');
  $todayZ = date('Y-m-d');
    $ambil_today = date('d F Y',strtotime($todayZ));
  $detik = date("s");
  $date = date("YmdHis");

?>

<!-- <link href = "assets/css/jquery-ui.css" rel = "stylesheet"> -->
<script type="text/javascript" src="assets/js/jquery.min.js"></script>
<!-- <script type="text/javascript" src="assets/js/jquery-3.5.1.js"></script> -->
<!-- <script type="text/javascript" src="assets/js/jquery.iframe-post-form.js"></script> -->

<script type="text/javascript" src="assets/js/transaksi_baru.js?d=<?php echo date('YmdHis');?>"></script>
<script type="text/javascript" src="assets/js/jam.js?d=<?php echo date('YmdHis');?>"></script>
<script type="text/javascript" src="assets/js/format.20110630-1100.min.js"></script>
<script type="text/javascript" src="assets/js/jquery_currency_input.js"></script>
<!-- <script type="text/javascript" src="assets/js/autocomplete.js"></script> -->
<script type="text/javascript" src="assets/js/notifikasi.js?d=<?php echo date('YmdHis');?>"></script>

<script>
  $(document).ready(function(){
      $("#jml_update").on("keypress", function(e){
        if(e.which == 13){
          $("#update").click();
        }
      });
  });
</script>

<section class="section">
  <div class="row">
    <div class="col-lg-4">

      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Transaksi Penjualan</h5>

            <div class="input-group mb-3">
              <label for="inputText" class="col-sm-3 col-form-label">Kode Barang</label>
              <!-- <div class="col-sm-8"> -->
                <input type="hidden" class="form-control" id="id_urutan" name="id_urutan">
                <input type="text" class="form-control" id="kode_barang" name="kode_barang" autocomplete="">
              <!-- </div> -->
                <span class="input-group-text" onclick="buka_list()"><i class="bi bi-search"></i></span>
            </div>
            <div class="row mb-3">
              <label for="inputEmail" class="col-sm-3 col-form-label">Nama Barang</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" id="nama_barang" name="nama_barang" readonly>
              </div>
            </div>
            <div class="row mb-3">
              <label for="stokBarang" class="col-sm-3 col-form-label">Stok</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" id="stok" name="stok" readonly>
                <input type="hidden" class="form-control" id="id_lokasi" name="id_lokasi">
              </div>
            </div>
            <div class="input-group mb-3">
              <label for="inputNumber" class="col-sm-3 col-form-label">Harga</label>
              <span class="input-group-text">Rp</span>
              <input type="text" class="form-control currInput"   id="harga" name="harga" onkeyup="CurrFormat()" onmouseout="CurrFormat()" onvolumechange="CurrFormat()" readonly>
              <span class="input-group-text">.00</span>
            </div>
            <div class="row mb-3">
              <label for="inputNumber" class="col-sm-3 col-form-label">Jumlah</label>
              <div class="col-sm-8">
                <input type="number" class="form-control"  id="jml" name="jml" onKeyPress="return isNumber(event)">
                <input type="number" class="form-control"  id="jml_update" name="jml_update" onKeyPress="return isNumber(event)" onkeyup="perkalian_update()" onchange='perkalian_update()'>
              </div>
            </div>
            <div class="input-group mb-3"  id="dis">
              <label for="inputNumber" class="col-sm-3 col-form-label">Diskon</label>
                <input type="text" class="form-control"  id="diskon" name="diskon" value="0" onKeyPress="return isNumber(event)" onchange='perkalian()' onkeyup="perkalian()">
                <span class="input-group-text">
                  <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked">
                  </div>
                </span>
            </div>
            <div class="input-group mb-3" id="dis_up">
              <label for="inputNumber" class="col-sm-3 col-form-label">Diskon</label>
                <input type="text" class="form-control"  id="diskon_update" name="diskon_update" value="0" onKeyPress="return isNumber(event)" onchange='perkalian_update()' onkeyup="perkalian_update()">
                <span class="input-group-text">
                  <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="ceklis_update">
                  </div>
                </span>
                
            </div>
            <div class="input-group mb-3">
              <label for="inputNumber" class="col-sm-3 col-form-label">Total</label>
              <span class="input-group-text">Rp</span>
              <input type="text" class="form-control" aria-label="Amount (to the nearest dollar)"  id="total" name="total" readonly>
              <span class="input-group-text">.00</span>
            </div>
            <div class="mb-3">
              <!-- <label class="col-sm-2 col-form-label">Tambah</label> -->
              <div class="col-sm-12">
                <!-- <span id="p" name="p" class="btn btn-block btn-primary" onclick="buka_modul_print('TRANS_221221144916000003','systemadm')">print</span> -->
                <span id="btn_submit" name="btn_submit" class="btn btn-block btn-primary" onclick="simpan()">Tambah</span>
                <span id="update" name="update" class="btn btn-block btn-warning" onclick="update()">Update</span>
                <span id="batal_update" name="batal_update" class="btn btn-block btn-danger" onclick="batal_update()">Batal</span>
              </div>
            </div>
        </div>
      </div>

    </div>

    <div class="col-lg-8">

      <div class="card">
        <div class="card-body">
          <br>
          <div class="row mb-5">
              <label class="col-sm-2 col-form-label">No. Transaksi</label>
              <div class="col-sm-10">
              <!--               <label for="basic-url" class="form-label">: <?php echo $lastNoIT;?></label><br>

                <label for="basic-url" class="form-label">: <?php echo $lastbulan;?></label><br>
                <label for="basic-url" class="form-label">: <?php echo $lastNoUrut;?></label><br>
                <label for="basic-url" class="form-label">: <?php echo $nextNoUrut;?></label><br> -->
                <label>:</label>
                <label for="basic-url" class="form-label" id="notrans"></label>
              </div>
              <label class="col-sm-2 col-form-label">Tanggal</label>
              <div class="col-sm-10">
                <label for="basic-url" class="form-label">: <?php echo $ambil_today;?> <span id="jam" style="font-size:24"></span></label>
                <div id="tanggalJam"></div>
              </div>
              <label class="col-sm-2 col-form-label">Kasir</label>
              <div class="col-sm-10">
                <label for="basic-url" class="form-label">: <?php echo $session_nama;?></label>
              </div>
          </div>

          <div id="tabel_trans"></div>
          
          <?php
            $sql_="SELECT count(id)AS jml_data FROM tbl_transaksi_detail_temp WHERE updateby='$session_nik'";
            $res_=mysqli_query($connect,$sql_);
            $data = mysqli_fetch_array($res_);
            // echo $jml_data['jml_data'];
          ?>
          <?php //if($data['jml_data'] > 0){ ?>
            <div class="col-sm-12 but_exec" align="center">
              <span id="simpan" name="simpan" class="btn btn-block btn-primary" onclick="proses()" disabled>Simpan</span>
              <span id="clear" name="clear" class="btn btn-block btn-danger" onclick="hapus()" disabled>Clear</span>
            </div>
          <?php //} ?>
        </div>
      </div>

    </div>
  </div>
  <span id="notifikasi"></span>
</section>


<div class="modal fade" id="konfirmasi_jual" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop='static'>
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">
        Jika Yakin Klik tombol Proses!.</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" align="center">
        <span id="button_simpan" name="button_simpan" class="btn btn-block btn-primary" onclick="proses_penjualan()">Proses</span>
        <!-- <button id="button_simpan" name="button_simpan" class="btn btn-default">Proses</button> -->
        <span id="batal" name="batal" class="btn btn-block btn-danger" onclick="modalTutup()">Batal</span>

      </div>
    </div>
  </div>
</div>



<div class="modal fade" id="form_data_tabungan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop='static'>
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">
        </h5>
        <!-- Jika  Yakin Klik tombol Proses!.
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
      </div>
      <div class="modal-body" align="center">
        <input type="hidden" id="counter_t" class="form-control">
        <table class="table table-bordered table-hover table-striped datatable">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">NIS-Nama</th>
              <th scope="col">Saldo</th>
              <th scope="col">Tgl Deposit</th>
            </tr>
          </thead>
          <tbody>
            <?php
              $sql_master_barang = "SELECT nis, id_jenis, no_rekening, nama, saldo, tgl_input, updatedate, updateby, is_aktif
                                    FROM tbl_mst_tabungan as d 
                                    WHERE is_aktif=1";
              $res_mst_barang = mysqli_query($connect,$sql_master_barang);
              while($data=mysqli_fetch_array($res_mst_barang)){
                $nomer++;
                $nis = $data['nis'];
                $nama = $data['nama'];
                $saldo = $data['saldo'];
                $tgl_input = $data['tgl_input'];
                  $ambil_tgl_input = date("d-m-Y",strtotime($tgl_input));
            ?>
            <tr>
              <th scope="row"><?php echo $nomer;?></th>
              <td id="kd" onclick="pilih_data_debit('<?php echo $nis;?>','<?php echo $nama;?>','<?php echo $saldo;?>','<?php echo $tgl_input;?>')"><?php echo $nis.' - '.$nama;?></td>
              <td id="nm" onclick="pilih_data_debit('<?php echo $nis;?>','<?php echo $nama;?>','<?php echo $saldo;?>','<?php echo $tgl_input;?>')"><?php echo number_format($saldo);?></td>
              <td id="st" onclick="pilih_data_debit('<?php echo $nis;?>','<?php echo $nama;?>','<?php echo $saldo;?>','<?php echo $tgl_input;?>')"><?php echo $ambil_tgl_input;?></td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
      <div class="modal-footer" align="right">
        <span class="btn btn-danger btn-sm" onclick="batal_buka()">Batal</span>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="form_print_out" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop='static'>
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <div align="center">
          <h5 class="modal-title">
            PT. Harmet
            <br>Jl.
          </h5>
        </div>
      </div>
      <div class="modal-body" id="dt_trans"></div>
      
    </div>
  </div>
</div>

<div class="modal fade" id="largeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop='static'>
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <table class="table table-bordered table-hover table-striped datatable">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Kode Barang</th>
              <th scope="col">Nama Barang</th>
              <th scope="col">Harga</th>
              <th scope="col">Stok</th>
              <th scope="col">Satuan</th>
              <th scope="col">Lokasi</th>
            </tr>
          </thead>
          <tbody>
            <?php
              if($session_id_group==1){
                $filter_lokasi = "";
              }else{
                $filter_lokasi = " AND s.lokasi='$session_lokasi'";
              }
              
              $sql_master_barang = "SELECT s.kd_barang, s.nama_barang, s.satuan, s.stok, s.harga_jual, s.ppn , st.satuan AS nama_satuan, s.lokasi, l.nama_lokasi
                                    FROM tbl_stok AS s
                                    LEFT JOIN tbl_satuan AS st ON s.satuan=st.id
                                    LEFT JOIN mst_lokasi as l ON s.lokasi=l.id
                                    WHERE s.stok > 0 $filter_lokasi";
              $res_mst_barang = mysqli_query($connect,$sql_master_barang);
              while($data=mysqli_fetch_array($res_mst_barang)){
                $nomer++;
                $kd_barang = $data['kd_barang'];
                $nama_barang = $data['nama_barang'];
                $satuan = $data['satuan'];
                $nama_satuan = $data['nama_satuan'];
                $stok = $data['stok'];
                $harga_jual = $data['harga_jual'];
                $ppn = $data['ppn'];
                $lokasi = $data['lokasi'];
                $nama_lokasi = $data['nama_lokasi'];
            ?>
            <tr>
              <th scope="row"><?php echo $nomer;?></th>
              <td id="kd" onclick="pilih_data('<?php echo $kd_barang;?>','<?php echo $nama_barang;?>','<?php echo $satuan;?>','<?php echo $stok;?>','<?php echo $harga_jual;?>','<?php echo $lokasi;?>')"><?php echo $kd_barang;?></td>
              <td id="nm" onclick="pilih_data('<?php echo $kd_barang;?>','<?php echo $nama_barang;?>','<?php echo $satuan;?>','<?php echo $stok;?>','<?php echo $harga_jual;?>','<?php echo $lokasi;?>')"><?php echo $nama_barang;?></td>
              <td id="hj" onclick="pilih_data('<?php echo $kd_barang;?>','<?php echo $nama_barang;?>','<?php echo $satuan;?>','<?php echo $stok;?>','<?php echo $harga_jual;?>','<?php echo $lokasi;?>')"><?php echo number_format($harga_jual);?></td>
              <td id="sk" onclick="pilih_data('<?php echo $kd_barang;?>','<?php echo $nama_barang;?>','<?php echo $satuan;?>','<?php echo $stok;?>','<?php echo $harga_jual;?>','<?php echo $lokasi;?>')"><?php echo number_format($stok);?></td>
              <td id="st" onclick="pilih_data('<?php echo $kd_barang;?>','<?php echo $nama_barang;?>','<?php echo $satuan;?>','<?php echo $stok;?>','<?php echo $harga_jual;?>','<?php echo $lokasi;?>')"><?php echo $nama_satuan;?></td>
              <td id="p" onclick="pilih_data('<?php echo $kd_barang;?>','<?php echo $nama_barang;?>','<?php echo $satuan;?>','<?php echo $stok;?>','<?php echo $harga_jual;?>','<?php echo $lokasi;?>')"><?php echo $nama_lokasi;?></td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
      <!-- <div class="modal-footer"> -->
        <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button> -->
      <!-- </div> -->
    </div>
  </div>
</div>