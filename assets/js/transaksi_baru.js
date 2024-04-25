$(document).ready(function(){
  $('#tabel_trans').load("json/tampil_data.php");
	$('#notrans').load("json/nomor_transaksi_penjualan.php");
  $("#dis_up").hide();
  $("#update").hide();
  $("#batal_update").hide();
  $("#diskon").prop('disabled', true);
  $("#data_nis").hide();
  $("#jml_update").hide();
  $("#diskon_update").hide();
  $("#diskon_update").prop('disabled', true);
  // document.getElementById("nis").style.display = 'none';

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
                $("#id_lokasi").val(data[4]);

                $("#jml").val('1');
                perkalian();
              }else{
                alert('Stok kosong atau kode barang belum ada, silahkan lihat di master barang');
                return;
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

  $("#ceklis_update").click(function () {
    if ($(this).is(":checked")) {
        // $("#diskon").prop('disabled', false);
        $("#diskon_update").removeAttr("disabled");
        $("#diskon_update").focus();
    } else {
        $("#diskon_update").attr("disabled", "disabled");
        $("#diskon_update").val('0');
        perkalian_update();
        // $("#diskon").prop('disabled', true);
    }
  });

});

function removeRow(counter){
  var id_jenis_bayar = $("#id_jenis_bayar"+counter).val();
  if(id_jenis_bayar == 1){
    $("#data_nis").val('');
    $("#data_nis").hide();
  }

  $('#row'+counter).remove();
  // pengurangan_debit(counter);
  hitung_total_non_cash();
  pengurangan();
}

function removeRow_all(){
  for(let i = 0; i < 10; i++){
      // document.write("<p>Perulangan ke-" + i + "</p>")
    var id_jenis_bayar = $("#id_jenis_bayar"+i).val();
      $("#data_nis").val('');
      $("#data_nis").hide();
      $('#row'+i).remove();
  }
  // pengurangan_debit(counter);
  hitung_total_non_cash();
  pengurangan();
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

function perkalian(){
 var harga = $("#harga").val();
 var jml = $("#jml").val();
 var jml_update = $("#jml_update").val();
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

function perkalian_update(){
 var harga = $("#harga").val();
 var jml = $("#jml").val();
 var jml_update = $("#jml_update").val();
 var diskon_update = $("#diskon_update").val();

 var hasil_diskon = harga * diskon_update / 100;
 var harga_akhir = harga - hasil_diskon;
 var hasil = jml_update * harga_akhir;
 var thasil = hasil.value;

 $("#total").val(format('#,##0.##',hasil));
 // var total_harga = $(".total").val();
 // $('#total_biaya').val(total_harga);

}

function pilih_data_debit(nis,nama,nilai,tgl_input){
  // alert(nilai);
  // return;
  var total_bayar = $("#total_bayar").val();
  var counter_t = $("#counter_t").val();

  if(nilai == 0){
    alert('Nilai Deposit Anda sudah habis, silahkan lakukan pengisian ulang');
    return;
  }

  if(parseInt(nilai) >= parseInt(total_bayar)){
    $("#bayar_non_cash"+counter_t).val(format('#,##0.##',total_bayar));
    $("#input_bayar_non_cash"+counter_t).val(total_bayar);
    pengurangan_debit(counter_t);
  }else{
    $("#bayar_non_cash"+counter_t).val(format('#,##0.##',nilai));
    $("#input_bayar_non_cash"+counter_t).val(nilai);
    pengurangan_debit(counter_t);
  }

  $("#nis").val(nis+'-'+nama);
  $("#form_data_tabungan").modal('hide');

  hitung_total_non_cash();
}

function pengurangan_debit(counter_t){
  // alert(counter_t);
  // return;
 var total_bayar = $("#total_bayar").val();
 // var bayar_non_cash = removeFormat($("#bayar_non_cash"+counter_t).val());
 // var bayar = removeFormat($("#bayar").val());
 var diskon_total = $("#diskon_total").val();

 var hasil_diskon_total = (total_bayar * diskon_total) / 100;

 var harga_akhir = total_bayar - hasil_diskon_total;

 // var kembalian = bayar_non_cash - harga_akhir;
 // var thasil = hasil.value;
 // $("#total_non_cash").val(bayar_non_cash);

 $("#hasil_diskon_total").val(hasil_diskon_total);
 $("#harga_akhir").val(harga_akhir);

 // $("#kembalian").val(format('#,##0.##',kembalian));

 hitung_total_non_cash();
 pengurangan();
}




function pengurangan(){
 var total_bayar = $("#total_bayar").val();
 var total_non_cash = removeFormat($("#total_non_cash").val());
 if(total_non_cash == ''){
  var t_bayar_non_cash = 0;
 }else{
  var t_bayar_non_cash = total_non_cash;
 }

 var bayar = removeFormat($("#bayar").val());
 var diskon_total = $("#diskon_total").val();

 var hasil_diskon_total = (total_bayar * diskon_total) / 100;

 var harga_akhir = total_bayar - hasil_diskon_total;

 var total_nilai = parseInt(t_bayar_non_cash) + parseInt(bayar);
 // var kembalian = bayar - harga_akhir;
 var kembalian = total_nilai - harga_akhir;
 // var thasil = hasil.value;
 // alert(t_bayar_non_cash);

 $("#hasil_diskon_total").val(hasil_diskon_total);
 $("#harga_akhir").val(harga_akhir);
 $("#kembalian").val(format('#,##0.##',kembalian));

 $("#tot_pembayaran").val(format('#,##0.##',total_nilai));
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
  $("#jml_update").val('');
  $("#diskon_update").val('');
  $("#total").val('');

}

function simpan(){
  var kode_barang = $("#kode_barang").val();
  var nama_barang = $("#nama_barang").val();
  var harga = removeFormat($("#harga").val());
  var stok = $("#stok").val();
  var jml = $("#jml").val();
  var diskon = $("#diskon").val();
  var total = removeFormat($("#total").val());
  var id_lokasi = $("#id_lokasi").val();

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
      data:"op=proses&kode_barang="+kode_barang+"&nama_barang="+nama_barang+"&harga="+harga+"&stok="+stok+"&jml="+jml+"&total="+total+"&id_lokasi="+id_lokasi+"&diskon="+diskon,
      cache:false,
      success: function(msg) {
        console.log(msg);
        if(msg.trim()==="sukses"){
          // alert('berhasil');
          $('#tabel_trans').load("json/tampil_data.php");
          $('#notrans').load("json/nomor_transaksi_penjualan.php");
          clear_input();
        }else if(msg.trim()==="over"){
          alert('barang sudah dimasukkan ke list penjualan dan melebihi batas stok');
        }else if(msg.trim()==="gagal"){
          alert('silahkan ulangi'+ msg);
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
  var id_lokasi = $("#id_lokasi").val();
  var jml_update = $("#jml_update").val();
  var diskon_update = $("#diskon_update").val();
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

  if(jml_update==''){
    alert("Jumlah Barang tidak boleh kosong");
    return;
  }

  if(total==''){
    alert("Total Harga tidak boleh kosong");
    return;
  }

  if(parseInt(jml_update) > parseInt(stok)){
    alert('jumlah melebihi stok barang');
    return;
  }

  // alert(kode_barang+' - '+nama_barang+' - '+stok+' - '+harga+' - '+jml+' - '+total);
  // return;
  $.ajax({
    url: "json/simpan_transaksi.php",
    data:"op=update&kode_barang="+kode_barang+"&nama_barang="+nama_barang+"&harga="+harga+"&stok="+stok+"&jml_update="+jml_update+"&total="+total+"&id_lokasi="+id_lokasi+"&diskon_update="+diskon_update,
    cache:false,
    success: function(msg) {
      console.log(msg);
      if(msg.trim()==="sukses"){
        // alert('berhasil');
        $('#tabel_trans').load("json/tampil_data.php");
        $('#notrans').load("json/nomor_transaksi_penjualan.php");
        $("#id_urutan").val('');
        $("#kode_barang").val('');
        $("#nama_barang").val('');
        $("#stok").val('');
        $("#id_lokasi").val('');
        $("#harga").val('');
        $("#jml_update").val('');
        $("#diskon").val('');
        $("#diskon_update").val('');
        $("#total").val('');

        $("#diskon").show();
        $("#dis").show();
        $("#dis_up").hide();

        $("#btn_submit").show();
        $("#update").hide();
        $("#batal_update").hide();

      }else{
        alert('silahkan ulangi');
        // console.log(msg);  
      }      
    }
  });
  
}

function batal_update(){
  $("#kode_barang").val('');
  $("#nama_barang").val('');
  $("#harga").val('');
  $("#stok").val('');
  $("#jml").val('');
  $("#jml_update").val('');
  $("#diskon").val('');
  $("#diskon_update").val('');
  $("#total").val('');

  $("#btn_submit").show();
  $("#update").hide();
  $("#batal_update").hide();
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
        $('#notrans').load("json/nomor_transaksi_penjualan.php");
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


function modalTutup(){
  $("#konfirmasi_jual").modal('hide');
  $.ajax({
    url: "json/simpan_transaksi.php",
    data:"op=clear_temp_trans_non_cash",
    cache:false,
    success: function(msg) {
      console.log(msg);
      if(msg.trim()==="sukses"){
      
      }else{
      
      }
    
    }
  });
}

function proses(){
  var b_n_cash = $("#b_n_cash").val();
  var b_cs = $("#b_cs").val();
  // alert(b_n_cash+' - '+b_cs);return;

  var items = new Array();
  var itemCount = document.getElementsByClassName("tnc");
  var nilai_non_cash = 0;
  var id_jenis_bayar= "";
  var jenis_bayar= "";
  var id= "";
  var seq= "";
  var nis = $("#nis").val();
  
  
  var total_non_cash = $("#total_non_cash").val();
  var tot_pembayaran = $("#tot_pembayaran").val();
  // alert(total_non_cash);return;
  if((b_n_cash == 1) && (b_cs == 0)){
    for(var i = 0; i < itemCount.length; i++){
      id_jenis_bayar = "id_jenis_bayar"+(i+1);
      jenis_bayar = "jenis_bayar"+(i+1);
      id = "input_bayar_non_cash"+(i+1);
      seq = i+1;

      // total = parseInt(document.getElementById(id).value);
      id_jenis_bayar = document.getElementById(id_jenis_bayar).value;
      jenis_bayar = document.getElementById(jenis_bayar).value;
      nilai_non_cash = document.getElementById(id).value;
      // console.log(id_jenis_bayar+' - '+jenis_bayar+' - '+nilai_non_cash);
      if(itemCount == 'undefined'){
        var ambil_seq = 0;
      }else{
        var ambil_seq = seq;
      }

      // alert('test');return;
      $.ajax({
        url: "json/simpan_transaksi.php",
        data:"op=simpan_sementara&id_jenis_bayar="+id_jenis_bayar+"&jenis_bayar="+jenis_bayar+"&nilai_non_cash="+nilai_non_cash+"&nis="+nis+"&seq="+ambil_seq+"&total_non_cash="+total_non_cash,
        cache:false,
        success: function(msg) {
          console.log(msg);
          if(msg.trim()==="sukses"){
            // alert('berhasil');
            $("#konfirmasi_jual").modal('show');
            $('#konfirmasi_jual').modal('show',{backdrop: 'static', keyboard: false});
            // modalTutup();
          }else{
            // modalTutup();
            alert('silahkan ulangi');
          }
        
        }
      });
    }
  }else if(b_n_cash == 1 && b_cs == 1){
      for(var i = 0; i < itemCount.length; i++){
        id_jenis_bayar = "id_jenis_bayar"+(i+1);
        jenis_bayar = "jenis_bayar"+(i+1);
        id = "input_bayar_non_cash"+(i+1);
        seq = i+1;

        // total = parseInt(document.getElementById(id).value);
        id_jenis_bayar = document.getElementById(id_jenis_bayar).value;
        jenis_bayar = document.getElementById(jenis_bayar).value;
        nilai_non_cash = document.getElementById(id).value;
        // console.log(id_jenis_bayar+' - '+jenis_bayar+' - '+nilai_non_cash);
        if(itemCount == 'undefined'){
          var ambil_seq = 0;
        }else{
          var ambil_seq = seq;
        }

        // alert('test');return;
        $.ajax({
          url: "json/simpan_transaksi.php",
          data:"op=simpan_sementara&id_jenis_bayar="+id_jenis_bayar+"&jenis_bayar="+jenis_bayar+"&nilai_non_cash="+nilai_non_cash+"&nis="+nis+"&seq="+ambil_seq+"&total_non_cash="+total_non_cash,
          cache:false,
          success: function(msg) {
            console.log(msg);
            if(msg.trim()==="sukses"){
              // alert('berhasil');
              $("#konfirmasi_jual").modal('show');
              $('#konfirmasi_jual').modal('show',{backdrop: 'static', keyboard: false});
              // modalTutup();
            }else{
              // modalTutup();
              alert('silahkan ulangi');
            }
          
          }
        });
      }
  }else if(b_n_cash == 0 && b_cs == 1){
    // alert(total_non_cash);return;
    $("#konfirmasi_jual").modal('show');
    $('#konfirmasi_jual').modal('show',{backdrop: 'static', keyboard: false});
  }else{
    alert('Total pembayaran masih kosong');
  }
}

function proses_penjualan(){
  var items = new Array();
  var itemCount = document.getElementsByClassName("tnc");
  var nilai_non_cash = 0;
  var id_jenis_bayar= "";
  var jenis_bayar= "";
  var id= "";
  var seq= "";
  for(var i = 0; i < itemCount.length; i++){
    id_jenis_bayar = "id_jenis_bayar"+(i+1);
    jenis_bayar = "jenis_bayar"+(i+1);
    id = "input_bayar_non_cash"+(i+1);
    seq = i+1;

    // total = parseInt(document.getElementById(id).value);
    id_jenis_bayar = document.getElementById(id_jenis_bayar).value;
    jenis_bayar = document.getElementById(jenis_bayar).value;
    nilai_non_cash = document.getElementById(id).value;
    // console.log(id_jenis_bayar+' - '+jenis_bayar+' - '+nilai_non_cash);
  }

  var total_bayar = $("#total_bayar").val();
  var diskon_total = $("#diskon_total").val();
  var hasil_diskon_total = $("#hasil_diskon_total").val();
  var harga_akhir = $("#harga_akhir").val();
  var total_non_cash = $("#total_non_cash").val();
  var tot_pembayaran = $("#tot_pembayaran").val();
  var bayar = $("#bayar").val();
  var kembalian = $("#kembalian").val();
  var nis = $("#nis").val();

  if(itemCount == 'undefined'){
    var ambil_seq = 0;
  }else{
    var ambil_seq = seq;
  }
  // console.log(total_bayar+' - '+diskon_total+' - '+hasil_diskon_total+' - '+harga_akhir+' - '+total_non_cash+' - '+tot_pembayaran+' - '+bayar+' - '+kembalian+' - '+nis);

  // if(total_bayar==''){
  //   alert('total bayar kosong');
  //   return
  // }

  // if(bayar==''){
  //   alert('total bayar kosong');
  //   modalTutup();
  //   $("#bayar").focus();
  //   return;
  // }

  // if(bayar=='0'){
  //   alert('total tidak bisa di isi nol');
  //   modalTutup();
  //   $("#bayar").focus();
  //   return;
  // }
  var number_str_tot_pembayaran = tot_pembayaran.replace(/[^\d]/g,"");
  if(parseInt(number_str_tot_pembayaran) > 0){
    console.log(number_str_tot_pembayaran);
    if(diskon_total == 0){
      if(parseFloat(number_str_tot_pembayaran) < parseInt(total_bayar)){
        alert('Nilai bayar lebih kecil dari total harga');
        modalTutup();
        $("#bayar").focus();
        return;
      }
    }
  }else{
    console.log('0');
    alert('Nilai bayar lebih kecil dari total harga');
    return;
  }

  // return;

  if(parseInt(kembalian) < 0){
    alert('Nilai kembalian tidak bisa minus');
    modalTutup();
    $("#kembalian").focus();
    return;
  }

  if(kembalian==''){
    alert('Nilai kembalian tidak benar');
    modalTutup();
    $("#kembalian").focus();
    return;
  }

  // var number_str_bayar = bayar.replace(/[^\d]/g,"");

  // if(parseFloat(number_str_bayar) < parseInt(total_bayar)){
  //   alert('Nilai bayar  lebih kecil dari total harga');
  //   modalTutup();
  //   $("#bayar").focus();
  //   return;
  // }


  // alert(number_string+' - '+total_bayar);
  // return;
  // return;
  // alert(total_bayar+' - '+diskon_total+' - '+hasil_diskon_total+' - '+bayar+' - '+kembalian);

  $.ajax({
    url: "json/simpan_transaksi.php",
    data:"op=simpan&total_bayar="+total_bayar+"&diskon_total="+diskon_total+"&hasil_diskon_total="+hasil_diskon_total+"&harga_akhir="+harga_akhir+"&bayar="+bayar+"&kembalian="+kembalian+"&nis="+nis+"&seq="+ambil_seq+"&id_jenis_bayar="+id_jenis_bayar+"&jenis_bayar="+jenis_bayar+"&nilai_non_cash="+nilai_non_cash+"&total_non_cash="+total_non_cash+"&tot_pembayaran="+tot_pembayaran,
    cache:false,
    success: function(msg) {
      console.log(msg);
      data=msg.split("|");
      var pesan = data[0];
      var no_transaksi = data[1];
      var id_kasir = data[2];
      var tgl_transaksi = data[3];
      var id_kasir = data[4];
      var qty = data[5];
      var subtotal = data[6];
      var diskon = data[7];
      var total_akhir = data[8];
      var total_non_cash = data[9];
      var total_cash = data[10];
      var total_pembayaran = data[11];
      var total_bayar = data[12];
      var kembalian = data[13];
      var lokasi = data[14];
      var status_penjualan = data[15];
      var tgl_batal = data[16];
      var tgl_transaksi_update = data[17];
      var user_pembatal = data[18];

      if(pesan.trim()==="sukses"){
        notif('simpan_penjualan');
        modalTutup();
        print_out(no_transaksi,id_kasir);
        // buka_modul_print(no_transaksi,id_kasir);
        // window.location.href="pages/print_out_trans.php?notrans="+no_transaksi+"&id_kasir="+id_kasir+"&target="+_blank;
        // window.open('pages/print_out_trans.php?notrans="+no_transaksi+"&id_kasir="+id_kasir', '_blank');

        $('#tabel_trans').load("json/tampil_data.php");
        $('#notrans').load("json/nomor_transaksi_penjualan.php");
        upload_transaksi(tgl_transaksi,no_transaksi,id_kasir,qty,subtotal,diskon,total_akhir,total_non_cash,total_cash,total_pembayaran,total_bayar,kembalian,lokasi,status_penjualan,tgl_batal,tgl_transaksi_update,user_pembatal);
        // alert(tgl_transaksi+' - '+no_transaksi+' - '+id_kasir+' - '+qty+' - '+subtotal+' - '+diskon+' - '+total_akhir+' - '+total_non_cash+' - '+total_cash+' - '+total_pembayaran+' - '+total_bayar+' - '+kembalian+' - '+lokasi+' - '+status_penjualan+' - '+tgl_batal+' - '+tgl_transaksi_update+' - '+user_pembatal);
  // return;

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

function pilih_data(kd_barang,nama_barang,satuan,stok,harga_jual,lokasi){
  $("#kode_barang").val(kd_barang);
  $("#nama_barang").val(nama_barang);
  $("#stok").val(stok);
  $("#harga").val(harga_jual);
  $("#id_lokasi").val(lokasi);

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
        $('#notrans').load("json/nomor_transaksi_penjualan.php");
      }else{
        alert('silahkan ulangi');
      }
    
    }
  });
}

function edit_data(id,kode_barang,nama_barang,harga,stok,qty,diskon,total,id_lokasi) {
  // $("#id_urutan").val(id);
  $("#kode_barang").val(kode_barang);
  $("#nama_barang").val(nama_barang);
  $("#harga").val(harga);
  $("#stok").val(stok);
  $("#id_lokasi").val(id_lokasi);
  $("#jml").hide();
  $("#jml_update").show();
  $("#jml_update").val(qty);
  $("#diskon").hide();
  $("#diskon_update").show();
  $("#diskon_update").val(diskon);
  // $("#diskon_update").prop('disabled', true);

  $("#dis").hide();
  $("#dis_up").show();

  $("#total").val(total);

  $("#btn_submit").hide();
  $("#update").show();
  $("#batal_update").show();
}


// function buka_tf(){
//   $("#form_data_tf").modal('show');
//   $('#form_data_tf').modal('show',{backdrop:'static', keyboard:false});
//   $("#data_nis").show();
// }

function batal_buka(){
  $("#form_data_tabungan").modal('hide');
  $("#data_nis").hide();
  
  $("#b_tf").prop('checked', false);
}

function pilih_jenis(id,jenis){
  var no = $("#counter_jenis").val();
  var total_bayar = $("#total_bayar").val();
  var harga_akhir = $("#harga_akhir").val();

  if(harga_akhir == 0){
    var ambil_nilai = total_bayar;
  }else{
    var ambil_nilai = harga_akhir;
  }

  if(id != 1){
    // $("#bayar_non_cash"+no).removeAttr("readonly");
    $("#input_bayar_non_cash"+no).val(ambil_nilai);
    $("#bayar_non_cash"+no).val(format('#,##0.##',ambil_nilai));

    // $("#total_non_cash").val(tot);
    pengurangan_debit(no);
  }else{
    $("#bayar_non_cash"+no).val("");
    $("#total_non_cash").val('0,00');
    $("#tot_pembayaran").val('0,00');
    $("#kembalian").val('0,00');
    $("#data_nis").show();
    // hitung_total_non_cash();
  }

  $("#id_jenis_bayar"+no).val(id);
  $("#jenis_bayar"+no).val(jenis);
  tutup_jenis_bayar();
}

function tutup_jenis_bayar(){
  $("#tabel_jenis_bayar").modal('hide');
}


function buka_modul_print(notrans,id_kasir){
  // var notrans = $("#notrans").text();
  // alert(notrans);
  // return;
  // $.ajax({
  //   url: "json/struk_belanja.php",
  //   data:"op=proses&notrans="+notrans,
  //   cache:false,
  //   success: function(msg) {
  //     console.log(msg);
          // data=msg.split("|");
          // var pesan = data[0];
        
          // if(msg.trim()==="sukses"){
            $('#dt_trans').load("json/modal_print.php?notrans="+notrans+"&id_kasir="+id_kasir);
            $("#form_print_out").modal('show');
            // print_out(notrans,id_kasir);
            // $("#no_transaksi").html(notrans);
            // $("#qty_p").html(qty);
            // $("#nama_barang_p").html(nama_barang);
            // $("#kode_barang_p").html(kode_barang);
            // $("#harga_p").html(harga);
            // $("#total_p").html(total);
            // $("#subtotal_p").html(subtotal);
            // $("#total_qty_p").html(total_qty);
            // $("#diskon_p").html(diskon);
            // $("#total_akhir_p").html(total_akhir);
            // $("#total_non_cash_p").html(total_non_cash);
            // $("#total_cash_p").html(total_cash);
            // $("#total_pembayaran_p").html(total_pembayaran);
            // $("#total_bayar_p").html(total_bayar);
            // $("#kembalian_p").html(kembalian);
            // $("#lokasi_p").html(lokasi);
            // $("#updatedate_p").html(updatedate);
            // $("#id_kasir_p").html(id_kasir);
            // $("#kode").load("prosesdo.php","op=ambilbarang");
          // }
    // }
  // });
}

function print_out(notrans,id_kasir){
  $.ajax({
    url: "pages/print_out_trans.php",
    data:{notrans:notrans,id_kasir:id_kasir},
    cache:false,
    success: function(msg) {
      console.log(msg);

    }
  });
}

function upload_transaksi(tgl_transaksi,no_transaksi,id_kasir,qty,subtotal,diskon,total_akhir,total_non_cash,total_cash,total_pembayaran,total_bayar,kembalian,lokasi,status_penjualan,tgl_batal,tgl_transaksi_update,user_pembatal){
  var no = 1;
  // alert(tgl_transaksi+' - '+no_transaksi+' - '+id_kasir+' - '+qty+' - '+subtotal+' - '+diskon+' - '+total_akhir+' - '+total_non_cash+' - '+total_cash+' - '+total_pembayaran+' - '+total_bayar+' - '+kembalian+' - '+lokasi+' - '+status_penjualan+' - '+tgl_batal+' - '+tgl_transaksi_update+' - '+user_pembatal);
  // return;

  $.ajax({
    url: "json/upload_transaksi_harian.php",
    // type:"POST",
    data:"op=proses_upload&no="+no+"&tgl_transaksi="+tgl_transaksi+"&no_transaksi="+no_transaksi+"&id_kasir="+id_kasir+"&qty="+qty+"&subtotal="+subtotal+"&diskon="+diskon+"&total_akhir="+total_akhir+"&total_non_cash="+total_non_cash+"&total_cash="+total_cash+"&total_pembayaran="+total_pembayaran+"&total_bayar="+total_bayar+"&kembalian="+kembalian+"&lokasi="+lokasi+"&status_penjualan="+status_penjualan+"&tgl_batal="+tgl_batal+"&tgl_transaksi_update="+tgl_transaksi_update+"&user_pembatal="+user_pembatal,
    cache:false,
    success: function(msg) {
      console.log(msg);
      if(msg.trim()==="sukses"){
          // $(".loader").fadeOut();
          // notif('berhasil_upload');
      }else{

      }
    }
  });
}

function hitung_total_non_cash(){
    var items = new Array();
    var itemCount = document.getElementsByClassName("tnc");
    var total = 0;
    var id= "";

    for(var i = 0; i < itemCount.length; i++){
      id = "input_bayar_non_cash"+(i+1);
      // alert(id);
      // return;
      total = total + parseInt(document.getElementById(id).value);
      
     console.log(total);
    }

    if (!isNaN(total)) { 
      document.getElementById('total_non_cash').value = total;
      $("#total_non_cash").val(format('#,##0.##',total));
      return total;
    
    }if (isNaN(total)) {
      document.getElementById('total_non_cash').value = "";
      $("#total_non_cash").val(format('#,##0.##',total));
    }

  }