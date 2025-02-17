<?php
session_start();
include 'config/database.php';

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = mysqli_query($connect, "SELECT * FROM users WHERE username='$username'");
    $user = mysqli_fetch_assoc($query);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];
        
        if ($user['role'] == 'admin') {
            header('Location: admin/index.php');
        } else {
            header('Location: user/index.php');
        }
    } else {
        $error_message = "Username atau password salah!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
            margin-bottom: 20px;
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
        .error-message {
            color: red;
            margin-bottom: 20px;
            text-align: center;
            font-size: 14px;
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
        <h1>Welcome Back</h1>
        <?php if (isset($error_message)): ?>
            <div class="error-message"><?= $error_message ?></div>
        <?php endif; ?>
        <form method="POST" action="">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            
            <button type="submit" name="login">Login</button>
        </form>
        <div class="footer">
            <p>Belum punya akun? <a href="register.php">Daftar Sekarang</a></p>
        </div>
    </div>
</body>
</html>
