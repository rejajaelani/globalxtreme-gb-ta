<?php
include "./KoneksiController.php";

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $id = $_GET["id"]; // ID data yang akan dihapus

    // Menggunakan prepared statement untuk menghindari SQL injection
    $sqli = "DELETE FROM packages WHERE Id_jenis=?";
    $result = $conn->prepare($sqli);

    if ($result) {
        $result->bind_param("i", $id);
        if ($result->execute()) {

            $sql = "DELETE FROM jenis WHERE Id=?";
            $stmt = $conn->prepare($sql);

            if ($stmt) {
                $stmt->bind_param("i", $id);
                if ($stmt->execute()) {
                    header("Location: ../../jenis-package/");
                    exit;
                } else {
                    echo "Terjadi kesalahan saat menghapus data dari database: " . mysqli_error($conn);
                }
                $stmt->close();
            } else {
                echo "Terjadi kesalahan dalam persiapan pernyataan SQL: " . mysqli_error($conn);
            }

        } else {
            echo "Terjadi kesalahan saat menghapus data dari database: " . mysqli_error($conn);
        }
        $result->close();
    } else {
        echo "Terjadi kesalahan dalam persiapan pernyataan SQL: " . mysqli_error($conn);
    }

    $conn->close();
}
