<?php

include "./KoneksiController.php";

$id_newlead = $_POST['id_newlead'];
$notes = $_POST['notes'];
$type = $_POST['type'];

$sql = "INSERT INTO tb_notes_newlead (id_newlead, note, note_type) VALUE('$id_newlead', '$notes', '$type')";
$result = mysqli_query($conn, $sql);
if (!$result) {
    die("Gagal menjalankan query: " . mysqli_error($conn));
}
header("Location: ../new-lead/detail/?id=" . $id_newlead);
exit;
