<?php session_start();
  include("config/koneksi.php");
  include("config/lock.php");
  $today = date('Y-m-d H:i:s');
  $todayZ = date('Y-m-d');
  $bulan = date("Y-m");
  $tahun = date("Y");
?>

<script src="assets/js/highcharts.js"></script>
<script src="assets/js/highcharts-3d.js"></script>
<script>
  var chart;
  var name;
  var y;
  var x;

  $(document).ready(function() {
      chart = new Highcharts.Chart({
       chart: {
        renderTo: 'jml_penjualan',
        // plotBackgroundColor: null,
        // plotBorderWidth: null,
        // plotShadow: false,
        type: 'pie',
        options3d: {
            enabled: true,
            alpha: 45
        }
       },
       title: {
        text: ''
       },
       tooltip: {
        formatter: function() {
          name = this.point.name;
          y = this.point.y;
          // if(name == 1){
          //   var label = 'Laki-laki';
          // }else{
          //   var label = 'Perempuan';
          // }
          return '<b>' +name+' '+ this.point.y + '</b>: '+' ';
        }
       },
       
      plotOptions: {
        pie: {
              innerSize: 100,
              depth: 45
          },
        allowPointSelect: true,
        series: {
          cursor: 'pointer',
          dataLabels: {
            enabled: true,
            color: '#000000',
            connectorColor: 'green',
            formatter: function() {
              name = this.point.name;
              y = this.point.y;
              // if(name == 1){
              //   var label = 'Laki-laki';
              // }else{
              //   var label = 'Perempuan';
              // }
              /*return '<b>' + this.point.name + '</b>: ' + Highcharts.numberFormat(this.percentage, 2) +' % ';*/
              return '<b>' +name+' '+ Highcharts.numberFormat(this.point.y, 0) + '</b>';
            }
           },
        }
      },

        series: [{
          type: 'pie',
          // name: 'Browser share',
          data: [

                <?php

                  $sql_1 = "SELECT id,nama_lokasi FROM mst_lokasi WHERE `status` = '1' ORDER BY id asc";
                  $query = mysqli_query($connect,$sql_1);
                 
                  while ($row = mysqli_fetch_array($query)) {
                    $id = $row['id'];
                    $nama_lokasi = $row['nama_lokasi'];

                    $sql_jml = "SELECT `tgl_transaksi`, sum(`total_akhir`)as total_akhir
                                FROM `tbl_transaksi`
                                WHERE is_aktif=1 AND lokasi='$id'
                                ORDER BY lokasi ASC";
                    $data_pengajuan = mysqli_fetch_array(mysqli_query($connect,$sql_jml));
                    $total_akhir =$data_pengajuan['total_akhir'];
                ?>
            [ 
              '<?php echo $nama_lokasi ;?>', <?php echo $total_akhir; ?>
            ],
            <?php
              }
            ?>
          ],
          point:{
              events:{
                  click: function (event) {
                      // alert(this.x + " " + this.y);
                      // $("#status_pengajuan").val(this.x);
                      // $("#klasifikasi").val('1');
                      // $('#cari_data_pengajuan').click();
                  }
              }
          }
           
        }]
      });
  });
</script>

<div class="pagetitle">
  <h1>Dashboard</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="index.html">Home</a></li>
      <li class="breadcrumb-item active">Dashboard</li>
    </ol>
  </nav>
</div>

<section class="section dashboard">
  <div class="row">

    
    <div class="col-lg-8">
      <div class="row">
        <div class="col-xxl-4 col-md-6">
          <div class="card info-card sales-card">

            <!-- <div class="filter">
              <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
              <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                <li class="dropdown-header text-start">
                  <h6>Filter</h6>
                </li>

                <li><a class="dropdown-item" href="#">Today</a></li>
                <li><a class="dropdown-item" href="#">This Month</a></li>
                <li><a class="dropdown-item" href="#">This Year</a></li>
              </ul>
            </div> -->

            <div class="card-body">
              <h5 class="card-title">Sales <span>| Today</span></h5>
              <?php
                if($session_id_group==1){
                  $cari_lokasi = "";
                }else{
                  $cari_lokasi = " AND l.id='$session_lokasi'";
                }

                $sql_daftar_penjualan = "SELECT SUBSTRING(t.no_transaksi,7,3) AS lokasi
                                          , SUM(`t`.`qty`) as total_qty
                                          , SUM(`t`.`total_akhir`) as total_akhir
                                          , COUNT(`t`.`no_transaksi`) as total_barang_jual
                                      FROM `tbl_transaksi` as `t`
                                      LEFT JOIN mst_lokasi as `l` ON SUBSTRING(t.no_transaksi,7,3) = l.id
                                      WHERE is_aktif= 1 AND tgl_transaksi ='$todayZ' $cari_lokasi";
                // echo $sql_daftar_penjualan;
                $res_mst_barang = mysqli_query($connect,$sql_daftar_penjualan)or die($sql_daftar_penjualan);
                list($lokasi,$total_qty,$total_akhir,$total_barang_jual)=mysqli_fetch_array($res_mst_barang);
              ?>
              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-cart"></i>
                </div>
                <div class="ps-3">
                  <h6><?php echo $total_qty;?></h6>
                  <!-- <span class="text-success small pt-1 fw-bold">12%</span>  -->
                  <span class="text-muted small pt-2 ps-1">Produk</span>

                </div>
              </div>
            </div>

          </div>
        </div>

        <div class="col-xxl-4 col-md-6">
          <div class="card info-card revenue-card">
            <!-- <div class="filter">
              <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
              <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                <li class="dropdown-header text-start">
                  <h6>Filter</h6>
                </li>

                <li><a class="dropdown-item" href="#">Today</a></li>
                <li><a class="dropdown-item" href="#">This Month</a></li>
                <li><a class="dropdown-item" href="#">This Year</a></li>
              </ul>
            </div> -->
            <div class="card-body">
              <h5 class="card-title">Revenue <span>| This Month</span></h5>
              <?php
                if($session_id_group==1){
                  $cari_lokasi = "";
                }else{
                  $cari_lokasi = " AND l.id='$session_lokasi'";
                }

                $sql_daftar_penjualan = "SELECT SUBSTRING(t.no_transaksi,7,3) AS lokasi
                                          , SUM(`t`.`qty`) as total_qty
                                          , SUM(`t`.`total_akhir`) as total_akhir
                                          , COUNT(`t`.`no_transaksi`) as total_barang_jual
                                      FROM `tbl_transaksi` as `t`
                                      LEFT JOIN mst_lokasi as `l` ON SUBSTRING(t.no_transaksi,7,3) = l.id
                                      WHERE is_aktif= 1 AND tgl_transaksi like '$bulan%' $cari_lokasi";
                // echo $sql_daftar_penjualan;
                $res_mst_barang = mysqli_query($connect,$sql_daftar_penjualan)or die($sql_daftar_penjualan);
                list($lokasi,$total_qty,$total_akhir,$total_barang_jual)=mysqli_fetch_array($res_mst_barang);
              ?>
              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-currency-dollar"></i>
                </div>
                <div class="ps-3">
                  <h6><?php echo number_format($total_akhir);?></h6>
                  <!-- <span class="text-success small pt-1 fw-bold">8%</span> -->
                  <span class="text-muted small pt-2 ps-1">Rupiah</span>
                </div>
              </div>
            </div>

          </div>
        </div>

        <div class="col-xxl-4 col-xl-12">
          <div class="card info-card customers-card">
            <!-- <div class="filter">
              <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
              <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                <li class="dropdown-header text-start">
                  <h6>Filter</h6>
                </li>

                <li><a class="dropdown-item" href="#">Today</a></li>
                <li><a class="dropdown-item" href="#">This Month</a></li>
                <li><a class="dropdown-item" href="#">This Year</a></li>
              </ul>
            </div> -->

            <div class="card-body">
              <h5 class="card-title">Customers <span>| This Year</span></h5>
              <?php
                if($session_id_group==1){
                  $cari_lokasi = "";
                }else{
                  $cari_lokasi = " AND l.id='$session_lokasi'";
                }

                $sql_daftar_penjualan = "SELECT SUBSTRING(t.no_transaksi,7,3) AS lokasi
                                          , SUM(`t`.`qty`) as total_qty
                                          , SUM(`t`.`total_akhir`) as total_akhir
                                          , COUNT(`t`.`no_transaksi`) as total_barang_jual
                                      FROM `tbl_transaksi` as `t`
                                      LEFT JOIN mst_lokasi as `l` ON SUBSTRING(t.no_transaksi,7,3) = l.id
                                      WHERE is_aktif= 1 AND tgl_transaksi like '$tahun%' $cari_lokasi";
                // echo $sql_daftar_penjualan;
                $res_mst_barang = mysqli_query($connect,$sql_daftar_penjualan)or die($sql_daftar_penjualan);
                list($lokasi,$total_qty,$total_akhir,$total_barang_jual)=mysqli_fetch_array($res_mst_barang);
              ?>
              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-people"></i>
                </div>
                <div class="ps-3">
                  <h6><?php echo $total_barang_jual;?></h6>
                  <!-- <span class="text-danger small pt-1 fw-bold">12%</span> -->
                  <span class="text-muted small pt-2 ps-1">transaksi</span>
                </div>
              </div>

            </div>
          </div>

        </div>

        <div class="col-12">
          <div class="card">

            <!-- <div class="filter">
              <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
              <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                <li class="dropdown-header text-start">
                  <h6>Filter</h6>
                </li>

                <li><a class="dropdown-item" href="#">Today</a></li>
                <li><a class="dropdown-item" href="#">This Month</a></li>
                <li><a class="dropdown-item" href="#">This Year</a></li>
              </ul>
            </div> -->

            <div class="card-body">
              <h5 class="card-title">Reports <span>/Today</span></h5>
              <div id="jml_penjualan"></div>
            </div>

          </div>
        </div>

        <div class="col-12">
          <div class="card recent-sales overflow-auto">

            <div class="filter">
              <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
              <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                <li class="dropdown-header text-start">
                  <h6>Filter</h6>
                </li>

                <li><a class="dropdown-item" href="#">Today</a></li>
                <li><a class="dropdown-item" href="#">This Month</a></li>
                <li><a class="dropdown-item" href="#">This Year</a></li>
              </ul>
            </div>

          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-4">
      <!-- <div class="card">
        <div class="filter">
          <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
            <li class="dropdown-header text-start">
              <h6>Filter</h6>
            </li>

            <li><a class="dropdown-item" href="#">Today</a></li>
            <li><a class="dropdown-item" href="#">This Month</a></li>
            <li><a class="dropdown-item" href="#">This Year</a></li>
          </ul>
        </div>

        <div class="card-body">
          <h5 class="card-title">Recent Activity <span>| Today</span></h5>

          <div class="activity">

            <div class="activity-item d-flex">
              <div class="activite-label">32 min</div>
              <i class='bi bi-circle-fill activity-badge text-success align-self-start'></i>
              <div class="activity-content">
                Quia quae rerum <a href="#" class="fw-bold text-dark">explicabo officiis</a> beatae
              </div>
            </div>

            <div class="activity-item d-flex">
              <div class="activite-label">56 min</div>
              <i class='bi bi-circle-fill activity-badge text-danger align-self-start'></i>
              <div class="activity-content">
                Voluptatem blanditiis blanditiis eveniet
              </div>
            </div>

            <div class="activity-item d-flex">
              <div class="activite-label">2 hrs</div>
              <i class='bi bi-circle-fill activity-badge text-primary align-self-start'></i>
              <div class="activity-content">
                Voluptates corrupti molestias voluptatem
              </div>
            </div>

            <div class="activity-item d-flex">
              <div class="activite-label">1 day</div>
              <i class='bi bi-circle-fill activity-badge text-info align-self-start'></i>
              <div class="activity-content">
                Tempore autem saepe <a href="#" class="fw-bold text-dark">occaecati voluptatem</a> tempore
              </div>
            </div>

            <div class="activity-item d-flex">
              <div class="activite-label">2 days</div>
              <i class='bi bi-circle-fill activity-badge text-warning align-self-start'></i>
              <div class="activity-content">
                Est sit eum reiciendis exercitationem
              </div>
            </div>

            <div class="activity-item d-flex">
              <div class="activite-label">4 weeks</div>
              <i class='bi bi-circle-fill activity-badge text-muted align-self-start'></i>
              <div class="activity-content">
                Dicta dolorem harum nulla eius. Ut quidem quidem sit quas
              </div>
            </div>

          </div>

        </div>
      </div> -->

      <!-- <div class="card">
        <div class="filter">
          <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
            <li class="dropdown-header text-start">
              <h6>Filter</h6>
            </li>

            <li><a class="dropdown-item" href="#">Today</a></li>
            <li><a class="dropdown-item" href="#">This Month</a></li>
            <li><a class="dropdown-item" href="#">This Year</a></li>
          </ul>
        </div>

        <div class="card-body pb-0">
          <h5 class="card-title">Budget Report <span>| This Month</span></h5>

          <div id="budgetChart" style="min-height: 400px;" class="echart"></div>

          <script>
            document.addEventListener("DOMContentLoaded", () => {
              var budgetChart = echarts.init(document.querySelector("#budgetChart")).setOption({
                legend: {
                  data: ['Allocated Budget', 'Actual Spending']
                },
                radar: {
                  // shape: 'circle',
                  indicator: [{
                      name: 'Sales',
                      max: 6500
                    },
                    {
                      name: 'Administration',
                      max: 16000
                    },
                    {
                      name: 'Information Technology',
                      max: 30000
                    },
                    {
                      name: 'Customer Support',
                      max: 38000
                    },
                    {
                      name: 'Development',
                      max: 52000
                    },
                    {
                      name: 'Marketing',
                      max: 25000
                    }
                  ]
                },
                series: [{
                  name: 'Budget vs spending',
                  type: 'radar',
                  data: [{
                      value: [4200, 3000, 20000, 35000, 50000, 18000],
                      name: 'Allocated Budget'
                    },
                    {
                      value: [5000, 14000, 28000, 26000, 42000, 21000],
                      name: 'Actual Spending'
                    }
                  ]
                }]
              });
            });
          </script>

        </div>
      </div> -->

      
<!--       <div class="card">
        <div class="filter">
          <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
            <li class="dropdown-header text-start">
              <h6>Filter</h6>
            </li>

            <li><a class="dropdown-item" href="#">Today</a></li>
            <li><a class="dropdown-item" href="#">This Month</a></li>
            <li><a class="dropdown-item" href="#">This Year</a></li>
          </ul>
        </div> -->

        <!-- <div class="card-body pb-0"> -->
          <!-- <h5 class="card-title">Website Traffic <span>| Today</span></h5> -->

          <!-- <div id="trafficChart" style="min-height: 400px;" class="echart"></div> -->

          <!-- <script>
            document.addEventListener("DOMContentLoaded", () => {
              echarts.init(document.querySelector("#trafficChart")).setOption({
                tooltip: {
                  trigger: 'item'
                },
                legend: {
                  top: '5%',
                  left: 'center'
                },
                series: [{
                  name: 'Access From',
                  type: 'pie',
                  radius: ['40%', '70%'],
                  avoidLabelOverlap: false,
                  label: {
                    show: false,
                    position: 'center'
                  },
                  emphasis: {
                    label: {
                      show: true,
                      fontSize: '18',
                      fontWeight: 'bold'
                    }
                  },
                  labelLine: {
                    show: false
                  },
                  data: [{
                      value: 1048,
                      name: 'Search Engine'
                    },
                    {
                      value: 735,
                      name: 'Direct'
                    },
                    {
                      value: 580,
                      name: 'Email'
                    },
                    {
                      value: 484,
                      name: 'Union Ads'
                    },
                    {
                      value: 300,
                      name: 'Video Ads'
                    }
                  ]
                }]
              });
            });
          </script> -->

        <!-- </div> -->
      <!-- </div> -->

      <div class="card">
        <!-- <div class="filter">
          <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
            <li class="dropdown-header text-start">
              <h6>Filter</h6>
            </li>

            <li><a class="dropdown-item" href="#">Today</a></li>
            <li><a class="dropdown-item" href="#">This Month</a></li>
            <li><a class="dropdown-item" href="#">This Year</a></li>
          </ul>
        </div> -->

        <div class="card-body pb-0">
          <div class="box-body table-responsive no-padding">
            <h5 class="card-title">Top Selling <span>| This Month <?php echo $id;?></span></h5>

            <table class="table table-borderless">
              <thead>
                <tr>
                  <th scope="col">Kode Produk</th>
                  <th scope="col">Nama Produk</th>
                  <th scope="col">Harga</th>
                  <th scope="col">Qty</th>
                  <th scope="col">Total</th>
                </tr>
              </thead>
              <tbody>
                <?php
                  $sql_top_selling="SELECT t.lokasi, d.kode_barang, d.nama_barang, d.harga, COUNT(*) as jml_barang, SUM(d.total) as total_harga
                        FROM `tbl_transaksi` AS `t` 
                        LEFT JOIN mst_lokasi AS `l` ON t.lokasi = l.id 
                        LEFT JOIN tbl_transaksi_detail AS d ON t.no_transaksi= d.no_transaksi
                        WHERE is_aktif= 1 AND tgl_transaksi LIKE '$bulan%' 
                        GROUP BY d.kode_barang HAVING COUNT(d.kode_barang) > 0
                        ORDER BY jml_barang DESC";
                  $res_top_selling = mysqli_query($connect,$sql_top_selling);
                  // echo $sql_top_selling;
                  while(list($lokasi,$kode_barang,$nama_barang,$harga,$jml_barang,$total_harga)=mysqli_fetch_array($res_top_selling)){
                ?>
                <tr>
                  <td><?php echo $kode_barang;?></td>
                  <td><?php echo $nama_barang;?></td>
                  <td><?php echo number_format($harga);?></td>
                  <td><?php echo $jml_barang;?></td>
                  <td><?php echo number_format($total_harga);?></td>
                </tr>
                <?php } ?>
                <!-- <tr>
                  <th scope="row"><a href="#"><img src="assets/img/product-1.jpg" width="50" alt=""></a></th>
                  <td><a href="#" class="text-primary fw-bold">Ut inventore ipsa voluptas nulla</a></td>
                  <td>$64</td>
                  <td class="fw-bold">124</td>
                  <td>$5,828</td>
                </tr>
                <tr>
                  <th scope="row"><a href="#"><img src="assets/img/product-2.jpg" width="50" alt=""></a></th>
                  <td><a href="#" class="text-primary fw-bold">Exercitationem similique doloremque</a></td>
                  <td>$46</td>
                  <td class="fw-bold">98</td>
                  <td>$4,508</td>
                </tr>
                <tr>
                  <th scope="row"><a href="#"><img src="assets/img/product-3.jpg" width="50" alt=""></a></th>
                  <td><a href="#" class="text-primary fw-bold">Doloribus nisi exercitationem</a></td>
                  <td>$59</td>
                  <td class="fw-bold">74</td>
                  <td>$4,366</td>
                </tr>
                <tr>
                  <th scope="row"><a href="#"><img src="assets/img/product-4.jpg" width="50" alt=""></a></th>
                  <td><a href="#" class="text-primary fw-bold">Officiis quaerat sint rerum error</a></td>
                  <td>$32</td>
                  <td class="fw-bold">63</td>
                  <td>$2,016</td>
                </tr>
                <tr>
                  <th scope="row"><a href="#"><img src="assets/img/product-5.jpg" width="50" alt=""></a></th>
                  <td><a href="#" class="text-primary fw-bold">Sit unde debitis delectus repellendus</a></td>
                  <td>$79</td>
                  <td class="fw-bold">41</td>
                  <td>$3,239</td>
                </tr> -->
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Recent Sales <span>| Today</span></h5>
          <table class="table table-borderless datatable">
            <thead>
              <tr>
                <th scope="col">Product</th>
                <th scope="col">Price</th>
                <th scope="col">Qty</th>
                <th scope="col">Total</th>
              </tr>
            </thead>
            <tbody>
              <?php
                $sql_recent_jual = "SELECT
                                        `t`.`no_transaksi`
                                        , `t`.`tgl_transaksi`
                                        , `d`.`nama_barang`
                                        , `d`.`harga`
                                        , `d`.`qty`
                                        , `d`.`total`
                                        , `t`.`diskon`
                                        , `t`.`total_akhir`
                                    FROM
                                        `tbl_transaksi` AS `t`
                                        INNER JOIN `pos`.`tbl_transaksi_detail` AS `d` 
                                            ON (`t`.`no_transaksi` = `d`.`no_transaksi`)
                                    ORDER BY t.tgl_transaksi DESC LIMIT 50;";
                $res_recent_jual = mysqli_query($connect,$sql_recent_jual);
                while($d=mysqli_fetch_array($res_recent_jual)){ 
              ?>
              <tr>
                <td><?php echo $d['nama_barang'];?></td>
                <td><?php echo number_format($d['harga']);?></td>
                <td><?php echo $d['qty'];?></td>
                <td><?php echo number_format($d['total']);?></td>
              </tr>
              <?php
                }
              ?>
            </tbody>
          </table>

        </div>
      </div>
    </div>

  </div>
</section>