<?php
include '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['username'];
    $email = $_POST['email'];

    $stmt = $connect->prepare("INSERT INTO users (username, email) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $email);

    if ($stmt->execute()) {
        header("Location: ../index.php?success=Data berhasil ditambahkan");
    } else {
        header("Location: ../index.php?error=Gagal menambahkan data");
    }

    $stmt->close();
    $conn->close();
}
?>
