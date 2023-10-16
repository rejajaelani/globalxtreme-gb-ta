<?php
include "./KoneksiController.php";

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $editId = $_POST["packageId"];
    $name = $_POST["name"];
    $jenis = $_POST["jenis"];
    $decs = $_POST["decs"];
    $harga = $_POST["harga"];

    // Menggunakan prepared statement untuk menghindari SQL injection
    $sql = "UPDATE packages SET Id_jenis=?, Nama_Packages=?, Deskripsi=?, Harga_jual=? WHERE Id=?";

    // Menggunakan prepared statement untuk menghindari SQL injection
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("ssssi", $jenis, $name, $decs, $harga, $editId);

        if ($stmt->execute()) {
            $_SESSION['msg'] = [
                'key' => 'Data package berhasil diupdate',
                'timestamp' => time()
            ];
            header("Location: ../package/");
            exit;
        } else {
            $_SESSION['msg-f'] = [
                'key' => 'Terjadi kesalahan saat mengupdate data ke database: ' . mysqli_error($conn),
                'timestamp' => time()
            ];
            header("Location: ../package/");
            exit;
        }
        $stmt->close();
    } else {
        $_SESSION['msg-f'] = [
            'key' => 'Terjadi kesalahan dalam persiapan pernyataan SQL: ' . mysqli_error($conn),
            'timestamp' => time()
        ];
        header("Location: ../package/");
        exit;
    }

    $conn->close();
}
