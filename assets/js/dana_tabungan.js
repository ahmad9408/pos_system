$(document).ready(function(){
  $(".loader").fadeOut();
  var nis = $("#nis").val();
  var nama = $("#nama").val();
  $('#data_master_tabungan').load("json/data_master_tabungan.php?nis="+nis+"&nama="+nama);

  // $('#export').on('click', function(e){
    // $("#tbl_tabungan").table2excel({
    //     // exclude: ".noExport",
    //     // name: "Data",
    //     // filename: "Workbook",
    //     // exclude: ".noExl",
    //     name: "Table2Excel",
    //     filename: "daftar_tabungan.xls",
    //     fileext: ".xls",
    //     exclude_img: true,
    //     exclude_links: true,
    //     exclude_inputs: true,
    //     preserveColors: false
    // });
  // });
});

function getDetail(no_nis,nama_req,norek){
  $("#no_nis").val(no_nis);
  $("#nama_req").val(nama_req);
  $("#norek").val(norek);
  $("#tabel_tabungan").attr({
      method : 'POST',
      action : '?menu=detail_penggunaan_tabungan',
      target : '_blank'
  });

  $("#cari").click();
  $("#tabel_tabungan").attr({
      method : 'POST',
      action : '?menu=daftar_tabungan&action=lagh86253nyvtehr',
      target : ''
  });
}

function ekspor_master_tabungan(){
  $("#tbl_tabungan").table2excel({
      // exclude: ".noExport",
      // name: "Data",
      // filename: "Workbook",
      // exclude: ".noExl",
      name: "Table2Excel",
      filename: "daftar_tabungan.xls",
      fileext: ".xls",
      exclude_img: true,
      exclude_links: true,
      exclude_inputs: true,
      preserveColors: false
  });
}

function buka_form_pencarian_tabungan(){
  $("#form_pencarian").modal('show');
}

function tutup_form_pencarian_tabungan(){
  $("#form_pencarian").modal('hide');
}

function cari_tabungan(){
  var awal = $("#awal").val();
  var akhir = $("#akhir").val();

  if((awal=='')||(akhir=='')){
    alert("range tanggal harus dipilih");
    return;
  }
  // alert(awal+' - '+akhir);
  // return;
  tutup_form_pencarian_tabungan();
  notif('proses_download');
  $(".loader").fadeIn();
  $.ajax({
    url: "json/download_data_tabungan.php",
    data:"op=proses_download&awal="+awal+"&akhir="+akhir,
    cache:false,
    success: function(msg) {
      console.log(msg);

      if(msg.trim()==="sukses"){
        $(".loader").fadeOut();
        notif('berhasil_download');

        $('#data_master_tabungan').load("json/data_master_tabungan.php?awal="+awal+"&akhir="+akhir);

      }else if(msg.trim()==="kosong"){
        alert('Tidak ada data terbaru');
        return;
      }else{
        $(".loader").fadeOut();
        alert('silahkan ulangi');
        return;
      }
    }
  });

}