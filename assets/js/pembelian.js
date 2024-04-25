$(document).ready(function(){
	$('#table_pembelian').load("json/data_pembelian.php");
  $("#notrans").load("json/nomor_transaksi_pembelian.php");
  $("#kode_barang").focus();

  $("#kode_barang").on("keypress", function(e){
  var kode_barang = $("#kode_barang").val();
    if(e.which == 13){
      $.ajax({
          // type: 'POST',
          url: "json/cari_data_barang.php",
          data:"op=kode&kode_barang="+kode_barang,
          cache:false,
          success: function(msg) {
            data=msg.split("|");
            console.log(data);
            if(data[0].trim()==="sukses"){
              // alert('berhasil');
              $("#nama_barang").val(data[1]);
              // $("#stok").val(data[2]);
              $("#harga_pokok").val(data[2]);
              $("#harga_jual").val(data[3]);
              $("#id_jenis").val(data[4]);
              $("#satuan").val(data[5]);

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
  var kode_barang = $("#kode_barang").val();
  var nama_barang = $("#nama_barang").val();
  var harga_pokok = removeFormat($("#harga_pokok").val());
  var harga_jual = removeFormat($("#harga_jual").val());
  var id_jenis = $("#id_jenis").val();
  var satuan = $("#satuan").val();
  var qty = $("#qty").val();

  if(kode_barang==''){
    alert("Kode Barang tidak boleh kosong");
    $("#kode_barang").focus();
    return;
  }

  $.ajax({
      // type: 'POST',
      url: "json/simpan_pembelian.php",
      data:"op=proses&kode_barang="+kode_barang+"&nama_barang="+nama_barang+"&harga_pokok="+harga_pokok+"&harga_jual="+harga_jual+"&id_jenis="+id_jenis+"&satuan="+satuan+"&qty="+qty,
      cache:false,
      success: function(msg) {
        console.log(msg);
        if(msg.trim()==="sukses"){
          // alert('berhasil');
          $('#table_pembelian').load("json/data_pembelian.php");
          $("#notrans").load("json/nomor_transaksi_pembelian.php");
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

function simpan_modal(){
  var kode_barang = $("#m_kode_barang").val();
  var nama_barang = $("#m_nama_barang").val();
  var harga_pokok = removeFormat($("#m_harga_pokok").val());
  var harga_jual = removeFormat($("#m_harga_jual").val());
  var stok = $("#m_stok").val();
  var qty = $("#m_qty").val();

  if(kode_barang==''){
    alert("Kode Barang tidak boleh kosong");
    $("#m_kode_barang").focus();
    return;
  }

  $.ajax({
      // type: 'POST',
      url: "json/simpan_pembelian.php",
      data:"op=update&kode_barang="+kode_barang+"&nama_barang="+nama_barang+"&harga_pokok="+harga_pokok+"&harga_jual="+harga_jual+"&stok="+stok+"&qty="+qty,
      cache:false,
      success: function(msg) {
        console.log(msg);
        if(msg.trim()==="sukses"){
          // alert('berhasil');
          tutup_modal();
          $('#table_pembelian').load("json/data_pembelian.php");
          $("#notrans").load("json/nomor_transaksi_pembelian.php");
          // clear_input();
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

function clear_input(){
  $("#kode_barang").val('');
  $("#nama_barang").val('');
  $("#harga_pokok").val('');
  $("#harga_jual").val('');
  $("#stok").val('');
  $("#qty").val('');

}


function tutup_modal_konfirmasi(){
  $("#konfirmasi_simpan").modal('hide');
}

function hapus(){
  $.ajax({
    // type: 'POST',
    url: "json/simpan_pembelian.php",
    data:"op=clear",
    cache:false,
    success: function(msg) {
      console.log(msg);
      if(msg.trim()==="sukses"){
        // alert('berhasil');
        $('#table_pembelian').load("json/data_pembelian.php");
        $("#notrans").load("json/nomor_transaksi_pembelian.php");
      }else{
        alert('silahkan ulangi');
        // console.log(msg);  
      }
    
    }
  });
}

function edit_data(id,kode_barang,nama_barang,harga_pokok,harga_jual,stok,qty) {
  // $("#id_urutan").val(id);
  $("#edit_list").modal('show');
  $("#m_kode_barang").val(kode_barang);
  $("#m_nama_barang").val(nama_barang);
  $("#m_harga_pokok").val(harga_pokok);
  $("#m_harga_jual").val(harga_jual);
  $("#m_stok").val(stok);
  $("#m_qty").val(qty);

  $("#m_qty").focus();
}


function tutup_modal(){
  $("#edit_list").modal('hide');
}

function proses_simpan_pembelian(){
  var lokasi = $("#lokasi").val();

  if(lokasi==''){
    alert('lokasi tujuan tidak boleh kosong');
    tutup_modal_konfirmasi();
    return;
  }

  $.ajax({
    url: "json/simpan_pembelian.php",
    data:"op=simpan&lokasi="+lokasi,
    cache:false,
    success: function(msg) {
      console.log(msg);
      if(msg.trim()==="sukses"){
        alert('berhasil disimpan');
        tutup_modal_konfirmasi();
        $('#table_pembelian').load("json/data_pembelian.php");
        $("#notrans").load("json/nomor_transaksi_pembelian.php");
      }else{
        tutup_modal_konfirmasi();
        alert('ada kesalahan, silahkan ulangi');
      }
    
    }
  });
}