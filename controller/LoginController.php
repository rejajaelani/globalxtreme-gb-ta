<?php
session_start();
include "KoneksiController.php";

$email = $_POST['email'];
$password = $_POST['password'];

// Selanjutnya, Anda perlu memeriksa email dan password dengan data yang ada di database
// Pastikan bahwa kolom email dan Password di tabel database sesuai dengan kolom yang Anda gunakan di sini

// Query SQL untuk mengambil data user berdasarkan email
$sql = "SELECT * FROM pengguna WHERE Email = '$email'";

$result = mysqli_query($conn, $sql);

if (!$result) {
    // Query tidak berhasil
    die("Error: " . mysqli_error($conn));
}

if (mysqli_num_rows($result) > 0) {
    // Data ditemukan, verifikasi password
    $row = mysqli_fetch_assoc($result);
    $hashed_password = $row['Password'];

    if (password_verify($password, $hashed_password)) {
        // Password cocok, login berhasil
        // Lakukan registrasi identifikasi login dan register session
        // Pengenalan variable pendukung
        $token_login = mt_rand(100, 999);
        date_default_timezone_set("Asia/Makassar");
        $dateNow = date("Y-m-d H:i:s");

        $_SESSION['login_status'] = $token_login;

        // Tambahkan tanda kutip pada variabel $dateNow
        $is_login = "UPDATE pengguna SET is_login = " . $_SESSION['login_status'] . ", Last_login = '" . $dateNow . "' WHERE Email = '$email'";
        $result = mysqli_query($conn, $is_login);
        if ($result) {
            // Anda bisa melakukan pengalihan ke halaman dashboard di sini
            header("Location: ../dashboard/");
            exit;
        } else {
            die("Login Error: " . mysqli_error($conn));
        }
    } else {
        // Password tidak cocok
        header("Location: ../?msg=Email Atau Password Invalid");
        exit;
    }
} else {
    // User dengan email yang dimasukkan tidak ditemukan
    header("Location: ../?msg=Email Atau Password Invalid");
    exit;
}

// Memastikan $_SESSION['level'] diatur
if (!isset($_SESSION['level'])) {
    $_SESSION['level'] = "Pengguna Default"; // Gantilah dengan level default yang sesuai
}

// Menutup koneksi ke database
mysqli_close($conn);
