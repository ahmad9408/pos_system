$(document).ready(function(){
  $(".loader").fadeOut();

  var awal = $("#awal").val();
  var akhir = $("#akhir").val();
  no_trans = $("#no_trans").val();
  
  $('#tbl_trans_upload_pembelian').load("json/data_trans_pembelanjaan.php?awal="+awal+"&akhir="+akhir+"&no_trans="+no_trans);
});

function getDetail(notrans,tgl_input){
  $("#notrans").val(notrans);
  $("#tgl_input").val(tgl_input);
  $("#tabel_transaksi").attr({
      method : 'POST',
      action : '?menu=detail_pembelian',
      target : '_blank'
  });

  $("#cari").click();
  $("#tabel_transaksi").attr({
      method : 'POST',
      action : '?menu=daftar_pembelian&action=lagh86253nyvtehr',
      target : ''
  });
}

function reset(){
  $("#awal").val('');
  $("#akhir").val('');
  $("#no_transaksi").val('');
}

function checkAll(){
  for(i=1; i <=1000; i++){
    var nomor_awal = $("#nomor_awal"+i).text();

    //alert(id_detailbarang+' - '+alat+' - '+spek+' - '+qty+' - '+harga+' - '+total+' - '+cash+' - '+kredit);
    if(nomor_awal.length==0){
      i=1001;
    }else{
      $("#checkbox"+i).prop("checked",true);
       var nomor_awal_ = $("#nomor_awal"+(i+1)).text();
       
       if(nomor_awal_.length==0){
          var ak=i;
       }else{
          var ak=1000;
       }

      // alert(i+' - '+ak);
      // return;
      klik(i,ak);
    }
     
  }
}

function discheckAll(){
  for(i=1; i <=1000; i++){
    var nomor_awal = $("#nomor_awal"+i).text();

    //alert(id_detailbarang+' - '+alat+' - '+spek+' - '+qty+' - '+harga+' - '+total+' - '+cash+' - '+kredit);
    if(nomor_awal.length==0){
      i=1001;
    }else{
      $("#checkbox"+i).prop("checked",false);
       var nomor_awal_ = $("#nomor_awal"+(i+1)).text();
       
       if(nomor_awal_.length==0){
          var ak=i;
       }else{
          var ak=1000;
       }

      // $("#batal").hide();
      // $("#s_rev").show();
      klik(i,ak);
    }
     
  }
}
    
function klik(no,no_akhir){
  awal = $("#awal").val();
  akhir = $("#akhir").val();
  no_trans = $("#no_trans").val();

  invoice = $("#invoice"+no).val();
  tgl_invoice = $("#tgl_invoice"+no).val();
  tgl_input = $("#tgl_input"+no).val();
  updateby = $("#updateby"+no).val();
  total_harga_pokok = $("#total_harga_pokok"+no).val();
  total_harga_jual = $("#total_harga_jual"+no).val();
  total_qty = $("#total_qty"+no).val();
  lokasi = $("#lokasi"+no).val();
  updatedate = $("#updatedate"+no).val();
  tgl_batal = $("#tgl_batal"+no).val();
  user_pembatal = $("#user_pembatal"+no).val();
  is_aktif = $("#is_aktif"+no).val();

  if(awal == 'undefined'){
    alert('Tanggal awal harus dipilih');
    return;
  }

  if(akhir == 'undefined'){
    alert('Tanggal akhir harus dipilih');
    return;
  }

  if($("#checkbox"+no).prop("checked")){
    // alert(no+' - '+invoice+' - '+tgl_invoice+' - '+updateby+' - '+total_harga_pokok+' - '+total_harga_jual+' - '+total_qty+' - '+updatedate+' - '+tgl_batal+' - '+user_pembatal+' - '+is_aktif);
    // if(no_akhir==no){
    //   $(".loader").fadeOut();
    //   notif('berhasil_upload');
    // }
    // return;
    

    $("#btn_upload").hide();
    notif('proses_upload');
    $(".loader").fadeIn();
    $.ajax({
      url: "json/upload_pembelanjaan.php",
      // type:"POST",
      data:"op=proses_upload&no="+no+"&invoice="+invoice+"&tgl_invoice="+tgl_invoice+"&tgl_input="+tgl_input+"&updateby="+updateby+"&total_harga_pokok="+total_harga_pokok+"&total_harga_jual="+total_harga_jual+"&total_qty="+total_qty+"&lokasi="+lokasi+"&updatedate="+updatedate+"&tgl_batal="+tgl_batal+"&user_pembatal="+user_pembatal+"&is_aktif="+is_aktif,
      cache:false,
      success: function(msg) {
        console.log(msg);

        if(msg.trim()==="sukses"){
          if(no_akhir==no){
            // alert('berhasil di upload');
            $(".loader").fadeOut();
            notif('berhasil_upload');
            $('#tbl_trans_upload_pembelian').load("json/data_trans_pembelanjaan.php?awal="+awal+"&akhir="+akhir+"&no_trans="+no_trans);
          }
        }else{
          if(no_akhir==no){
            $(".loader").fadeOut();
            alert('silahkan ulangi');
          }
        }
      }
    });
  // }else if($("#checkbox"+no).prop("checked", false)){
  //  alert(nomor+' - '+awal+' - '+akhir);
  //   return;
  //   $.ajax({
//    url: "json/upload_transaksi_harian.php",
//    data:"op=proses_upload&awal="+awal+"&akhir="+akhir,
//    cache:false,
//    success: function(msg) {
//      console.log(msg);
//      if(msg.trim()==="sukses"){
//        alert('berhasil');
//        $('#tbl_trans_upload').load("json/data_trans_upload.php");
//      }else{
//        alert('silahkan ulangi');
//      }
//    }
//  });
  }
}