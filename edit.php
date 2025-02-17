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

// Ambil data makanan berdasarkan ID
$query = mysqli_query($connect, "SELECT * FROM makanan WHERE id = $id");
$makanan = mysqli_fetch_assoc($query);

// Proses update data
if (isset($_POST['submit'])) {
    $nama = $_POST['nama'];
    $deskripsi = $_POST['deskripsi'];
    $lokasi = $_POST['lokasi'];
    $rating = $_POST['rating'];

    $updateQuery = "UPDATE makanan SET nama='$nama', deskripsi='$deskripsi', lokasi='$lokasi', rating='$rating' WHERE id=$id";
    if (mysqli_query($conn, $updateQuery)) {
        echo "Data berhasil diperbarui!";
        header("Location: index.php");
        exit();
    } else {
        echo "Gagal memperbarui data: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Makanan</title>
</head>
<body>
    <h1>Edit Makanan</h1>
    <form method="POST" action="">
        <label>Nama:</label><br>
        <input type="text" name="nama" value="<?= $makanan['nama']; ?>" required><br>
        <label>Deskripsi:</label><br>
        <textarea name="deskripsi" required><?= $makanan['deskripsi']; ?></textarea><br>
        <label>Lokasi:</label><br>
        <input type="text" name="lokasi" value="<?= $makanan['lokasi']; ?>" required><br>
        <label>Rating:</label><br>
        <input type="number" step="0.1" name="rating" value="<?= $makanan['rating']; ?>" required><br><br>
        <button type="submit" name="submit">Update</button>
    </form>
    <a href="index.php">Kembali</a>
</body>
</html>
