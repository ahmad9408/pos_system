<?php session_start();
    include("../config/koneksi.php");
    include("../config/lock.php");
    
    $today = date('Y-m-d H:i:s');
    $tahun = date('y');
    $bulan = date('m');
    $tanggal = date('d');
?>

<script type="text/javascript">
	// function hapus_list(kode_barang){
	//   $.ajax({
	//     url: "json/simpan_transaksi_pengiriman.php",
	//     data:"op=hapus_list&invoice="+invoice+"&kode_barang="+kode_barang,
	//     cache:false,
	//     success: function(msg) {
	//       console.log(msg);
	//       if(msg.trim()==="sukses"){
	//         $('#table_pengiriman').load("json/data_pengiriman.php");
    //     	$("#notrans").load("json/nomor_transaksi_pengiriman.php");
	//       }else{
	//         alert('silahkan ulangi');
	//       }
	    
	//     }
	//   });
	// }
	// $(document).ready(function(){

	// 	document.getElementById("simpan").addEventListener("click", () => {
	// 		$("#konfirmasi_kirim").modal('show');
	// 	  // document.getElementById("button_simpan").focus({focusVisible: true});
	// 	  $("#button_simpan").focus({focusVisible: true});
	// 	});
	// });

	function proses(){
	  $("#konfirmasi_kirim").modal('show');
	  // document.getElementById("button_simpan").focus({focusVisible: true});
	}
</script>

<div class="card">
	<div class="card-body">
		<h5 class="card-title"></h5>
		<table class="table table-bordered">
			<thead>
			  <tr>
			  	<th align="center">#</th>
			    <th align="center" scope="col">Invoice</th>
			    <th align="center" scope="col">Kode Barang</th>
			    <th align="center" scope="col">Nama Barang</th>
			    <th align="center" scope="col">Stok</th>
			    <th align="center" scope="col">Harga Pokok</th>
			    <th align="center" scope="col">Harga Jual</th>
			    <th align="center" scope="col">QTY</th>
			    <th align="center" scope="col">Satuan</th>
			  </tr>
			</thead>
		    <?php
			    $sql="SELECT t.invoice, t.kd_barang, t.nama_barang, t.satuan, t.stok, t.harga_pokok, t.harga_jual, t.qty, t.tgl_input, t.updatedate, t.updateby, s.satuan as nama_satuan
					    	FROM tbl_do_temp as t
					    	LEFT JOIN tbl_satuan as s ON t.satuan=s.id
					    	WHERE t.updateby='$session_nik' ORDER BY t.updatedate DESC";
			    $hasil=mysqli_query($connect,$sql)or die($sql);
			    $jml_data = mysqli_num_rows($hasil);
			    $no=0;
			    // echo $sql;
	        while ($data = mysqli_fetch_array($hasil)) {
		        $no++;
		        $gtotal += $data['total'];
		    ?>
		    <tbody>
			    <tr>
			        <td id="urutan<?php echo $no;?>" value="<?php echo $data[id];?>"><?php echo $no;?></td>
			        <td><?php echo $data["invoice"];?></td>
			        <td><?php echo $data["kd_barang"];?></td>
			        <td><?php echo $data["nama_barang"];?></td>
			        <td><?php echo $data["stok"];?></td>
			        <td><?php echo number_format($data["harga_pokok"]);?></td>
			        <td><?php echo number_format($data["harga_jual"]);?></td>
			        <td><?php echo $data["qty"];?></td>
			        <td><?php echo $data["nama_satuan"];?></td>
			        <td colspan="2">
			          <!-- <span class="btn btn-warning btn-sm" id="edit" name="edit" onclick="edit_data('<?php echo $data[invoice];?>','<?php echo $data["kd_barang"];?>','<?php echo $data["nama_barang"];?>','<?php echo $data["harga_pokok"];?>','<?php echo $data["harga_jual"];?>','<?php echo $data["stok"];?>','<?php echo $data["qty"];?>')"><i class="bi bi-pencil-square"></i></span> -->
			          <span class="btn btn-danger btn-sm" id="hapus" name="hapus" onclick="hapus_list('<?php echo $data[invoice];?>','<?php echo $data[kd_barang];?>')"><i class="bi bi-trash-fill"></i></span>
			        </td>
			    </tr>
		    </tbody>

		    <?php
		        }
		    ?>
		</table>
		<?php if($jml_data>0){ ?> 
			<div class="col-sm-12 but_exec" align="center">
	          <span id="simpan" name="simpan" class="btn btn-block btn-primary" onclick="proses()" disabled>Simpan</span>
	          <span id="clear" name="clear" class="btn btn-block btn-danger" onclick="hapus()" disabled>Clear</span>
	        </div>
		<?php } ?>
	</div>
</div>

<div class="modal fade" id="largeModal" tabindex="-1">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <table class="table table-striped table-bordered datatable">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Kode Barang</th>
              <th scope="col">Invoice</th>
              <th scope="col">Nama Barang</th>
              <th scope="col">Satuan</th>
              <th scope="col">Harga Pokok</th>
              <th scope="col">Harga Jual</th>
              <th scope="col">Stok</th>
            </tr>
          </thead>
          <tbody>
            <?php
              $sql_master_barang = "SELECT g.invoice, g.kd_barang, g.nama_barang, m.satuan, g.stok, g.harga_pokok, g.harga_jual, g.id_jenis, s.satuan AS nama_satuan
              											FROM tbl_stok_gudang as g 
              											LEFT JOIN tbl_mst_barang AS m ON g.kd_barang=m.kd_barang
              											LEFT JOIN tbl_satuan AS s ON m.satuan=s.id
              											WHERE g.stok > 0 AND g.is_aktif = '1'";
              $res_mst_barang = mysqli_query($connect,$sql_master_barang);
              while($s=mysqli_fetch_array($res_mst_barang)){
                $nomer++;
                $invoice = $s['invoice'];
                $kd_barang = $s['kd_barang'];
                $nama_barang = $s['nama_barang'];
                $satuan = $s['satuan'];
                $nama_satuan = $s['nama_satuan'];
                $stok = $s['stok'];
                $harga_pokok = $s['harga_pokok'];
                $harga_jual = $s['harga_jual'];
                $id_jenis = $s['id_jenis'];
            ?>
            <tr>
              <th scope="row"><?php echo $nomer;?></th>
              <td id="kd" onclick="pilih_data('<?php echo $invoice;?>','<?php echo $kd_barang;?>','<?php echo $nama_barang;?>','<?php echo $id_jenis;?>','<?php echo $satuan;?>','<?php echo $stok;?>','<?php echo $harga_pokok;?>','<?php echo $harga_jual;?>')"><?php echo $kd_barang;?></td>
              <td id="inv" onclick="pilih_data('<?php echo $invoice;?>','<?php echo $kd_barang;?>','<?php echo $nama_barang;?>','<?php echo $id_jenis;?>','<?php echo $satuan;?>','<?php echo $stok;?>','<?php echo $harga_pokok;?>','<?php echo $harga_jual;?>')"><?php echo $invoice;?></td>
              <td id="nm" onclick="pilih_data('<?php echo $invoice;?>','<?php echo $kd_barang;?>','<?php echo $nama_barang;?>','<?php echo $id_jenis;?>','<?php echo $satuan;?>','<?php echo $stok;?>','<?php echo $harga_pokok;?>','<?php echo $harga_jual;?>')"><?php echo $nama_barang;?></td>
              <td id="st" onclick="pilih_data('<?php echo $invoice;?>','<?php echo $kd_barang;?>','<?php echo $nama_barang;?>','<?php echo $id_jenis;?>','<?php echo $satuan;?>','<?php echo $stok;?>','<?php echo $harga_pokok;?>','<?php echo $harga_jual;?>')"><?php echo $nama_satuan;?></td>
              <td id="hj" onclick="pilih_data('<?php echo $invoice;?>','<?php echo $kd_barang;?>','<?php echo $nama_barang;?>','<?php echo $id_jenis;?>','<?php echo $satuan;?>','<?php echo $stok;?>','<?php echo $harga_pokok;?>','<?php echo $harga_jual;?>')"><?php echo number_format($harga_pokok);?></td>
              <td id="hj" onclick="pilih_data('<?php echo $invoice;?>','<?php echo $kd_barang;?>','<?php echo $nama_barang;?>','<?php echo $id_jenis;?>','<?php echo $satuan;?>','<?php echo $stok;?>','<?php echo $harga_pokok;?>','<?php echo $harga_jual;?>')"><?php echo number_format($harga_jual);?></td>
              <td id="sk" onclick="pilih_data('<?php echo $invoice;?>','<?php echo $kd_barang;?>','<?php echo $nama_barang;?>','<?php echo $id_jenis;?>','<?php echo $satuan;?>','<?php echo $stok;?>','<?php echo $harga_pokok;?>','<?php echo $harga_jual;?>')"><?php echo $stok;?></td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
      <div class="modal-footer">
<!--         <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button> -->
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="konfirmasi_kirim">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">
        Jika  Yakin Klik tombol Proses!.</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" align="center">
        <span id="button_simpan" name="button_simpan" class="btn btn-block btn-primary" onclick="proses_kirim()" tabindex="-1">Proses</span>
        <!-- <a href="#" id="button_simpan" name="button_simpan" onclick="proses_kirim()">Proses</a> -->
        <span id="batal" name="batal" class="btn btn-block btn-danger" onclick="modalTutup()">Batal</span>

      </div>
    </div>
  </div>
</div>