<?php
include '../../config/database.php';

// Cek apakah ada parameter ID yang dikirimkan
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Validasi ID (hanya angka yang diperbolehkan)
    if (filter_var($id, FILTER_VALIDATE_INT)) {
        // Query untuk menghapus pesan berdasarkan ID
        $sql = "DELETE FROM user_feedback WHERE id = ?";

        // Persiapkan pernyataan SQL
        $stmt = $connect->prepare($sql);

        if ($stmt) {
            // Binding parameter (integer)
            $stmt->bind_param("i", $id);

            // Eksekusi query
            if ($stmt->execute()) {
              echo "<script>window.history.back();</script>";
            } else {
                echo "<script>alert('Gagal menghapus pesan.'); window.history.back();</script>";
            }

            // Menutup statement
            $stmt->close();
        } else {
            echo "<script>alert('Gagal mempersiapkan pernyataan SQL.'); window.history.back();</script>";
        }
    } else {
        echo "window.history.back();</script>";
    }
} else {
    echo "window.history.back();</script>";
}

// Menutup koneksi database
$connect->close();
?>
