<?php
include '../../config/database.php'; // Pastikan koneksi database sudah benar

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = 'pengunjung';

    // Query untuk menambahkan data ke database
    $query = "INSERT INTO users (username, email, password, role) VALUES ('$username', '$email', '$password', '$role')";
    if ($connect->query($query)) {
      header('Location: ../index.php?status=success');
    } else {
      header('Location: ../index.php?status=error');
    }
}
?>
