<?php
include "./KoneksiController.php";

function deleteUserData($id)
{
    global $conn; // Menggunakan koneksi yang sudah dibuat di KoneksiController.php

    // Menggunakan prepared statement untuk menghindari SQL injection
    $sql1 = "DELETE FROM new_lead WHERE Id = ?";
    $stmt1 = $conn->prepare($sql1);

    if ($stmt1) {
        // Mengikat parameter
        $stmt1->bind_param("s", $id);

        if ($stmt1->execute()) {
            // Menggunakan prepared statement untuk menghapus catatan di tb_notes_newlead
            $sql2 = "DELETE FROM tb_notes_newlead WHERE id_newlead = ?";
            $stmt2 = $conn->prepare($sql2);

            if ($stmt2) {
                $stmt2->bind_param("s", $id);
                if ($stmt2->execute()) {
                    return true; // Data berhasil dihapus
                } else {
                    return false; // Terjadi kesalahan saat menghapus catatan di tb_notes_newlead
                }
                $stmt2->close();
            } else {
                return false; // Terjadi kesalahan dalam persiapan pernyataan SQL untuk tb_notes_newlead
            }
        } else {
            return false; // Terjadi kesalahan saat menghapus data dari new_lead
        }
        $stmt1->close();
    } else {
        return false; // Terjadi kesalahan dalam persiapan pernyataan SQL untuk new_lead
    }
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $id = $_GET["id"]; // Mengambil ID pengguna yang akan dihapus

    if (deleteUserData($id)) {
        header("Location: ../../new-lead/");
        exit;
    } else {
        echo "Terjadi kesalahan saat menghapus data newlead.";
    }
}
