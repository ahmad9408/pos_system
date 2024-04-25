<?php session_start();
  include("../config/koneksi.php");
  include("../config/lock.php");
  $today = date('Y-m-d H:i:s');
  $todayZ = date('Y-m-d');

?>
<div class="col-lg-12">
  <div class="card">
    <div class="card-body">
      <!-- <h5 class="card-title">Daftar Jenis Barang</h5> -->
      <div class="box-body table-responsive no-padding">
        <br>
        <br>
        <p>Nb: Silahkan isi kode barcode sesuai dengan yang tertera dikemasan, setelah itu lengkapi data yang dibutuhkan seperti Nama Barang, Jenis, Satuan, Harga Pokok dan Harga Jual.<br>
          jika sudah lengkap , silahkan simpan data tersebut dengan cara tekan Enter (posisi kursor berada di kolom harga jual). Maka data yang di input tai akan dimunculkan di tabel dibawah ini<br>
          Data yang dimunculkan adalah data input per tanggal berjalan</p><br>
        <p>Jika terdapat kesalahan saat menginput data, silahkan klik tombol berwarna merah di sudut kanan tabel sesuai dengan data yang akan dihapus</p>
        <table class="table table-bordered">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Kode Barang</th>
              <th scope="col">Nama Barang</th>
              <th scope="col">Satuan</th>
              <th scope="col">Harga Pokok</th>
              <th scope="col">Harga Jual</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <?php
              $sql_master_barang = "SELECT
                                      m.`kd_barang`,
                                      m.`nama_barang`,
                                      m.`id_jenis`,
                                      m.`harga_pokok`,
                                      m.`harga_jual`,
                                      m.`updatedate`,
                                      s.`satuan`
                                    FROM `tbl_mst_barang` as m
                                    LEFT JOIN tbl_satuan as s on m.satuan=s.id
                                    WHERE kd_barang!='' AND updatedate like '%$todayZ%'
                                    ORDER BY updatedate DESC";
              // echo $sql_master_barang;
              $res_master_barang = mysqli_query($connect,$sql_master_barang);
              while($data=mysqli_fetch_array($res_master_barang)){
                $no++;
                $updatedate = $data['updatedate'];
                $exp = explode(" ",$updatedate);
                $tgl_input = $exp[0];

            ?>
            <tr>
              <td><?php echo $no;?></td>
              <td><?php echo $data['kd_barang'];?></td>
              <td><?php echo $data['nama_barang'];?></td>
              <td><?php echo $data['satuan'];?></td>
              <td align="left">Rp. <span style="float: right;"><?php echo number_format($data['harga_pokok']);?></span></td>
              <td align="left">Rp. <span style="float: right;"><?php echo number_format($data['harga_jual']);?></span></td>
              <td colspan="2">
                <?php if($tgl_input == $todayZ){ ?>
                <!-- <span class="btn btn-warning btn-sm" id="edit" name="edit" onclick="edit_data('<?php echo $data['kd_barang'];?>','<?php echo $data['nama_barang'];?>','<?php echo $data['id_jenis'];?>','<?php echo $data['satuan'];?>','<?php echo $data['harga_pokok'];?>','<?php echo $data['harga_jual'];?>')"><i class="bi bi-pencil-square"></i></span> -->
                <span class="btn btn-danger btn-sm" onclick="hapus_list('<?php echo $data['kd_barang'];?>')" id="btn_hapus"><i class="bi bi-trash-fill"></i></span>
                <?php } ?>
              </td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>