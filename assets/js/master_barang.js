$(document).ready(function(){
  $( "#awal_download" ).datepicker({
    changeMonth: true,
    changeYear: true,
    format: 'yyyy-mm-dd',
    autoclose: true
  });

  $( "#akhir_download" ).datepicker({
    changeMonth: true,
    changeYear: true,
    format: 'yyyy-mm-dd',
    autoclose: true
  });

  $(".loader").fadeOut();
	$('#data_master').load("json/data_master_barang.php");
	
	$("#form_tambah_master_barang").hide();
	$("#but_cancel").hide();

	$("#harga_jual").on("keypress", function(e){
    var kode_barang = $("#kode_barang").val();
	var nm_barang = $("#nm_barang").val();
	var id_jenis = $("#id_jenis").val();
	var satuan = $("#satuan").val();
	var harga_pokok = $("#harga_pokok").val();
    var harga_jual = $("#harga_jual").val();

      if(e.which == 13){
      	// alert(kode_barang+' - '+nm_barang+' - '+id_jenis+' - '+satuan+' - '+harga_pokok+' - '+harga_jual);
      	// return;
        $.ajax({
            // type: 'POST',
            url: "json/simpan_master_barang.php",
            data:"op=proses&kode_barang="+kode_barang+"&nm_barang="+nm_barang+"&id_jenis="+id_jenis+"&satuan="+satuan+"&harga_pokok="+harga_pokok+"&harga_jual="+harga_jual,
            cache:false,
            success: function(msg) {
              data=msg.split("|");
              console.log(data);
              if(data[0].trim()==="sukses"){
                $('#data_master').load("json/data_master_barang.php");
                clear_input();
              }else{
                alert('Kode Barang Sudah ada');
                return;
              }      
          }
        });
      }
    });
});

function clear_input(){
	$("#kode_barang").val('');
	$("#nm_barang").val('');
	$("#id_jenis").val('');
	$("#satuan").val('');
	$("#harga_pokok").val('');
	$("#harga_jual").val('');
}

function buka_form_input(){
	$("#form_tambah_master_barang").show();
	$("#but_input").hide();
	$("#but_cancel").show();
	$("#table_master").hide();
}

function tutup_form_input(){
	$("#form_tambah_master_barang").hide();
	$("#but_input").show();
	$("#but_cancel").hide();
	$("#table_master").show();
}

function edit_data(kd_barang,nama_barang,id_jenis,satuan,harga_pokok,harga_jual){
	$("#konfirmasi_edit").modal('show');
	$("#kode_barang_edit").val(kd_barang);
	$("#nama_barang_edit").val(nama_barang);
	$("#id_jenis_edit").val(id_jenis);
	$("#harga_pokok_edit").val(harga_pokok);
	$("#harga_jual_edit").val(harga_jual);
	$("#satuan_edit").html("<select id='satuan_edit' class='form-select' style='width:300px'>"+satuan+"</select>");

}

function modalTutup(){
	$("#konfirmasi_edit").modal('hide');
}

function hapus_list(kd_barang){
	var kd_barang = kd_barang;
	$.ajax({
        url: "json/simpan_master_barang.php",
        data:"op=hapus&kd_barang="+kd_barang,
        cache:false,
        success: function(msg) {
          data=msg.split("|");
          console.log(data);
          if(data[0].trim()==="sukses"){
            $('#data_master').load("json/data_master_barang.php");
            // clear_input();
          }else{
            alert('Ada kesalahan, silahkan ulangi');
            return;
          }      
      }
    });
}

function CurrFormat(){
  $('.currInput').blur(function() {
          // $('.nilai1').html(null);
          $(this).formatCurrency({ colorize: true, negativeFormat: '-%s%n', roundToDecimalPlace: 0 });
  })

  .keyup(function(e) {
      var e = window.event || e;
      var keyUnicode = e.charCode || e.keyCode;
      if (e !== undefined) {
        switch (keyUnicode) {
          case 16: break; // Shift
          case 27: this.value = ''; break; // Esc: clear entry
          case 35: break; // End
          case 36: break; // Home
          case 37: break; // cursor left
          case 38: break; // cursor up
          case 39: break; // cursor right
          case 40: break; // cursor down
          case 78: break; // N (Opera 9.63+ maps the "." from the number key section to the "N" key too!) (See: http://unixpapa.com/js/key.html search for ". Del")
          case 110: break; // . number block (Opera 9.63+ maps the "." from the number block to the "N" key (78) !!!)
          case 190: break; // .
          default: $(this).formatCurrency({ colorize: true, negativeFormat: '-%s%n', roundToDecimalPlace: -1, eventOnDecimalsEntered: true });
        }
      }
  })
}

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

function buka_form_pencarian_pengiriman(){
  $("#form_pencarian").modal('show');
}

function tutup_form_pencarian_pengiriman(){
  $("#form_pencarian").modal('hide');
}

function cari_pengiriman(){
  var awal = $("#awal_download").val();
  var akhir = $("#akhir_download").val();
  var lokasi = $("#lokasi").val();
  var no_transaksi = $("#no_transaksi").val();

  if((awal=='')||(akhir=='')){
    alert("range tanggal harus dipilih");
    return;
  }
  // alert(awal+' - '+akhir);
  // return;
  tutup_form_pencarian_pengiriman();
  notif('proses_download');
  $(".loader").fadeIn();
  $.ajax({
    // type: 'POST',
    url: "json/download_master_barang.php",
    data:"op=proses_download&awal="+awal+"&akhir="+akhir,
    cache:false,
    success: function(msg) {
      console.log(msg);
      data=msg.split("|");
      if(data[0].trim()==="sukses"){
        $(".loader").fadeOut();
        notif('berhasil_download');
        window.location.reload();
        // $('#tbl_do').load("json/data_do.php?lokasi="+lokasi+"&awal="+awal+"&akhir="+akhir+"&no_transaksi="+no_transaksi);
      }else if(data[0].trim()==="kosong"){
        alert('Tidak ada data terbaru');
        $(".loader").fadeOut();
        return;
      }else{
        $(".loader").fadeOut();
        alert('silahkan ulangi');
        return;
      }
    }
  });

}