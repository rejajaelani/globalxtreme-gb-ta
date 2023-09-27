<?php
include "./KoneksiController.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = $_POST["fullname"];
    $address = $_POST["address"];
    $phonenumber = $_POST["phonenumber"];
    $email = $_POST["email"];
    $companyname = $_POST["companyname"];
    $companyaddress = $_POST["companyaddress"];
    $companyphonenumber = $_POST["companyphonenumber"];
    $companyemail = $_POST["companyemail"];
    $status = $_POST["status"];
    $probability = $_POST["probability"];
    $source = $_POST["source"];
    $media = $_POST["media"];
    $last_update = date("Y-m-d");
    $asigned_to = 00;

    $id_pengguna = $_POST["id_pengguna"];

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
            // ID pengguna valid, lakukan INSERT ke tabel new_lead
            $insertSql = "INSERT INTO new_lead (id_pengguna, Fullname, Address, Phonenumber, Email, Companyname, Companyaddress, Companyphonenumber, Companyemail, Status, Probability, source, media, asigned_to, last_update) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $insertStmt = $conn->prepare($insertSql);

            if ($insertStmt) {
                $insertStmt->bind_param("issssssssssssss", $id_pengguna, $fullname, $address, $phonenumber, $email, $companyname, $companyaddress, $companyphonenumber, $companyemail, $status, $probability, $source, $media, $asigned_to, $last_update);
                if ($insertStmt->execute()) {
                    header("Location: ../new-lead/");
                    exit;
                } else {
                    echo "Terjadi kesalahan saat menyimpan data ke database: " . mysqli_error($conn);
                }
                $insertStmt->close();
            } else {
                echo "Terjadi kesalahan dalam persiapan pernyataan SQL: " . mysqli_error($conn);
            }
        } else {
            echo "ID pengguna yang dikirimkan tidak valid.";
        }
    } else {
        echo "Terjadi kesalahan dalam persiapan pernyataan SQL: " . mysqli_error($conn);
    }

    $conn->close();
}
