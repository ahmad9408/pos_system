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
  
	// $('#tbl_jenis').load("json/data_jenis_barang.php");

    $("#nama_jenis").on("keypress", function(e){
    var nama_jenis = $("#nama_jenis").val();
      if(e.which == 13){
        $.ajax({
            // type: 'POST',
            url: "json/simpan_jenis_barang.php",
            data:"op=nama&nama_jenis="+nama_jenis,
            cache:false,
            success: function(msg) {
              data=msg.split("|");
              console.log(data);
              if(data[0].trim()==="sukses"){
				$('#tbl_jenis').load("json/data_jenis_barang.php");
				clear();
              }else{
                alert('Jenis Tersebut sudah ada, silahkan menggunakan nama jenis lain');
                return;
              }      
          }
        });
      }
    });


    $("#nama_jenis_edit").on("keypress", function(e){
      var id_edit = $("#id_edit").val();
      var nama_jenis_edit = $("#nama_jenis_edit").val();
      if(e.which == 13){
        $.ajax({
            // type: 'POST',
            url: "json/simpan_jenis_barang.php",
            data:"op=edit&nama_jenis_edit="+nama_jenis_edit+"&id_edit="+id_edit,
            cache:false,
            success: function(msg) {
              data=msg.split("|");
              console.log(data);
              if(data[0].trim()==="sukses"){
                $('#tbl_jenis').load("json/data_jenis_barang.php");
                tutup_edit()
              }else{
                alert('Silahkan Ulangi');
                return;
              }      
          }
        });
      }
    });

});

function clear(){
	$("#nama_jenis").val('');
}

function simpan(){
	var nama_jenis = $("#nama_jenis").val();
  // alert(nama_jenis);return;
  if(nama_jenis ==''){
    alert("Jenis Belum di input");
    return;
  }
	$.ajax({
        // type: 'POST',
        url: "json/simpan_jenis_barang.php",
        data:"op=nama&nama_jenis="+nama_jenis,
        cache:false,
        success: function(msg) {
          data=msg.split("|");
          console.log(data);
          if(data[0].trim()==="sukses"){
      			$('#tbl_jenis').load("json/data_jenis_barang.php");
      			clear();
          }else{
            alert('Jenis Tersebut sudah ada, silahkan menggunakan nama jenis lain');
            return;
          }      
      }
    });
}

function edit_data(id,nama_jenis){
  var id = id;
	var nama_jenis = nama_jenis;

	$("#konfirmasi_edit_jenis").modal('show');
  $("#id_edit").val(id);
  $("#nama_jenis_edit").val(nama_jenis);
}


function tutup_edit(){
	$("#konfirmasi_edit_jenis").modal('hide');
}

function proses_edit_jenis(){
	var id_edit = $("#id_edit").val();
	var nama_jenis_edit = $("#nama_jenis_edit").val();
	// var status_jenis = $("#status_jenis").val();
	$.ajax({
        // type: 'POST',
        url: "json/simpan_jenis_barang.php",
        data:"op=edit&nama_jenis_edit="+nama_jenis_edit+"&id_edit="+id_edit,
        cache:false,
        success: function(msg) {
          data=msg.split("|");
          console.log(data);
          if(data[0].trim()==="sukses"){
      			$('#tbl_jenis').load("json/data_jenis_barang.php");
      			tutup_edit()
          }else{
            alert('silahkan ulangi');
            return;
          }      
      }
    });
}

function buka_form_pencarian_jenis(){
  $("#form_pencarian").modal('show');
}

function tutup_form_pencarian_jenis(){
  $("#form_pencarian").modal('hide');
}

function cari_jenis_baru(){
  var awal = $("#awal_download").val();
  var akhir = $("#akhir_download").val();

  if((awal=='')||(akhir=='')){
    alert("range tanggal harus dipilih");
    return;
  }
  // alert(awal+' - '+akhir);
  // return;
  tutup_form_pencarian_jenis();
  notif('proses_download');
  $(".loader").fadeIn();
  $.ajax({
    url: "json/download_master_jenis_barang.php",
    data:"op=proses_download&awal="+awal+"&akhir="+akhir,
    cache:false,
    success: function(msg) {
      console.log(msg);
      if(msg.trim()==="sukses"){
        $(".loader").fadeOut();
        notif('berhasil_download');
        window.location.reload();
        // $('#tbl_do').load("json/data_do.php?lokasi="+lokasi+"&awal="+awal+"&akhir="+akhir+"&no_transaksi="+no_transaksi);
      }else if(msg.trim()==="kosong"){
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