<?php include "../assets/template/header.php" ?>

<?php

$type = 1;

$bulan_src = $_GET['bulan-src'] ?? date('n');
function formatRupiah($angka)
{
  $format_rupiah = number_format($angka, 0, ',', '.');
  return 'Rp ' . $format_rupiah;
}

?>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">

    <!-- Preloader -->
    <!-- <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
  </div> -->

    <?php include "../assets/template/navbar.php" ?>

    <?php include "../assets/template/sidebar.php" ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-12">
              <h1 class="m-0">Dashboard</h1>
            </div><!-- /.col -->
            <div class="col-12">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header bg-custom-lgreen p-5 center-of-center flex-column">
                  <h4 class="text-white"><?= $name ?></h4>
                  <h6 class="text-white">Sebagai <?php
                                                  // Konversi level berdasarkan nilai $levelIs_login
                                                  switch ($levelIs_login) {
                                                    case 1:
                                                      echo "Admin";
                                                      break;
                                                    case 2:
                                                      echo "Super Admin";
                                                      break;
                                                    case 3:
                                                      echo "Sales";
                                                      break;
                                                    default:
                                                      echo "Uknown";
                                                      break;
                                                  }
                                                  ?></h6>
                </div>
                <div class="card-body">
                  <h6>Welcome Back, <br><?= $name ?></h6>
                  <a href="../pengguna/edit-data/?id=<?= $idIs_login ?>" class="btn btn-sm bg-custom-lgreen float-right">
                    <i class="fas fa-edit"></i>
                    Edit Profile
                  </a>
                </div>
              </div>
            </div>
          </div>
          <!-- /.row -->
          <div class="row">
            <div class="col-6">
              <div class="card">
                <div class="card-body d-flex" style="gap: 20px;">
                  <img src="../assets/images/revenue.png" width="auto" height="100px" alt="revenue grow">
                  <div class="contentwrapper">
                    <h2>Sales Revenue</h2>
                    <?php

                    $sqlTotRevenue = "SELECT ps.`Id`, pk.`Harga_jual` FROM prospect ps JOIN packages pk ON pk.`Id` = ps.`Id_packages` WHERE MONTH(ps.`created_at`) = $bulan_src";
                    $resultTotRevenue = mysqli_query($conn, $sqlTotRevenue);
                    $totalRevenue = 0;
                    while ($rowTotRevenue = $resultTotRevenue->fetch_assoc()) {
                      $totalRevenue += $rowTotRevenue['Harga_jual'];
                    }

                    ?>
                    <h4><?= formatRupiah($totalRevenue) ?></h4>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-6">
              <div class="card">
                <div class="card-body d-flex" style="gap: 20px;">
                  <img src="../assets/images/trophy.png" width="auto" height="100px" alt="trophy">
                  <div class="contentwrapper">
                    <h4>Best Sales Performances</h4>
                    <?php

                    $sqlTotRevenue = "SELECT 
                      pg.`Nama`, SUM(pk.`Harga_jual`) AS Harga_jual
                      FROM prospect ps 
                      JOIN packages pk ON pk.`Id` = ps.`Id_packages` 
                      JOIN pengguna pg ON pg.`Id` = ps.`Id_pengguna` 
                      WHERE MONTH(ps.`created_at`) = $bulan_src 
                      GROUP BY pg.`Nama` 
                      ORDER BY Harga_jual DESC 
                      LIMIT 1";
                    $resultTotRevenue = mysqli_query($conn, $sqlTotRevenue);
                    $totalRevenue = 0;
                    $namaTop = "-";
                    while ($rowTotRevenue = $resultTotRevenue->fetch_assoc()) {
                      $totalRevenue += $rowTotRevenue['Harga_jual'];
                      $namaTop = $rowTotRevenue['Nama'];
                    }

                    //RUBAH INI BUAT NENTUIN TARGET CAPAIAN SALES
                    $target = 1000000;
                    //RUBAH INI BUAT NENTUIN TARGET CAPAIAN SALES

                    $persent = ($totalRevenue / $target) * 100;

                    ?>
                    <h6><?= $namaTop ?> <span class="badge badge-success"><?= $persent ?>%</span></h6>
                    <h5><?= formatRupiah($totalRevenue) ?></h5>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <!-- BAR CHART -->
              <div class="card">
                <div class="card-header">
                  <div class="row">
                    <div class="col-lg-4 col-md-6 col-sm-8">
                      <form method="GET" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        <div class="form-group row">
                          <div class="col">
                            <select class="form-control form-control-sm" name="bulan-src">
                              <?php

                              $bulan_array = [
                                'January', 'February', 'March', 'April', 'May', 'June',
                                'July', 'August', 'September', 'October', 'November', 'December'
                              ];

                              foreach ($bulan_array as $index => $bulan) {
                                $bulan_value = $index + 1;
                                echo '<option ' . (($bulan_src == $bulan_value) ? 'selected' : '') . ' value="' . $bulan_value . '">' . $bulan . '</option>';
                              }

                              ?>
                            </select>
                          </div>
                          <div class="col">
                            <button class="btn btn-sm btn-danger">Cari</button>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
                <div class="card-body">
                  <div class="chart">
                    <canvas id="barChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                  </div>
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
            </div>
            <!-- /.col -->
          </div>

          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h6 style="opacity: 0.8;">Sales Tracking Report</h6>
                </div>
                <div class="card-body">
                  <table id="myDataTable" class="table table-striped table-bordered display">
                    <thead>
                      <tr>
                        <th style="width: 20px;">#</th>
                        <th>Sales</th>
                        <th>Cancel</th>
                        <th>Converted</th>
                        <th>Pending</th>
                      </tr>
                    </thead>
                    <tbody>
                      <!-- Data akan ditambahkan di sini -->
                      <?php
                      $sqlDT = "SELECT 
                          pg.Nama, 
                          (SELECT COUNT(nl.id_pengguna) FROM new_lead nl WHERE nl.id_pengguna = pg.id AND Probability = 'Cancel') AS Cancel, 
                          (SELECT COUNT(nl.id_pengguna) FROM new_lead nl WHERE nl.id_pengguna = pg.id AND Probability = 'Converted') AS Converted, 
                          (SELECT COUNT(nl.id_pengguna) FROM new_lead nl WHERE nl.id_pengguna = pg.id AND Probability = 'Pending') AS Pending 
                          FROM pengguna pg";
                      $resultDT = mysqli_query($conn, $sqlDT);
                      $no = 1;
                      while ($rowDT = $resultDT->fetch_assoc()) {
                      ?>
                        <tr>
                          <td><?= $no ?></td>
                          <td><?= $rowDT['Nama'] ?></td>
                          <td><?= $rowDT['Cancel'] ?></td>
                          <td><?= $rowDT['Converted'] ?></td>
                          <td><?= $rowDT['Pending'] ?></td>
                        </tr>
                      <?php $no++;
                      } ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>

        </div><!-- /.container-fluid -->
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <?php include "../assets/template/footer.php" ?>
    <!-- Script Here -->
    <?php

    $sqlNama = "SELECT * FROM pengguna ORDER BY nama ASC";
    $resultNama = mysqli_query($conn, $sqlNama);
    $dataNama = [];
    while ($rowNama = $resultNama->fetch_assoc()) {
      $dataNama[] = $rowNama['Nama'];
    }

    $sqlCancel = "SELECT pg.`Nama`, COALESCE(COUNT(nl.`id_pengguna`), 0) AS jumlah FROM pengguna pg LEFT JOIN new_lead nl ON nl.`id_pengguna` = pg.`Id` AND MONTH(nl.`created_at`) = $bulan_src AND nl.`Probability` = 'Cancel' GROUP BY pg.`Nama` ORDER BY pg.`nama` ASC";
    $resultCancel = mysqli_query($conn, $sqlCancel);
    $dataCancel = [];
    while ($rowCancel = $resultCancel->fetch_assoc()) {
      $dataCancel[] = $rowCancel['jumlah'];
    }

    $sqlConverted = "SELECT pg.`Nama`, COALESCE(COUNT(nl.`id_pengguna`), 0) AS jumlah FROM pengguna pg LEFT JOIN new_lead nl ON nl.`id_pengguna` = pg.`Id` AND MONTH(nl.`created_at`) = $bulan_src AND nl.`Probability` = 'Converted' GROUP BY pg.`Nama` ORDER BY pg.`nama` ASC";
    $resultConverted = mysqli_query($conn, $sqlConverted);
    $dataConverted = [];
    while ($rowConverted = $resultConverted->fetch_assoc()) {
      $dataConverted[] = $rowConverted['jumlah'];
    }

    $sqlPending = "SELECT pg.`Nama`, COALESCE(COUNT(nl.`id_pengguna`), 0) AS jumlah FROM pengguna pg LEFT JOIN new_lead nl ON nl.`id_pengguna` = pg.`Id` AND MONTH(nl.`created_at`) = $bulan_src AND nl.`Probability` = 'Pending' GROUP BY pg.`Nama` ORDER BY pg.`nama` ASC";
    $resultPending = mysqli_query($conn, $sqlPending);
    $dataPending = [];
    while ($rowPending = $resultPending->fetch_assoc()) {
      $dataPending[] = $rowPending['jumlah'];
    }

    ?>

    <!-- Tambahkan DataTables -->

    <script>
      $(document).ready(function() {
        $('#myDataTable').DataTable();
      });

      var jsonDataNama = <?php echo json_encode($dataNama); ?>;
      var jsonDataCancel = <?php echo json_encode($dataCancel); ?>;
      var jsonDataConverted = <?php echo json_encode($dataConverted); ?>;
      var jsonDataPending = <?php echo json_encode($dataPending); ?>;
      $(function() {
        /* ChartJS
         * -------
         * Here we will create a few charts using ChartJS
         */
        // BAR CHART DATA
        var barChartData = {
          labels: jsonDataNama,
          datasets: [{
              label: 'Cancel',
              backgroundColor: '#B6BBC4',
              borderColor: '#B6BBC4',
              borderWidth: 1,
              data: jsonDataCancel
            },
            {
              label: 'Converted',
              backgroundColor: '#3081D0',
              borderColor: '#3081D0',
              borderWidth: 1,
              data: jsonDataConverted
            },
            {
              label: 'Pending',
              backgroundColor: '#FFB534',
              borderColor: '#FFB534',
              borderWidth: 1,
              data: jsonDataPending
            }
          ]
        };

        // BAR CHART OPTIONS
        var barChartOptions = {
          responsive: true,
          maintainAspectRatio: false,
          scales: {
            x: {
              beginAtZero: true
            },
            y: {
              beginAtZero: true
            }
          }
        };

        // Get the canvas element
        var barChartCanvas = document.getElementById('barChart');

        // Create the bar chart
        var barChart = new Chart(barChartCanvas, {
          type: 'bar',
          data: barChartData,
          options: barChartOptions
        });
      });
    </script>
    <!-- /.Script -->
    <?php include "../assets/template/footer-end.php" ?>