<?php 
session_start();
include_once "config/koneksi.php";
include_once "config/lock.php";

$_SESSION['loggedinmysistem']=true;

  $sql_jml_transaksi = "SELECT COUNT(`no_transaksi`)AS jml_transaksi, MIN(tgl_transaksi) AS tgl_transaksi_awal, MAX(tgl_transaksi) AS tgl_transaksi_akhir
                        FROM tbl_transaksi
                        WHERE is_aktif = 1 AND is_upload = 0";
  $res_jml_transaksi = mysqli_query($connect,$sql_jml_transaksi);
  list($jml_transaksi,$tgl_transaksi_awal,$tgl_transaksi_akhir)=mysqli_fetch_array($res_jml_transaksi);

$year = date('Y');
$sekarang = date('Y-m-d');
?>

<header id="header" class="header fixed-top d-flex align-items-center">

<div class="d-flex align-items-center justify-content-between">
  <a href="home.php" class="logo d-flex align-items-center">
    <img src="img/logo.webp" alt="">
    <span class="d-none d-lg-block">PointOfSales</span>
  </a>
  <!-- <i class="bi bi-list toggle-sidebar-btn"></i> -->
</div><!-- End Logo -->

<!-- <div class="search-bar">
  <form class="search-form d-flex align-items-center" method="POST" action="#">
    <input type="text" name="query" placeholder="Search" title="Enter search keyword">
    <button type="submit" title="Search"><i class="bi bi-search"></i></button>
  </form>
</div> -->

<nav class="header-nav ms-auto">
    <ul class="d-flex align-items-center">
      <li class="nav-item dropdown">

          <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
            <i class="bi bi-bell"></i>
            <?php if($jml_transaksi > 0){ ?>
              <span class="badge bg-danger badge-number"><?php echo $jml_transaksi;?></span>
            <?php } ?>
          </a><!-- End Notification Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
            <li class="dropdown-header">
              Ada <?php echo $jml_transaksi;?> transaksi yang belum di upload
              <!-- <a href="?menu=daftar_transaksi&action=lagh86253nyvtehr" target="_blank"> -->
                <span id="btn_cari" class="badge rounded-pill p-2 ms-2 btn btn-primary btn-sm" >Lihat Semua</span>
                <!-- <span class="badge rounded-pill p-2 ms-2 btn btn-primary btn-sm" onclick="lihat('<?php echo $tgl_transaksi_awal;?>','<?php echo $tgl_transaksi_akhir;?>')">Lihat Semua</span> -->
              <!-- </a> -->
            </li>
            <!-- <li>
              <hr class="dropdown-divider">
            </li> -->

            <!-- <li class="notification-item">
              <i class="bi bi-exclamation-circle text-warning"></i>
              <div>
                <h4>Lorem Ipsum</h4>
                <p>Quae dolorem earum veritatis oditseno</p>
                <p>30 min. ago</p>
              </div>
            </li> -->

            <!-- <li>
              <hr class="dropdown-divider">
            </li> -->
          </ul>
        </li>

        <?php
            if($_SESSION["loggedinmysistem"]){ 
        ?>
        <?php
            
            if($session_id_group==1){
              $terinner="";
              $wter="";
            }else{
              $terinner="   INNER JOIN mst_group_menu AS kg ON (kg.id_menu=k.id_menu) ";
              $wter="  AND kg.id_group='$session_id_group' ";
            }
            $sql="SELECT k.id_menu,k.nama_menu,k.link_pindah,k.icon,k.dropdown_toggle,k.id_nav,k.chevron,k.sub FROM mst_menu  as k 
            $terinner 
            WHERE k.parent='0' and k.status='1' 
            $wter 
            order by k.seq asc "; 
          // echo $sql;
          $query=mysqli_query($connect,$sql)or die($sql);
             while(list($id_menu,$nama_menu,$link_pindah,$icon,$dropdown_toggle,$id_nav,$chevron,$sub)=mysqli_fetch_array($query)){
              $sql="SELECT k.id_menu,k.nama_menu,k.link_pindah FROM mst_menu as k
              $terinner  
               WHERE k.parent='$id_menu' and k.status='1' 
               $wter  
               order by k.seq asc  ";

              $res=mysqli_query($connect,$sql)or die($sql);
              $banyak=mysqli_num_rows($res);

              if($banyak>0){ ?>

                <li class="nav-item dropdown pe-3">
                  <a href="<?php echo $link_pindah?>" class='nav-link nav-profile d-flex align-items-center pe-0' data-bs-toggle="<?php echo $sub?>">
                    <i class="bi <?php echo $icon;?>"></i> <span class="d-none d-md-block <?php echo $dropdown_toggle;?> ps-2"><?php echo $nama_menu?></span>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                    <li>
                    <?php
                      $mi=0;
                      while(list($id_menu,$nama_menu,$link_pindah,$icon,$dropdown_toggle,$id_nav,$chevron,$sub)=mysqli_fetch_array($res)){
                        $mi++;
                        ?>
                        <li><a href="<?php echo $link_pindah?>" class="dropdown-item d-flex align-items-center"><i class="fa fa-circle-o text-red"> </i><?php echo $nama_menu?></a></li>
                            <?php if($mi==$banyak){}else{?>
                        <li class="dropdown-divider"></li>
                        <?php }
                          }
                        ?>
                  </ul>
                </li>
        

              <?php }else{
            ?><li><a href="<?php echo $link_pindah?>"><?php echo $nama_menu?></a></li>


            <?php }

           }
        ?>
        <?php 
            } 
        ?>
        <li class="nav-item dropdown pe-3">

          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <!-- <img src="assets/img/profile-img.jpg" alt="Profile" class="rounded-circle"> -->
            <span class="d-none d-md-block dropdown-toggle ps-2"><?php echo $session_nama;?></span>
          </a>

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h6><?php echo $session_nama;?></h6>
              <!-- <span>Web Designer</span> -->
            </li>
            <!-- <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
                <i class="bi bi-person"></i>
                <span>My Profile</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
                <i class="bi bi-gear"></i>
                <span>Account Settings</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="pages-faq.html">
                <i class="bi bi-question-circle"></i>
                <span>Need Help?</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li> -->

            <li>
              <a class="dropdown-item d-flex align-items-center" href="logout.php">
                <i class="bi bi-box-arrow-right"></i>
                <span>Sign Out</span>
              </a>
            </li>

          </ul>
        </li>
</nav>

</header>

<script type="text/javascript">
  $(document).ready(function(){
    // function buka_transaksi(){
      $('#btn_cari').on('click', function(e){
        $("#submit").click();
      });
    // }
  });

  function lihat(aw,ak){
    alert(aw+' - '+ak);
    return
  }
</script>

<form id="kirim" enctype="multipart/form-data" class="form-vertical" method="post" action="?menu=force_upload_top_menu&action=yaynesbhsyver" target="_blank">
  <table>
    <tr>
      <td><input type="date" class="form-control" id="tanggal_awal" name="tanggal_awal" value="<?php echo $tgl_transaksi_awal;?>"></td>
      <td><input type="date" class="form-control" id="tanggal_akhir" name="tanggal_akhir" value="<?php echo $tgl_transaksi_akhir;?>"></td>
      <td><input type="text" class="form-control" id="status_transaksi" name="status_transaksi" value="1"></td>
      <td><input type="text" class="form-control" id="no_transaksi" name="no_transaksi"></td>
      <td colspan="2" align="left"><input type="submit" name="submit" id="submit" value="Cari" class="btn btn-primary btn-sm"></td>
    </tr>
  </table>
</form>