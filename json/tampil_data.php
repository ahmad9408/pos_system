<?php session_start();
    include("../config/koneksi.php");
    include("../config/lock.php");
    
    $today = date('Y-m-d H:i:s');
    $tahun = date('y');
    $bulan = date('m');
    $tanggal = date('d');
    $jam = date('His');
    $querys = "SELECT MAX(no_transaksi)AS `last` FROM tbl_transaksi WHERE YEAR(tgl_transaksi)='$year'";
    $hasil = mysqli_query($connect,$querys);
    $data  = mysqli_fetch_array($hasil);
    $lastNo = $data['last'];
    $lastthn = substr($lastNo, 6,2);
    $lastNoUrut = substr($lastNo, 18, 6);
    
    if($tahun>$lastthn){
      $nextNoUrut = '000001';
    }else{
      $nextNoUrut = $lastNoUrut + '1';
    }

    // $no_transaksi = 'TRANS'.'_'.$tahun.$bulan.$tanggal.$jam.sprintf('%06s', $nextNoUrut);
?>

<!-- <?php echo $lastNoIT;?><br>
<?php echo $lastbulan;?><br>
<?php echo $lastNoUrut;?><br>
<?php echo $nextNoUrut;?><br>
<?php echo $no_transaksi;?><br> -->
<script type="text/javascript">
    $(document).ready(function(){
      $(function(){
        $("#bayar").on("keypress", function(e){
          if(e.which == 13){
            $("#simpan").click();
          }
        });
        $("#data_nis").hide();
        $("#crud_table").hide();
        $("#tot_n_c").hide();
        // $(".kolom_cash").hide();
        $("#b_n_cash").val('0');
        $("#b_cs").val('0');

        var count = 0;
        $('#add').click(function(){
          var kembalian = $("#kembalian").val();
          if(kembalian >= 0){
            return;
          }
          count = count + 1;
          /*iframe hanya bisa 1 page tidak bisa multi*/
          //  <input name="username" type="text" id="username" class="demoInputBox" onBlur="checkAvailability()"><span id="user-availability-status"></span>
          // /<p><img src="LoaderIcon.gif" id="loaderIcon" style="display:none" /></p>
          var del='<button type="button" name="del'+count+'" id="del'+count+'" class="btn btn-danger btn-sm" onclick="removeRow(\''+ count+'\')"><i class="bi bi-trash-fill"></i></button>';
          del+='<span id="r'+ count +'"></span>';
          //var sim='<button type="button" name="sim_'+count+'" id="sim_'+count+'" class="btn btn-primary btn-sm" onclick="simpan_sementara(\''+ count+'\')">Copy</button>';
          var html_code = "<tr id='row"+count+"'>";
           html_code += "<td width='15' align='right'><input type='hidden' id='nm"+count+"' name='nm' value='"+count+"'>"+count+". </td>";
           html_code += "<td width='15' align='right'><input type='hidden' id='id_jenis_bayar"+count+"' name='id_jenis_bayar'></td>";
           html_code += "<td><input type='text' id='jenis_bayar"+count+"' name='jenis_bayar' class='form-control' style='width:350px' placeholder='Klik untuk jenis bayar' onclick='buka_jenis_bayar(\""+count+"\")' readonly></td>";
           html_code += "<td><input type='hidden' id='input_bayar_non_cash"+count+"' nama='input_bayar_non_cash' class='form-control' onclick='buka_nilai_jenis(\""+count+"\")' onkeyup='hitung_total_non_cash();' onvolumechange='hitung_total_non_cash()' onchange='hitung_total_non_cash()' readonly></td>";
           html_code += "<td><input type='text' id='bayar_non_cash"+count+"' nama='bayar_non_cash' class='form-control currInput tnc' onclick='buka_nilai_jenis(\""+count+"\")' onkeyup='CurrFormat();copytextbox(\""+count+"\");hitung_total_non_cash();pengurangan_debit()' onvolumechange='CurrFormat();hitung_total_non_cash()' onchange='CurrFormat();hitung_total_non_cash()' readonly></td>";
           html_code += "<td>"+del+"</td>";
           html_code += "</tr>";

          $('#crud_table').append(html_code);
        });

      });
    });

    $("#bayar").attr("disabled", "disabled");
    $("#bayar").val("0,00");
    $("#kembalian").val("0,00");

    $("#diskon_total").prop('disabled', true);
    $("#check_dis").click(function () {
      if ($(this).is(":checked")) {
          // $("#diskon").prop('disabled', false);
          $("#diskon_total").removeAttr("disabled");
          $("#diskon_total").focus();
      } else {
          $("#diskon_total").attr("disabled", "disabled");
          $("#diskon_total").val('0');
          pengurangan();
          // $("#diskon").prop('disabled', true);
      }
    });

    $("#b_n_cash").click(function () {
      if ($(this).is(":checked")) {
          $("#b_n_cash").val('1');
          // $("#diskon").prop('disabled', false);
          // $("#bayar_tf").removeAttr("disabled");
          // $("#bayar_tf").val("");
          // buka_tf();
          $("#crud_table").show();
          $("#tot_n_c").show();
          // $("#form_cash").hide();
          // $("#form_data_tf").modal({backdrop: false});
          if($("#b_cs").val('0'));{
            $("#tot_pembayaran").val('');
          }
      } else {
        removeRow_all();
          $("#b_n_cash").val('0');
          $("#crud_table").hide();
          $("#tot_n_c").hide();
          $("#total_non_cash").val('');
          if($("#b_cs").val('0'));{
            $("#kembalian").val('0,00');
          }
          // $("#form_cash").show();
          // $("#bayar_tf").val('0');
          // $("#data_nis").hide();
          // pengurangan();
          // $("#b_n_cash").prop('checked', false);
          // $("#diskon").prop('disabled', true);
      }

    });

    $("#b_cs").click(function(){
      var kembalian = $("#kembalian").val();
      if(kembalian >=0){
        return;
      }
      if ($(this).is(":checked")) {
        $("#b_cs").val('1');
        // $(".kolom_cash").show();
        $("#bayar").removeAttr("disabled");
        $("#bayar").val('');
        $("#bayar").focus();
        // $("#form_non_cash").hide();
      } else {
        $("#b_cs").val('0');
        // $(".kolom_cash").hide();
        $("#bayar").attr("disabled", "disabled");
        $("#bayar").val('0,00');
        // $("#form_non_cash").show();
        pengurangan();
      }
    });

    function buka_jenis_bayar(counter){
      $("#tabel_jenis_bayar").modal('show');
      $("#counter_jenis").val(counter);
    }

    function tutup_jenis_bayar(){
      $("#tabel_jenis_bayar").modal('hide');
    }

    function buka_nilai_jenis(counter){
      var id_jenis_bayar = $("#id_jenis_bayar"+counter).val();
      // alert(id_jenis_bayar);
      // return;

      if(id_jenis_bayar ==''){
        alert('silahkan pilih dulu jenis bayar');
        $("#jenis_bayar").focus();
        return;
      }else{
        if(id_jenis_bayar == 1){
          $("#form_data_tabungan").modal('show');
          $("#counter_t").val(counter);
        }else{
          $("#bayar_non_cash").removeAttr("readonly");
          $("#bayar_non_cash").focus();
        }

      }
    }

    // function hitung_total_non_cash_2(){
    //   var table = document.getElementById("crud_table"), sumHsl = 0;
    //   // alert(table);
    //   // return;
    //     for(var t = 1; t < table.rows.length; t++){
    //       var tot = $("#bayar_non_cash"+t).val();
    //       // alert(table.rows[t].cells[3].innerHTML);
    //       alert(tot);
    //       return;
    //       sumHsl = sumHsl + parseInt(table.rows[t].removeFormat(cells[4]).innerHTML);
    //       alert(sumHsl);
    //     }
    //     document.getElementById("total_non_cash").innerHTML = sumHsl;
    //     // alert(sumHsl);
    // }

    function copytextbox(counter) {
      document.getElementById('input_bayar_non_cash'+counter).value = document.getElementById('bayar_non_cash'+counter).value;
    }
</script>
<script type="text/javascript">
  function hitung_total_non_cash(){
    var items = new Array();
    var itemCount = document.getElementsByClassName("tnc");
    var total = 0;
    var id= "";

    for(var i = 0; i < itemCount.length; i++){
      id = "input_bayar_non_cash"+(i+1);
      // alert(id);
      // return;
      total = total + parseInt(document.getElementById(id).value);
      
     console.log(total);
    }

    if (!isNaN(total)) { 
      document.getElementById('total_non_cash').value = total;
      $("#total_non_cash").val(format('#,##0.##',total));
      return total;
    
    }if (isNaN(total)) {
      document.getElementById('total_non_cash').value = "";
      $("#total_non_cash").val(format('#,##0.##',total));
    }

  }
    hitung_total_non_cash();
</script>
<script type="text/javascript">
  
</script>
<table class="table table-bordered table-hover">
    <thead>
    <tr>
        <th scope="col">#</th>
        <th scope="col">Kode Barang</th>
        <th scope="col">Nama Barang</th>
        <th scope="col">Harga</th>
        <th scope="col">Stok</th>
        <th scope="col">QTY</th>
        <th scope="col">Diskon</th>
        <th scope="col">Total</th>
        <th></th>
    </tr>
    </thead>
    <?php
    $sql="SELECT id, kode_barang, nama_barang, harga, stok, qty, diskon, total, id_lokasi FROM tbl_transaksi_detail_temp WHERE updateby ='$session_nik' ORDER BY updatedate DESC";
    $hasil=mysqli_query($connect,$sql);
    $no=0;
        while ($data = mysqli_fetch_array($hasil)) {
        $no++;
        $gtotal += $data['total'];
    ?>
    <tbody>
    <tr>
        <td id="urutan<?php echo $no;?>" value="<?php echo $data[id];?>"><?php echo $no;?></td>
        <td><?php echo $data["kode_barang"];?></td>
        <td><?php echo $data["nama_barang"];?></td>
        <td><?php echo number_format($data["harga"]);?></td>
        <td><?php echo $data["stok"];?></td>
        <td><?php echo $data["qty"];?></td>
        <td><?php echo $data["diskon"];?> %</td>
        <td><?php echo number_format($data["total"]);?></td>
        <td colspan="2">
          <span class="btn btn-warning btn-sm" id="edit" name="edit" onclick="edit_data('<?php echo $data["id"];?>','<?php echo $data["kode_barang"];?>','<?php echo $data["nama_barang"];?>','<?php echo $data["harga"];?>','<?php echo $data["stok"];?>','<?php echo $data["qty"];?>','<?php echo $data["diskon"];?>','<?php echo $data["total"];?>','<?php echo $data["id_lokasi"];?>')"><i class="bi bi-pencil-square"></i></span>
          <span class="btn btn-danger btn-sm" id="hapus" name="hapus" onclick="hapus_list('<?php echo $data[kode_barang];?>')"><i class="bi bi-trash-fill"></i></span>
        </td>
    </tr>
    </tbody>

    <?php
        }
    ?>
</table>

<div class="row mb-5">
    <label class="col-sm-2 col-form-label">TOTAL KESELURUHAN</label>
    <div class="col-sm-10">
        <input type="hidden" name="total_bayar" id="total_bayar" value="<?php echo $gtotal;?>" class="form-control currInput" onclick="CurrFormat()">
        <label class="col-sm-12 col-form-label"><font size="18" color="#FF0000">Rp. <?php echo number_format($gtotal);?></font></label>
    </div>
</div>

<div class="input-group mb-3" id="form_non_cash">
  <label class="col-sm-2 col-form-label">BAYAR NON CASH</label>
      <div class="form-check form-switch">
        <input class="form-check-input" type="checkbox" id="b_n_cash">
      </div>
    
    <table id="crud_table">
      <tr style="font-size: 13px">
        <td colspan="2" align="right" style="display: block"><button type="button" name="add" id="add" class="btn btn-warning btn-sm">+</button></td>
        <td style="display: none"><input type="text" name="counter" id="counter" value="" /></td>
        <td style="display: none"><p id="up-result"></p></td>
      </tr>
    </table>
</div>
<div class="input-group mb-3" id="tot_n_c">
  <label class="col-sm-2 col-form-label">TOTAL NON CASH</label>
    <span class="input-group-text">Rp</span>
    <input type="text" id="total_non_cash" nama="total_non_cash" class="form-control currInput" onclick="hitung_total_non_cash()" onkeyup="CurrFormat();pengurangan();" onvolumechange="CurrFormat()" onchange="CurrFormat()" readonly>
    <span class="input-group-text">.00</span>
</div>
<div class="input-group mb-3" id="data_nis">
  <label class="col-sm-2 col-form-label">NIS</label>
    <input type="text" id="nis" nama="nis" class="form-control currInput" readonly>
</div>
<div class="input-group mb-3" id="form_cash">
  <label class="col-sm-2 col-form-label">BAYAR CASH</label>
      <div class="form-check form-switch">
        <input class="form-check-input" type="checkbox" id="b_cs">
      </div>
    
      <span class="input-group-text kolom_cash">Rp</span>
      <input type="text" id="bayar" nama="bayar" class="form-control kolom_cash currInput"  onkeyup="CurrFormat();pengurangan();" onvolumechange="CurrFormat()" onchange="CurrFormat()">
      <span class="input-group-text kolom_cash">.00</span>
</div>
<div class="input-group mb-5">
  <label class="col-sm-2 col-form-label">DISKON</label>
  <input type="text" class="form-control"  id="diskon_total" name="diskon_total" value="0" onkeyup="pengurangan();" onvolumechange="CurrFormat()" onchange="CurrFormat()">
  <span class="input-group-text">
    <div class="form-check form-switch">
      <input class="form-check-input" type="checkbox" id="check_dis">
    </div>
  </span>
  <input type="hidden" class="form-control"  id="hasil_diskon_total" name="hasil_diskon_total">
  <input type="hidden" class="form-control"  id="harga_akhir" name="harga_akhir">
</div>
<div class="input-group mb-3" id="for_total_pembayaran">
  <label class="col-sm-2 col-form-label">TOTAL PEMBAYARAN</label>
    <span class="input-group-text">Rp</span>
    <input type="text" id="tot_pembayaran" nama="tot_pembayaran" class="form-control currInput" readonly>
    <span class="input-group-text">.00</span>
</div>
<div class="input-group mb-3">
  <label class="col-sm-2 col-form-label">KEMBALIAN</label>
  <!-- <div class="col-sm-10"> -->
      <span class="input-group-text">Rp</span>
      <input type="text" id="kembalian" nama="kembalian" class="form-control" disabled>
      <span class="input-group-text">.00</span>
  <!-- </div> -->
</div>
<hr>




<div class="modal fade" id="form_app">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Form Konfirmasi Persetujuan</h5>
      </div>
      <div class="modal-body">
        
      </div>
      <div class="modal-footer">
          
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="tabel_jenis_bayar">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
<!--       <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tabel Jenis Bayar</h5>
      </div> -->
      <div class="modal-body">
        <input type="hidden" id="counter_jenis" class="form_text">
        <table class="table table-bordered table-hover table-striped datatable">
          <thead>
            <tr align="center">
              <th scope="col">#</th>
              <th scope="col">Jenis Bayar</th>
            </tr>
          </thead>
          <tbody>
            <?php
              $sql_jenis = "SELECT id, jenis FROM tbl_jenis_bayar WHERE is_aktif=1";
              $res_jenis_bayar = mysqli_query($connect,$sql_jenis);
              while($data=mysqli_fetch_array($res_jenis_bayar)){
                $id = $data['id'];
                $jenis = $data['jenis'];
                $nomor++;
            ?>
            <tr>
              <th scope="row"><?php echo $nomor;?></th>
              <td id="nm" onclick="pilih_jenis('<?php echo $id;?>','<?php echo $jenis;?>')"><?php echo $jenis;?></td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
      <div class="modal-footer">
          
      </div>
    </div>
  </div>
</div>