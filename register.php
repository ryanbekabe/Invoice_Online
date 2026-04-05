<?php
session_start();
require_once 'config/db.php';

if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$error = '';
$success = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $conn->real_escape_string($_POST['username']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        $error = "Password tidak cocok.";
    } else {
        $check = $conn->query("SELECT id FROM users WHERE username = '$username'");
        if ($check->num_rows > 0) {
            $error = "Username sudah digunakan.";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            if ($conn->query("INSERT INTO users (username, password) VALUES ('$username', '$hashed_password')")) {
                $user_id = $conn->insert_id;
                // auto seed user_settings for this new user
                $conn->query("INSERT INTO user_settings (user_id) VALUES ($user_id)");
                $success = "Pendaftaran berhasil! Silakan <a href='login.php' style='text-decoration:underline;'>login</a>.";
            } else {
                $error = "Gagal mendaftar. Silakan coba lagi.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - Invoice Manager</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        body { display: flex; align-items: center; justify-content: center; background: var(--background); }
        .auth-card { background: #fff; padding: 3rem; border-radius: 1rem; box-shadow: 0 10px 25px rgba(0,0,0,0.1); width: 100%; max-width: 400px; }
        .auth-card h2 { margin-bottom: 2rem; color: var(--text-main); text-align: center; }
        .error-msg { background: #FEE2E2; color: #B91C1C; padding: 0.75rem; border-radius: 0.5rem; margin-bottom: 1rem; font-size: 0.875rem; }
        .success-msg { background: #D1FAE5; color: #047857; padding: 0.75rem; border-radius: 0.5rem; margin-bottom: 1rem; font-size: 0.875rem; }
    </style>
</head>
<body>
    <div class="auth-card">
        <h2><i class="fa-solid fa-file-invoice-dollar" style="color:var(--primary);"></i> InvoicePro</h2>
        <h3>Daftar Akun</h3>
        <br>
        <?php if($error): ?><div class="error-msg"><?= $error ?></div><?php endif; ?>
        <?php if($success): ?><div class="success-msg"><?= $success ?></div><?php endif; ?>
        <form method="POST">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Konfirmasi Password</label>
                <input type="password" name="confirm_password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center; margin-top: 1rem;">Daftar</button>
        </form>
        <p style="text-align: center; margin-top: 1.5rem; font-size: 0.875rem;">
            Sudah punya akun? <a href="login.php" style="color: var(--primary); font-weight: 500;">Masuk di sini</a>
        </p>
    </div>
</body>
</html>
