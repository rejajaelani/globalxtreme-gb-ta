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
    date_default_timezone_set('Asia/Makassar');
    $last_update = date("Y-m-d h:i:s");
    $asigned_to = 00;

    // Inisialisasi variabel
    $id_newlead = '';

    // Query untuk menghitung jumlah baris dalam tabel newlead
    $sql = "SELECT COUNT(*) as count FROM new_lead";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        die("Gagal menjalankan query: " . mysqli_error($conn));
    }

    $row = mysqli_fetch_assoc($result);
    $count = $row['count'];

    // Membuat id_newlead yang unik
    $id_newlead = 'LD' . str_pad($count + 1, 4, '0', STR_PAD_LEFT); // Format 'LD0001', 'LD0002', dll.

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
            $insertSql = "INSERT INTO new_lead (Id, id_pengguna, Fullname, Address, Phonenumber, Email, Companyname, Companyaddress, Companyphonenumber, Companyemail, Status, Probability, source, media, asigned_to, last_update) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $insertStmt = $conn->prepare($insertSql);

            if ($insertStmt) {
                $insertStmt->bind_param("sissssssssssssss", $id_newlead, $id_pengguna, $fullname, $address, $phonenumber, $email, $companyname, $companyaddress, $companyphonenumber, $companyemail, $status, $probability, $source, $media, $asigned_to, $last_update);
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
