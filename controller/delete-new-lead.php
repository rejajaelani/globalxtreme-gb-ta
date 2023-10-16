<?php
include "./KoneksiController.php";

session_start();

// function deleteUserData($id)
// {
//     global $conn; // Menggunakan koneksi yang sudah dibuat di KoneksiController.php

//     // Menggunakan prepared statement untuk menghindari SQL injection
//     $sql1 = "DELETE FROM new_lead WHERE Id = ?";
//     $stmt1 = $conn->prepare($sql1);

//     if ($stmt1) {
//         // Mengikat parameter
//         $stmt1->bind_param("s", $id);

//         if ($stmt1->execute()) {
//             // Menggunakan prepared statement untuk menghapus catatan di tb_notes_newlead
//             $sql2 = "DELETE FROM tb_notes_newlead WHERE id_newlead = ?";
//             $stmt2 = $conn->prepare($sql2);

//             if ($stmt2) {
//                 $stmt2->bind_param("s", $id);
//                 if ($stmt2->execute()) {
//                     return true; // Data berhasil dihapus
//                 } else {
//                     return false; // Terjadi kesalahan saat menghapus catatan di tb_notes_newlead
//                 }
//                 $stmt2->close();
//             } else {
//                 return false; // Terjadi kesalahan dalam persiapan pernyataan SQL untuk tb_notes_newlead
//             }
//         } else {
//             return false; // Terjadi kesalahan saat menghapus data dari new_lead
//         }
//         $stmt1->close();
//     } else {
//         return false; // Terjadi kesalahan dalam persiapan pernyataan SQL untuk new_lead
//     }
// }

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $id = $_GET["id"]; // Mengambil ID pengguna yang akan dihapus

    $sql_0 = "DELETE FROM prospect WHERE Id_newlead = '$id'";
    if (mysqli_query($conn, $sql_0)) {
        $sql_1 = "DELETE FROM tb_notes_newlead WHERE id_newlead = '$id'";
        if (mysqli_query($conn, $sql_1)) {
            $sql_2 = "DELETE FROM new_lead WHERE Id = '$id'";
            if (mysqli_query($conn, $sql_2)) {
                $_SESSION['msg'] = [
                    'key' => 'Data new lead berhasil didelete',
                    'timestamp' => time()
                ];
                header("Location: ../../new-lead/");
                exit;
            } else {
                $_SESSION['msg-f'] = [
                    'key' => 'Terjadi kesalahan saat menghapus data newlead : ' . mysqli_error($conn),
                    'timestamp' => time()
                ];
                header("Location: ../../new-lead/");
                exit;
            }
        } else {
            $_SESSION['msg-f'] = [
                'key' => 'Terjadi kesalahan saat menghapus data notes newlead : ' . mysqli_error($conn),
                'timestamp' => time()
            ];
            header("Location: ../../new-lead/");
            exit;
        }
    } else {
        $_SESSION['msg-f'] = [
            'key' => 'Terjadi kesalahan saat menghapus data prospect newlead : ' . mysqli_error($conn),
            'timestamp' => time()
        ];
        header("Location: ../../new-lead/");
        exit;
    }
}
