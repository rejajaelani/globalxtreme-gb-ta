<?php
session_start();

include "../controller/KoneksiController.php"; // Pastikan Anda memasukkan file yang benar

include "../assets/delMsg.php";

$type = 1;

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
}

$is_login = "SELECT * FROM pengguna WHERE is_login = " . $_SESSION['login_status'];
$resultIs_login = mysqli_query($conn, $is_login);
if ($resultIs_login->num_rows > 0) {
  // Output data dari setiap baris
  while ($rowIs_login = $resultIs_login->fetch_assoc()) {
    $name = $rowIs_login['Nama'];
    $idIs_login = $rowIs_login['Id'];
    $foto = $rowIs_login['Foto'];
    $levelIs_login = $rowIs_login['Level'];
  }
} else {
  echo "Tidak ada data yang ditemukan.";
}

// Data sesuai dengan session login_status, tidak perlu mengarahkan
// Anda dapat melanjutkan eksekusi kode jika pengguna memiliki akses yang valid
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
            <?php
            if (!empty($_SESSION['msg'])) {
            ?>
              <div class="col-12">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                  <strong>Message!</strong> <?= $_SESSION['msg']['key'] ?>
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
              </div>
            <?php } ?>
            <?php
            if (!empty($_SESSION['msg-w'])) {
            ?>
              <div class="col-12">
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                  <strong>Message!</strong> <?= $_SESSION['msg-w']['key'] ?>
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
              </div>
            <?php } ?>
            <?php
            if (!empty($_SESSION['msg-f'])) {
            ?>
              <div class="col-12">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                  <strong>Message!</strong> <?= $_SESSION['msg-f']['key'] ?>
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
              </div>
            <?php } ?>
            <div class="col-12">
              <h1 class="m-0">Data Jenis Package</h1>
            </div><!-- /.col -->
            <div class="col-12">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Data Master</a></li>
                <li class="breadcrumb-item active">Jenis Package</li>
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
                <div class="card-header bg-white">
                  <a href="tambah-data/" class="btn bg-custom-lgreen mt-2 mb-2" style="color: #FFFF !important;">
                    <i class="fas fa-plus"></i> Tambah Jenis Package
                  </a>
                  <h3 class="card-title text-center" style="width: 100%;">Data Jenis Package</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Nama Jenis Package</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      // Query SQL untuk mengambil Jenis Package
                      $sql = "SELECT * FROM jenis";
                      $result = $conn->query($sql);

                      if ($result->num_rows > 0) {
                        $no = 1; // Inisialisasi nomor baris
                        // Output Jenis Package ke dalam tabel
                        while ($row = $result->fetch_assoc()) {
                          echo "<tr>";
                          echo "<td>" . $no . "</td>";
                          echo "<td>" . $row["Nama_jenis"] . "</td>";
                      ?>
                          <td>
                            <a href="edit-data/?id=<?= $row['Id'] ?>" class="btn btn-primary">
                              <i class="fas fa-edit"></i> Edit
                            </a>
                            <a href="../controller/delete-jenis.php/?id=<?= $row['Id'] ?>" class="btn btn-danger">
                              <i class="fas fa-trash-alt"></i> Delete
                            </a>
                          </td>
                      <?php
                          echo "</tr>";
                          $no++; // Tingkatkan nomor baris setiap kali iterasi
                        }
                      } else {
                        echo "<tr><td colspan='6'>Tidak ada Jenis Package.</td></tr>";
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
      <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
      All rights reserved.
      <div class="float-right d-none d-sm-inline-block">
        <b>Version</b> 3.2.0
      </div>
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
  </div>
  <!-- ./wrapper -->
  <!-- Jquery -->
  <script src="../assets/jQuery.js"></script>
  <!-- Data Table -->
  <script src="../assets/dataTable.min.js"></script>
  <script src="../assets/dataTable.bootstrap4.min.js"></script>
  <!-- Bootstrap JavaScript -->
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
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