<?php
session_start();
require_once 'config/db.php';

if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $conn->real_escape_string($_POST['username']);
    $password = $_POST['password'];

    $result = $conn->query("SELECT * FROM users WHERE username = '$username'");
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            header("Location: index.php");
            exit;
        } else {
            $error = "Username atau password salah.";
        }
    } else {
        $error = "Username atau password salah.";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Invoice Manager</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        body { display: flex; align-items: center; justify-content: center; background: var(--background); }
        .auth-card { background: #fff; padding: 3rem; border-radius: 1rem; box-shadow: 0 10px 25px rgba(0,0,0,0.1); width: 100%; max-width: 400px; }
        .auth-card h2 { margin-bottom: 2rem; color: var(--text-main); text-align: center; }
        .error-msg { background: #FEE2E2; color: #B91C1C; padding: 0.75rem; border-radius: 0.5rem; margin-bottom: 1rem; font-size: 0.875rem; }
    </style>
</head>
<body>
    <div class="auth-card">
        <h2><i class="fa-solid fa-file-invoice-dollar" style="color:var(--primary);"></i> InvoicePro</h2>
        <h3>Masuk</h3>
        <br>
        <?php if($error): ?><div class="error-msg"><?= $error ?></div><?php endif; ?>
        <form method="POST">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center; margin-top: 1rem;">Login</button>
        </form>
        <p style="text-align: center; margin-top: 1.5rem; font-size: 0.875rem;">
            Belum punya akun? <a href="register.php" style="color: var(--primary); font-weight: 500;">Daftar di sini</a>
        </p>
    </div>
</body>
</html>
