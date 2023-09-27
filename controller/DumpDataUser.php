<?php
include "KoneksiController.php";

$pw1 = password_hash('test1', PASSWORD_BCRYPT);
$pw2 = password_hash('test2', PASSWORD_BCRYPT);
$pw3 = password_hash('test3', PASSWORD_BCRYPT);

$sql = "INSERT INTO pengguna (Nama, Username, Password, Level, Foto, Status, Email, is_login, Last_login)
VALUES
('John Doe', 'johndoe', '$pw1', 1, 'johndoe.jpg', 1, 'johndoe@example.com', 1, '2023-09-15 10:00:00'),
('Jane Smith', 'janesmith', '$pw2', 2, 'janesmith.jpg', 1, 'janesmith@example.com', 1, '2023-09-15 10:30:00'),
('Bob Johnson', 'bobjohnson', '$pw3', 1, 'bobjohnson.jpg', 0, 'bobjohnson@example.com', 0, '2023-09-14 15:45:00');
";

if (mysqli_query($conn, $sql)) {
    echo "Data berhasil dimasukkan ke dalam tabel users.";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}
?>
