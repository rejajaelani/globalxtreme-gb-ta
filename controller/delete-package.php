<?php
include "./KoneksiController.php";

session_start();

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $id = $_GET["id"]; // ID data yang akan dihapus

    // Menggunakan prepared statement untuk menghindari SQL injection
    $sqli = "DELETE FROM packages WHERE Id=?";
    $result = $conn->prepare($sqli);

    if ($result) {
        $result->bind_param("i", $id);
        if ($result->execute()) {
            $_SESSION['msg'] = [
                'key' => 'Berhasil menghapus package',
                'timestamp' => time()
            ];
            header("Location: ../../package/");
            exit;
        } else {
            $_SESSION['msg-f'] = [
                'key' => 'Terjadi kesalahan saat menghapus data dari database: ' . mysqli_error($conn),
                'timestamp' => time()
            ];
            header("Location: ../../package/");
            exit;
        }
        $result->close();
    } else {
        $_SESSION['msg-w'] = [
            'key' => 'Terjadi kesalahan dalam persiapan pernyataan SQL: ' . mysqli_error($conn),
            'timestamp' => time()
        ];
        header("Location: ../../package/");
        exit;
    }
}
