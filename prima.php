<?php

$batas_awal = 1;
$batas_akhir = 100;

for ($i = $batas_awal; $i <= $batas_akhir; $i++) {
    $isPrima = true; // Asumsikan awalnya bahwa $i adalah bilangan prima

    if ($i <= 1) {
        $isPrima = false; // Bilangan 1 dan bilangan negatif bukan bilangan prima
    } else {
        for ($k = 2; $k < $i; $k++) {
            if ($i % $k == 0) {
                $isPrima = false; // Jika bisa dibagi selain 1 dan dirinya sendiri, maka bukan bilangan prima
                break; // Hentikan loop karena sudah tidak perlu mencari lebih lanjut
            }
        }
    }

    if ($isPrima) {
        echo $i;
        echo "<br/>";
    }
}
