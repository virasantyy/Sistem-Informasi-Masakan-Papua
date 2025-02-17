<?php
session_start();
include '../config/database.php';

// Cek apakah user adalah admin
if ($_SESSION['role'] != 'admin') {
    header('Location: ../login.php');
    exit();
}

// Proses tambah data
if (isset($_POST['submit'])) {
    $nama = $_POST['nama'];
    $deskripsi = $_POST['deskripsi'];
    $lokasi = $_POST['lokasi'];
    $rating = $_POST['rating'];

    $insertQuery = "INSERT INTO makanan (nama, deskripsi, lokasi, rating) VALUES ('$nama', '$deskripsi', '$lokasi', '$rating')";
    if (mysqli_query($conn, $insertQuery)) {
        echo "Data berhasil ditambahkan!";
        header("Location: index.php");
        exit();
    } else {
        echo "Gagal menambahkan data: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Tambah Makanan</title>
</head>
<body>
    <h1>Tambah Makanan</h1>
    <form method="POST" action="">
        <label>Nama:</label><br>
        <input type="text" name="nama" required><br>
        <label>Deskripsi:</label><br>
        <textarea name="deskripsi" required></textarea><br>
        <label>Lokasi:</label><br>
        <input type="text" name="lokasi" required><br>
        <label>Rating:</label><br>
        <input type="number" step="0.1" name="rating" required><br><br>
        <button type="submit" name="submit">Simpan</button>
    </form>
    <a href="index.php">Kembali</a>
</body>
</html>
