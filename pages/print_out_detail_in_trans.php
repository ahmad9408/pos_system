<?php session_start();
  include("../config/koneksi.php");
  include("../config/lock.php");
  $today = date('Y-m-d H:i:s');

  $notrans = $_REQUEST['notrans'];
  $id_kasir = $_REQUEST['id_kasir'];
  
?>
  <div align="center">
    <h5 class="modal-title">
    KANTIN ABBA
      <!-- <br>Jl. -->
    </h5>
  </div>
  <hr>
  Nomor Transaksi : <?php echo $notrans;?>
  <br>ID Kasir : <?php echo $id_kasir;?>
  <hr>
    <div class="box-body table-responsive no-padding">
      <div class="col-lg-12">
        <table class="table table-bordered" width="300">
          <thead>
            <tr>
              <th>Nama Barang</th>
              <th>Harga</th>
              <th>QTY</th>
              <th>Total</th>
            </tr>
          </thead>
          <tbody>
            <?php
              $sql="SELECT
                        `d`.`qty`
                        , `d`.`nama_barang`
                        , `d`.`kode_barang`
                        , `d`.`harga`
                        , `d`.`total`
                        , `t`.`subtotal`
                        , `t`.`qty` as total_qty
                        , `t`.`diskon`
                        , `t`.`total_akhir`
                        , `t`.`total_non_cash`
                        , `t`.`total_cash`
                        , `t`.`total_pembayaran`
                        , `t`.`total_bayar`
                        , `t`.`kembalian`
                        , `t`.`lokasi`
                        , `t`.`updatedate`
                        , `t`.`id_kasir`
                    FROM
                        `tbl_transaksi_detail` AS `d`
                        INNER JOIN `tbl_transaksi` AS `t` 
                            ON (`d`.`no_transaksi` = `t`.`no_transaksi`)
                    WHERE `t`.`no_transaksi` = '$notrans'";
                $res = mysqli_query($connect,$sql);
                // echo $sql;
              while($data=mysqli_fetch_array($res)){
                $total_qty = $data[total_qty];
                $subtotal = $data[subtotal];
                $total_akhir = $data[total_akhir];
                $total_pembayaran = $data[total_pembayaran];
                $total_bayar = $data[total_bayar];
                $kembalian = $data[kembalian];
            ?>

              <tr>
                <td id='nama_barang_p'><?php echo $data[nama_barang];?></td>
                <td id='harga_p'><?php echo number_format($data[harga]);?></td>
                <td id='qty_p'><?php echo $data[qty];?></td>
                <td id='total_p'><?php echo number_format($data[total]);?></td>
              </tr>
            <?php
              }
            ?>
          </tbody>
        </table>
        <hr>
        <table>
            <tr>
              <td width="150">Total Item</td>
              <td width="15">:</td>
              <td align="left"><?php echo $total_qty;?></td>
            </tr>
            <tr>
              <td>Grand Total</td>
              <td width="15">:</td>
              <td align="Left">Rp. <span style="float: right"> <?php echo number_format($total_pembayaran);?></span></td>
            </tr>
            <tr>
              <td>Tunai</td>
              <td width="15">:</td>
              <td align="Left">Rp. <span style="float: right"> <?php echo number_format($total_bayar);?></span></td>
            </tr>
            <tr>
              <td>Kembali</td>
              <td width="15">:</td>
              <td align="Left">Rp. <span style="float: right"> <?php echo number_format($kembalian);?></span></td>
            </tr>
        </table>
        <hr>
        <label>Barang yang sudah dibeli tidak dapat ditukar / dikembalikan dalam bentuk apapun!</label>
      </div>
    </div>
</div>

<script>

  window.load =  window.print();

</script>     