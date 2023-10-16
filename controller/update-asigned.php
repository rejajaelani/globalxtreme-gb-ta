<?php
include "./KoneksiController.php";

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_new_lead = $_POST["id_new_lead"]; // ID data yang akan diubah
    $id_pengguna = $_POST["id_pengguna"]; // ID data yang akan diubah
    $last_update = date("Y-m-d H:i:s");
    $asigned_to = $_POST['asigned_to'];

    // Periksa apakah ID pengguna yang dikirimkan ada di dalam tabel pengguna
    $checkSql = "SELECT COUNT(*) FROM pengguna WHERE Id = ?";
    $checkStmt = $conn->prepare($checkSql);

    if ($checkStmt) {
        $checkStmt->bind_param("i", $id_pengguna);
        $checkStmt->execute();
        $checkStmt->bind_result($penggunaCount);
        $checkStmt->fetch();
        $checkStmt->close();

        if ($penggunaCount > 0) {
            // ID pengguna valid, lakukan UPDATE pada tabel new_lead
            $updateSql = "UPDATE new_lead SET asigned_to=?, last_update=? WHERE Id=?";
            $updateStmt = $conn->prepare($updateSql);

            if ($updateStmt) {
                $updateStmt->bind_param("ssi", $asigned_to, $last_update, $id_new_lead);
                if ($updateStmt->execute()) {
                    $_SESSION['msg'] = [
                        'key' => 'Data asigned berhasil diupdate',
                        'timestamp' => time()
                    ];
                    header("Location: ../new-lead/");
                    exit;
                } else {
                    $_SESSION['msg-f'] = [
                        'key' => 'Terjadi kesalahan saat mengedit data di database: ' . mysqli_error($conn),
                        'timestamp' => time()
                    ];
                    header("Location: ../new-lead/");
                    exit;
                }
                $updateStmt->close();
            } else {
                $_SESSION['msg-f'] = [
                    'key' => 'Terjadi kesalahan dalam persiapan pernyataan SQL: ' . mysqli_error($conn),
                    'timestamp' => time()
                ];
                header("Location: ../new-lead/");
                exit;
            }
        } else {
            $_SESSION['msg-w'] = [
                'key' => 'ID pengguna yang dikirimkan tidak valid',
                'timestamp' => time()
            ];
            header("Location: ../new-lead/");
            exit;
        }
    } else {
        $_SESSION['msg-w'] = [
            'key' => 'Terjadi kesalahan dalam persiapan pernyataan SQL: ' . mysqli_error($conn),
            'timestamp' => time()
        ];
        header("Location: ../new-lead/");
        exit;
    }

    $conn->close();
}
