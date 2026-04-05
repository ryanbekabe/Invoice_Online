<?php
require_once 'config/db.php';
require_once 'config/auth.php';

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$hash_id = $conn->real_escape_string($_GET['id']);
$user_id = $_SESSION['user_id'];

$sql = "SELECT * FROM invoices WHERE hash_id = '$hash_id' AND user_id = $user_id";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    die("Invoice not found.");
}
$invoice = $result->fetch_assoc();
$id = $invoice['id'];

$sql_items = "SELECT * FROM invoice_items WHERE invoice_id = $id";
$items_result = $conn->query($sql_items);

$sql_settings = "SELECT * FROM user_settings WHERE user_id = $user_id";
$settings_result = $conn->query($sql_settings);
$settings = $settings_result->fetch_assoc() ?: [
    'company_name' => 'Your Company LLC',
    'company_address1' => '123 Business Road',
    'company_address2' => 'Tech City, TC 10101',
    'company_email' => 'hello@yourcompany.com'
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice <?= htmlspecialchars($invoice['invoice_number']) ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .invoice-document {
            background: #fff;
            max-width: 800px;
            margin: 2rem auto;
            border-radius: 0.5rem;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            padding: 3rem;
        }
        .invoice-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            border-bottom: 2px solid var(--primary);
            padding-bottom: 2rem;
            margin-bottom: 2rem;
        }
        .invoice-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--primary);
            margin: 0;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        .company-details {
            text-align: right;
            color: var(--text-muted);
        }
        .company-name {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--text-main);
            margin-bottom: 0.5rem;
        }
        .billing-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
            margin-bottom: 3rem;
        }
        .billing-box h3 {
            font-size: 0.875rem;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 0.5rem;
        }
        .print-only { display: none; }
        
        @media print {
            body { background: #fff; }
            .sidebar, .print-btn, .back-btn { display: none; }
            .content { margin-left: 0; padding: 0; }
            .invoice-document { box-shadow: none; max-width: 100%; margin: 0; padding: 0; }
        }
    </style>
</head>
<body class="<?= htmlspecialchars($global_theme) ?>">
    <div class="sidebar">
        <div class="logo">
            <i class="fa-solid fa-file-invoice-dollar placeholder-icon"></i>
            <span>InvoicePro</span>
        </div>
        <nav>
            <a href="index.php"><i class="fa-solid fa-table-cells-large"></i> Dasbor</a>
            <a href="create.php"><i class="fa-solid fa-plus"></i> Tagihan Baru</a>
            <a href="settings.php"><i class="fa-solid fa-gear"></i> Pengaturan</a>
            <a href="logout.php" style="margin-top: auto; color: #DC2626;"><i class="fa-solid fa-arrow-right-from-bracket"></i> Keluar</a>
        </nav>
    </div>

    <main class="content">
        <div style="display:flex; justify-content:space-between; max-width:800px; margin: 0 auto 1rem;">
            <a href="index.php" class="btn btn-secondary back-btn"><i class="fa-solid fa-arrow-left"></i> Kembali</a>
            <button onclick="window.print()" class="btn btn-primary print-btn"><i class="fa-solid fa-print"></i> Cetak / Simpan PDF</button>
        </div>

        <div class="invoice-document">
            <div class="invoice-header">
                <div>
                    <h1 class="invoice-title">TAGIHAN</h1>
                    <p style="margin-top: 0.5rem; font-weight: 600; color: #6B7280;">#<?= htmlspecialchars($invoice['invoice_number']) ?></p>
                </div>
                <div class="company-details">
                    <div class="company-name"><?= htmlspecialchars($settings['company_name']) ?></div>
                    <p><?= htmlspecialchars($settings['company_address1']) ?></p>
                    <p><?= htmlspecialchars($settings['company_address2']) ?></p>
                    <p><?= htmlspecialchars($settings['company_email']) ?></p>
                </div>
            </div>

            <div class="billing-grid">
                <div class="billing-box">
                    <h3>Ditagihkan Kepada</h3>
                    <p style="font-weight: 600; font-size: 1.1rem;"><?= htmlspecialchars($invoice['client_name']) ?></p>
                    <p><?= htmlspecialchars($invoice['client_address']) ?></p>
                    <p><?= htmlspecialchars($invoice['client_email']) ?></p>
                </div>
                <div class="billing-box" style="text-align: right;">
                    <h3>Detail</h3>
                    <p><strong>Tanggal:</strong> <?= date('d M Y', strtotime($invoice['issue_date'])) ?></p>
                    <p><strong>Jatuh Tempo:</strong> <?= date('d M Y', strtotime($invoice['due_date'])) ?></p>
                    <p><strong>Status:</strong> <span style="font-weight:bold;"><?= htmlspecialchars($invoice['status']) ?></span></p>
                </div>
            </div>

            <table class="data-table" style="margin-bottom: 2rem;">
                <thead>
                    <tr>
                        <th style="width: 50%;">Deskripsi</th>
                        <th style="width: 15%; text-align: center;">Jml</th>
                        <th style="width: 15%; text-align: right;">Harga (Rp)</th>
                        <th style="width: 20%; text-align: right;">Total (Rp)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($item = $items_result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($item['description']) ?></td>
                        <td style="text-align: center;"><?= $item['quantity'] ?></td>
                        <td style="text-align: right;">Rp <?= number_format($item['unit_price'], 0, ',', '.') ?></td>
                        <td style="text-align: right;">Rp <?= number_format($item['total'], 0, ',', '.') ?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>

            <div style="display: flex; justify-content: flex-end; margin-bottom: 3rem;">
                <div style="width: 300px;">
                    <div style="display:flex; justify-content:space-between; padding: 1rem 0; font-size: 1.25rem; font-weight: 700; border-top: 2px solid var(--border);">
                        <span>Total Tagihan</span>
                        <span style="color: var(--primary);">Rp <?= number_format($invoice['total_amount'], 0, ',', '.') ?></span>
                    </div>
                </div>
            </div>

            <?php if(!empty($invoice['notes'])): ?>
            <div style="background: var(--background); padding: 1.5rem; border-radius: 0.5rem;">
                <h3 style="font-size: 0.875rem; color: var(--text-muted); margin-bottom: 0.5rem; text-transform:uppercase;">Catatan</h3>
                <p style="white-space: pre-line;"><?= htmlspecialchars($invoice['notes']) ?></p>
            </div>
            <?php endif; ?>
        </div>
    </main>
</body>
</html>
