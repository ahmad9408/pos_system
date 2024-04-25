function notif(jenis) {
  //data calon siswa
  if(jenis=='simpan_penjualan'){
    var pesan = $("#notifikasi").html('Simpan Penjualan Berhasil');
  }else if(jenis=='lokasi'){
    var pesan = $("#notifikasi").html('Lokasi harus di pilih!');
  }else if(jenis =='proses_upload'){
    var pesan = $("#notifikasi").html('Sedang proses upload!');
  }else if(jenis =='proses_download'){
    var pesan = $("#notifikasi").html('Sedang proses download!');
  }else if(jenis =='berhasil_upload'){
    var pesan = $("#notifikasi").html('Berhasil upload!');
  }else if(jenis =='berhasil_download'){
    var pesan = $("#notifikasi").html('Berhasil download!');
  }else if(jenis =='proses_pembatalan'){
    var pesan = $("#notifikasi").html('Sedang Proses Pembatalan!');
  }else if(jenis =='pembatalan_berhasil'){
    var pesan = $("#notifikasi").html('Pembatalan Berhasil!');
  }
    var x = document.getElementById("notifikasi");
    x.className = "show";
    setTimeout(function(){ 
      x.className = x.className.replace("show", ""); 
    }, 3000);


    // $("#setuju").prop("checked", false);
}