<?php
session_start();
include 'config/database.php'; // Pastikan path ini benar

// Inisialisasi pesan error
$passwordError = '';
$confirmPasswordError = '';

// Proses pendaftaran
if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $email = $_POST['email'];
    $role = 'pengunjung'; // Role default sebagai pengunjung

    // Validasi password dan konfirmasi password
    if (strlen($password) < 6) {
        $passwordError = "Password harus minimal 6 karakter.";
    } elseif ($password !== $confirm_password) {
        $confirmPasswordError = "Password dan konfirmasi password tidak cocok!";
    } else {
        // Hash password sebelum menyimpan ke database
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Cek apakah username sudah ada
        $checkQuery = "SELECT * FROM users WHERE username='$username'";
        $result = mysqli_query($connect, $checkQuery);

        if (mysqli_num_rows($result) > 0) {
            echo "<script>alert('Username sudah digunakan. Pilih username lain.');</script>";
        } else {
            // Simpan data ke database
            $insertQuery = "INSERT INTO users (username, password, email, role) VALUES ('$username', '$hashed_password', '$email', '$role')";
            if (mysqli_query($connect, $insertQuery)) {
                echo "<script>alert('Pendaftaran berhasil! Silakan login.');</script>";
                header('Location: login.php');
                exit();
            } else {
                echo "Gagal mendaftar: " . mysqli_error($connect);
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
        body {
            font-family: 'Roboto', Arial, sans-serif;
            background: linear-gradient(to right, #d0eaff, #ffffff);
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .login-container {
            background: #ffffff;
            padding: 25px 35px;
            border-radius: 12px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 420px;
            text-align: center;
        }
        .login-container h1 {
            margin-bottom: 25px;
            font-size: 26px;
            color: #007bff;
        }
        .login-container label {
            font-weight: 600;
            display: block;
            margin-bottom: 8px;
            text-align: left;
            color: #444;
        }
        .login-container input {
            width: 100%;
            padding: 12px;
            margin-bottom: 10px;
            border: 1px solid #cce4f7;
            border-radius: 6px;
            box-sizing: border-box;
            background: #f9fbfd;
            font-size: 14px;
            color: #333;
        }
        .login-container input:focus {
            border-color: #007bff;
            outline: none;
        }
        .error-message {
            color: red;
            font-size: 12px;
            text-align: left;
            margin-top: -10px;
            margin-bottom: 10px;
        }
        .login-container button {
            width: 100%;
            padding: 12px;
            background: #007bff;
            color: #fff;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s;
        }
        .login-container button:hover {
            background: #0056b3;
        }
        .login-container .footer {
            margin-top: 20px;
            font-size: 14px;
            color: #777;
        }
        .login-container .footer a {
            color: #007bff;
            text-decoration: none;
        }
        .login-container .footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h1>Register</h1>
        <form method="POST" action="">
            <label>Username:</label>
            <input type="text" name="username" required><br>
            
            <label>Password:</label>
            <input type="password" name="password" required>
            <?php if (!empty($passwordError)) { ?>
                <span class="error-message"><?= $passwordError ?></span>
            <?php } ?>
            
            <label>Konfirmasi Password:</label>
            <input type="password" name="confirm_password" required>
            <?php if (!empty($confirmPasswordError)) { ?>
                <span class="error-message"><?= $confirmPasswordError ?></span>
            <?php } ?>
            
            <label>Email:</label>
            <input type="email" name="email" required><br>
            
            <button type="submit" name="register">Daftar</button>
        </form>
        <br>
        Sudah Punya Akun? <a href="login.php">Login</a>
    </div>
</body>
</html>
