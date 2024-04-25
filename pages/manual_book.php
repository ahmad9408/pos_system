<?php session_start();
  include("config/koneksi.php");
  include("config/lock.php");

?>

<script type="text/javascript">
	$(document).ready(function(){
		$(".loader").fadeOut();
	});
</script>

<style type="text/css">
  .loader {
    content:" ";
/*    display:block;*/
    position: fixed;
    left: 0px;
    top: 0px;
    width: 100%;
    height: 100%;
    z-index: 9999;
    background: url('img/double-ring.gif') 50% 50% no-repeat;
    opacity: 0.8;
    animation: spin 2s linear infinite;
  }
</style>
<section class="section">
  <div id="loader" class="loader"></div>
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Transaksi Penjualan</h5>
          <div class="box-body table-responsive no-padding">
          	<table class="table">
							<?php

								$sql="SELECT t.id_tutorial, d.filename 
									FROM tbl_tutorial as t
									LEFT JOIN tbl_tutorial_detail as d ON t.id_tutorial=d.id_tutorial
									WHERE t.id_tutorial='1'";
									// echo $sql;
								$query=mysqli_query($connect,$sql);
								list($id_tutorial,$filename)=mysqli_fetch_array($query);
							?>
							<tr>
								<td>
									<?php 
										echo '<embed width="1080" height="980" src="manual_book/'.$filename.'" type="application/pdf"></embed>';
									?>
								</td>
							</tr>
						</table>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
