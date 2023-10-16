<?php

include "./KoneksiController.php";

session_start();

$id_newlead = $_POST['id_newlead'];
$notes = $_POST['notes'];
$type = $_POST['type'];

$sql = "INSERT INTO tb_notes_newlead (id_newlead, note, note_type) VALUE('$id_newlead', '$notes', '$type')";
$result = mysqli_query($conn, $sql);
if (!$result) {
    $_SESSION['msg-f'] = [
        'key' => 'Gagal menjalankan query: ' . mysqli_error($conn),
        'timestamp' => time()
    ];
    header("Location: ../new-lead/detail/?id=" . $id_newlead);
    exit;
}

$_SESSION['msg'] = [
    'key' => 'Data notes berhasil diinput',
    'timestamp' => time()
];
header("Location: ../new-lead/detail/?id=" . $id_newlead);
exit;
