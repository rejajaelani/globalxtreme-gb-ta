<?php
include "./KoneksiController.php";

function deleteUserData($id)
{
    global $conn; // Menggunakan koneksi yang sudah dibuat di KoneksiController.php

    // Menggunakan prepared statement untuk menghindari SQL injection
    $sql = "DELETE FROM new_lead WHERE Id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        // Mengikat parameter
        $stmt->bind_param("i", $id);

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
        header("Location: ../../new-lead/");
        exit;
    } else {
        echo "Terjadi kesalahan saat menghapus data pengguna.";
    }
}
