$(document).ready(function(){
	$(".loader").fadeOut();

	$( "#tgl_awal" ).datepicker({
	  changeMonth: true,
	  changeYear: true,
	  format: 'yyyy-mm-dd',
	  autoclose: true
	});

	$( "#tgl_akhir" ).datepicker({
	  changeMonth: true,
	  changeYear: true,
	  format: 'yyyy-mm-dd',
	  autoclose: true
	});

	var tgl_awal = $("#tgl_awal").val();
	var tgl_akhir = $("#tgl_akhir").val();
	$("#btn_upload").hide();
	// $('#tbl_trans_upload').load("json/data_trans_upload.php?awal="+awal+"&akhir="+akhir);
	$('#tbl_trans_upload').load("json/data_trans_upload.php?awal="+tgl_awal+"&akhir="+tgl_akhir);

});

function reset(){
  $("#tgl_awal").val('');
  $("#tgl_akhir").val('');
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

	awal = $("#tgl_awal").val();
	akhir = $("#tgl_akhir").val();
	
	tgl_transaksi = $("#tgl_transaksi"+no).val();
	no_transaksi = $("#no_transaksi"+no).val();
	id_kasir = $("#id_kasir"+no).val();
	qty = $("#qty"+no).val();
	subtotal = $("#subtotal"+no).val();
	diskon = $("#diskon"+no).val();
	total_akhir = $("#total_akhir"+no).val();
	total_non_cash = $("#total_non_cash"+no).val();
	total_cash = $("#total_cash"+no).val();
	total_pembayaran = $("#total_pembayaran"+no).val();
	total_bayar = $("#total_bayar"+no).val();
	kembalian = $("#kembalian"+no).val();
	lokasi = $("#lokasi"+no).val();
	status_penjualan = $("#status_penjualan"+no).val();
	tgl_batal = $("#tgl_batal"+no).val();
	user_pembatal = $("#user_pembatal"+no).val();
	tgl_transaksi_update = $("#tgl_transaksi_update"+no).val();

	if(awal == 'undefined'){
		alert('Tanggal awal harus dipilih');
		return;
	}

	if(akhir == 'undefined'){
		alert('Tanggal akhir harus dipilih');
		return;
	}

  if($("#checkbox"+no).prop("checked")){
    // alert(no_transaksi+' - '+id_kasir+' - '+qty+' - '+subtotal+' - '+diskon+' - '+total_akhir+' - '+total_non_cash+' - '+total_cash+' - '+total_pembayaran+' - '+total_bayar+' - '+kembalian+' - '+lokasi+' - '+status_penjualan+' - '+tgl_batal+' - '+user_pembatal);		
    // return;
		

    $("#btn_upload").hide();
    notif('proses_upload');
    $(".loader").fadeIn();
		$.ajax({
			url: "json/upload_transaksi_harian.php",
			// type:"POST",
			data:"op=proses_upload&no="+no+"&tgl_transaksi="+tgl_transaksi+"&no_transaksi="+no_transaksi+"&id_kasir="+id_kasir+"&qty="+qty+"&subtotal="+subtotal+"&diskon="+diskon+"&total_akhir="+total_akhir+"&total_non_cash="+total_non_cash+"&total_cash="+total_cash+"&total_pembayaran="+total_pembayaran+"&total_bayar="+total_bayar+"&kembalian="+kembalian+"&lokasi="+lokasi+"&status_penjualan="+status_penjualan+"&tgl_batal="+tgl_batal+"&tgl_transaksi_update="+tgl_transaksi_update+"&user_pembatal="+user_pembatal,
			cache:false,
			success: function(msg) {
			  console.log(msg);

			  if(msg.trim()==="sukses"){
			  	if(no_akhir==no){
				    // alert('berhasil di upload');
				    $(".loader").fadeOut();
				    notif('berhasil_upload');
				    $('#tbl_trans_upload').load("json/data_trans_upload.php?awal="+awal+"&akhir="+akhir);
					}
			  }else{
			  	if(no_akhir==no){
			  		$(".loader").fadeOut();
				    alert('silahkan ulangi');
				  }
			  }
			}
		});
  }else if($("#checkbox"+no).prop("checked", false)){
  	// alert(no+' - '+no_transaksi+' - '+id_kasir+' - '+lokasi);
    // return;
		$("#btn_upload").hide();
		notif('proses_pembatalan');
		$(".loader").fadeIn();

		$.ajax({
			url: "json/upload_transaksi_harian.php",
			// type:"POST",
			data:"op=pembatalan&no="+no+"&tgl_transaksi="+tgl_transaksi+"&no_transaksi="+no_transaksi+"&id_kasir="+id_kasir+"&lokasi="+lokasi,
			cache:false,
			success: function(msg) {
			  console.log(msg);

			  if(msg.trim()==="sukses"){
			  	if(no_akhir==no){
				    // alert('berhasil di upload');
				    $(".loader").fadeOut();
				    notif('pembatalan_berhasil');
				    $('#tbl_trans_upload').load("json/data_trans_upload.php?awal="+awal+"&akhir="+akhir);
					}
			  }else{
			  	if(no_akhir==no){
			  		$(".loader").fadeOut();
				    alert('silahkan ulangi');
				  }
			  }
			}
		});
  }
}
