<?php session_start();
  include("../config/koneksi.php");
  // include("../config/lock.php");
  $today = date('Y-m-d H:i:s');

error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
  require __DIR__ . '/../escpos-php-development/vendor/autoload.php';
  use Mike42\Escpos\Printer;
  use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
  try {
  
  function buatBaris1Kolom($kolom1){
      // Mengatur lebar setiap kolom (dalam satuan karakter)
      $lebar_kolom_1 = 40;

      // Melakukan wordwrap(), jadi jika karakter teks melebihi lebar kolom, ditambahkan \n 
      $kolom1 = wordwrap($kolom1, $lebar_kolom_1, "\n", true);

      // Merubah hasil wordwrap menjadi array, kolom yang memiliki 2 index array berarti memiliki 2 baris (kena wordwrap)
      $kolom1Array = explode("\n", $kolom1);

      // Mengambil jumlah baris terbanyak dari kolom-kolom untuk dijadikan titik akhir perulangan
      $jmlBarisTerbanyak = count($kolom1Array);

      // Mendeklarasikan variabel untuk menampung kolom yang sudah di edit
      $hasilBaris = array();

      // Melakukan perulangan setiap baris (yang dibentuk wordwrap), untuk menggabungkan setiap kolom menjadi 1 baris 
      for ($i = 0; $i < $jmlBarisTerbanyak; $i++) {

          // memberikan spasi di setiap cell berdasarkan lebar kolom yang ditentukan, 
          $hasilKolom1 = str_pad((isset($kolom1Array[$i]) ? $kolom1Array[$i] : ""), $lebar_kolom_1, " ");

          // Menggabungkan kolom tersebut menjadi 1 baris dan ditampung ke variabel hasil (ada 1 spasi disetiap kolom)
          $hasilBaris[] = $hasilKolom1;
      }

      // Hasil yang berupa array, disatukan kembali menjadi string dan tambahkan \n disetiap barisnya.
      return implode($hasilBaris) . "\n";
  }

  function buatBaris2Kolom($kolom1, $kolom2){
      // Mengatur lebar setiap kolom (dalam satuan karakter)
      $lebar_kolom_1 = 20;
      $lebar_kolom_2 = 20;

      $kolom1 = wordwrap($kolom1, $lebar_kolom_1, "\n", true);
      $kolom2 = wordwrap($kolom2, $lebar_kolom_2, "\n", true);

      $kolom1Array = explode("\n", $kolom1);
      $kolom2Array = explode("\n", $kolom2);

      $jmlBarisTerbanyak = max(count($kolom1Array), count($kolom2Array));

      // Mendeklarasikan variabel untuk menampung kolom yang sudah di edit
      $hasilBaris = array();

      // Melakukan perulangan setiap baris (yang dibentuk wordwrap), untuk menggabungkan setiap kolom menjadi 1 baris 
      for ($i = 0; $i < $jmlBarisTerbanyak; $i++) {

          // memberikan spasi di setiap cell berdasarkan lebar kolom yang ditentukan, 
          $hasilKolom1 = str_pad((isset($kolom1Array[$i]) ? $kolom1Array[$i] : ""), $lebar_kolom_1, " ");
          $hasilKolom2 = str_pad((isset($kolom2Array[$i]) ? $kolom2Array[$i] : ""), $lebar_kolom_2, " ", STR_PAD_LEFT);

          // Menggabungkan kolom tersebut menjadi 1 baris dan ditampung ke variabel hasil (ada 1 spasi disetiap kolom)
          $hasilBaris[] = $hasilKolom1 . " " . $hasilKolom2;
      }

      // Hasil yang berupa array, disatukan kembali menjadi string dan tambahkan \n disetiap barisnya.
      return implode($hasilBaris) . "\n";
  }

  function buatBaris3Kolom($kolom1, $kolom2, $kolom3){
      // Mengatur lebar setiap kolom (dalam satuan karakter)
      $lebar_kolom_1 = 16;
      $lebar_kolom_2 = 4;
      $lebar_kolom_3 = 10;

      $kolom1 = wordwrap($kolom1, $lebar_kolom_1, "\n", true);
      $kolom2 = wordwrap($kolom2, $lebar_kolom_2, "\n", true);
      $kolom3 = wordwrap($kolom3, $lebar_kolom_3, "\n", true);

      $kolom1Array = explode("\n", $kolom1);
      $kolom2Array = explode("\n", $kolom2);
      $kolom3Array = explode("\n", $kolom3);

      $jmlBarisTerbanyak = max(count($kolom1Array), count($kolom2Array), count($kolom3Array));

      $hasilBaris = array();
      for ($i = 0; $i < $jmlBarisTerbanyak; $i++) {
          $hasilKolom1 = str_pad((isset($kolom1Array[$i]) ? $kolom1Array[$i] : ""), $lebar_kolom_1, " ");
          $hasilKolom2 = str_pad((isset($kolom2Array[$i]) ? $kolom2Array[$i] : ""), $lebar_kolom_2, " ", STR_PAD_LEFT);
          $hasilKolom3 = str_pad((isset($kolom3Array[$i]) ? $kolom3Array[$i] : ""), $lebar_kolom_3, " ", STR_PAD_LEFT);
          $hasilBaris[] = $hasilKolom1 . " " . $hasilKolom2 . " " . $hasilKolom3;
      }
      return implode($hasilBaris) . "\n";
  }

  function buatBaris4Kolom($kolom1, $kolom2, $kolom3, $kolom4){
      // Mengatur lebar setiap kolom (dalam satuan karakter)
      $lebar_kolom_1 = 12;
      $lebar_kolom_2 = 8;
      $lebar_kolom_3 = 4;
      $lebar_kolom_4 = 8;

      // Melakukan wordwrap(), jadi jika karakter teks melebihi lebar kolom, ditambahkan \n 
      $kolom1 = wordwrap($kolom1, $lebar_kolom_1, "\n", true);
      $kolom2 = wordwrap($kolom2, $lebar_kolom_2, "\n", true);
      $kolom3 = wordwrap($kolom3, $lebar_kolom_3, "\n", true);
      $kolom4 = wordwrap($kolom4, $lebar_kolom_4, "\n", true);

      // Merubah hasil wordwrap menjadi array, kolom yang memiliki 2 index array berarti memiliki 2 baris (kena wordwrap)
      $kolom1Array = explode("\n", $kolom1);
      $kolom2Array = explode("\n", $kolom2);
      $kolom3Array = explode("\n", $kolom3);
      $kolom4Array = explode("\n", $kolom4);

      // Mengambil jumlah baris terbanyak dari kolom-kolom untuk dijadikan titik akhir perulangan
      $jmlBarisTerbanyak = max(count($kolom1Array), count($kolom2Array), count($kolom3Array), count($kolom4Array));

      // Mendeklarasikan variabel untuk menampung kolom yang sudah di edit
      $hasilBaris = array();

      // Melakukan perulangan setiap baris (yang dibentuk wordwrap), untuk menggabungkan setiap kolom menjadi 1 baris 
      for ($i = 0; $i < $jmlBarisTerbanyak; $i++) {

          // memberikan spasi di setiap cell berdasarkan lebar kolom yang ditentukan, 
          $hasilKolom1 = str_pad((isset($kolom1Array[$i]) ? $kolom1Array[$i] : ""), $lebar_kolom_1, " ");
          // memberikan rata kanan pada kolom 3 dan 4 karena akan kita gunakan untuk harga dan total harga
          $hasilKolom2 = str_pad((isset($kolom2Array[$i]) ? $kolom2Array[$i] : ""), $lebar_kolom_2, " ", STR_PAD_LEFT);

          $hasilKolom3 = str_pad((isset($kolom3Array[$i]) ? $kolom3Array[$i] : ""), $lebar_kolom_3, " ", STR_PAD_LEFT);

          $hasilKolom4 = str_pad((isset($kolom4Array[$i]) ? $kolom4Array[$i] : ""), $lebar_kolom_4, " ", STR_PAD_LEFT);

          // Menggabungkan kolom tersebut menjadi 1 baris dan ditampung ke variabel hasil (ada 1 spasi disetiap kolom)
          $hasilBaris[] = $hasilKolom1 . " " . $hasilKolom2 . " " . $hasilKolom3. " " . $hasilKolom4;
      }

      // Hasil yang berupa array, disatukan kembali menjadi string dan tambahkan \n disetiap barisnya.
      return implode($hasilBaris) . "\n";
  }

  $notrans = $_REQUEST['notrans'];
  $id_kasir = $_REQUEST['id_kasir'];

    // Enter the share name for your USB printer here
    // $connector = null;
    $connector = new WindowsPrintConnector("POS-58");
    $printer = new Printer($connector);

    /* mulai cetak */
    $printer -> initialize();
    $printer -> setFont(Printer::FONT_B);
    $printer -> setTextSize(1, 1);
    $printer -> setJustification(Printer::JUSTIFY_CENTER);
    $printer -> text("PT. Harmet Setia Cemerlang\n");
    $printer -> text("---------------------------------------\n");
    $printer -> text("KASIR : $id_kasir |".date('Y:m:d h:i:s')." \n");
    $printer -> text("NO TRANSAKSI : $notrans \n");
    $printer -> text("---------------------------------------\n");

    // $printer -> setJustification(Printer::JUSTIFY_LEFT);
        // $printer -> text(buatBaris4Kolom("Produk", "Qty", "Diskon", "Total"));
    /* buat perulangan data transaksi */
    $sql="SELECT
              `d`.`qty`, `d`.`nama_barang`, `d`.`kode_barang`, `d`.`harga`, `d`.`total`, `d`.`diskon`, `t`.`diskon` as `diskon_tambahan`,`t`.`subtotal`, `t`.`qty` as total_qty, `t`.`total_akhir`, `t`.`total_non_cash`, `t`.`total_cash`, `t`.`total_pembayaran`, `t`.`total_bayar`, `t`.`kembalian`, `t`.`lokasi`, `t`.`updatedate`, `t`.`id_kasir`
          FROM `tbl_transaksi_detail` AS `d`
          LEFT JOIN `tbl_transaksi` AS `t` ON (`d`.`no_transaksi` = `t`.`no_transaksi`)
          WHERE `t`.`no_transaksi` = '$notrans'";
    $q_transkasi = mysqli_query($connect,$sql);
    while($data = $q_transkasi->fetch_array()){
        $nama_barang    =$data['nama_barang'];
        $diskon = $data['diskon'];
        $diskon_tambahan = number_format($data['diskon_tambahan'],0);
        $total_bayar = $data['total_bayar'];
        $kembalian = $data['kembalian'];
        $harga = $data['harga'];
        $format_harga = number_format($harga,0);
        $total = $data['total'];
        $total_akhir += $data['total'];
        $qty = $data['qty'];
        $total_per_pcs = number_format($harga * $qty,0);
        $total_qty += $qty;
        $printer -> setJustification(Printer::JUSTIFY_CENTER);
        $printer -> text(buatBaris1Kolom($nama_barang));
        $printer -> text(buatBaris3Kolom("$qty x $format_harga","$diskon %",number_format($total,0)));
    }
   
    // $printer -> text("Hello World!\n");
    $printer -> text("========================================\n");
    $printer -> text(buatBaris2Kolom("Total Harga",number_format($total_akhir,0)));
    $printer -> text(buatBaris2Kolom("Diskon Tambahan","$diskon_tambahan %"));
    $printer -> text(buatBaris2Kolom("Total Bayar",number_format($total_bayar,0)));
    $printer -> text(buatBaris2Kolom("Kembali",number_format($kembalian,0)));
    $printer -> text("\nBarang yang sudah dibeli tidak dapat\n");
    $printer -> text("ditukar/dikembalikan dalam bentuk apapun!\n");
    $printer -> text("\nTerima kasih atas pembelian Anda! \n");
    $printer -> text("Kami harap Anda menyukai produk ini\n");
    $printer -> text("sama seperti kami senang menciptakannya!\n");
    $printer -> feed();
    $printer -> cut();
    
    /* Close printer */
    $printer -> close();
} catch (Exception $e) {
    echo "Couldn't print to this printer: " . $e -> getMessage() . "\n";
}

?>