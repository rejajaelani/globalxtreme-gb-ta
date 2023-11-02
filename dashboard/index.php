<?php include "../assets/template/header.php" ?>

<?php
include "../controller/KoneksiController.php";

if (isset($_SESSION['login_status']) && $_SESSION['login_status'] == true) {
  $sql = "SELECT * FROM pengguna WHERE is_login = " . $_SESSION['login_status'];
  $result = mysqli_query($conn, $sql);

  if (!$result) {
    // Query tidak berhasil
    die("Error: " . mysqli_error($conn));
  }

  if (mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_assoc($result);
    $email = $row['Email'];
    $name = $row['Nama'];
    $idIs_login = $row['Id'];
    $foto = $row['Foto'];
    $levelIs_login = $row['Level'];

    // Inisialisasi variabel SQL
    $sql00 = "SELECT nl.*, pg.Nama AS sales_nama FROM new_lead nl JOIN pengguna pg ON nl.id_pengguna = pg.Id";
    $sqlPengguna = "SELECT * FROM pengguna";

    // Inisialisasi variabel pencarian
    $where = array();
    //$where2 = array();

    date_default_timezone_set('Asia/Makassar');
    if ($levelIs_login == 3) {
      $sales_src = $idIs_login;
    } else {
      $sales_src = isset($_GET['sales-src']) ? $_GET['sales-src'] : '';
    }

    $tahun_src = isset($_GET['tahun-src']) ? $_GET['tahun-src'] : date('Y');
    $probability = isset($_GET['probability']) ? $_GET['probability'] : '';

    if (!empty($sales_src)) {
      //$where[] = "nl.id_pengguna = " . $sales_src;
      $where[] = "Id = " . $sales_src;
      //$where2[] = "nl.id_pengguna = " . $sales_src;
    }

    // if (!empty($status)) {
    //   $where[] = "nl.Status = '" . $status . "'";
    //   $where2[] = "nl.Status = '" . $status . "'";
    // }

    // Gabungkan semua kondisi pencarian
    if (!empty($where)) {
      //$sql00 .= " AND " . implode(" AND ", $where);
      //$sql01 .= " WHERE " . implode(" AND ", $where2);
      $sqlPengguna .= " WHERE " . implode(" AND ", $where);
    }

    $result00 = mysqli_query($conn, $sql00);
    $resultPengguna = mysqli_query($conn, $sqlPengguna);

    if (!$result00) {
      // Query tidak berhasil
      die("Error: " . mysqli_error($conn));
    }
  } else {
    // Pengguna tidak memiliki akses yang valid
    header("Location: ../");
    exit;
  }
} else {
  // Pengguna belum login
  header("Location: ../");
  exit;
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
            </div>
            <div class="col-12">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
              </ol>
            </div>
          </div>
        </div>
      </div>
      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header bg-custom-lgreen p-5 center-of-center flex-column">
                  <h4 class="text-white"><?= $name ?></h4>
                  <h6 class="text-white">
                    Sebagai <?php
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
                            ?>
                  </h6>
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
            <div class="col-12" style="<?= ($levelIs_login == 3) ? 'display: none' : ''; ?>">
              <div class="card">
                <div class="card-header border-0">
                  <p class="text-secondary m-0">Filter Data</p>
                </div>
                <div class="card-body">
                  <form method="GET" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <div class="row">
                      <div class="col-5">
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
                      <div class="col-5">
                        <div class="form-group">
                          <label for="probability">Probability</label>
                          <select class="form-control" id="probability" name="probability">
                            <option value="">-- Select Probability --</option>
                            <option value="Cancel" <?= ($probability == 'Cancel') ? 'selected' : ''; ?>>Cancel</option>
                            <option value="Pending" <?= ($probability == 'Pending') ? 'selected' : ''; ?>>Pending</option>
                            <option value="Converted" <?= ($probability == 'Converted') ? 'selected' : ''; ?>>Converted</option>
                          </select>
                        </div>
                        <!-- <div class="form-group">
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
                        </div> -->
                      </div>
                      <div class="col-2">
                        <div class="form-group">
                          <label for="wrraperBtn" style="opacity: 0;">-</label>
                          <div id="wrraperBtn">
                            <button class="btn bg-custom-lgreen text-white">Tampilkan</button>
                            <a href="./" class="btn btn-secondary text-white"><i class="fas fa-sync-alt"></i></a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
          <!-- /.row -->
          <div class="row">
            <?php
            $DataCancel = array();
            $DataPending = array();
            $DataConverted = array();
            $Ids = array();

            while ($row = mysqli_fetch_assoc($resultPengguna)) {
              $Ids[] = $row['Id'];
              $DataCancel[$row['Id']] = 0;
              $DataPending[$row['Id']] = 0;
              $DataConverted[$row['Id']] = 0;
            ?>
              <div class="col-4">
                <!-- PIE CHART -->
                <div class="card card">
                  <div class="card-header bg-custom-lgreen text-white">
                    <h3 class="card-title m-0"><?= $row['Nama'] ?></h3>
                  </div>
                  <div class="card-body">
                    <canvas id="<?= $row['Id'] ?>" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                    <?php if ($probability == "Converted" || empty($probability)) { ?>
                      <div class="hargaCount mt-4">
                        <?php
                        $nama_pengguna = '';
                        $sql01 = "SELECT * FROM new_lead nl JOIN prospect ps ON nl.Id = ps.Id_newlead WHERE nl.id_pengguna = " . $row['Id'];
                        $result01 = mysqli_query($conn, $sql01);
                        $tercapai = 0;
                        while ($data = mysqli_fetch_assoc($result01)) {
                          $sqlP = "SELECT * FROM pengguna WHERE Id = " . $row['Id'];
                          $resultP = $conn->query($sqlP);
                          if ($resultP) {
                            $rowP = $resultP->fetch_assoc();
                            $nama_pengguna = $rowP['Nama'];
                          }
                          $sqlH = "SELECT SUM(Harga_jual) AS total_harga_jual FROM packages WHERE Id = " . $data['Id_packages'];
                          $resultH = $conn->query($sqlH);
                          $rowH = mysqli_fetch_assoc($resultH);
                          $tercapai += $rowH['total_harga_jual'];
                        }
                        $target = 10000000;
                        $percent = ($tercapai / $target) * 100;
                        ?>
                        <div class="ket" style="display: flex;justify-content: space-between;">
                          <?php if ($tercapai === $target) { ?>
                            <p class="badge badge-success">Tercapai : Rp. <?= number_format($tercapai) ?></p>
                          <?php } elseif ($tercapai === 10000000) { ?>
                            <p class="badge badge-warning">Tercapai : Rp. <?= number_format($tercapai) ?></p>
                          <?php } elseif ($tercapai < 10000000) { ?>
                            <p class="badge badge-danger">Tercapai : Rp. <?= number_format($tercapai) ?></p>
                          <?php } ?>
                          <p class="badge badge-success">Target : Rp. <?= number_format($target) ?></p>
                        </div>
                        <?php
                        if ($tercapai === $target) {
                        ?>
                          <div class="progress rounded">
                            <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: <?= $percent ?>%" aria-valuenow="<?= $percent ?>" aria-valuemin="0" aria-valuemax="100"><?= $percent ?>%</div>
                          </div>
                        <?php
                        } elseif ($tercapai === 10000000) {
                        ?>
                          <div class="progress rounded">
                            <div class="progress-bar progress-bar-striped bg-warning" role="progressbar" style="width: <?= $percent ?>%" aria-valuenow="<?= $percent ?>" aria-valuemin="0" aria-valuemax="100"><?= $percent ?>%</div>
                          </div>
                        <?php
                        } elseif ($tercapai < 10000000) {
                        ?>
                          <div class="progress rounded">
                            <div class="progress-bar progress-bar-striped bg-danger" role="progressbar" style="width: <?= $percent ?>%" aria-valuenow="<?= $percent ?>" aria-valuemin="0" aria-valuemax="100"><?= $percent ?>%</div>
                          </div>
                        <?php } ?>
                      </div>
                    <?php } ?>
                  </div>
                  <!-- /.card-body -->
                </div>
                <!-- /.card -->
              </div>
              <!-- /.col -->

            <?php
              $where3 = array();
              $sqlNewlead = "SELECT * FROM new_lead WHERE id_pengguna = " . $row['Id'];
              if (!empty($probability)) {
                $where3[] = "Probability = '" . $probability . "'";
              }
              if (!empty($where3)) {
                $sqlNewlead .= " AND " . implode(" AND ", $where3);
              }
              $result03 = mysqli_query($conn, $sqlNewlead);

              if ($result03) {
                while ($newleadRow = mysqli_fetch_assoc($result03)) {
                  if ($newleadRow['Probability'] == "Cancel") {
                    $DataCancel[$row['Id']] += 1;
                  } else if ($newleadRow['Probability'] == "Pending") {
                    $DataPending[$row['Id']] += 1;
                  } else if ($newleadRow['Probability'] == "Converted") {
                    $DataConverted[$row['Id']] += 1;
                  }
                }
              } else {
                // Handle kesalahan jika query gagal
                echo "Query gagal: " . mysqli_error($conn);
              }
            }
            $IdsJson = json_encode($Ids);
            ?>
          </div>
        </div><!-- /.container-fluid -->
      </section>
      <!-- /.content -->
    </div>
    <?php
    $phpData = array(
      'DataCancel' => $DataCancel,
      'DataPending' => $DataPending,
      'DataConverted' => $DataConverted
    );
    $dataJSON = json_encode($phpData);
    ?>
    <script>
      var jsData = <?php echo $dataJSON; ?>;
      console.log(jsData);
      console.log(jsData.DataCancel[8]);
    </script>
    <!-- /.content-wrapper -->
    <?php include "../assets/template/footer.php" ?>

    <!-- Sertakan Chart.js jika belum disertakan -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
      let IdPengguna = <?= $IdsJson ?>;

      console.log("hey")

      for (let i = 0; i < IdPengguna.length; i++) {
        const id = IdPengguna[i];
        let DataCancel = jsData.DataCancel[id];
        let DataPending = jsData.DataPending[id];
        let DataConverted = jsData.DataConverted[id];

        console.log(DataCancel, DataPending, DataConverted);
        console.log("----------------")
        var donutData = {
          labels: [
            'Cancel',
            'Pending',
            'Converted',
          ],
          datasets: [{
            data: [DataCancel, DataPending, DataConverted],
            backgroundColor: ['#f56954', '#f39c12', '#00c0ef'],
          }]
        }

        var pieData = donutData;
        var pieOptions = {
          maintainAspectRatio: false,
          responsive: true,
        }
        console.log(id);
        var pieChartCanvas = $('#' + id).get(0).getContext('2d')
        new Chart(pieChartCanvas, {
          type: 'pie',
          data: pieData,
          options: pieOptions
        });
      }
    </script>
    <?php include "../assets/template/footer-end.php" ?>