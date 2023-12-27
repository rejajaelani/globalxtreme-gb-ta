<?php
include "./KoneksiController.php";

if ($_SERVER["REQUEST_METHOD"] == "GET") {

    session_start();

    $id = $_GET["id"];
    $status = $_GET["status"];
    $msg = "";

    if ($status == "1") {
        $sql = "UPDATE pengguna SET Status = 0 WHERE Id = $id";
        $msg = "Data pengguna berhasil di non-aktifkan";
    } else if ($status == "0") {
        $sql = "UPDATE pengguna SET Status = 1 WHERE Id = $id";
        $msg = "Data pengguna berhasil di aktifkan";
    }
    $result = mysqli_query($conn, $sql);
    if ($result) {
        $_SESSION['msg'] = [
            'key' => $msg,
            'timestamp' => time()
        ];
        header("Location: ../../pengguna/");
        exit;
    } else {
        $_SESSION['msg-f'] = [
            'key' => 'Terjadi kesalahan saat proses data pengguna : ' . mysqli_error($conn),
            'timestamp' => time()
        ];
        header("Location: ../../pengguna/");
        exit;
    }
}
