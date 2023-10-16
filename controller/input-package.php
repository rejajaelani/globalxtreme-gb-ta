<?php
include "./KoneksiController.php";

session_start();

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
                    $_SESSION['msg'] = [
                        'key' => 'Data package berhasil diinput',
                        'timestamp' => time()
                    ];
                    header("Location: ../package/");
                    exit;
                } else {
                    $_SESSION['msg-f'] = [
                        'key' => 'Terjadi kesalahan saat menyimpan data ke database: ' . mysqli_error($conn),
                        'timestamp' => time()
                    ];
                    header("Location: ../package/");
                    exit;
                }
                $insertStmt->close();
            } else {
                $_SESSION['msg-f'] = [
                    'key' => 'Terjadi kesalahan dalam persiapan pernyataan SQL: ' . mysqli_error($conn),
                    'timestamp' => time()
                ];
                header("Location: ../package/");
                exit;
            }
        } else {
            $_SESSION['msg-w'] = [
                'key' => 'ID jenis yang dikirimkan tidak valid',
                'timestamp' => time()
            ];
            header("Location: ../package/");
            exit;
        }
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
