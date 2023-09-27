<?php 
include "./KoneksiController.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"]; // ID data yang akan di-edit
    $name = $_POST["name"];

    // Menggunakan prepared statement untuk menghindari SQL injection
    $sql = "UPDATE jenis SET Nama_jenis=? WHERE Id=?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("si", $name, $id);
        if ($stmt->execute()) {
            header("Location: ../jenis-package/");
            exit;
        } else {
            echo "Terjadi kesalahan saat mengupdate data ke database: " . mysqli_error($conn);
        }
        $stmt->close();
    } else {
        echo "Terjadi kesalahan dalam persiapan pernyataan SQL: " . mysqli_error($conn);
    }

    $conn->close();
}
