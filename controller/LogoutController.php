<?php 

include "KoneksiController.php";

// Mulai sesi
session_start();

$email = $_POST['email'];

$is_login = "UPDATE pengguna SET is_login = 0 WHERE Email = '$email'";
$result = mysqli_query($conn, $is_login);
if ($result) {
        
    // Hapus semua variabel sesi
    session_unset();

    // Hancurkan sesi
    session_destroy();

    // Mematikan koneksi ke database
    mysqli_close($conn);

    // Anda bisa melakukan pengalihan ke halaman dashboard di sini
    header("Location: ../");
    exit;

} else {
    die("Logout Error: " . mysqli_error($conn));
}
