<?php
require_once 'config/db.php';
require_once 'config/auth.php';

$user_id = $_SESSION['user_id'];

// Fetch distinct customers
$sql = "SELECT client_name, client_email, client_address, COUNT(id) as invoice_count, SUM(total_amount) as total_spent 
        FROM invoices 
        WHERE user_id = $user_id 
        GROUP BY client_name, client_email, client_address 
        ORDER BY client_name ASC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Kostumer - Invoice Manager</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="<?= htmlspecialchars($global_theme) ?>">
    <div class="sidebar">
        <div class="logo">
            <i class="fa-solid fa-file-invoice-dollar placeholder-icon"></i>
            <span>InvoicePro</span>
        </div>
        <nav>
            <a href="index.php"><i class="fa-solid fa-table-cells-large"></i> Dasbor</a>
            <a href="customers.php" class="active"><i class="fa-solid fa-users"></i> Kostumer</a>
            <a href="create.php"><i class="fa-solid fa-plus"></i> Tagihan Baru</a>
            <a href="settings.php"><i class="fa-solid fa-gear"></i> Pengaturan</a>
            <a href="logout.php" style="margin-top: auto; color: #DC2626;"><i class="fa-solid fa-arrow-right-from-bracket"></i> Keluar</a>
        </nav>
    </div>

    <main class="content">
        <header>
            <div class="header-left">
                <h1>Kostumer</h1>
                <p>Daftar klien yang pernah Anda tagih</p>
            </div>
            <div class="header-right">
                <a href="create.php" class="btn btn-primary"><i class="fa-solid fa-plus"></i> Buat Tagihan</a>
            </div>
        </header>

        <section class="invoice-list-container">
            <div class="card">
                <div class="card-header">
                    <h2>Daftar Pelanggan</h2>
                </div>
                <div class="table-responsive">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Nama Pelanggan</th>
                                <th>Email</th>
                                <th>Alamat</th>
                                <th style="text-align: center;">Total Tagihan</th>
                                <th style="text-align: right;">Total Nilai (Rp)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($result->num_rows > 0): ?>
                                <?php while($row = $result->fetch_assoc()): ?>
                                    <tr>
                                        <td><strong><?= htmlspecialchars($row['client_name']) ?></strong></td>
                                        <td><?= htmlspecialchars($row['client_email'] ? $row['client_email'] : '-') ?></td>
                                        <td><div style="max-width:250px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;" title="<?= htmlspecialchars($row['client_address']) ?>"><?= htmlspecialchars($row['client_address'] ? $row['client_address'] : '-') ?></div></td>
                                        <td style="text-align: center;">
                                            <span class="badge" style="background:var(--primary); color:white;"><?= $row['invoice_count'] ?></span>
                                        </td>
                                        <td style="text-align: right;">Rp <?= number_format($row['total_spent'], 0, ',', '.') ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="empty-state">
                                        <i class="fa-solid fa-users empty-icon"></i>
                                        <p>Belum ada pelanggan. Data akan otomatis muncul saat Anda membuat tagihan.</p>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </main>
</body>
</html>
