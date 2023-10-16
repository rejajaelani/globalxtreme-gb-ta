<?php
include "./KoneksiController.php";

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"]; // ID data yang akan di-edit
    $name = $_POST["name"];

    // Menggunakan prepared statement untuk menghindari SQL injection
    $sql = "UPDATE jenis SET Nama_jenis=? WHERE Id=?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("si", $name, $id);
        if ($stmt->execute()) {
            $_SESSION['msg'] = [
                'key' => 'Data jeni berhasil diupdate',
                'timestamp' => time()
            ];
            header("Location: ../jenis-package/");
            exit;
        } else {
            $_SESSION['msg-f'] = [
                'key' => 'Terjadi kesalahan saat mengupdate data ke database: ' . mysqli_error($conn),
                'timestamp' => time()
            ];
            header("Location: ../jenis-package/");
            exit;
        }
        $stmt->close();
    } else {
        $_SESSION['msg-f'] = [
            'key' => 'Terjadi kesalahan dalam persiapan pernyataan SQL: ' . mysqli_error($conn),
            'timestamp' => time()
        ];
        header("Location: ../jenis-package/");
        exit;
    }

    $conn->close();
}
