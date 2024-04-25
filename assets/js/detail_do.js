$(document).ready(function(){
  $(".loader").fadeOut();

});

function batal_pengiriman(){
 $("#form_pembatal").modal('show');
}

function modalTutup(){
 $("#form_pembatal").modal('hide');
}

function proses_pembatalan(notrans){
  var notrans = notrans;
  // alert(notrans);
  $("#button_simpan").hide();
  $.ajax({
    url: "json/simpan_transaksi_pengiriman.php",
    data:"op=batal&notrans="+notrans,
    cache:false,
    success: function(msg) {
      console.log(msg);
      if(msg.trim()==="sukses"){
        modalTutup();
        alert('pembatalan berhasil');
        window.location.reload();
      }else{
        alert('silahkan ulangi');
      }
    }
  });
}

function terima_pengiriman(){
 $("#form_terima").modal('show');
}

function tutup_form_terima(){
 $("#form_terima").modal('hide');
}

function proses_penerimaan(notrans){
  var notrans = notrans;
  // alert(notrans);
  $(".loader").fadeIn();
  tutup_form_terima();
  $.ajax({
    url: "json/simpan_transaksi_pengiriman.php",
    data:"op=terima&notrans="+notrans,
    cache:false,
    success: function(msg) {
      console.log(msg);
      if(msg.trim()==="sukses"){
        tutup_form_terima();
        alert('berhasil di terima');
        $(".loader").fadeOut();
        window.location.reload();
      }else{
        $(".loader").fadeOut();
        alert('silahkan ulangi');
      }
    }
  });
}

function tolak_pengiriman(){
 $("#form_tolak").modal('show');
}

function tutup_form_penolakan(){
 $("#form_tolak").modal('hide');
}

function proses_penolakan(notrans){
  var notrans = notrans;
  // alert(notrans);
  $(".loader").fadeIn();
  $("#button_tolak").hide();
  $.ajax({
    url: "json/simpan_transaksi_pengiriman.php",
    data:"op=tolak&notrans="+notrans,
    cache:false,
    success: function(msg) {
      console.log(msg);
      if(msg.trim()==="sukses"){
        tutup_form_penolakan();
        alert('penolakan berhasil');
        $(".loader").fadeOut();
        window.location.reload();
      }else{
        $(".loader").fadeOut();
        alert('silahkan ulangi');
      }
    }
  });
}