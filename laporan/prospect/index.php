<?php
session_start();

include "../../controller/KoneksiController.php"; // Pastikan Anda memasukkan file yang benar

$sql = "SELECT * FROM pengguna WHERE is_login = " . $_SESSION['login_status'];

$result = mysqli_query($conn, $sql);

if (!$result) {
    // Query tidak berhasil
    die("Error: " . mysqli_error($conn));
}

if (mysqli_num_rows($result) == 0) {
    // Pengguna tidak memiliki akses yang valid, arahkan kembali ke halaman login atau halaman lain yang sesuai
    header("Location: ../../");
    exit; // Pastikan untuk menghentikan eksekusi kode setelah pengalihan
} else {
    $row = mysqli_fetch_assoc($result);
    $email = $row['Email'];
    $name = $row['Nama'];
    $idIs_login = $row['Id'];
    $foto = $row['Foto'];
    $levelIs_login = $row['Level'];
}

// Inisialisasi variabel SQL
$sql = "SELECT * FROM prospect";

// Inisialisasi variabel pencarian
$where = array();
$sales_src = isset($_GET['sales-src']) ? $_GET['sales-src'] : '';
$status = isset($_GET['status']) ? $_GET['status'] : '';
// $probability = isset($_GET['probability']) ? $_GET['probability'] : '';
$tgl_start = isset($_GET['tgl-start']) ? $_GET['tgl-start'] : '';
$tgl_end = isset($_GET['tgl-end']) ? $_GET['tgl-end'] : '';

// SELECT * FROM prospect
// WHERE created_at >= 'tanggal_mulai' AND created_at <= 'tanggal_selesai';

date_default_timezone_set('Asia/Makassar');
$tgl_now = date("Y-m-d");

if (!empty($sales_src)) {
    $where[] = "sales_representativ = " . $sales_src;
}

// if (!empty($probability)) {
//     $where[] = "Probability LIKE '%" . $probability . "%'";
// }

if (!empty($tgl_start) && !empty($tgl_end)) {
    $where[] = "DATE(created_at) BETWEEN '" . $tgl_start . "' AND '" . $tgl_end . "'";
}

if (!empty($tgl_start) && empty($tgl_end)) {
    $where[] = "DATE(created_at) BETWEEN '" . $tgl_start . "' AND '" . $tgl_now . "'";
}

if (empty($tgl_start) && !empty($tgl_end)) {
    $where[] = "DATE(created_at) BETWEEN '" . $tgl_now . "' AND '" . $tgl_end . "'";
}

// Gabungkan semua kondisi pencarian
if (!empty($where)) {
    $sql .= " WHERE " . implode(" AND ", $where);
}

$result = mysqli_query($conn, $sql);

if (!$result) {
    // Query tidak berhasil
    die("Error: " . mysqli_error($conn));
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AdminLTE 3 | Dashboard</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../../assets/plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../assets/dist/css/adminlte.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="../../css/style-custom-component.css">
    <!-- Bootstrap Data Table -->
    <link rel="stylesheet" href="../../assets/bootstrap.min.css">
    <link rel="stylesheet" href="../../assets/dataTables.bootstrap4.min.css">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Preloader -->
        <!-- <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
  </div> -->

        <?php include "../../assets/template/navbar.php" ?>

        <?php include "../../assets/template/sidebar-2.php" ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-12">
                            <h1 class="m-0">Data Prospect</h1>
                        </div><!-- /.col -->
                        <div class="col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">Laporan</li>
                                <li class="breadcrumb-item active">Prospect</li>
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
                            <div class="card border-dark">
                                <div class="card-header border-0 bg-white">
                                    <h5 class="m-0">Filter Pencarian Data</h5>
                                </div>
                                <div class="card-body">
                                    <form method="GET" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                        <div class=" row">
                                            <div class="col-4">
                                                <div class="form-group" style="<?= ($levelIs_login == 3) ? 'display: none' : ''; ?>">
                                                    <label for="sales-src">Select Sales</label>
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
                                            <div class="col-4"></div>
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label for="status">Select Status</label>
                                                    <select class="form-control" id="status" name="status">
                                                        <option value="">-- Select Status --</option>
                                                        <option value="Converted" <?= ($status == 'Converted') ? 'selected' : ''; ?>>Converted</option>
                                                        <option value="Pending" <?= ($status == 'Pending') ? 'selected' : ''; ?>>Pending</option>
                                                        <option value="Cancel" <?= ($status == 'Cancel') ? 'selected' : ''; ?>>Cancel</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row border-bottom mb-3">
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label for="tgl-start">From Date</label>
                                                    <input type="date" class="form-control" id="tgl-start" name="tgl-start" <?= ($tgl_start == "") ? "" : "value='" . $tgl_start . "'" ?>>
                                                </div>
                                            </div>
                                            <div class="col-4"></div>
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label for="tgl-end">Until Date</label>
                                                    <input type="date" class="form-control" id="tgl-end" name="tgl-end" <?= ($tgl_end == "") ? "" : "value='" . $tgl_end . "'" ?>>
                                                </div>
                                            </div>
                                        </div>
                                        <a href="./" class="btn btn-secondary ml-2 float-right"><i class="fas fa-sync-alt"></i></a>
                                        <button class="btn btn-success float-right">Search Data</button>
                                    </form>
                                    <form action="../../controller/print.php" method="post" target="_blank">
                                        <input type="hidden" name="sales-src" id="sales-src" value="<?= $sales_src ?>">
                                        <input type="hidden" name="probability" id="probability" value="<?= $probability ?>">
                                        <input type="hidden" name="type" id="type" value="Prospect">
                                        <input type="hidden" name="tgl-start" id="tgl-start" value="<?= $tgl_start ?>">
                                        <input type="hidden" name="tgl-end" id="tgl-end" value="<?= $tgl_end ?>">
                                        <button class="btn btn-dark ml-2"><i class="fas fa-print"></i></button>
                                    </form>
                                </div>
                            </div>
                            <div class="kop" style="margin: 15px 0;display: flex;align-items: center;gap: 10px;">
                                <img src="../../images/logo.png" alt="logo.png" style="width: auto;height: 100px;">
                                <div class="text-kop">
                                    <p class="m-0">Global Xtreme</p>
                                    <p class="m-0">Alamat : Penarungan, Kecamatan Mengwi, Babupaten Badung, Bali</p>
                                    <p class="m-0">Telepon : 081907164770 </p>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header bg-white border-0">
                                    <h5 class="pt-4 m-0" style="opacity: 0.5;text-align: center;">Laporan Sales Prospect</h5>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <table id="example1" class="table table-bordered table-striped" style="font-size: 12px !important;">
                                        <thead>
                                            <tr class="text-secondary ">
                                                <th>#</th>
                                                <th>PROSPECT</th>
                                                <th>PACKAGE</th>
                                                <th>STATUS</th>
                                                <th>DATE CREATED</th>
                                                <th>SALES</th>
                                                <th>ACTION</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if ($result->num_rows > 0) {
                                                $no = 1; // Inisialisasi nomor baris
                                                // Output data pengguna ke dalam tabel
                                                while ($row = $result->fetch_assoc()) {
                                                    $fullname = $row['Givenname'] . $row['Surname'];
                                                    echo "<tr>";
                                                    echo "<td>" . $row['Id'] . "</td>";
                                                    echo "<td><strong>" . $fullname . "</strong><br>" . $row['Curaddress'] . "</td>";
                                                    $sql2 = "SELECT * FROM packages WHERE Id = " . $row['Id_packages'];
                                                    $result2 = mysqli_query($conn, $sql2);
                                                    if ($result2->num_rows > 0) {
                                                        while ($row2 = $result2->fetch_assoc()) {
                                                            echo "<td><strong>" . $row2['Nama_Packages'] . "</strong></td>";
                                                        }
                                                    }
                                                    echo "<td><strong>Uknown</strong></td>";
                                                    echo "<td>" . $row['created_at'] . "</td>";
                                                    $sql3 = "SELECT * FROM pengguna WHERE Id = " . $row['sales_representativ'];
                                                    $result3 = mysqli_query($conn, $sql3);
                                                    if ($result3->num_rows > 0) {
                                                        while ($row3 = $result3->fetch_assoc()) {
                                                            echo "<td><strong>" . $row3['Nama'] . "</strong><br>" . $row3['sales_from'] . "</td>";
                                                        }
                                                    }
                                            ?>
                                                    <td>
                                                        <a href="../controller/delete-prospect.php?id=<?= $row['Id'] ?>" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i></a>
                                                        <a href="./edit-data?id=<?= $row['Id'] ?>" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                                                    </td>
                                            <?php
                                                    echo "</tr>";
                                                }
                                                $no++; // Tingkatkan nomor baris setiap kali iterasi
                                            } else {
                                                echo "<tr><td colspan='9'>Tidak ada data Prospect.</td></tr>";
                                            }

                                            // Tutup koneksi
                                            $conn->close();
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <footer class="main-footer">
            <strong>&copy; <?php echo date("Y"); ?> <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
                <b>Version</b> 3.2.0
            </div>
        </footer>
    </div>
    <!-- ./wrapper -->

    <!-- Jquery -->
    <script src="../../assets/jQuery.js"></script>
    <!-- Data Table -->
    <script src="../../assets/dataTable.min.js"></script>
    <script src="../../assets/dataTable.bootstrap4.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../../assets/dist/js/adminlte.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="../../assets/dist/js/demo.js"></script>
    <!-- Script Here -->
    <script>
        $(document).ready(function() {
            $("#example1").DataTable();
        });
    </script>

    <!-- /.Script -->
    <?php include "../../assets/template/footer-end.php" ?>
</body>

</html>