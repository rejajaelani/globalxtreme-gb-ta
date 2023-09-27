<?php
// Include koneksi database
include_once("./KoneksiController.php");

// Inisialisasi variabel untuk menyimpan pesan kesalahan
$errorMsg = "";

// Cek apakah form telah disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $id_lead = $_POST["id_lead"];
    $customer_type = $_POST["customer-type"];
    $notes_customer_type = $_POST["notes-customer-type"];
    $first_name = $_POST["first-name"];
    $last_name = $_POST["last-name"];
    $fullname = $first_name . " " . $last_name;
    $gender = $_POST["gender"];
    $religion = $_POST["religion"];
    $birthday = $_POST["birthday"];
    $hometown = $_POST["hometown"];
    $current_address = $_POST["current-address"];
    $current_city = $_POST["current-city"];
    $area = $_POST["area"];
    $nationality = $_POST["nationality"];
    $type_general = $_POST["type-general"];
    $mobile_phone = $_POST["mobile-phone"];
    $home_phone = $_POST["home-phone"];
    $id_card_no = $_POST["id-card-no"];
    $passport_no = $_POST["passport-no"];
    $street_name = $_POST["street-name"];
    $building_name = $_POST["building-name"];
    $building_number = $_POST["building-number"];
    $building_type = $_POST["building-type"];
    $property_owner_type = $_POST["property-owner-type"];
    $latitude = $_POST["latitude"];
    $longitude = $_POST["longitude"];
    $location_nickname = $_POST["location-nickname"];
    $package_id = $_POST["package-id"];
    $id_pengguna = $_POST["id-pengguna"];
    $sales_rep = $_POST["sales-rep"];
    $lead_tele = $_POST["lead-tele"];
    $general_notes_all = $_POST["general-notes-all"];

    $id_card_foto_name = $_FILES["id-card-foto"]["name"];
    $id_card_foto_tmp = $_FILES["id-card-foto"]["tmp_name"];
    $passport_foto_name = $_FILES["passport-foto"]["name"];
    $passport_foto_tmp = $_FILES["passport-foto"]["tmp_name"];

    // Inisialisasi variabel
    $id_prospect = '';

    // Query untuk menghitung jumlah baris dalam tabel prospect
    $sql = "SELECT COUNT(*) as count FROM prospect";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        die("Gagal menjalankan query: " . mysqli_error($conn));
    }

    $row = mysqli_fetch_assoc($result);
    $count = $row['count'];

    // Membuat id_prospect yang unik
    $id_prospect = 'PRO' . str_pad($count + 1, 4, '0', STR_PAD_LEFT); // Format 'PRO0001', 'PRO0002', dll.



    // Fungsi untuk menghasilkan nama acak untuk file
    function generateRandomFileName($file_name)
    {
        $file_extension = pathinfo($file_name, PATHINFO_EXTENSION);
        $random_string = bin2hex(random_bytes(8)); // Membuat string acak (gunakan lebih banyak karakter sesuai kebutuhan)
        return $random_string . '.' . $file_extension;
    }

    $id_card_foto_name_rand = generateRandomFileName($id_card_foto_name);
    $passport_foto_name_rand = generateRandomFileName($passport_foto_name);

    // Validasi data yang harus diisi
    $required_fields = array(
        $id_lead, $customer_type, $notes_customer_type, $first_name, $last_name, $gender, $birthday, $hometown,
        $current_address, $current_city, $area, $nationality, $type_general, $mobile_phone, $id_card_no, $passport_no,
        $street_name, $building_name, $building_number, $building_type, $property_owner_type, $latitude, $longitude,
        $location_nickname, $package_id, $id_pengguna, $sales_rep, $lead_tele
    );

    if (in_array("", $required_fields)) {
        $errorMsg = "Semua kolom harus diisi.";
    } else {
        // Lakukan penyimpanan data ke database
        $sql = "INSERT INTO prospect (Id, Id_newlead, Prospect_type_cust, Note_type_cust, Givenname, Gender, Birthday, Surname, Religion, Hometown, Curcity, Nationality, Curaddress, Area, Type, Mobile, Id_card_no, Passport_no, Id_card_foto, Passport_foto, Streetname, Building_type, Building_name, No, Property_ownership_type, Location, Id_packages, Id_pengguna, sales_representativ, Lead_telemarketing, General_note) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);

        if (!$stmt) {
            die("Gagal menyiapkan pernyataan SQL: " . $conn->error);
        }

        $stmt->bind_param(
            "ssssssssssssssssiisssssissiisss",
            $id_prospect,
            $id_lead,
            $customer_type,
            $notes_customer_type,
            $first_name,
            $gender,
            $birthday,
            $last_name,
            $religion,
            $hometown,
            $current_city,
            $nationality,
            $current_address,
            $area,
            $type_general,
            $mobile_phone,
            $id_card_no,
            $passport_no,
            $id_card_foto_name_rand,
            $passport_foto_name_rand,
            $street_name,
            $building_type,
            $building_name,
            $building_number,
            $property_owner_type,
            $location_nickname,
            $package_id,
            $id_pengguna,
            $sales_rep,
            $lead_tele,
            $general_notes_all
        );

        if ($stmt->execute()) {

            $confirm = 'Confirmed';

            $sql2 = "UPDATE new_lead SET Probability = ? WHERE Id = ?";

            $stmt2 = $conn->prepare($sql2);

            if (!$stmt2) {
                die("Gagal menyiapkan pernyataan SQL: " . $conn->error);
            }

            $stmt2->bind_param(
                "si",
                $confirm,
                $id_lead
            );

            if ($stmt2->execute()) {
                // Data berhasil disimpan ke database
                echo '<div class="alert alert-success">Data berhasil disimpan.</div>';

                // Validasi foto id_card_foto
                $id_card_foto_destination = "../images/id-card/" . $id_card_foto_name_rand;

                // Pemeriksaan tipe MIME
                $allowed_image_types = array("image/jpeg", "image/jpg", "image/png", "image/gif");
                if (in_array($_FILES["id-card-foto"]["type"], $allowed_image_types)) {
                    move_uploaded_file($id_card_foto_tmp, $id_card_foto_destination);
                } else {
                    echo '<div class="alert alert-danger">Hanya file gambar (jpeg, jpg, png, gif) yang diizinkan.</div>';
                }

                // Validasi foto passport_foto
                $passport_foto_destination = "../images/passport/" . $passport_foto_name_rand;

                // Pemeriksaan tipe MIME
                if (in_array($_FILES["passport-foto"]["type"], $allowed_image_types)) {
                    move_uploaded_file($passport_foto_tmp, $passport_foto_destination);
                } else {
                    echo '<div class="alert alert-danger">Hanya file gambar (jpeg, jpg, png, gif) yang diizinkan.</div>';
                }

                // Jika tidak ada kesalahan, arahkan ke halaman sukses
                header("Location: ../prospect");
                exit;
            }
        } else {
            // Gagal menyimpan data ke database
            echo '<div class="alert alert-danger">Terjadi kesalahan saat menyimpan data: ' . $stmt->error . '</div>';
        }

        // Tutup statement
        $stmt->close();
    }

    // Tutup koneksi database
    $conn->close();
}

// Jika terdapat pesan kesalahan, tampilkan pesan kesalahan
if (!empty($errorMsg)) {
    echo '<div class="alert alert-danger">' . $errorMsg . '</div>';
}
