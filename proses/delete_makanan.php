<?php
include '../../config/database.php';
// Ambil ID dari URL
$id = $_GET['id'];

// Hapus data dari tabel berdasarkan ID
$sql = "DELETE FROM makanan WHERE id = $id";

if ($connect->query($sql) === TRUE) {
    echo "<script>
        alert('Data berhasil dihapus!');
        window.location.href = '../pages/makanan.php'; // Redirect ke halaman utama
    </script>";
} else {
    echo "Error: " . $sql . "<br>" . $connect->error;
}

$connect->close();
?>
