<?php
// Inisialisasi array untuk menyimpan data per bulan
$bulan2 = array();

// Loop melalui bulan-bulan
for ($bulan = 1; $bulan <= 12; $bulan++) {
    $sql = "SELECT COUNT(*) AS total FROM new_lead WHERE MONTH(created_at) = $bulan AND Probability = 'Pending'";

    if (!empty($sales_src)) {
        $sql .= " AND id_pengguna = $sales_src";
    }

    if (!empty($status)) {
        $sql .= " AND Status = '" . $status . "'";
    }

    $result = mysqli_query($conn, $sql);

    if (!$result) {
        // Penanganan kesalahan jika kueri gagal
        die("Error: " . mysqli_error($conn));
    }

    $row = mysqli_fetch_assoc($result);

    // Menyimpan jumlah data untuk bulan tertentu ke dalam array
    $namaBulan = date("F", strtotime("2023-$bulan-01")); // Konversi angka bulan ke nama bulan
    $bulan2[$namaBulan] = $row['total'];
}
