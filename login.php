
<?php 
include_once('config/koneksi.php');

$today = date('Y-m-d');
$todayTime = date('YmdHis');
    session_start();
    include("config/koneksi.php");
    
    $error = ""; //Variable for storing our errors.
    if(isset($_POST["submit"])){
        if(empty($_POST["username"]) || empty($_POST["password"])){
            // $error = "Both fields are required.";
            echo "
                <script>
                  alert ('silahkan isi username dan password anda!');
                </script>";
        }else{
            // Define $username and $password
            $username=$_POST['username'];
            $password=$_POST['password'];

            // To protect from MySQL injection
            $username = stripslashes($username);
            $password = stripslashes($password);
            $username = mysqli_real_escape_string($connect, $username);
            $password = mysqli_real_escape_string($connect, $password);
            // $password = md5($password);
            
            //Check username and password from database
            $sql="SELECT * FROM mst_user_login
            WHERE nik='$username' and password='$password' AND status='1'";
                    // mysqli_query($connect,"insert into login_session(user,tgl_login)values('$username','$today')");
            $result=mysqli_query($connect,$sql);
            $row=mysqli_fetch_array($result);
            
            //If username and password exist in our database then create a session.
            //Otherwise echo error.
            

            if(mysqli_num_rows($result) == 1){
                $sql_log = "INSERT INTO `mst_login_session` (`user`,`tgl_login`,`current_time`)
                            VALUES ('$username','$today','$todayTime')";
                $res_log = mysqli_query($connect,$sql_log);
                
                $_SESSION['login_user'] = $username; 

                //Create other session update by iwan 2021-06-14
                $username = $_SESSION['login_user'];
                $ses_sql = mysqli_query($connect,"SELECT
                                                    `u`.`nik`
                                                    , `u`.`password`
                                                    , `u`.`nama`
                                                    , `u`.`status`
                                                    , `u`.`id_group`
                                                    , `u`.`is_koreksi`
                                                    , `u`.`lokasi`
                                                    , `l`.`nama_lokasi`
                                                FROM
                                                    `mst_user_login` AS `u`
                                                    LEFT JOIN `mst_lokasi` AS `l` 
                                                        ON (`u`.`lokasi` = `l`.`id`)
                                                WHERE u.status=1 AND u.nik = '$username'");
                $row = mysqli_fetch_array($ses_sql);

                $_SESSION['nama'] = $row['nama'];
                $_SESSION['nik'] = $row['nik'];
                $_SESSION['bagian'] = $row['bagian'];
                $_SESSION['jabatan'] = $row['jabatan'];
                $_SESSION['id_group'] = $row['id_group'];
                $_SESSION['lokasi'] = $row['lokasi'];
            // echo "
            //     <script>
            //       alert ('login berhasil');
            //     </script>";
                header("location:home.php"); // Redirecting To Other Page

              // if(!empty($remember)){
              //   $_SESSION['user_login_cookie_rnd']=$username;
              //   $_SESSION['pass_login_cookie_rnd']=$password;
              //   $_SESSION['remember_login_rnd']=1;
              // }else{
              //   $_SESSION['user_login_cookie_rnd']='';
              //   $_SESSION['pass_login_cookie_rnd']='';
              //   $_SESSION['remember_login_rnd']='';
              // }
            }else{
                /*$error = "Incorrect username or password.";*/
                echo " 
                <script>
                  alert ('username atau password salah ');
                </script>";
                        
            }

        }
    }

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>POS</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

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
  <link href="assets/css/style.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: NiceAdmin - v2.4.1
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

  <main>
    <div class="container">

      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

<!--               <div class="d-flex justify-content-center py-4">
                <a href="index.html" class="logo d-flex align-items-center w-auto">
                  <img src="assets/img/logo.png" alt="">
                  <span class="d-none d-lg-block">NiceAdmin</span>
                </a>
              </div> -->
              
              <div class="card mb-3">

                <div class="card-body">

                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">Login to Your Account</h5>
                    <p class="text-center small">Enter your username & password to login</p>
                  </div>

                  <form class="row g-3 needs-validation" action="" method="post" novalidate>

                    <div class="col-12">
                      <label for="yourUsername" class="form-label">Username</label>
                      <div class="input-group has-validation">
                        <span class="input-group-text" id="inputGroupPrepend">@</span>
                        <input type="text" name="username" class="form-control" id="username" required>
                        <div class="invalid-feedback">Please enter your username.</div>
                      </div>
                    </div>

                    <div class="col-12">
                      <label for="yourPassword" class="form-label">Password</label>
                      <input type="password" name="password" class="form-control" id="password" required>
                      <div class="invalid-feedback">Please enter your password!</div>
                    </div>

                    <div class="col-12">
                      <div class="form-check">
                        <!-- <input class="form-check-input" type="checkbox" name="remember" value="true" id="rememberMe"> -->
                        <!-- <label class="form-check-label" for="rememberMe">Remember me</label> -->
                      </div>
                    </div>
                    <div class="col-12">
                      <button type="submit" name="submit" class="btn btn-primary w-100" type="submit">Login</button>
                    </div>
                    <div class="col-12">
                      <!-- <p class="small mb-0">Don't have account? <a href="pages-register.html">Create an account</a></p> -->
                    </div>
                  </form>

                </div>
              </div>

              <div class="credits">
                <!-- All the links in the footer should remain intact. -->
                <!-- You can delete the links only if you purchased the pro version. -->
                <!-- Licensing information: https://bootstrapmade.com/license/ -->
                <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
                <!-- Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a> -->
              </div>

            </div>
          </div>
        </div>

      </section>

    </div>
  </main><!-- End #main -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/chart.js/chart.min.js"></script>
  <script src="assets/vendor/echarts/echarts.min.js"></script>
  <script src="assets/vendor/quill/quill.min.js"></script>
  <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>