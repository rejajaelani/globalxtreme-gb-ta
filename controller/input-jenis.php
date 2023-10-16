<?php
include "./KoneksiController.php";

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];

    $sql = "INSERT INTO jenis (Nama_jenis) VALUES (?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("s", $name);
        if ($stmt->execute()) {
            $_SESSION['msg'] = [
                'key' => 'Data jenis package berhasil diinput',
                'timestamp' => time()
            ];
            header("Location: ../jenis-package/");
            exit;
        } else {
            $_SESSION['msg-f'] = [
                'key' => 'Terjadi kesalahan saat menyimpan data ke database: ' . mysqli_error($conn),
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
