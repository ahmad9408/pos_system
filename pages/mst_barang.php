<?php
  include("config/koneksi.php");
?>

<script type="text/javascript" src="assets/js/jquery.min.js"></script>
<!-- <script type="text/javascript" src="assets/js/transaksi_baru.js"></script> -->
<section class="section">
  <div class="row">
    <div class="col-lg-12">

      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Master Data Barang</h5>

            <div class="row mb-3">
              <label for="inputEmail" class="col-sm-3 col-form-label">Nama Barang</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" id="nama_barang" name="nama_barang">
              </div>
            </div>
            
            <div class="mb-3">
              <!-- <label class="col-sm-2 col-form-label">Tambah</label> -->
              <div class="col-sm-12">
                <span id="submit" name="submit" class="btn btn-block btn-primary">Cari</span>
              </div>
            </div>
        </div>
      </div>

    </div>

    <div class="col-lg-12">

      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Daftar Jenis Barang</h5>
          <table class="table table-bordered">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Kode Barang</th>
                <th scope="col">Nama Barang</th>
                <th scope="col">Jenis Barang</th>
                <th scope="col">Satuan</th>
                <th scope="col">Harga Pokok</th>
                <th scope="col">PPN</th>
                <th scope="col">Harga Jual</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td colspan="2">
                  <span class="btn btn-warning btn-sm" id="edit" name="edit"><i class="bi bi-pencil-square"></i></span>
                  <span class="btn btn-danger btn-sm" id="hapus" name="hapus"><i class="bi bi-trash-fill"></i></span>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

    </div>
  </div>
</section>