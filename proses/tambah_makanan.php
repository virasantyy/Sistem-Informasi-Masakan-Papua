<?php
include '../../config/database.php';

// Tangkap data dari form
$nama = $_POST['nama'];
$deskripsi = $_POST['deskripsi'];
$alamat = $_POST['alamat'];
$bahan_utama = $_POST['bahan_utama'];
$pendamping = $_POST['pendamping'];
$kategori = $_POST['kategori'];

// Upload file foto
$target_dir = "../../uploads/"; // Folder tempat menyimpan file
$foto = $_FILES['foto']['name'];
$target_file = $target_dir . basename($foto);
move_uploaded_file($_FILES['foto']['tmp_name'], $target_file);

// Query untuk menambahkan data
$sql = "INSERT INTO makanan (nama, deskripsi, alamat, bahan_utama, pendamping, kategori, foto, tanggal_ditambahkan)
        VALUES ('$nama', '$deskripsi', '$alamat', '$bahan_utama', '$pendamping', '$kategori', '$foto', NOW())";

if ($connect->query($sql) === TRUE) {
    echo "Data berhasil ditambahkan!";
    header("Location: ../pages/makanan.php"); // Redirect ke halaman utama
} else {
    echo "Error: " . $sql . "<br>" . $connect->error;
}

$connect->close();
?>
