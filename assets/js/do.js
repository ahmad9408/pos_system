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


  var lokasi = $("#lokasi").val();
  var awal = $("#awal").val();
  var akhir = $("#akhir").val();
  var no_transaksi = $("#no_transaksi").val();
  $('#tbl_do').load("json/data_do.php?lokasi="+lokasi+"&awal="+awal+"&akhir="+akhir+"&no_transaksi="+no_transaksi);
});

function getDetail(notrans,ambil_tgl_transaksi,nama_lokasi){
  $("#notrans").val(notrans);
  $("#tgl").val(ambil_tgl_transaksi);
  $("#nama_lokasi").val(nama_lokasi);
  $("#tabel_transaksi").attr({
      method : 'POST',
      action : '?menu=detail_do',
      target : '_blank'
  });

  $("#cari").click();
  $("#tabel_transaksi").attr({
      method : 'POST',
      action : '?menu=do&action=anyeurydbdxnjy',
      target : ''
  });
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
  var id_lokasi = $("#id_lokasi").val();
  var no_transaksi = $("#no_transaksi").val();

  if((awal=='')||(akhir=='')){
    alert("range tanggal harus dipilih");
    return;
  }
  // alert(awal+' - '+akhir+' - '+id_lokasi);
  // return;


  tutup_form_pencarian_pengiriman();
  notif('proses_download');
  $(".loader").fadeIn();
  $.ajax({
    url: "json/download_data_pengiriman.php",
    data:"op=proses_download&awal="+awal+"&akhir="+akhir+"&id_lokasi="+id_lokasi,
    cache:false,
    success: function(msg) {
      console.log(msg);
      if(msg.trim()==="sukses"){
        $(".loader").fadeOut();
        notif('berhasil_download');
        $("#cari").click();
        // $('#tbl_do').load("json/data_do.php?lokasi="+lokasi+"&awal="+awal+"&akhir="+akhir+"&no_transaksi="+no_transaksi);
        $('#tbl_do').load("json/data_do.php?id_lokasi="+id_lokasi+"&awal="+awal+"&akhir="+akhir);
      }else if(msg.trim()==="kosong"){
        alert('Tidak ada data terbaru');
        $(".loader").fadeOut();
        return;
      }else{
        $(".loader").fadeOut();
        alert('data sudah pernah di download semua');
        return;
      }
    }
  });

}