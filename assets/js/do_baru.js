$(document).ready(function(){
	$('#table_pengiriman').load("json/data_pengiriman.php");
  $("#notrans").load("json/nomor_transaksi_pengiriman.php");
  $("#kode_barang").focus();

  $("#kode_barang").on("keypress", function(e){
  var kode_barang = $("#kode_barang").val();
    if(e.which == 13){
      $.ajax({
          // type: 'POST',
          url: "json/cari_data_barang.php",
          data:"op=stok_gudang&kode_barang="+kode_barang,
          cache:false,
          success: function(msg) {
            data=msg.split("|");
            console.log(data);
            if(data[0].trim()==="sukses"){
              // alert('berhasil');
              $("#invoice").val(data[1]);
              $("#nama_barang").val(data[2]);
              $("#stok").val(data[3]);
              $("#harga_pokok").val(data[4]);
              $("#harga_jual").val(data[5]);
              $("#id_jenis").val(data[6]);
              $("#satuan").val(data[7]);

              // $("#qty").val('1');
              $("#qty").focus();
            }else{
              alert('kode barang belum ada, silahkan input di master jenis barang');
              return;
              // console.log(msg);  
            }      
        }
      });
    }
  });

});

function removeFormat(str){
  // var n = parseFloat(str.replace(/£/g, ""));
  var n=str.search(/\)/g);
  result="";
  if(Number(n)!=-1){// maka nlai tersebut adalah negatif dan akan dirubah ke nilai sebelumnya
     result="-" + str.replace(/\)/g,'');
   result=result.replace(/\(/g,'');// remove tanda kurung buka
   result=result.replace(/\s/g,'');// remove tanda spasi kosong
   result=result.replace(/[^\d\.\-\ ]/g, ''); //remove koma      
  }else{
     result=str.replace(/[^\d\.\-\ ]/g, '');
  } 
  return result
}

function isNumber(evt) {
  evt = (evt) ? evt : window.event;
  var charCode = (evt.which) ? evt.which : evt.keyCode;     
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
      return false;
    }
  return true;
}

function tambah(){
  var invoice = $("#invoice").val();
  var kode_barang = $("#kode_barang").val();
  var nama_barang = $("#nama_barang").val();
  var harga_pokok = removeFormat($("#harga_pokok").val());
  var harga_jual = removeFormat($("#harga_jual").val());
  var stok = $("#stok").val();
  var id_jenis = $("#id_jenis").val();
  var satuan = $("#satuan").val();
  var qty = $("#qty").val();

  if(kode_barang==''){
    alert("Kode Barang tidak boleh kosong");
    $("#kode_barang").focus();
    return;
  }

  if(parseInt(qty) > parseInt(stok)){
    alert("jumlah melebihi stok gudang");
    return;
  }

  if((parseInt(qty) == 0) || (qty =='')){
    alert("jumlah qty tidak boleh nol atau kosong");
    return;
  }

  $.ajax({
      // type: 'POST',
      url: "json/simpan_transaksi_pengiriman.php",
      data:"op=tambah&invoice="+invoice+"&kode_barang="+kode_barang+"&nama_barang="+nama_barang+"&harga_pokok="+harga_pokok+"&harga_jual="+harga_jual+"&stok="+stok+"&id_jenis="+id_jenis+"&satuan="+satuan+"&qty="+qty,
      cache:false,
      success: function(msg) {
        console.log(msg);
        if(msg.trim()==="sukses"){
          // alert('berhasil');
          $('#table_pengiriman').load("json/data_pengiriman.php");
          $("#notrans").load("json/nomor_transaksi_pengiriman.php");
          clear_input();
          $("#kode_barang").focus();
        }else if(msg.trim()==="over"){
          alert('barang sudah dimasukkan ke list penjualan dan melebihi batas stok');
        }else if(msg.trim()==="gagal"){
          alert('silahkan ulangi');
          // console.log(msg);  
        }      
    }
  });
  
}

function buka_list(){
  $("#largeModal").modal('show');
}

function pilih_data(invoice,kd_barang,nama_barang,id_jenis,satuan,stok,harga_pokok,harga_jual){
  $("#invoice").val(invoice);
  $("#kode_barang").val(kd_barang);
  $("#nama_barang").val(nama_barang);
  $("#stok").val(stok);
  $("#harga_pokok").val(harga_pokok);
  $("#harga_jual").val(harga_jual);
  $("#id_jenis").val(id_jenis);
  $("#satuan").val(satuan);

  $("#largeModal").modal('hide');
  $("#qty").focus();

  // perkalian();
}

function clear_input(){
  $("#invoice").val('');
  $("#kode_barang").val('');
  $("#nama_barang").val('');
  $("#harga_pokok").val('');
  $("#harga_jual").val('');
  $("#stok").val('');
  $("#qty").val('');

}

function hapus(){
  $.ajax({
    // type: 'POST',
    url: "json/simpan_transaksi_pengiriman.php",
    data:"op=clear",
    cache:false,
    success: function(msg) {
      console.log(msg);
      if(msg.trim()==="sukses"){
        $('#table_pengiriman').load("json/data_pengiriman.php");
        $("#notrans").load("json/nomor_transaksi_pengiriman.php");
      }else{
        alert('silahkan ulangi');
        // console.log(msg);  
      }
    
    }
  });
}

function hapus_list(invoice,kode_barang){
  $.ajax({
    url: "json/simpan_transaksi_pengiriman.php",
    data:"op=hapus_list&invoice="+invoice+"&kode_barang="+kode_barang,
    cache:false,
    success: function(msg) {
      console.log(msg);
      if(msg.trim()==="sukses"){
        $('#table_pengiriman').load("json/data_pengiriman.php");
        $("#notrans").load("json/nomor_transaksi_pengiriman.php");
      }else{
        alert('silahkan ulangi');
      }
    
    }
  });
}

function modalTutup(){
  $("#konfirmasi_kirim").modal('hide');
}

function proses_kirim(){
  // alert('tes tombol proses_kirim');
  // return;

  var lokasi = $("#lokasi").val();

  if(lokasi==''){
    alert('silahkan pilih lokasi pengiriman');
    modalTutup();
    return;
  }

  // alert(lokasi);
  // return;
  $.ajax({
    url: "json/simpan_transaksi_pengiriman.php",
    data:"op=simpan&lokasi="+lokasi,
    cache:false,
    success: function(msg) {
      console.log(msg);
      if(msg.trim()==="sukses"){
        alert('berhasil');
        modalTutup();
        $('#table_pengiriman').load("json/data_pengiriman.php");
        $("#notrans").load("json/nomor_transaksi_pengiriman.php");
      }else{
        modalTutup();
        alert('silahkan ulangi');
      }
    
    }
  });
}