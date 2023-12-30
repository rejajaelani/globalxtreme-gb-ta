<?php

include "./KoneksiController.php";

session_start();

$sql = "SELECT * FROM pengguna WHERE is_login = " . $_SESSION['login_status'];

$result = mysqli_query($conn, $sql);

if (!$result) {
    // Query tidak berhasil
    die("Error: " . mysqli_error($conn));
}

if (mysqli_num_rows($result) == 0) {
    // Pengguna tidak memiliki akses yang valid, arahkan kembali ke halaman login atau halaman lain yang sesuai
    header("Location: ../");
    exit; // Pastikan untuk menghentikan eksekusi kode setelah pengalihan
} else {
    $row = mysqli_fetch_assoc($result);
    $email = $row['Email'];
    $name = $row['Nama'];
    $idIs_login = $row['Id'];
    $foto = $row['Foto'];
    $levelIs_login = $row['Level'];
}

// var_dump($_POST['sales-src']);

// Inisialisasi variabel SQL
$type = isset($_POST['type']) ? $_POST['type'] : '';
if ($type == 'New Lead') {
    $sql = "SELECT * FROM new_lead";
} else {
    $sql = "SELECT ps.*, nl.Probability FROM prospect ps JOIN new_lead nl ON ps.Id_newlead = nl.Id";
}

// Inisialisasi variabel pencarian
$where = array();
$sales_src = isset($_POST['sales-src']) ? $_POST['sales-src'] : '';
$status = isset($_POST['status']) ? $_POST['status'] : '';
$probability = isset($_POST['probability']) ? $_POST['probability'] : '';
$tgl_start = isset($_POST['tgl-start']) ? $_POST['tgl-start'] : '';
$tgl_end = isset($_POST['tgl-end']) ? $_POST['tgl-end'] : '';

date_default_timezone_set('Asia/Makassar');
$tgl_now = date("Y-m-d");

if (!empty($sales_src)) {
    if ($type == 'New Lead') {
        $where[] = "id_pengguna = " . $sales_src;
    } else {
        $where[] = "sales_representativ = " . $sales_src;
    }
    $sql2 = "SELECT Nama FROM pengguna WHERE Id = " . $sales_src;
    $result2 = $conn->query($sql2);

    if ($result2->num_rows > 0) {
        while ($row2 = $result2->fetch_assoc()) {
            $nama_sales = $row2['Nama'];
        }
    }
}

if ($type == 'New Lead') {
    if (!empty($probability)) {
        $where[] = "Probability LIKE '%" . $probability . "%'";
    }
} else {
    if (!empty($probability)) {
        $where[] = "nl.Probability LIKE '%" . $probability . "%'";
    }
}

if ($type == 'New Lead') {
    if (!empty($tgl_start) && !empty($tgl_end)) {
        $where[] = "DATE(created_at) BETWEEN '" . $tgl_start . "' AND '" . $tgl_end . "'";
    }

    if (!empty($tgl_start) && empty($tgl_end)) {
        $where[] = "DATE(created_at) BETWEEN '" . $tgl_start . "' AND '" . $tgl_now . "'";
    }

    if (empty($tgl_start) && !empty($tgl_end)) {
        $where[] = "DATE(created_at) BETWEEN '" . $tgl_now . "' AND '" . $tgl_end . "'";
    }
} else {
    if (!empty($tgl_start) && !empty($tgl_end)) {
        $where[] = "DATE(ps.created_at) BETWEEN '" . $tgl_start . "' AND '" . $tgl_end . "'";
    }

    if (!empty($tgl_start) && empty($tgl_end)) {
        $where[] = "DATE(ps.created_at) BETWEEN '" . $tgl_start . "' AND '" . $tgl_now . "'";
    }

    if (empty($tgl_start) && !empty($tgl_end)) {
        $where[] = "DATE(ps.created_at) BETWEEN '" . $tgl_now . "' AND '" . $tgl_end . "'";
    }
}

// Gabungkan semua kondisi pencarian
if (!empty($where)) {
    $sql .= " WHERE " . implode(" AND ", $where);
}

$result = mysqli_query($conn, $sql);

if (!$result) {
    // Query tidak berhasil
    die("Error: " . mysqli_error($conn));
}

// if ($sales_src == "") {
//     $_SESSION['msg-f'] = [
//         'key' => 'Gagal mendapatkan data print!',
//         'timestamp' => time()
//     ];
//     if ($type == "New Lead") {
//         header("Location: ../laporan/new-lead");
//         exit;
//     } else {
//         header("Location: ../laporan/prospect");
//         exit;
//     }
// }

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Laporan | <?= $type ?></title>

    <style>
        table {
            margin-top: 20px;
            border-collapse: collapse;
            border-spacing: 0;
            width: 100%;
            border: 1px solid #ddd;
            font-size: 10px;
        }

        th,
        td {
            text-align: left;
            padding: 5px;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="kop" style="margin: 15px 0;padding: 5px;display: flex;align-items: center;gap: 10px;border: 1px solid #000;">
            <img src="../images/logo.png" alt="logo.png" style="width: auto;height: 100px;">
            <div class="text-kop" style="padding-left: 10px;border-left: 1px solid #000;">
                <p style="margin: 0;">GlobalXtreme</p>
                <p style="margin: 0;">Jl. Raya Kerobokan No.388X, Kerobokan Kelod, Kec. Kuta Utara, Kabupaten
                    Badung, Bali 80361</p>
                <p style="margin: 0;">Telepon : (0361) 736811</p>
            </div>
        </div>
        <p style="margin: 0;padding-bottom: 10px;font-size: 18px;font-weight: bold;">Laporan <?= $type ?></p>
        <p style="margin: 0;">Atas Nama Sales : <?= ($sales_src == "") ? "-" : $nama_sales ?></p>
        <p style="margin: 0;<?= ($probability == "") ? "display: none;" : '' ?>">Probability : <?= ($probability == "") ? "-" : $probability ?></p>
        <p style="margin: 0;<?= ($status == "") ? "display: none;" : '' ?>"> Status : <?= ($status == "") ? "-" : $status ?></p>
        <p style="margin: 0;">Periode <?= $tgl_start ?> - <?= $tgl_end ?></p>

        <?php
        if ($type == 'New Lead') { ?>
            <table border="1">
                <thead>
                    <th>Lead</th>
                    <th>Primary Contact</th>
                    <th>Status</th>
                    <th>Probabilty</th>
                    <th>Source</th>
                    <th>Media</th>
                    <th>Last Update</th>
                    <th>Asigned To</th>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        $no = 1; // Inisialisasi nomor baris
                        // Output data pengguna ke dalam tabel
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row['Id'] . "</td>";
                            echo "<td>" . $row['Phonenumber'] . "</td>";
                            echo "<td>" . $row['Status'] . "</td>";
                            if ($row['Probability'] === 'Converted') {
                                echo "<td><div class='badge badge-primary'>" . $row['Probability'] . "</div></td>";
                            } elseif ($row['Probability'] === 'Pending') {
                                echo "<td><div class='badge badge-warning'>" . $row['Probability'] . "</div></td>";
                            } elseif ($row['Probability'] === 'Cancel') {
                                echo "<td><div class='badge badge-danger'>" . $row['Probability'] . "</div></td>";
                            }
                            echo "<td>" . $row['source'] . "</td>";
                            echo "<td>" . $row['media'] . "</td>";
                            echo "<td>" . $row['last_update'] . "</td>";
                            if ($row['asigned_to'] == 00) {
                    ?>
                                <td>
                                    -
                                </td>
                                <?php } else {
                                $sql2 = "SELECT Nama FROM pengguna WHERE Id = " . $row['asigned_to'];
                                $result2 = $conn->query($sql2);

                                if ($result2->num_rows > 0) {
                                    while ($row2 = $result2->fetch_assoc()) {
                                ?>
                                        <td>
                                            <?= $row2['Nama'] ?></i>
                                        </td>
                    <?php }
                                }
                            }
                        }
                        $no++; // Tingkatkan nomor baris setiap kali iterasi
                    } else {
                        echo "<tr><td colspan='9'>Tidak ada data new lead.</td></tr>";
                    }

                    // Tutup koneksi
                    $conn->close();
                    ?>
                </tbody>
            </table>
        <?php } else if ($type == 'Prospect') { ?>
            <table border="1">
                <thead>
                    <th>#</th>
                    <th>PROSPECT</th>
                    <th>PACKAGE</th>
                    <th>STATUS</th>
                    <th>DATE CREATED</th>
                    <th>SALES</th>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        $no = 1; // Inisialisasi nomor baris
                        // Output data pengguna ke dalam tabel
                        while ($row = $result->fetch_assoc()) {
                            $fullname = $row['Givenname'] . $row['Surname'];
                            echo "<tr>";
                            echo "<td>" . $row['Id'] . "</td>";
                            echo "<td>" . $fullname . "<br>" . $row['Curaddress'] . "</td>";
                            $sql2 = "SELECT * FROM packages WHERE Id = " . $row['Id_packages'];
                            $result2 = mysqli_query($conn, $sql2);
                            if ($result2->num_rows > 0) {
                                while ($row2 = $result2->fetch_assoc()) {
                                    echo "<td>" . $row2['Nama_Packages'] . "</td>";
                                }
                            }
                            echo "<td>" . $row['Probability'] . "</td>";
                            echo "<td>" . $row['created_at'] . "</td>";
                            $sql3 = "SELECT * FROM pengguna WHERE Id = " . $row['sales_representativ'];
                            $result3 = mysqli_query($conn, $sql3);
                            if ($result3->num_rows > 0) {
                                while ($row3 = $result3->fetch_assoc()) {
                                    echo "<td>" . $row3['Nama'] . "<br>" . $row3['sales_from'] . "</td>";
                                }
                            }

                            echo "</tr>";
                        }
                        $no++; // Tingkatkan nomor baris setiap kali iterasi
                    } else {
                        echo "<tr><td colspan='9'>Tidak ada data prospect.</td></tr>";
                    }

                    // Tutup koneksi
                    $conn->close();
                    ?>
                </tbody>
            </table>
        <?php } else {
            echo "<br/>";
            echo "Data harus dikirim ulang kembali ke halaman laporan!!<br>";
            echo "Mohon jangan refresh halaman ini!!<br>";
            echo "<a href='../'><< Kembali</a>";
        } ?>

    </div>

    <!-- Script JavaScript untuk Cetak -->
    <script>
        // Mencetak halaman saat dokumen selesai dimuat
        window.onload = function() {
            window.print();
        };
    </script>
</body>

</html>