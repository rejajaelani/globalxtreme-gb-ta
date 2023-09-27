<?php
include "./KoneksiController.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_new_lead = $_POST["id_new_lead"]; // ID data yang akan diubah
    $id_pengguna = $_POST["id_pengguna"]; // ID data yang akan diubah
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
    $last_update = date("Y-m-d H:i:s");
    $asigned_to = 00;

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
            $updateSql = "UPDATE new_lead SET Fullname=?, Address=?, Phonenumber=?, Email=?, Companyname=?, Companyaddress=?, Companyphonenumber=?, Companyemail=?, Status=?, Probability=?, source=?, media=?, asigned_to=?, last_update=? WHERE Id=?";
            $updateStmt = $conn->prepare($updateSql);

            if ($updateStmt) {
                $updateStmt->bind_param("ssssssssssssssi", $fullname, $address, $phonenumber, $email, $companyname, $companyaddress, $companyphonenumber, $companyemail, $status, $probability, $source, $media, $asigned_to, $last_update, $id_new_lead);
                if ($updateStmt->execute()) {
                    header("Location: ../new-lead/");
                    exit;
                } else {
                    echo "Terjadi kesalahan saat mengedit data di database: " . mysqli_error($conn);
                }
                $updateStmt->close();
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
