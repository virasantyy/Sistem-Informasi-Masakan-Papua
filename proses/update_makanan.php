<?php
include '../../config/database.php';

// Tangkap data dari form
$id = isset($_POST['id']) ? intval($_POST['id']) : 0; // Pastikan ID berupa integer
$nama = isset($_POST['nama']) ? $connect->real_escape_string($_POST['nama']) : '';
$deskripsi = isset($_POST['deskripsi']) ? $connect->real_escape_string($_POST['deskripsi']) : '';
$bahan_utama = isset($_POST['bahan_utama']) ? $connect->real_escape_string($_POST['bahan_utama']) : '';
$pendamping = isset($_POST['pendamping']) ? $connect->real_escape_string($_POST['pendamping']) : '';
$rating = isset($_POST['rating']) ? floatval($_POST['rating']) : 0;
$kategori = isset($_POST['kategori']) ? $connect->real_escape_string($_POST['kategori']) : '';

// Validasi ID
if ($id <= 0) {
    echo "ID tidak valid!";
    exit;
}

// Periksa apakah ada file foto yang diunggah
if (!empty($_FILES['foto']['name'])) {
    $target_dir = "../../uploads/";
    $foto = basename($_FILES['foto']['name']);
    $target_file = $target_dir . $foto;

    // Upload file baru
    if (move_uploaded_file($_FILES['foto']['tmp_name'], $target_file)) {
        // Query untuk update data termasuk foto
        $sql = "UPDATE makanan 
                SET nama = '$nama', deskripsi = '$deskripsi', bahan_utama = '$bahan_utama', 
                    pendamping = '$pendamping', rating = $rating, 
                    kategori = '$kategori', foto = '$foto', tanggal_ditambahkan = NOW() 
                WHERE id = $id";
    } else {
        echo "Gagal mengunggah foto.";
        exit;
    }
} else {
    // Query untuk update data tanpa mengubah foto
    $sql = "UPDATE makanan 
            SET nama = '$nama', deskripsi = '$deskripsi', bahan_utama = '$bahan_utama', 
                pendamping = '$pendamping', rating = $rating, 
                kategori = '$kategori', tanggal_ditambahkan = NOW() 
            WHERE id = $id";
}

// Jalankan query
if ($connect->query($sql) === TRUE) {
    echo "Data berhasil diperbarui!";
    header("Location: ../pages/makanan.php"); // Redirect ke halaman utama
    exit;
} else {
    echo "Error: " . $sql . "<br>" . $connect->error;
}

$connect->close();
?>
