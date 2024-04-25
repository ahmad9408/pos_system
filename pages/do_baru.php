<?php session_start();
  include("config/koneksi.php");
  include("config/lock.php");
  $today = date('Y-m-d H:i:s');
  $todayZ = date('Y-m-d');

  $ambil_today = date('d F Y',strtotime($todayZ));

?>

<script type="text/javascript" src="assets/js/jquery.min.js"></script>
<script type="text/javascript" src="assets/js/do_baru.js?d=<?php echo date('YmdHis');?>"></script>
<script type="text/javascript" src="assets/js/jam.js?d=<?php echo date('YmdHis');?>"></script>
<script>
  $(document).ready(function(){
      $("#qty").on("keypress", function(e){
        if(e.which == 13){
          $("#submit").click();
        }
      });
  });
</script>
<section class="section">
  <div class="row">
    <div class="col-lg-12">
      
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Form Pengiriman Stok</h5>
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
                      $qrylokasi = "SELECT id, nama_lokasi FROM mst_lokasi WHERE status ='1'";
                      eval("\$sql_cari_lokasi=\"$qrylokasi\";");
                      $result = mysqli_query($connect,$sql_cari_lokasi);
                      while($r=mysqli_fetch_array($result)){
                    ?>
                      <!-- <option value="<?php echo $r['id']?>"<?php echo"selected";?>> -->
                      <option value="<?php echo $r['id']?>">
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
                <th align="center" scope="col" style="width: 350px;">Kode Barang</th>
                <th align="center" scope="col" style="width: 350px;">Invoice</th>
                <th align="center" scope="col" style="width: 350px;">Nama Barang</th>
                <th align="center" scope="col" style="width: 100px;" >Stok Awal</th>
                <th align="center" scope="col" style="width: 150px;">Harga Pokok</th>
                <th align="center" scope="col" style="width: 150px;">Harga Jual</th>
                <th align="center" scope="col" style="width: 100px;">Input Qty</th>
              </tr>
            </thead>
            <tbody>
              <tr align="center">
                <td>
                  <div class="input-group mb-3">
                    <input type="text" class="form-control" id="kode_barang" name="kode_barang" autocomplete="" disabled onclick="buka_list()">
                    <span class="input-group-text" onclick="buka_list()"><i class="bi bi-search"></i></span>
                  </div>
                </td>
                <td><input type="text" id="invoice" class="form-control" disabled></td>
                <td><input type="text" id="nama_barang" class="form-control" disabled></td>
                <td><input type="text" id="stok" class="form-control" style="width: 100px;" disabled></td>
                <td><input type="text" id="harga_pokok" class="form-control" style="width: 150px;" disabled></td>
                <td><input type="text" id="harga_jual" class="form-control" style="width: 150px;" disabled></td>
                <td style="display: none;"><input type="text" id="id_jenis" class="form-control"></td>
                <td style="display: none;"><input type="text" id="satuan" class="form-control"></td>
                <td><input type="text" id="qty" class="form-control" onKeyPress="return isNumber(event)" style="width: 100px;"></td>
                <td style="display: none;"><span class="btn btn-primary btn-sm" id="submit" onclick="tambah()">+</span></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      
      <div id="table_pengiriman"></div>

    </div>
  </div>
</section>

