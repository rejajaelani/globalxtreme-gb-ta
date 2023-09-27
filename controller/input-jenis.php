<?php
include "./KoneksiController.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];

    $sql = "INSERT INTO jenis (Nama_jenis) VALUES (?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("s", $name);
        if ($stmt->execute()) {
            header("Location: ../jenis-package/");
            exit;
        } else {
            echo "Terjadi kesalahan saat menyimpan data ke database: " . mysqli_error($conn);
        }
        $stmt->close();
    } else {
        echo "Terjadi kesalahan dalam persiapan pernyataan SQL: " . mysqli_error($conn);
    }

    $conn->close();
}
