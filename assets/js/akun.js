$(document).ready(function(){
  $(".loader").fadeOut();
});

  function tambah_user(){
	$("#tambah_user").modal('show');
}

function simpan_akun(){
	var username = $("#username").val();
	var pass = $("#pass").val();
  var group = $("#group").val();
  var nama_user = $("#nama_user").val();
	var lokasi = $("#lokasi").val();

	// alert(username + pass + group);
	$.ajax({
        // type: 'POST',
        url: "json/simpan_akun_baru.php",
        data:"op=proses&username="+username+"&pass="+pass+"&group="+group+"&nama_user="+nama_user+"&lokasi="+lokasi,
        cache:false,
        success: function(msg) {
          data=msg.split("|");
          console.log(data);
          if(data[0].trim()==="sukses"){
            $("#tambah_user").modal('hide');
            alert('Berhasil simpan akun baru');
            window.location.reload();
          }else{
            alert('silahkan ulangi');
            return;
          }      
      }
    });
}


function edit_data(nik,password,nama,group,status){
  // alert(nik+' - '+password+' - '+nama+' - '+group+' - '+status);
  // return;
  $("#edit_user").modal('show');
  $("#username_edit").val(nik);
  $("#group_edit").val(group);
  $("#nama_user_edit").val(nama);
  $("#pass_edit").val(password);
  $("#status_edit").val(status);
}

function edit_akun(){
  var username = $("#username_edit").val();
  var group = $("#group_edit").val();
  var nama_user = $("#nama_user_edit").val();
  var pass = $("#pass_edit").val();
  var status = $("#status_edit").val();

  $.ajax({
    // type: 'POST',
    url: "json/simpan_akun_baru.php",
    data:"op=edit&username="+username+"&pass="+pass+"&group="+group+"&nama_user="+nama_user+"&status="+status,
    cache:false,
    success: function(msg) {
      data=msg.split("|");
      console.log(data);
      if(data[0].trim()==="sukses"){
        $("#tambah_user").modal('hide');
        alert('Berhasil di update');
        window.location.reload();
      }else{
        alert('silahkan ulangi');
        return;
      }      
  }
  });
}