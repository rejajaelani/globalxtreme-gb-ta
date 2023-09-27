<?php include "../assets/template/header.php" ?>

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
                                                      echo "Supervisor";
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
          <div class="row">
            <div class="col-lg-6 col-sm-12">
              <div class="card">
                <div class="card-header border-0">
                  <p class="text-secondary m-0">Filter Data</p>
                </div>
                <div class="card-body">
                  <form action="#">
                    <div class="row">
                      <div class="col-4">
                        <div class="form-group">
                          <label for="sales">Sales</label>
                          <select class="form-control" id="sales">
                            <option>1</option>
                            <option>2</option>
                            <option>3</option>
                            <option>4</option>
                            <option>5</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-4">
                        <div class="form-group">
                          <label for="status">Status</label>
                          <select class="form-control" id="status">
                            <option>1</option>
                            <option>2</option>
                            <option>3</option>
                            <option>4</option>
                            <option>5</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-4">
                        <button class="btn bg-custom-lgreen mt-4 text-white" style="width: 100%;">Tampilkan</button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <div class="col-lg-6 col-sm-12">
              <div class="card">
                <div class="card-header border-0">
                  <p class="text-secondary m-0">Target Capaian Sales A/N : Sumartono</p>
                </div>
                <div class="card-body">
                  <p>Target : 50</p>
                  <div class="progress rounded">
                    <div class="progress-bar progress-bar-striped bg-danger" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                  <p>Tercapai : 25</p>
                  <div class="progress rounded">
                    <div class="progress-bar progress-bar-striped bg-warning" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- /.row -->
          <div class="row">
            <div class="col-12">
              <!-- BAR CHART -->
              <div class="card">
                <div class="card-header">
                  <div class="row">
                    <div class="col-lg-4 col-md-6 col-sm-8">
                      <form action="#">
                        <div class="form-group row">
                          <div class="col">
                            <select class="form-control form-control-sm">
                              <option>2023</option>
                              <option>2022</option>
                              <option>2021</option>
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
        </div><!-- /.container-fluid -->
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <?php include "../assets/template/footer.php" ?>
    <!-- Script Here -->
    <script>
      $(function() {
        /* ChartJS
         * -------
         * Here we will create a few charts using ChartJS
         */

        // BAR CHART DATA
        var barChartData = {
          labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
          datasets: [{
              label: 'Cancel',
              backgroundColor: '#DC3545',
              borderColor: '#DC3545',
              borderWidth: 1,
              data: [28, 48, 40, 19, 86, 27, 90, 40, 19, 86, 27, 90]
            },
            {
              label: 'Converted',
              backgroundColor: '#1AB394',
              borderColor: '#1AB394',
              borderWidth: 1,
              data: [27, 90, 40, 28, 48, 40, 65, 59, 80, 81, 56, 55]
            },
            {
              label: 'Pending',
              backgroundColor: 'rgba(210, 214, 222, 1)',
              borderColor: 'rgba(210, 214, 222, 1)',
              borderWidth: 1,
              data: [65, 59, 80, 81, 56, 55, 40, 40, 19, 86, 27, 100]
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