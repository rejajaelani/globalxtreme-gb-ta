<?php
include "./KoneksiController.php";

session_start();

function deleteUserData($id)
{
    global $conn; // Menggunakan koneksi yang sudah dibuat di KoneksiController.php

    // Menggunakan prepared statement untuk menghindari SQL injection
    $sql = "DELETE FROM prospect WHERE Id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        // Mengikat parameter
        $stmt->bind_param("s", $id);

        if ($stmt->execute()) {
            return true; // Data berhasil dihapus
        } else {
            return false; // Terjadi kesalahan saat menghapus data
        }
        $stmt->close();
    } else {
        return false; // Terjadi kesalahan dalam persiapan pernyataan SQL
    }
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $id = $_GET["id"]; // Mengambil ID pengguna yang akan dihapus

    if (deleteUserData($id)) {
        $_SESSION['msg'] = [
            'key' => 'Data procpect berhasil didelete',
            'timestamp' => time()
        ];
        header("Location: ../prospect/");
        exit;
    } else {
        $_SESSION['msg-f'] = [
            'key' => 'Terjadi kesalahan saat menghapus data prospect : ' . mysqli_error($conn),
            'timestamp' => time()
        ];
        header("Location: ../prospect/");
        exit;
    }
}
