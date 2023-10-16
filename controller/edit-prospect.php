<?php
// Include koneksi database
include_once("./KoneksiController.php");

session_start();

// Inisialisasi variabel untuk menyimpan pesan kesalahan
$errorMsg = "";

// Cek apakah form telah disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $id_prospect_edit = $_POST['id-prospect-edit'];
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
    date_default_timezone_set('Asia/Makassar');
    $last_update = date("Y-m-d h:i:s");

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
        // Query SQL untuk mengedit data
        $sql = "UPDATE prospect SET Id_newlead = '$id_lead', Prospect_type_cust = '$customer_type', Note_type_cust = '$notes_customer_type', Givenname = '$first_name', Gender = '$gender', Birthday = '$birthday', Surname = '$last_name', Religion = '$religion', Hometown = '$hometown', Curcity = '$current_city', Nationality = '$nationality', Curaddress = '$current_address', Area = '$area', Type = '$type_general', Mobile = '$mobile_phone', home_number = '$home_phone', Id_card_no = '$id_card_no', Passport_no = '$passport_no', Id_card_foto = '$id_card_foto_name_rand', Passport_foto = '$passport_foto_name_rand', Streetname = '$street_name', Building_type = '$building_type', Building_name = '$building_name', No = '$building_number', Property_ownership_type = '$property_owner_type', Location = '$location_nickname', latitude = '$latitude', longitude = '$longitude', Id_packages = '$package_id', Id_pengguna = '$id_pengguna', sales_representativ = '$sales_rep', Lead_telemarketing = '$lead_tele', General_note = '$general_notes_all', last_update = '$last_update' WHERE Id = '$id_prospect_edit'";

        $stmt = mysqli_query($conn, $sql);

        if (!$stmt) {
            $_SESSION['msg-f'] = [
                'key' => 'Gagal menyiapkan pernyataan SQL: ' . mysqli_error($conn),
                'timestamp' => time()
            ];
            header("Location: ../prospect");
            exit;
        }

        if ($stmt) {
            // Data berhasil diubah di database
            echo '<div class="alert alert-success">Data berhasil diubah.</div>';

            // Hapus foto lama jika ada
            if (!empty($id_card_foto_name_rand)) {
                $old_id_card_foto_path = "../images/id-card/" . $id_card_foto_name_rand;
                if (file_exists($old_id_card_foto_path)) {
                    unlink($old_id_card_foto_path);
                }
            }

            // Hapus foto lama jika ada
            if (!empty($passport_foto_name_rand)) {
                $old_passport_foto_path = "../images/passport/" . $passport_foto_name_rand;
                if (file_exists($old_passport_foto_path)) {
                    unlink($old_passport_foto_path);
                }
            }

            // Upload foto baru
            move_uploaded_file($id_card_foto_tmp, "../images/id-card/" . $id_card_foto_name_rand);
            move_uploaded_file($passport_foto_tmp, "../images/passport/" . $passport_foto_name_rand);

            // Jika tidak ada kesalahan, arahkan ke halaman sukses
            $_SESSION['msg'] = [
                'key' => 'Data prospect berhasil diupdate',
                'timestamp' => time()
            ];
            header("Location: ../prospect");
            exit;
        } else {
            // Gagal menyimpan data ke database
            $_SESSION['msg-f'] = [
                'key' => 'Terjadi kesalahan saat mengubah data: ' . mysqli_error($conn),
                'timestamp' => time()
            ];
            header("Location: ../prospect");
            exit;
        }
    }

    // Tutup koneksi database
    mysqli_close($conn);
}

// // Jika terdapat pesan kesalahan, tampilkan pesan kesalahan
// if (!empty($errorMsg)) {
//     echo '<div class="alert alert-danger">' . $errorMsg . '</div>';
// }
