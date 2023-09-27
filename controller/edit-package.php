<?php
include "./KoneksiController.php";

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
            header("Location: ../package/");
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
?>
