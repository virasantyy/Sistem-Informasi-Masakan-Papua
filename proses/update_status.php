<?php
include '../../config/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $status = $_POST['status'];

    // Perbarui status di database
    $sql = "UPDATE user_feedback SET status = ? WHERE id = ?";
    $stmt = $connect->prepare($sql);
    $stmt->bind_param("si", $status, $id);

    if ($stmt->execute()) {
        // Redirect kembali ke index.php
        echo "<script>window.history.back();</script>";
        exit();
    } else {
        echo "Gagal memperbarui status: " . $connect->error;
    }
}
?>
