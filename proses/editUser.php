<?php
require '../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $username = $_POST['username'];
    $email = $_POST['email'];

    $sql = "UPDATE users SET username = ?, email = ? WHERE id = ?";
    $stmt = $connect->prepare($sql);
    $stmt->bind_param('ssi', $username, $email, $id);

    if ($stmt->execute()) {
        header('Location: ../index.php?status=success');
    } else {
        header('Location: ../index.php?status=error');
    }
    exit();
}
