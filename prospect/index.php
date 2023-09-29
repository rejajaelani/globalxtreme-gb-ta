<?php
session_start();

include "../controller/KoneksiController.php"; // Pastikan Anda memasukkan file yang benar

$sql = "SELECT * FROM pengguna WHERE is_login = " . $_SESSION['login_status'];

$result = mysqli_query($conn, $sql);

if (!$result) {
    // Query tidak berhasil
    die("Error: " . mysqli_error($conn));
}

if (mysqli_num_rows($result) == 0) {
    // Pengguna tidak memiliki akses yang valid, arahkan kembali ke halaman login atau halaman lain yang sesuai
    header("Location: ../");
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
// $where = array();
// $sales_src = isset($_GET['sales-src']) ? $_GET['sales-src'] : '';
// $status = isset($_GET['status']) ? $_GET['status'] : '';
// $probability = isset($_GET['probability']) ? $_GET['probability'] : '';
// $source = isset($_GET['source']) ? $_GET['source'] : '';
// $media = isset($_GET['media']) ? $_GET['media'] : '';

// if (!empty($sales_src)) {
//     $where[] = "id_pengguna = " . $sales_src;
// }

// if (!empty($status)) {
//     $where[] = "Status = '" . $status . "'";
// }

// if (!empty($probability)) {
//     $where[] = "Probability LIKE '%" . $probability . "%'";
// }

// if (!empty($source)) {
//     $where[] = "source LIKE '%" . $source . "%'";
// }

// if (!empty($media)) {
//     $where[] = "media LIKE '%" . $media . "%'";
// }

// // Gabungkan semua kondisi pencarian
// if (!empty($where)) {
//     $sql .= " WHERE " . implode(" AND ", $where);
// }

$result = mysqli_query($conn, $sql);

// if (!$result) {
//     // Query tidak berhasil
//     die("Error: " . mysqli_error($conn));
// }

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
    <link rel="stylesheet" href="../assets/plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../assets/dist/css/adminlte.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="../css/style-custom-component.css">
    <!-- Bootstrap Data Table -->
    <link rel="stylesheet" href="../assets/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/dataTables.bootstrap4.min.css">
</head>

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
                            <h1 class="m-0">Data New Lead</h1>
                        </div><!-- /.col -->
                        <div class="col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">Data Customer</li>
                                <li class="breadcrumb-item active">New Lead</li>
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
                                <div class="card-header bg-white border-0">
                                    <!-- Fillter New Lead -->
                                    <div class="fillter-new-lead">
                                        <form method="GET" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                            <div class="row">
                                                <div class="col" style="display: flex;align-items: center;">
                                                    <a href="tambah-data/" class="btn btn-primary" style="color: #FFFF !important;"><i class="fas fa-plus"></i> Tambah Data Prospect</a>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <!-- /.Fillter New Lead -->
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
                                                echo "<tr><td colspan='9'>Tidak ada data new lead.</td></tr>";
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
    <script src="../assets/jQuery.js"></script>
    <!-- Data Table -->
    <script src="../assets/dataTable.min.js"></script>
    <script src="../assets/dataTable.bootstrap4.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../assets/dist/js/adminlte.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="../assets/dist/js/demo.js"></script>
    <!-- Script Here -->
    <script>
        $(document).ready(function() {
            $("#example1").DataTable();
        });
    </script>

    <!-- /.Script -->
    <?php include "../assets/template/footer-end.php" ?>
</body>

</html>