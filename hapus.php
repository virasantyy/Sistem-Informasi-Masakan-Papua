<?php
session_start();
include '../config/database.php';

// Cek apakah user adalah admin
if ($_SESSION['role'] != 'admin') {
    header('Location: ../login.php');
    exit();
}

// Ambil ID dari parameter URL
$id = $_GET['id'];

// Hapus data makanan
$query = "DELETE FROM makanan WHERE id = $id";
if (mysqli_query($conn, $query)) {
    echo "Data berhasil dihapus!";
} else {
    echo "Gagal menghapus data: " . mysqli_error($conn);
}

// Redirect kembali ke halaman admin
header("Location: index.php");
exit();
?>
