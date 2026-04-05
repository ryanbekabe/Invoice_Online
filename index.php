<?php
require_once 'config/db.php';
require_once 'config/auth.php';

$user_id = $_SESSION['user_id'];

// Fetch all invoices
$sql = "SELECT * FROM invoices WHERE user_id = $user_id ORDER BY created_at DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Manager - Dasbor</title>
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
            <a href="index.php" class="active"><i class="fa-solid fa-table-cells-large"></i> Dasbor</a>
            <a href="create.php"><i class="fa-solid fa-plus"></i> Tagihan Baru</a>
            <a href="settings.php"><i class="fa-solid fa-gear"></i> Pengaturan</a>
            <a href="logout.php" style="margin-top: auto; color: #DC2626;"><i class="fa-solid fa-arrow-right-from-bracket"></i> Keluar</a>
        </nav>
    </div>

    <main class="content">
        <header>
            <div class="header-left">
                <h1>Dasbor</h1>
                <p>Kelola tagihan dan pembayaran Anda</p>
            </div>
            <div class="header-right">
                <a href="create.php" class="btn btn-primary"><i class="fa-solid fa-plus"></i> Buat Tagihan</a>
            </div>
        </header>

        <section class="invoice-list-container">
            <div class="card">
                <div class="card-header">
                    <h2>Tagihan Terbaru</h2>
                </div>
                <div class="table-responsive">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>No. Tagihan</th>
                                <th>Klien</th>
                                <th>Tanggal</th>
                                <th>Jatuh Tempo</th>
                                <th>Jumlah</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($result->num_rows > 0): ?>
                                <?php while($row = $result->fetch_assoc()): ?>
                                    <tr>
                                        <td><strong><?= htmlspecialchars($row['invoice_number']) ?></strong></td>
                                        <td><?= htmlspecialchars($row['client_name']) ?></td>
                                        <td><?= date('d M Y', strtotime($row['issue_date'])) ?></td>
                                        <td><?= date('d M Y', strtotime($row['due_date'])) ?></td>
                                        <td>Rp <?= number_format($row['total_amount'], 0, ',', '.') ?></td>
                                        <td>
                                            <span class="badge badge-<?= strtolower(str_replace(' ', '-', $row['status'])) ?>">
                                                <?= htmlspecialchars($row['status']) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <div class="actions">
                                                <a href="view.php?id=<?= htmlspecialchars($row['hash_id']) ?>"><i class="fa-regular fa-eye"></i></a>
                                                <a href="#" class="text-danger"><i class="fa-regular fa-trash-can"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" class="empty-state">
                                        <i class="fa-regular fa-folder-open empty-icon"></i>
                                        <p>Belum ada tagihan. <a href="create.php">Buat tagihan pertama Anda</a>.</p>
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
