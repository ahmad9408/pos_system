$(document).ready(function(){
	$('#tabel_trans').load("json/tampil_data.php");
  $("#update").hide();
  $("#diskon").prop('disabled', true);

    $("#kode_barang").on("keypress", function(e){
    var kode_barang = $("#kode_barang").val();
      if(e.which == 13){
        $.ajax({
            // type: 'POST',
            url: "json/cari_data_barang.php",
            data:"op=nama&kode_barang="+kode_barang,
            cache:false,
            success: function(msg) {
              data=msg.split("|");
              console.log(data);
              if(data[0].trim()==="sukses"){
                // alert('berhasil');
                $("#nama_barang").val(data[1]);
                $("#stok").val(data[2]);
                $("#harga").val(data[3]);

                $("#jml").val('1');
                perkalian();
              }else{
                // alert('silahkan ulangi');
                // console.log(msg);  
              }      
          }
        });
      }
    });

  $("#flexSwitchCheckChecked").click(function () {
    if ($(this).is(":checked")) {
        // $("#diskon").prop('disabled', false);
        $("#diskon").removeAttr("disabled");
        $("#diskon").focus();
    } else {
        $("#diskon").attr("disabled", "disabled");
        $("#diskon").val('0');
        perkalian();
        // $("#diskon").prop('disabled', true);
    }
  });

});

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

function perkalian(){
 var harga = $("#harga").val();
 var jml = $("#jml").val();
 var diskon = $("#diskon").val();

 var hasil_diskon = harga * diskon / 100;
 var harga_akhir = harga - hasil_diskon;
 var hasil = jml * harga_akhir;
 var thasil = hasil.value;

 $("#total").val(format('#,##0.##',hasil));
 // var total_harga = $(".total").val();
 // $('#total_biaya').val(total_harga);

 simpan();
}

function pengurangan(){
 var total_bayar = $("#total_bayar").val();
 var bayar = removeFormat($("#bayar").val());
 var diskon_total = $("#diskon_total").val();

 var hasil_diskon_total = (total_bayar * diskon_total) / 100;

 var harga_akhir = total_bayar - hasil_diskon_total;
 var kembalian = bayar - harga_akhir;
 // var thasil = hasil.value;

 $("#hasil_diskon_total").val(hasil_diskon_total);
 $("#harga_akhir").val(harga_akhir);
 $("#kembalian").val(format('#,##0.##',kembalian));
 // $("#kembalian").val(kembalian);
 // alert(harga_akhir);
 // var total_harga = $(".total").val();
 // $('#total_biaya').val(total_harga);
}


function clear_input(){
  $("#kode_barang").val('');
  $("#nama_barang").val('');
  $("#harga").val('');
  $("#stok").val('');
  $("#jml").val('');
  $("#total").val('');

}

function simpan(){
  var kode_barang = $("#kode_barang").val();
  var nama_barang = $("#nama_barang").val();
  var harga = removeFormat($("#harga").val());
  var stok = $("#stok").val();
  var jml = $("#jml").val();
  var total = removeFormat($("#total").val());

  if(kode_barang==''){
    alert("Kode Barang tidak boleh kosong");
    $("#kode_barang").focus();
    return;
  }

  if(nama_barang==''){
    alert("Nama Barang tidak boleh kosong");
    $("#nama_barang").focus();
    return;
  }

  if(harga==''){
    alert("Harga tidak boleh kosong");
    return;
  }

  if(jml==''){
    alert("Jumlah Barang tidak boleh kosong");
    return;
  }

  if(jml=='0'){
    alert("Jumlah Barang tidak boleh nol");
    return;
  }

  if(total==''){
    alert("Total Harga tidak boleh kosong");
    return;
  }

  if(stok=='0'){
    alert('stok barang habis');
    return;
  }

  if(parseInt(jml) > parseInt(stok)){
    alert('jumlah melebihi stok barang');
    return;
  }

  // alert(stok);
  // alert(kode_barang+' - '+nama_barang+' - '+harga+' - '+stok+' - '+jml+' - '+total);
  // return;


  $.ajax({
      // type: 'POST',
      url: "json/simpan_transaksi.php",
      data:"op=proses&kode_barang="+kode_barang+"&nama_barang="+nama_barang+"&harga="+harga+"&stok="+stok+"&jml="+jml+"&total="+total,
      cache:false,
      success: function(msg) {
        console.log(msg);
        if(msg.trim()==="sukses"){
          // alert('berhasil');
          $('#tabel_trans').load("json/tampil_data.php");
          clear_input();
        }else if(msg.trim()==="over"){
          alert('barang sudah dimasukkan ke list penjualan dan melebihi batas stok');
        }else if(msg.trim()==="gagal"){
          alert('silahkan ulangi');
          // console.log(msg);  
        }      
    }
  });
  
}

function update(){
  // var id_urutan = $("#id_urutan").val();
  var kode_barang = $("#kode_barang").val();
  var nama_barang = $("#nama_barang").val();
  var harga = removeFormat($("#harga").val());
  var stok = $("#stok").val();
  var jml = $("#jml").val();
  var total = removeFormat($("#total").val());

  if(kode_barang==''){
    alert("Kode Barang tidak boleh kosong");
    $("#kode_barang").focus();
    return;
  }

  // if(id_urutan==''){
  //   alert("Kode Urutan Barang tidak boleh kosong");
  //   $("#id_urutan").focus();
  //   return;
  // }

  if(nama_barang==''){
    alert("Nama Barang tidak boleh kosong");
    $("#nama_barang").focus();
    return;
  }

  if(harga==''){
    alert("Harga tidak boleh kosong");
    return;
  }

  if(jml==''){
    alert("Jumlah Barang tidak boleh kosong");
    return;
  }

  if(total==''){
    alert("Total Harga tidak boleh kosong");
    return;
  }

  if(parseInt(jml) > parseInt(stok)){
    alert('jumlah melebihi stok barang');
    return;
  }

  $.ajax({
      // type: 'POST',
      url: "json/simpan_transaksi.php",
      data:"op=update&kode_barang="+kode_barang+"&nama_barang="+nama_barang+"&harga="+harga+"&stok="+stok+"&jml="+jml+"&total="+total,
      cache:false,
      success: function(msg) {
        console.log(msg);
        if(msg.trim()==="sukses"){
          // alert('berhasil');
          $('#tabel_trans').load("json/tampil_data.php");
          $("#id_urutan").val('');
          $("#kode_barang").val('');
          $("#nama_barang").val('');
          $("#stok").val('');
          $("#harga").val('');
          $("#jml").val('');
          $("#total").val('');

          $("#submit").show();
          $("#update").hide();

        }else{
          alert('silahkan ulangi');
          // console.log(msg);  
        }      
    }
  });
  
}

function show_submit(){
  $('.but_exec').show();
  // alert('test');
}
function hapus(){
  // alert('ini tombol clear');
  // return;

  $.ajax({
    // type: 'POST',
    url: "json/simpan_transaksi.php",
    data:"op=clear",
    cache:false,
    success: function(msg) {
      console.log(msg);
      if(msg.trim()==="sukses"){
        // alert('berhasil');
        $('#tabel_trans').load("json/tampil_data.php");
        // document.getElementById("id").value = "";
        // document.getElementById("form-data").reset();
        // $('.but_exec').hide();
      }else{
        alert('silahkan ulangi');
        // console.log(msg);  
      }
    
    }
  });
}

function proses(){
  $("#konfirmasi_jual").modal('show');
}

function modalTutup(){
  $("#konfirmasi_jual").modal('hide');
}

function proses_penjualan(){
  var total_bayar = $("#total_bayar").val();
  var diskon_total = $("#diskon_total").val();
  var hasil_diskon_total = $("#hasil_diskon_total").val();
  var harga_akhir = $("#harga_akhir").val();
  var bayar = $("#bayar").val();
  var kembalian = $("#kembalian").val();

  // if(total_bayar==''){
  //   alert('total bayar kosong');
  //   return
  // }

  if(bayar==''){
    alert('total bayar kosong');
    modalTutup();
    $("#bayar").focus();
    return;
  }

  if(bayar=='0'){
    alert('total tidak bisa di isi nol');
    modalTutup();
    $("#bayar").focus();
    return;
  }

  if(kembalian==''){
    alert('nilai kembalian tidak benar');
    modalTutup();
    $("#kembalian").focus();
    return;
  }

  var number_str_bayar = bayar.replace(/[^\d]/g,"");

  if(parseFloat(number_str_bayar) < parseInt(total_bayar)){
    alert('nilai bayar  lebih kecil dari total harga');
    modalTutup();
    $("#bayar").focus();
    return;
  }

  // alert(number_string+' - '+total_bayar);
  // return;
  // return;
  // alert(total_bayar+' - '+diskon_total+' - '+hasil_diskon_total+' - '+bayar+' - '+kembalian);

  $.ajax({
    url: "json/simpan_transaksi.php",
    data:"op=simpan&total_bayar="+total_bayar+"&diskon_total="+diskon_total+"&hasil_diskon_total="+hasil_diskon_total+"&harga_akhir="+harga_akhir+"&bayar="+bayar+"&kembalian="+kembalian,
    cache:false,
    success: function(msg) {
      console.log(msg);
      if(msg.trim()==="sukses"){
        alert('berhasil');
        modalTutup();
        $('#tabel_trans').load("json/tampil_data.php");
      }else{
        modalTutup();
        alert('silahkan ulangi');
      }
    
    }
  });
}

function buka_list(){
  // alert('list barang');
  $("#largeModal").modal('show');
}

function batal(){
  $("#konfirmasi_jual").modal('hide');
  // alert('testing batal');
}

function pilih_data(kd_barang,nama_barang,satuan,stok,harga_jual){
  $("#kode_barang").val(kd_barang);
  $("#nama_barang").val(nama_barang);
  $("#stok").val(stok);
  $("#harga").val(harga_jual);

  $("#largeModal").modal('hide');

  $("#jml").val('1');

  perkalian();
}

function hapus_list(kode_barang){
  $.ajax({
    url: "json/simpan_transaksi.php",
    data:"op=hapus_list&kode_barang="+kode_barang,
    cache:false,
    success: function(msg) {
      console.log(msg);
      if(msg.trim()==="sukses"){
        // alert('berhasil');
        $('#tabel_trans').load("json/tampil_data.php");
      }else{
        alert('silahkan ulangi');
      }
    
    }
  });
}

function edit_data(id,kode_barang,nama_barang,harga,stok,qty,total) {
  // $("#id_urutan").val(id);
  $("#kode_barang").val(kode_barang);
  $("#nama_barang").val(nama_barang);
  $("#harga").val(harga);
  $("#stok").val(stok);
  $("#jml").val(qty);
  $("#total").val(total);

  $("#submit").hide();
  $("#update").show();
}
