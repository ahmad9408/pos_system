<?php session_start();
    include("../config/koneksi.php");
    include("../config/lock.php");
    
    $today = date('Y-m-d H:i:s');
    $tahun = date('y');
    $bulan = date('m');
    $tanggal = date('d');
?>

<script type="text/javascript">
	function hapus_list(kode_barang){
	  $.ajax({
	    url: "json/simpan_pembelian.php",
	    data:"op=hapus_list&kode_barang="+kode_barang,
	    cache:false,
	    success: function(msg) {
	      console.log(msg);
	      if(msg.trim()==="sukses"){
	        // alert('berhasil');
	        $('#table_pembelian').load("json/data_pembelian.php");
	      }else{
	        alert('silahkan ulangi');
	      }
	    
	    }
	  });
	}

	function proses(){
	  var lokasi = $("#lokasi").val();
	  if(lokasi == ''){
	    alert('pilih tujuan penyimpanan');
	    return;
	  }

	  $("#konfirmasi_simpan").modal('show');
	  // $("#button_simpan").focus();
	  document.getElementById("button_simpan").focus();
	}
</script>

<div class="card">
	<div class="card-body">
		<h5 class="card-title"></h5>
		<table class="table table-bordered">
			<thead>
			  <tr align="center">
			  	<th>#</th>
			    <th scope="col">Kode Barang</th>
			    <th scope="col">Nama Barang</th>
			    <!-- <th scope="col">Stok</th> -->
			    <th scope="col">Harga Pokok</th>
			    <th scope="col">Harga Jual</th>
			    <th scope="col">QTY</th>
			    <th scope="col">Satuan</th>
			  </tr>
			</thead>
		    <?php
			    $sql="SELECT t.id, t.kd_barang, t.nama_barang, t.satuan, t.harga_pokok, t.harga_jual, t.qty, t.tgl_input, t.updatedate, t.updateby, s.satuan as nama_satuan
			    	FROM tbl_pembelian_temp as t
			    	LEFT JOIN tbl_satuan as s ON t.satuan=s.id
			    	WHERE t.updateby='$session_nik' ORDER BY t.id DESC";
			    $hasil=mysqli_query($connect,$sql);
			    $jml_data = mysqli_num_rows($hasil);
			    $no=0;
			        while ($data = mysqli_fetch_array($hasil)) {
			        $no++;
			        $gtotal += $data['total'];
		    ?>
		    <tbody>
			    <tr>
			        <td id="urutan<?php echo $no;?>" value="<?php echo $data[id];?>"><?php echo $no;?></td>
			        <td><?php echo $data["kd_barang"];?></td>
			        <td><?php echo $data["nama_barang"];?></td>
			        <!-- <td><?php echo $data["stok"];?></td> -->
			        <td align="left">Rp. <span style="float: right;"><?php echo number_format($data["harga_pokok"]);?></span></td>
			        <td align="left">Rp. <span style="float: right;"><?php echo number_format($data["harga_jual"]);?></span></td>
			        <td><?php echo $data["qty"];?></td>
			        <td><?php echo $data["nama_satuan"];?></td>
			        <td colspan="2">
			          <span class="btn btn-warning btn-sm" id="edit" name="edit" onclick="edit_data('<?php echo $data["id"];?>','<?php echo $data["kd_barang"];?>','<?php echo $data["nama_barang"];?>','<?php echo $data["harga_pokok"];?>','<?php echo $data["harga_jual"];?>','<?php echo $data["stok"];?>','<?php echo $data["qty"];?>')"><i class="bi bi-pencil-square"></i></span>
			          <span class="btn btn-danger btn-sm" id="hapus" name="hapus" onclick="hapus_list('<?php echo $data[kd_barang];?>')"><i class="bi bi-trash-fill"></i></span>
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