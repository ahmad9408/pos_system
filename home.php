<?php session_start();
include("config/koneksi.php");
include("config/lock.php");

// $_SESSION['loggedinmysistem']=true;
// $session_nik = 'systemadm';
// $session_id_group = '1';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>POS - Harmet</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="img/logo.webp" rel="icon">
  <link href="img/logo.webp" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css?d=<?php echo date('YmdHis');?>" rel="stylesheet">

  <link rel="stylesheet" href="assets/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <!-- =======================================================
  * Template Name: NiceAdmin - v2.4.1
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
    <script type="text/javascript" src="assets/js/jquery.min.js"></script>

    <script type="text/javascript">
      $(document).ready(function(){
        // $(".sidebar").hide();
        $('body').addClass('sidebar-hidden');
        // $('#navbar-collapse-second').on('hide.bs.collapse', function () {
        //    $('body').removeClass('overlay-is-navbar-collapse');
        // });
      });

    </script>
</head>

<body>

    
      <?php
        include("topbar_menu.php");
        // include("sidebar_menu.php");
      ?>
      
      <main id="main" class="main">

      <?php
          $p=isset($_GET['menu'])?$_GET['menu']:null;
  
          $sql_redirect="SELECT link from mst_redirect_page where `name`='$p'";
          $res_redirect=mysqli_query($connect,$sql_redirect);
          list($page)=mysqli_fetch_array($res_redirect);
          
          
          if(empty($page)){
            $page='dashboard.php';
          }
  
        include_once($page);
          switch($p){
        }
      ?>
    
    </main><!-- End #main -->
    <?php
      include("footer.php");
    ?>

</body>

</html>
<!-- daterangepicker -->
<script src="assets/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<!-- add gitub -->