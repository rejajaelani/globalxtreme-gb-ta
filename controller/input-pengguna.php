<?php
include "./KoneksiController.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $username = $_POST["username"];
    $password = $_POST["password"];
    $level = $_POST["level"];
    $status = $_POST["status"];
    $email = $_POST["email"];

    $password_hash = password_hash($password, PASSWORD_BCRYPT);

    // Direktori tempat menyimpan file gambar yang diunggah
    $uploadDirectory = "../assets/images/";

    // Mendapatkan informasi file yang diunggah
    $fileName = $_FILES["image"]["name"];
    $fileTmpName = $_FILES["image"]["tmp_name"];
    $fileSize = $_FILES["image"]["size"];
    $fileError = $_FILES["image"]["error"];

    // Memeriksa apakah file yang diunggah adalah file gambar
    $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    $allowedExtensions = ["jpg", "jpeg", "png"];

    if (in_array($fileExt, $allowedExtensions)) {
        // Memeriksa apakah terjadi kesalahan saat mengunggah file
        if ($fileError === 0) {
            // Menghasilkan nama unik untuk file gambar
            $uniqueFileName = uniqid("image_") . "." . $fileExt;
            $targetPath = $uploadDirectory . $uniqueFileName;

            // Memindahkan file yang diunggah ke direktori tujuan
            if (move_uploaded_file($fileTmpName, $targetPath)) {
                // Menggunakan prepared statement untuk menghindari SQL injection
                $sql = "INSERT INTO pengguna (Nama, Username, Password, Level, Foto, Status, Email, is_login, Last_login) VALUES (?, ?, ?, ?, ?, ?, ?, 0, NOW())";
                $stmt = $conn->prepare($sql);

                if ($stmt) {
                    $stmt->bind_param("sssssss", $name, $username, $password_hash, $level, $uniqueFileName, $status, $email);
                    if ($stmt->execute()) {
                        header("Location: ../pengguna/");
                        exit;
                    } else {
                        echo "Terjadi kesalahan saat menyimpan data ke database: " . mysqli_error($conn);
                    }
                    $stmt->close();
                } else {
                    echo "Terjadi kesalahan dalam persiapan pernyataan SQL: " . mysqli_error($conn);
                }

                $conn->close();
            } else {
                echo "Terjadi kesalahan saat mengunggah file.";
            }
        } else {
            echo "Terjadi kesalahan saat mengunggah file.";
        }
    } else {
        echo "Format file tidak didukung. Silakan unggah file gambar (jpg, jpeg, png, gif).";
    }
}
?>
