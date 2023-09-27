<?php 
include "./KoneksiController.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $editUserId = $_POST["editUserId"]; // Mengambil ID pengguna yang akan di-edit
    $name = $_POST["name"];
    $username = $_POST["username"];
    $level = $_POST["level"];
    $status = $_POST["status"];
    $email = $_POST["email"];
    $password = $_POST["password"]; // Tambahan: mengambil password baru

    // Menggunakan prepared statement untuk menghindari SQL injection
    $sql = "UPDATE pengguna SET Nama=?, Username=?, Level=?, Status=?, Email=?";

    $bindTypes = "sssss"; // Ini adalah string yang akan menentukan tipe data binding

    // Cek apakah pengguna memasukkan password baru
    if (!empty($password)) {
        $password_hash = password_hash($password, PASSWORD_BCRYPT);
        $sql .= ", Password=?";
        $bindTypes .= "s";
    }

    // Memeriksa apakah pengguna memilih untuk mengunggah gambar baru
    if ($_FILES["image"]["size"] > 0) {
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
                    $sql .= ", Foto=?";
                    $bindTypes .= "s";
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

    // Selesai menambahkan kolom-kolom yang perlu di-update dalam query
    $sql .= " WHERE Id=?";
    $bindTypes .= "i";

    // Menggunakan prepared statement untuk menghindari SQL injection
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        // Membuat array dari variabel yang akan di-bind
        $bindParams = [&$bindTypes, &$name, &$username, &$level, &$status, &$email];

        // Jika ada pengunggahan gambar, tambahkan binding parameter
        if ($_FILES["image"]["size"] > 0) {
            $bindParams[] = &$uniqueFileName;
        }

        // Jika pengguna memasukkan password baru, tambahkan binding parameter
        if (!empty($password)) {
            $bindParams[] = &$password_hash;
        }

        // Terakhir, tambahkan editUserId sebagai binding parameter
        $bindParams[] = &$editUserId;

        // Membuat parameter binding secara dinamis menggunakan call_user_func_array
        call_user_func_array([$stmt, "bind_param"], $bindParams);

        if ($stmt->execute()) {
            header("Location: ../pengguna/");
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
