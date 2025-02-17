<?php
include '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $username = mysqli_real_escape_string($connect, $_POST['username']);
    $email = mysqli_real_escape_string($connect, $_POST['email']);
    $password = $_POST['password'];

    if (empty($password)) {
        $query = "UPDATE users SET username = '$username', email = '$email' WHERE id = $id";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $query = "UPDATE users SET username = '$username', email = '$email', password = '$hashed_password' WHERE id = $id";
    }

    if (mysqli_query($connect, $query)) {
        header("Location: index.php?status=success");
    } else {
        header("Location: index.php?status=error");
    }
}
