<?php session_start();
  include("config/koneksi.php");
  include("config/lock.php");
  $today = date('Y-m-d H:i:s');
  $todayZ = date('Y-m-d');

  $ambil_today = date('d F Y',strtotime($todayZ));

?>

<script type="text/javascript" src="assets/js/jquery.min.js"></script>
<script type="text/javascript" src="assets/js/pembelian.js?d=<?php echo date('YmdHis');?>"></script>
<script type="text/javascript" src="assets/js/jam.js?d=<?php echo date('YmdHis');?>"></script>
<script>
  $(document).ready(function(){
      $("#qty").on("keypress", function(e){
        if(e.which == 13){
          $("#submit").click();
        }
      });

      $("#m_qty").on("keypress", function(e){
        if(e.which == 13){
          $("#btn_pros").click();
        }
      });
  });

  
</script>

<section class="section">
  <div class="row">
    <div class="col-lg-12">
      
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Form Pembelian</h5>
          <table>
            <tr>
              <td width="150">Tanggal</td>
              <td width="15">:</td>
              <td><?php echo $ambil_today;?> <span id="jam" style="font-size:24"></span></td>
            </tr>
            <tr>
              <td width="150">No. Invoice</td>
              <td width="15">:</td>
              <td id="notrans"></td>
            </tr>
            <tr>
              <td width="150">Tujuan</td>
              <td width="15">: </td>
              <td>
                <div class="form-group has-success">
                  <select class="form-select" name="lokasi" id="lokasi" >
                    <option value=""></option>
                    <?php         
                      $qrylokasi = "SELECT id, nama_lokasi FROM mst_lokasi WHERE status ='2'";
                      eval("\$sql_cari_lokasi=\"$qrylokasi\";");
                      $result = mysqli_query($connect,$sql_cari_lokasi);
                      while($r=mysqli_fetch_array($result)){
                    ?>
                      <option value="<?php echo $r['id']?>"<?php echo"selected";?>>
                        <?php 
                          echo $r['nama_lokasi'] 
                        ?>
                      </option>
                    <?php
                      }
                    ?>
                  </select>
                </div>
              </td>
            </tr>
          </table>
          <br>
          <table class="table table-bordered">
            <thead>
              <tr align="center">
                <th align="center" scope="col">Kode Barang</th>
                <th align="center" scope="col">Nama Barang</th>
                <!-- <th align="center" scope="col">Stok Awal</th> -->
                <th align="center" scope="col">Harga Pokok</th>
                <th align="center" scope="col">Harga Jual</th>
                <th align="center" scope="col">Input Qty</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td><input type="text" id="kode_barang" class="form-control"></td>
                <td><input type="text" id="nama_barang" class="form-control" disabled></td>
                <!-- <td><input type="text" id="stok" class="form-control" disabled></td> -->
                <td align="right"><input type="text" id="harga_pokok" class="form-control" disabled></td>
                <td align="right"><input type="text" id="harga_jual" class="form-control" disabled></td>
                <td style="display: none"><input type="text" id="id_jenis" class="form-control"></td>
                <td style="display: none"><input type="text" id="satuan" class="form-control"></td>
                <td><input type="text" id="qty" class="form-control" onKeyPress="return isNumber(event)"></td>
                <td style="display: none;"><span class="btn btn-primary btn-sm" id="submit" onclick="tambah()">+</span></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      
      <div id="table_pembelian"></div>

    </div>
  </div>
</section>


<div class="modal fade" id="konfirmasi_simpan" tabindex="-1">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">
        Jika  Yakin Klik tombol Proses!.</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" align="center">
        <span id="button_simpan" name="button_simpan" class="btn btn-block btn-primary" onclick="proses_simpan_pembelian()">Proses</span>
        <span id="batal" name="batal" class="btn btn-block btn-danger" onclick="tutup_modal_konfirmasi()">Batal</span>

      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="edit_list" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">
        Jika  Yakin Klik tombol Proses!.</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" align="center">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th align="center" scope="col">Kode Barang</th>
              <th align="center" scope="col">Nama Barang</th>
              <!-- <th align="center" scope="col">Stok Awal</th> -->
              <th align="center" scope="col">Harga Pokok</th>
              <th align="center" scope="col">Harga Jual</th>
              <th align="center" scope="col">Input Qty</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>
                <input type="text" id="m_kode_barang" class="form-control" disabled>        
              </td>
              <td>
                <input type="text" id="m_nama_barang" class="form-control" disabled>        
              </td>
              <!-- <td>
                <input type="text" id="m_stok" class="form-control" disabled>
              </td> -->
              <td>
                <input type="text" id="m_harga_pokok" class="form-control" disabled>
              </td>
              <td>
                <input type="text" id="m_harga_jual" class="form-control" disabled>
              </td>
              <td>
                <input type="text" id="m_qty" class="form-control">
              </td>
              <td style="display: none">
                <span id="btn_pros" name="btn_pros" class="btn btn-block btn-primary" onclick="simpan_modal()">Proses</span>
              </td>
            </tr>
          </tbody>
        </table>
        <span id="cancel" name="cancel" class="btn btn-block btn-danger" onclick="tutup_modal()">Batal</span>
      </div>
    </div>
  </div>
</div>