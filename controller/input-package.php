<?php
include "./KoneksiController.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $jenis = $_POST["jenis"];
    $decs = $_POST["decs"];
    $harga = $_POST["harga"];

    // Periksa apakah ID jenis yang dikirimkan ada di dalam tabel jenis
    $checkSql = "SELECT COUNT(*) FROM jenis WHERE Id = ?";
    $checkStmt = $conn->prepare($checkSql);

    if ($checkStmt) {
        $checkStmt->bind_param("i", $jenis);
        $checkStmt->execute();
        $checkStmt->bind_result($jenisCount);
        $checkStmt->fetch();
        $checkStmt->close();

        if ($jenisCount > 0) {
            // ID jenis valid, lakukan INSERT
            $insertSql = "INSERT INTO packages (Id_jenis, Nama_Packages, Deskripsi, Harga_jual) VALUES (?, ?, ?, ?)";
            $insertStmt = $conn->prepare($insertSql);

            if ($insertStmt) {
                $insertStmt->bind_param("ssss", $jenis, $name, $decs, $harga);
                if ($insertStmt->execute()) {
                    header("Location: ../package/");
                    exit;
                } else {
                    echo "Terjadi kesalahan saat menyimpan data ke database: " . mysqli_error($conn);
                }
                $insertStmt->close();
            } else {
                echo "Terjadi kesalahan dalam persiapan pernyataan SQL: " . mysqli_error($conn);
            }
        } else {
            echo "ID jenis yang dikirimkan tidak valid.";
        }
    } else {
        echo "Terjadi kesalahan dalam persiapan pernyataan SQL: " . mysqli_error($conn);
    }

    $conn->close();
}
?>
