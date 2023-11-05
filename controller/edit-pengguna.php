<?php
include "./KoneksiController.php";

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $editUserId = $_POST["editUserId"]; // Mengambil ID pengguna yang akan di-edit
    $name = $_POST["name"];
    $username = $_POST["username"];
    $level = $_POST["level"];
    $status = $_POST["status"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Cek apakah pengguna memasukkan password baru
    if ($password == "") {
        $sql_cek_ps = "SELECT Password FROM pengguna WHERE Id = " . $editUserId;
        $result_cek_ps = mysqli_query($conn, $sql_cek_ps);
        while ($row = mysqli_fetch_assoc($result_cek_ps)) {
            $password = $row['Password'];
        }
    } else {
        $password = password_hash($password, PASSWORD_BCRYPT);
    }

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

    $nama_foto = "";

    if (in_array($fileExt, $allowedExtensions)) {
        // Memeriksa apakah terjadi kesalahan saat mengunggah file
        if ($fileError === 0) {
            // Menghasilkan nama unik untuk file gambar
            $uniqueFileName = uniqid("image_") . "." . $fileExt;
            $targetPath = $uploadDirectory . $uniqueFileName;

            // Memindahkan file yang diunggah ke direktori tujuan
            if (move_uploaded_file($fileTmpName, $targetPath)) {
                $name_foto = $uniqueFileName;
            } else {
                echo "Terjadi kesalahan saat mengunggah file.";
            }
        } else {
            echo "Terjadi kesalahan saat mengunggah file.";
        }
    } else {
        // echo "Format file tidak didukung. Silakan unggah file gambar (jpg, jpeg, png, gif).";

        if ($fileName == "") {
            $sql_cek_ft = "SELECT Foto FROM pengguna WHERE Id = " . $editUserId;
            $result_cek_ft = mysqli_query($conn, $sql_cek_ft);
            while ($row = mysqli_fetch_assoc($result_cek_ft)) {
                $name_foto = $row['Foto'];
            }
        }
    }


    // global $nama_foto;
    // var_dump($name_foto);

    // hapus foto lama 
    $cekFoto = "SELECT Foto FROM pengguna WHERE Id = " . $editUserId;
    $resultCekFoto = mysqli_query($conn, $cekFoto);
    while ($cek = mysqli_fetch_assoc($resultCekFoto)) {
        if ($fileName != "") {
            $oldPhotoPath = $uploadDirectory . $cek['Foto'];
            file_exists($oldPhotoPath);
            unlink($oldPhotoPath);
        }
        $sql = "UPDATE pengguna SET Nama = '$name', Username = '$username', Password = '$password', Email = '$email', Level = '$level', Status = $status, Foto = '$name_foto' WHERE Id = " . $editUserId;
        $result = mysqli_query($conn, $sql);
        if ($result) {
            $_SESSION['msg'] = [
                'key' => 'Update data pengguna berhasil',
                'timestamp' => time()
            ];
            header("Location: ../pengguna/");
            exit;
        } else {
            // echo 'Error : ' . mysqli_error($conn);
            $_SESSION['msg-f'] = [
                'key' => 'Error : ' . mysqli_error($conn),
                'timestamp' => time()
            ];
            header("Location: ../pengguna/");
            exit;
        }
    }
}
