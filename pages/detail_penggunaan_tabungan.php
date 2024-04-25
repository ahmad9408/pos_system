<?php session_start();
  include("config/koneksi.php");
  include("config/lock.php");
  $today = date('Y-m-d H:i:s');
  $todayZ = date('Y-m-d');

  $no_nis = $_REQUEST['no_nis'];
  $nama_req = $_REQUEST['nama_req'];
  $norek = $_REQUEST['norek'];
?>

<section class="section">
  <div class="row">
    <div class="col-lg-6">
      <div class="card-body">
        
      </div>
    </div>
    <div class="col-lg-12">

      <div class="card">
        <div class="card-body">
        	<div class="box-body table-responsive no-padding">
	          <h5 class="card-title">Detail Penggunaan Tabungan</h5>
	          <table>
	          	<tr>
	          		<td width="150">NIS</td>
	          		<td width="15">:</td>
	          		<td><?php echo $no_nis;?></td>
	          	</tr>
	          	<tr>
	          		<td width="150">Nama</td>
	          		<td width="15">:</td>
	          		<td><?php echo $nama_req;?></td>
	          	</tr>
	          	<tr>
	          		<td width="150">No. Rekening</td>
	          		<td width="15">:</td>
	          		<td><?php echo $norek;?></td>
	          	</tr>
	          </table>
	          <br><br>
	          <table class="table table-bordered table-hover table-striped">
	            <thead>
	              <tr align="center">
	                <th scope="col">#</th>
	                <th scope="col">NIS</th>
	                <th scope="col">Nomor Rekening</th>
	                <th scope="col">Saldo</th>
	                <th scope="col">No Transaksi</th>
	                <th scope="col">Tanggal Proses</th>
	                <th scope="col">Saldo Awal</th>
	                <th scope="col">Nilai</th>
	                <th scope="col">Saldo Akhir</th>
	                <th scope="col">Kode Barang</th>
	                <th scope="col">Nama Barang</th>
	                <th scope="col">Harga</th>
	                <th scope="col">Stok</th>
	                <th scope="col">Qty</th>
	                <th scope="col">Total</th>
	              </tr>
	            </thead>
	            <tbody>
	              <?php
	                  $sql_daftar_penjualan = "SELECT
												    `mt`.`nis`
												    , `mt`.`no_rekening`
												    , `mt`.`saldo`
												    , `tnc`.`no_transaksi`
												    , `pt`.`tgl_proses`
												    , `pt`.`saldo_awal`
												    , `pt`.`nilai`
												    , `pt`.`saldo_akhir`
												    , `pt`.`updatedate`
												    , `pt`.`updateby`
												    , `td`.`kode_barang`
												    , `td`.`nama_barang`
												    , `td`.`harga`
												    , `td`.`stok`
												    , `td`.`qty`
												    , `td`.`total`
												FROM
												    `tbl_mst_tabungan` AS `mt`
												    INNER JOIN `pos`.`tbl_transaksi_non_cash` AS `tnc` 
												        ON (`mt`.`no_rekening` = `tnc`.`no_kartu`)
												    INNER JOIN `pos`.`tbl_proses_tabungan` AS `pt`
												        ON (`tnc`.`no_transaksi` = `pt`.`id_proses`)
												    INNER JOIN `pos`.`tbl_transaksi_detail` AS `td`
												        ON (`tnc`.`no_transaksi` = `td`.`no_transaksi`)
												WHERE mt.nis='$no_nis'";
	                  $res_mst_barang = mysqli_query($connect,$sql_daftar_penjualan)or die($sql_daftar_penjualan);
	                  while($data=mysqli_fetch_array($res_mst_barang)){
	                    $no++;
	                    $nis = $data['nis'];
	                    $no_rekening = $data['no_rekening'];
	                    $saldo = $data['saldo'];
	                    $no_transaksi = $data['no_transaksi'];
	                    $updatedate = $data['updatedate'];
	                    	$ambil_updatedate = date("d M Y H:i:s",strtotime($data['updatedate']));
	                    $saldo_awal = $data['saldo_awal'];
	                    $nilai = $data['nilai'];
	                    $saldo_akhir = $data['saldo_akhir'];
	                    $kode_barang = $data['kode_barang'];
	                    $nama_barang = $data['nama_barang'];
	                    $harga = $data['harga'];
	                    $stok = $data['stok'];
	                    $qty = $data['qty'];
	                    $total = $data['total'];
	                    
	              ?>
	              <tr>
						<td><?php echo $no;?></td>
						<td><?php echo $nis;?></td>
						<td><?php echo $no_rekening;?></td>
						<td align="left">Rp. <span style="float: right"><?php echo number_format($saldo);?></span></td>
						<td><?php echo $no_transaksi;?></td>
						<td><?php echo $ambil_updatedate;?></td>
						<td align="left">Rp. <span style="float: right"><?php echo number_format($saldo_awal);?></span></td>
						<td align="left">Rp. <span style="float: right"><?php echo number_format($nilai);?></span></td>
						<td align="left">Rp. <span style="float: right"><?php echo number_format($saldo_akhir);?></span></td>
						<td><?php echo $kode_barang;?></td>
						<td><?php echo $nama_barang;?></td>
						<td align="left">Rp. <span style="float: right"><?php echo number_format($harga);?></span></td>
						<td><?php echo $stok;?></td>
						<td><?php echo $qty;?></td>
						<td align="left">Rp. <span style="float: right"><?php echo number_format($total);?></span></td>
	              </tr>
	            <?php } ?>
	            </tbody>
	          </table>
	      	</div>
        </div>
      </div>

    </div>
  </div>
</section>