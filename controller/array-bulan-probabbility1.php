<?php
// Inisialisasi array untuk menyimpan data per bulan
$bulan1 = array();

// Loop melalui bulan-bulan
for ($bulan = 1; $bulan <= 12; $bulan++) {
    $sql = "SELECT COUNT(*) AS total FROM prospect p INNER JOIN new_lead nl ON p.Id_newlead = nl.Id WHERE MONTH(p.created_at) = $bulan AND nl.Probability = 'Cancel'";

    if (!empty($sales_src)) {
        $sql .= " AND p.sales_representativ = $sales_src";
    }

    $result = mysqli_query($conn, $sql);

    if (!$result) {
        // Penanganan kesalahan jika kueri gagal
        die("Error: " . mysqli_error($conn));
    }

    $row = mysqli_fetch_assoc($result);

    // Menyimpan jumlah data untuk bulan tertentu ke dalam array
    $namaBulan = date("F", strtotime("$tahun_src-$bulan-01")); // Konversi angka bulan ke nama bulan
    $bulan1[$namaBulan] = $row['total'];
}
