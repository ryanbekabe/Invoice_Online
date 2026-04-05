<?php
require_once 'config/db.php';
require_once 'config/auth.php';

$success_msg = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $company_name = $conn->real_escape_string($_POST['company_name']);
    $company_address1 = $conn->real_escape_string($_POST['company_address1']);
    $company_address2 = $conn->real_escape_string($_POST['company_address2']);
    $company_email = $conn->real_escape_string($_POST['company_email']);

    $update = "UPDATE user_settings SET 
               company_name = '$company_name',
               company_address1 = '$company_address1',
               company_address2 = '$company_address2',
               company_email = '$company_email'
               WHERE user_id = $user_id";
    
    if($conn->query($update)) {
        $success_msg = "Pengaturan berhasil disimpan!";
    }
}

$user_id = $_SESSION['user_id'];
$setting_res = $conn->query("SELECT * FROM user_settings WHERE user_id = $user_id");
$settings = $setting_res->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan - Invoice Manager</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="sidebar">
        <div class="logo">
            <i class="fa-solid fa-file-invoice-dollar placeholder-icon"></i>
            <span>InvoicePro</span>
        </div>
        <nav>
            <a href="index.php"><i class="fa-solid fa-table-cells-large"></i> Dasbor</a>
            <a href="create.php"><i class="fa-solid fa-plus"></i> Tagihan Baru</a>
            <a href="settings.php" class="active"><i class="fa-solid fa-gear"></i> Pengaturan</a>
            <a href="logout.php" style="margin-top: auto; color: #DC2626;"><i class="fa-solid fa-arrow-right-from-bracket"></i> Keluar</a>
        </nav>
    </div>

    <main class="content">
        <header>
            <div class="header-left">
                <h1>Pengaturan</h1>
                <p>Sesuaikan informasi perusahaan Anda</p>
            </div>
        </header>

        <section class="invoice-list-container">
            <div class="card" style="padding: 2rem;">
                <?php if($success_msg): ?>
                <div style="background-color: var(--status-paid-bg); color: var(--status-paid-text); padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem; display:flex; align-items:center; gap:0.5rem;">
                    <i class="fa-solid fa-circle-check"></i> <?php echo $success_msg; ?>
                </div>
                <?php endif; ?>

                <form action="settings.php" method="POST">
                    <h3 style="margin-bottom: 1.5rem; border-bottom: 1px solid var(--border); padding-bottom: 0.5rem;">Detail Perusahaan</h3>
                    
                    <div class="form-group">
                        <label>Nama Perusahaan</label>
                        <input type="text" name="company_name" class="form-control" value="<?= htmlspecialchars($settings['company_name'] ?? 'Your Company LLC') ?>" required>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label>Baris Alamat 1</label>
                            <input type="text" name="company_address1" class="form-control" value="<?= htmlspecialchars($settings['company_address1'] ?? '123 Business Road') ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Baris Alamat 2 (Kota, Kode Pos)</label>
                            <input type="text" name="company_address2" class="form-control" value="<?= htmlspecialchars($settings['company_address2'] ?? 'Tech City, TC 10101') ?>" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Email Perusahaan</label>
                        <input type="email" name="company_email" class="form-control" value="<?= htmlspecialchars($settings['company_email'] ?? 'hello@yourcompany.com') ?>" required>
                    </div>

                    <div style="margin-top: 2rem;">
                        <button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i> Simpan Pengaturan</button>
                    </div>
                </form>
            </div>
        </section>
    </main>
</body>
</html>
