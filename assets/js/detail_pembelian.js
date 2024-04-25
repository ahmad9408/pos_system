function batal_pembelian(){
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
    url: "json/simpan_pembelian.php",
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