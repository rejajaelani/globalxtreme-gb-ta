<?php
session_start();

include "../../controller/KoneksiController.php"; // Pastikan Anda memasukkan file yang benar

if (!isset($_SESSION['login_status'])) {
  header("Location: ../");
  exit;
}

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
  <link rel="stylesheet" href="../../assets/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="../../assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="../../assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="../../assets/plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../assets/dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="../../assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="../../assets/plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="../../assets/plugins/summernote/summernote-bs4.min.css">
  <!-- Custom CSS -->
  <link rel="stylesheet" href="../../css/style-custom-component.css">
  <!-- Bootstrap Data Table -->
  <link rel="stylesheet" href="../assets/bootstrap.min.css">
  <link rel="stylesheet" href="../assets/dataTables.bootstrap4.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css" rel="stylesheet">

</head>