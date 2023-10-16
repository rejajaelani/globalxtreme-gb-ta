<?php include "../assets/template/header.php" ?>

<?php

// Inisialisasi variabel SQL
$sql00 = "SELECT * FROM prospect";

// Inisialisasi variabel pencarian
$where = array();
date_default_timezone_set('Asia/Makassar');
if ($levelIs_login == 3) {
  $sales_src = $idIs_login;
} else {
  $sales_src = isset($_GET['sales-src']) ? $_GET['sales-src'] : '';
}
$tahun_src = isset($_GET['tahun-src']) ? $_GET['tahun-src'] : date('Y');
$status = isset($_GET['status']) ? $_GET['status'] : '';

if (!empty($sales_src)) {
  $where[] = "sales_representativ = " . $sales_src;
}

if (!empty($status)) {
  $where[] = "Status = '" . $status . "'";
}

// Gabungkan semua kondisi pencarian
if (!empty($where)) {
  $sql00 .= " WHERE " . implode(" AND ", $where);
} else {
  // if ($levelIs_login == 3) {
  //   $sql00 .= " WHERE sales_representativ = " . $idIs_login;
  // }
  $sql00;
}

$result00 = mysqli_query($conn, $sql00);

if (!$result00) {
  // Query tidak berhasil
  die("Error: " . mysqli_error($conn));
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
          <div class="row">
            <div class="col-lg-6 col-sm-12" style="<?= ($levelIs_login == 3) ? 'display: none' : ''; ?>">
              <div class="card">
                <div class="card-header border-0">
                  <p class="text-secondary m-0">Filter Data</p>
                </div>
                <div class="card-body">
                  <form method="GET" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <div class="row">
                      <div class="col-4">
                        <div class="form-group">
                          <label for="sales-src">Sales</label>
                          <select class="form-control" id="sales-src" name="sales-src">
                            <option value="">-- Select Sales --</option>
                            <?php
                            // Query SQL untuk mengambil data pengguna
                            $sql2 = "SELECT * FROM pengguna";
                            $result2 = $conn->query($sql2);

                            if ($result2->num_rows > 0) {
                              while ($row2 = $result2->fetch_assoc()) {
                            ?>
                                <option value="<?= $row2['Id'] ?>" <?= ($sales_src == $row2['Id']) ? 'selected' : ''; ?>><?= $row2['Nama'] ?></option>
                            <?php
                              }
                            } else {
                              echo "Parameter ID tidak ditemukan.";
                              exit;
                            }
                            ?>
                          </select>
                        </div>
                      </div>
                      <div class="col-4">
                        <div class="form-group">
                          <label for="status">Status</label>
                          <select class="form-control" id="status" name="status">
                            <option value="">-- Select Status --</option>
                            <option value="Scheduled" <?= ($status == 'Scheduled') ? 'selected' : ''; ?>>Scheduled</option>
                            <option value="Consideration" <?= ($status == 'Consideration') ? 'selected' : ''; ?>>Consideration</option>
                            <option value="Junk" <?= ($status == 'Junk') ? 'selected' : ''; ?>>Junk</option>
                            <option value="FCB - Future Call Back" <?= ($status == 'FCB - Future Call Back') ? 'selected' : ''; ?>>FCB - Future Call Back</option>
                            <option value="Qualified" <?= ($status == 'Qualified') ? 'selected' : ''; ?>>Qualified</option>
                            <option value="NI - Not Interested" <?= ($status == 'NI - Not Interested') ? 'selected' : ''; ?>>NI - Not Interested</option>
                            <option value="Out Cover" <?= ($status == 'Out Cover') ? 'selected' : ''; ?>>Out Cover</option>
                            <option value="Not Response" <?= ($status == 'Not Response') ? 'selected' : ''; ?>>Not Response</option>
                            <option value="Pending" <?= ($status == 'Pending') ? 'selected' : ''; ?>>Pending</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-4">
                        <button class="btn bg-custom-lgreen mt-4 text-white">Tampilkan</button>
                        <a href="./" class="btn btn-secondary mt-4 text-white"><i class="fas fa-sync-alt"></i></a>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <!-- Tampilkan data prospek sesuai dengan filter di sini -->
            <?php
            $nama_pengguna = '';

            $tercapai = 0; // Inisialisasi variabel tercapai di luar loop
            while ($data = mysqli_fetch_assoc($result00)) {

              $sqlP = "SELECT * FROM pengguna WHERE Id = " . $data['sales_representativ'];
              $resultP = $conn->query($sqlP);
              if ($resultP) {
                $rowP = $resultP->fetch_assoc();
                $nama_pengguna = $rowP['Nama'];
              }



              // Cara mendapatkan data jual dan percent per sales
              $sqlH = "SELECT SUM(Harga_jual) AS total_harga_jual FROM packages WHERE Id = " . $data['Id_packages'];
              $resultH = $conn->query($sqlH);
              $rowH = mysqli_fetch_assoc($resultH);

              // Gunakan operator += untuk mengakumulasi total Harga_jual
              $tercapai += $rowH['total_harga_jual'];


              // Cara mendapatkan array atau data banyak penjualan perbulan dan pertahun


            }
            if ($sales_src === "") {
              $target = 100000000;
            } else {
              $target = 10000000;
            }
            $percent = ($tercapai / $target) * 100;

            // echo "Tercapai = " . number_format($tercapai); // Menampilkan nilai tercapai setelah loop

            ?>
            <div class="<?= ($levelIs_login == 3) ? 'col-lg-12' : 'col-lg-6'; ?> col-sm-12">
              <div class="card">
                <div class="card-header border-0">
                  <?php
                  if ($sales_src === "") { ?>
                    <p class="text-secondary m-0">Target Capaian Sales A/N : All</p>
                  <?php } else { ?>
                    <p class="text-secondary m-0">Target Capaian Sales A/N : <?= $nama_pengguna ?></p>
                  <?php } ?>
                </div>
                <div class="card-body">
                  <div class="ket" style="display: flex;justify-content: space-between;">
                    <p class="badge badge-warning">Tercapai : Rp. <?= number_format($tercapai) ?></p>
                    <p class="badge badge-success">Target : Rp. <?= number_format($target) ?></p>
                  </div>
                  <?php
                  if ($tercapai === $target) {
                  ?>
                    <div class="progress rounded">
                      <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                  <?php
                  } else {
                  ?>
                    <div class="progress rounded">
                      <div class="progress-bar progress-bar-striped bg-warning" role="progressbar" style="width: <?= $percent ?>%" aria-valuenow="<?= $percent ?>" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                  <?php } ?>
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
                      <form method="GET" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        <div class="form-group row">
                          <div class="col">
                            <select class="form-control form-control-sm" name="tahun-src">
                              <option <?= ($tahun_src == 2023) ? 'selected' : ''; ?>>2023</option>
                              <option <?= ($tahun_src == 2024) ? 'selected' : ''; ?>>2024</option>
                              <option <?= ($tahun_src == 2025) ? 'selected' : ''; ?>>2025</option>
                              <option <?= ($tahun_src == 2026) ? 'selected' : ''; ?>>2026</option>
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
    <?php

    $sql = "SELECT * FROM prospect WHERE YEAR(created_at) = " . $tahun_src;
    $result = mysqli_query($conn, $sql);

    $namaBulanE = array(
      "January", "February", "March", "April", "May", "June",
      "July", "August", "September", "October", "November", "December"
    );

    // Periksa apakah ada hasil data
    if (mysqli_num_rows($result) > 0) {

      include "../controller/array-bulan-probabbility1.php";
      include "../controller/array-bulan-probabbility2.php";
      include "../controller/array-bulan-probabbility3.php";

      foreach ($bulan1 as $namaBulan => $jumlah) {
        // Tambahkan jumlah ke array jumlahArray
        $cancelArray[] = $jumlah;
      }

      foreach ($bulan2 as $namaBulan => $jumlah) {
        // Tambahkan jumlah ke array jumlahArray
        $pendingArray[] = $jumlah;
      }

      foreach ($bulan3 as $namaBulan => $jumlah) {
        // Tambahkan jumlah ke array jumlahArray
        $convertedArray[] = $jumlah;
      }
    } else {
      // Tidak ada data yang cocok
      $cancelArray = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
      $pendingArray = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
      $convertedArray = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
    }


    $namaBulanArrayJSON = json_encode($namaBulanE);
    $cancelArrayJSON = json_encode($cancelArray);
    $pendingArrayJSON = json_encode($pendingArray);
    $convertedArrayJSON = json_encode($convertedArray);


    // $juma = array_sum($cancelArray) + array_sum($pendingArray) + array_sum($convertedArray);

    // var_dump($namaBulanArray);
    // echo "<br/>";
    // var_dump($jumlahArray);

    ?>
    <script>
      $(function() {
        /* ChartJS
         * -------
         * Here we will create a few charts using ChartJS
         */
        // BAR CHART DATA
        var barChartData = {
          labels: <?= $namaBulanArrayJSON ?>,
          datasets: [{
              label: 'Cancel',
              backgroundColor: '#DC3545',
              borderColor: '#DC3545',
              borderWidth: 1,
              data: <?= $cancelArrayJSON ?>
            },
            {
              label: 'Converted',
              backgroundColor: '#1AB394',
              borderColor: '#1AB394',
              borderWidth: 1,
              data: <?= $convertedArrayJSON ?>
            },
            {
              label: 'Pending',
              backgroundColor: 'rgba(210, 214, 222, 1)',
              borderColor: 'rgba(210, 214, 222, 1)',
              borderWidth: 1,
              data: <?= $pendingArrayJSON ?>
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