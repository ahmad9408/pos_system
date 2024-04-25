$(document).ready(function(){
  $(".loader").fadeOut();

  $( "#awal" ).datepicker({
    changeMonth: true,
    changeYear: true,
    format: 'yyyy-mm-dd',
    autoclose: true
  });

  $( "#akhir" ).datepicker({
    changeMonth: true,
    changeYear: true,
    format: 'yyyy-mm-dd',
    autoclose: true
  });

  $('#export').on('click', function(e){
    $("#tbl_trans").table2excel({
        // exclude: ".noExport",
        // name: "Data",
        // filename: "Workbook",
        // exclude: ".noExl",
        name: "Table2Excel",
        filename: "daftar_transaksi.xls",
        fileext: ".xls",
        exclude_img: true,
        exclude_links: true,
        exclude_inputs: true,
        preserveColors: false
    });
  });
});

function getDetail(notrans){
  $("#notrans").val(notrans);
  $("#tabel_transaksi").attr({
      method : 'POST',
      action : '?menu=detail_transaksi',
      target : '_blank'
  });

  $("#cari").click();
  $("#tabel_transaksi").attr({
      method : 'POST',
      action : '?menu=daftar_transaksi&action=lagh86253nyvtehr',
      target : ''
  });
}

function reset(){
  $("#awal").val('');
  $("#akhir").val('');
  $("#no_transaksi").val('');
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

function pindah(halaman){
  $(".bufhalaman").html("<input type='hidden' name='halaman' id='halaman' value='"+halaman+"'>");
   $("#tabel_transaksi").attr({
    method : "POST",
    action : "?menu=daftar_transaksi&action=lagh86253nyvtehr"
  }); 
$("#cari").click();

}