<?php 
session_start();
include_once "config/koneksi.php";
// include_once "config/lock.php";
#include_once "config/bahasa.php";
 // print_r($kata);

$_SESSION['loggedinmysistem']=true;
$session_id_group = '1';
$session_nik = 'systemadm';
?>

<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

<ul class="sidebar-nav" id="sidebar-nav">

<!--   <li class="nav-item">
    <a class="nav-link " href="index.html">
      <i class="bi bi-grid"></i>
      <span>Dashboard</span>
    </a>
  </li>

  <li class="nav-item">
    <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
      <i class="bi bi-menu-button-wide"></i><span>Components</span><i class="bi bi-chevron-down ms-auto"></i>
    </a>
    <ul id="components-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
      <li>
        <a href="components-alerts.html">
          <i class="bi bi-circle"></i><span>Alerts</span>
        </a>
      </li>
      <li>
        <a href="components-accordion.html">
          <i class="bi bi-circle"></i><span>Accordion</span>
        </a>
      </li>
      <li>
        <a href="components-badges.html">
          <i class="bi bi-circle"></i><span>Badges</span>
        </a>
      </li>
      <li>
        <a href="components-breadcrumbs.html">
          <i class="bi bi-circle"></i><span>Breadcrumbs</span>
        </a>
      </li>
      <li>
        <a href="components-buttons.html">
          <i class="bi bi-circle"></i><span>Buttons</span>
        </a>
      </li>
      <li>
        <a href="components-cards.html">
          <i class="bi bi-circle"></i><span>Cards</span>
        </a>
      </li>
      <li>
        <a href="components-carousel.html">
          <i class="bi bi-circle"></i><span>Carousel</span>
        </a>
      </li>
      <li>
        <a href="components-list-group.html">
          <i class="bi bi-circle"></i><span>List group</span>
        </a>
      </li>
      <li>
        <a href="components-modal.html">
          <i class="bi bi-circle"></i><span>Modal</span>
        </a>
      </li>
      <li>
        <a href="components-tabs.html">
          <i class="bi bi-circle"></i><span>Tabs</span>
        </a>
      </li>
      <li>
        <a href="components-pagination.html">
          <i class="bi bi-circle"></i><span>Pagination</span>
        </a>
      </li>
      <li>
        <a href="components-progress.html">
          <i class="bi bi-circle"></i><span>Progress</span>
        </a>
      </li>
      <li>
        <a href="components-spinners.html">
          <i class="bi bi-circle"></i><span>Spinners</span>
        </a>
      </li>
      <li>
        <a href="components-tooltips.html">
          <i class="bi bi-circle"></i><span>Tooltips</span>
        </a>
      </li>
    </ul>
  </li>

  <li class="nav-item">
    <a class="nav-link collapsed" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
      <i class="bi bi-journal-text"></i><span>Forms</span><i class="bi bi-chevron-down ms-auto"></i>
    </a>
    <ul id="forms-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
      <li>
        <a href="forms-elements.html">
          <i class="bi bi-circle"></i><span>Form Elements</span>
        </a>
      </li>
      <li>
        <a href="forms-layouts.html">
          <i class="bi bi-circle"></i><span>Form Layouts</span>
        </a>
      </li>
      <li>
        <a href="forms-editors.html">
          <i class="bi bi-circle"></i><span>Form Editors</span>
        </a>
      </li>
      <li>
        <a href="forms-validation.html">
          <i class="bi bi-circle"></i><span>Form Validation</span>
        </a>
      </li>
    </ul>
  </li>

  <li class="nav-item">
    <a class="nav-link collapsed" data-bs-target="#tables-nav" data-bs-toggle="collapse" href="#">
      <i class="bi bi-layout-text-window-reverse"></i><span>Tables</span><i class="bi bi-chevron-down ms-auto"></i>
    </a>
    <ul id="tables-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
      <li>
        <a href="tables-general.html">
          <i class="bi bi-circle"></i><span>General Tables</span>
        </a>
      </li>
      <li>
        <a href="tables-data.html">
          <i class="bi bi-circle"></i><span>Data Tables</span>
        </a>
      </li>
    </ul>
  </li>

  <li class="nav-item">
    <a class="nav-link collapsed" data-bs-target="#charts-nav" data-bs-toggle="collapse" href="#">
      <i class="bi bi-bar-chart"></i><span>Charts</span><i class="bi bi-chevron-down ms-auto"></i>
    </a>
    <ul id="charts-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
      <li>
        <a href="charts-chartjs.html">
          <i class="bi bi-circle"></i><span>Chart.js</span>
        </a>
      </li>
      <li>
        <a href="charts-apexcharts.html">
          <i class="bi bi-circle"></i><span>ApexCharts</span>
        </a>
      </li>
      <li>
        <a href="charts-echarts.html">
          <i class="bi bi-circle"></i><span>ECharts</span>
        </a>
      </li>
    </ul>
  </li>

  <li class="nav-item">
    <a class="nav-link collapsed" data-bs-target="#icons-nav" data-bs-toggle="collapse" href="#">
      <i class="bi bi-gem"></i><span>Icons</span><i class="bi bi-chevron-down ms-auto"></i>
    </a>
    <ul id="icons-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
      <li>
        <a href="icons-bootstrap.html">
          <i class="bi bi-circle"></i><span>Bootstrap Icons</span>
        </a>
      </li>
      <li>
        <a href="icons-remix.html">
          <i class="bi bi-circle"></i><span>Remix Icons</span>
        </a>
      </li>
      <li>
        <a href="icons-boxicons.html">
          <i class="bi bi-circle"></i><span>Boxicons</span>
        </a>
      </li>
    </ul>
  </li>

  <li class="nav-heading">Pages</li>

  <li class="nav-item">
    <a class="nav-link collapsed" href="users-profile.html">
      <i class="bi bi-person"></i>
      <span>Profile</span>
    </a>
  </li>

  <li class="nav-item">
    <a class="nav-link collapsed" href="pages-faq.html">
      <i class="bi bi-question-circle"></i>
      <span>F.A.Q</span>
    </a>
  </li>

  <li class="nav-item">
    <a class="nav-link collapsed" href="pages-contact.html">
      <i class="bi bi-envelope"></i>
      <span>Contact</span>
    </a>
  </li>

  <li class="nav-item">
    <a class="nav-link collapsed" href="pages-register.html">
      <i class="bi bi-card-list"></i>
      <span>Register</span>
    </a>
  </li>

  <li class="nav-item">
    <a class="nav-link collapsed" href="pages-login.html">
      <i class="bi bi-box-arrow-in-right"></i>
      <span>Login</span>
    </a>
  </li>

  <li class="nav-item">
    <a class="nav-link collapsed" href="pages-error-404.html">
      <i class="bi bi-dash-circle"></i>
      <span>Error 404</span>
    </a>
  </li>

  <li class="nav-item">
    <a class="nav-link collapsed" href="pages-blank.html">
      <i class="bi bi-file-earmark"></i>
      <span>Blank</span>
    </a>
  </li>
</ul> -->


  <?php
    if($session_id_group==1){
          $terinner="";
          $wter="";
        }else{
          $terinner="   INNER JOIN mst_group_menu AS kg ON (kg.id_menu=k.id_menu) ";
          $wter="  AND kg.id_group='$id_group' ";
        }
        $sql="SELECT k.id_menu,k.nama_menu,k.link_pindah,k.icon,k.dropdown_toggle,k.id_nav FROM mst_menu  as k 
        $terinner 
        WHERE k.parent='0' and k.status='1' 
        $wter 
        order by k.seq asc "; 

      $query=mysqli_query($connect,$sql)or die($sql);
         while(list($id_menu,$nama_menu,$link_pindah,$icon,$dropdown_toggle,$id_nav)=mysqli_fetch_array($query)){
          $sql="SELECT k.id_menu,k.nama_menu,k.link_pindah FROM mst_menu as k
          $terinner  
           WHERE k.parent='$id_menu' and k.status='1' 
           $wter  
           order by k.seq asc  ";

          $res=mysqli_query($connect,$sql)or die($sql);
          $banyak=mysqli_num_rows($res);

          if($banyak>0){ ?>

            <li class="nav-item">
              <a href="#" class="nav-link collapsed" data-bs-target="#<?php echo $id_nav?>" data-bs-toggle="collapse">
                <i class="bi <?php echo $icon;?>"></i><span><?php echo $nama_menu?></span><i class="bi <?php echo $dropdown_toggle?>"></i>
              </a>
              <ul id="<?php echo $id_nav?>" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li>
                <?php
                  $mi=0;
                  while(list($id_menu,$nama_menu,$link_pindah,$icon,$dropdown_toggle,$id_nav)=mysqli_fetch_array($res)){
                    $mi++;
                    ?>
                    <li><a href="<?php echo $link_pindah?>"><i class="fa fa-circle-o text-red"> </i><?php echo $nama_menu?></a></li>
                        <?php if($mi==$banyak){}else{?>
                    <li class="divider"></li>
                    <?php }
                      }
                    ?>
              </ul>
            </li>

    

          <?php }else{
        ?><li><a href="<?php echo $link_pindah?>"><?php echo $nama_menu?></a></li>

        <?php }

       }

    // $isCache=1;
    // if($isCache==1){
    //  $sql_cache=' SQL_CACHE '; 
    // }else{
    //  $sql_cache='';
    // } 

    // $sql="SELECT $sql_cache m.id_menu AS id , m.parent AS parent_id, m.nama_menu AS title, m.link_pindah as url, m.seq AS menu_order, m.icon, m.sub, m.dropdown_toggle, m.id_nav
    //         FROM mst_user_group AS u 
    //         INNER JOIN mst_group_menu AS mg  ON (mg.id_group = u.id_group) 
    //         INNER JOIN mst_menu AS m ON (m.id_menu = mg.id_menu) 
    //         WHERE u.nik = '$session_nik' AND `status`=1 
    //         ORDER BY m.parent ,m.seq";

    // if($session_id_group=='1' ){
    //    $sql="SELECT $sql_cache DISTINCT m.id_menu AS id , m.parent AS parent_id, m.nama_menu AS title, m.link_pindah as url, m.seq AS menu_order, m.icon, m.sub, m.dropdown_toggle, m.id_nav
    //         FROM  mst_menu AS m  
    //         WHERE  m.`status`=1
    //         ORDER BY m.parent,m.seq"; 
    // }
    // // echo$sql;
    // $result = mysqli_query($connect,$sql) or die(mysqli_error());
    // while ($row = mysqli_fetch_object($result)) {
    //    $data[$row->parent_id][] = $row;
    // }
    // try{
    //     if($_SESSION['loggedinmysistem']!=""){
    //         $row->parent_id=0;// wajib diisi 0 menandakan itu menu bukan submenu
    //         $row->id=1000;
    //     }else{
    //         $row->parent_id=0;
    //         $row->id=1000;
    //     }  
    //   }catch(Exception $e){
    //       echo "Error ". $e->getMessage();
    //   }
    
    // $menu = get_menu($data);
    // echo "$menu";
?>




</aside><!-- End Sidebar-->