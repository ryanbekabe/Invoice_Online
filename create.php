<?php
require_once 'config/db.php';
require_once 'config/auth.php';

// Generate a random invoice number
$invoice_num = 'INV-' . date('Ymd') . '-' . rand(1000, 9999);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Tagihan - InvoiceManager</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="<?= htmlspecialchars($global_theme) ?>">
    <div class="sidebar">
        <div class="logo">
            <i class="fa-solid fa-file-invoice-dollar"></i>
            <span>InvoicePro</span>
        </div>
        <nav>
            <a href="index.php"><i class="fa-solid fa-table-cells-large"></i> Dasbor</a>
            <a href="create.php" class="active"><i class="fa-solid fa-plus"></i> Tagihan Baru</a>
            <a href="settings.php"><i class="fa-solid fa-gear"></i> Pengaturan</a>
            <a href="logout.php" style="margin-top: auto; color: #DC2626;"><i class="fa-solid fa-arrow-right-from-bracket"></i> Keluar</a>
        </nav>
    </div>

    <main class="content">
        <header>
            <div class="header-left">
                <h1>Buat Tagihan Baru</h1>
            </div>
            <div class="header-right">
                <a href="index.php" class="btn btn-secondary">Batal</a>
            </div>
        </header>

        <form action="save_invoice.php" method="POST" id="invoiceForm">
            <div class="card create-form">
                <div class="form-row">
                    <div class="form-group">
                        <label>No. Tagihan</label>
                        <input type="text" name="invoice_number" class="form-control" value="<?= $invoice_num ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control">
                            <option value="Draft">Draft</option>
                            <option value="Terkirim">Terkirim</option>
                            <option value="Lunas">Lunas</option>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Tanggal Dibuat</label>
                        <input type="date" name="issue_date" class="form-control" value="<?= date('Y-m-d') ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Jatuh Tempo</label>
                        <input type="date" name="due_date" class="form-control" value="<?= date('Y-m-d', strtotime('+14 days')) ?>" required>
                    </div>
                </div>

                <hr style="margin: 2rem 0; border: none; border-top: 1px solid var(--border);">
                
                <h3>Detail Klien</h3><br>
                <div class="form-row">
                    <div class="form-group">
                        <label>Nama Klien</label>
                        <input type="text" name="client_name" class="form-control" placeholder="Nama perusahaan atau individu" required>
                    </div>
                    <div class="form-group">
                        <label>Email Klien</label>
                        <input type="email" name="client_email" class="form-control" placeholder="klien@example.com">
                    </div>
                </div>
                <div class="form-group">
                    <label>Alamat Klien</label>
                    <textarea name="client_address" class="form-control" rows="2" placeholder="Jalan, Kota, Kode Pos, dll."></textarea>
                </div>

                <hr style="margin: 2rem 0; border: none; border-top: 1px solid var(--border);">

                <h3>Item Tagihan</h3><br>
                <table class="data-table invoice-items-table" id="itemsTable">
                    <thead>
                        <tr>
                            <th style="width: 50%;">Deskripsi</th>
                            <th style="width: 15%;">Jml</th>
                            <th style="width: 20%;">Harga (Rp)</th>
                            <th style="width: 20%;">Total (Rp)</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="itemsBody">
                        <tr class="item-row">
                            <td><input type="text" name="items[0][description]" class="form-control" required></td>
                            <td><input type="number" name="items[0][qty]" class="form-control qty-input" value="1" min="1" required></td>
                            <td><input type="number" name="items[0][price]" class="form-control price-input" value="0.00" step="0.01" required></td>
                            <td><input type="text" class="form-control total-input" value="0.00" readonly></td>
                            <td><button type="button" class="remove-row"><i class="fa-solid fa-xmark"></i></button></td>
                        </tr>
                    </tbody>
                </table>
                <br>
                <button type="button" class="btn btn-secondary" id="addItemBtn">
                    <i class="fa-solid fa-plus"></i> Tambah Item
                </button>

                <div class="totals-section mt-4">
                    <div class="totals-box">
                        <div class="totals-row grand-total">
                            <span>Total Tagihan:</span>
                            <span>Rp <span id="grandTotal">0</span></span>
                            <input type="hidden" name="total_amount" id="totalAmountInput" value="0">
                        </div>
                    </div>
                </div>

                <hr style="margin: 2rem 0; border: none; border-top: 1px solid var(--border);">
                
                <div class="form-group">
                    <label>Catatan / Syarat</label>
                    <textarea name="notes" class="form-control" rows="3" placeholder="Terima kasih atas kerja sama Anda."></textarea>
                </div>

                <div style="text-align: right; margin-top: 2rem;">
                    <button type="submit" class="btn btn-primary" style="padding: 1rem 2rem; font-size: 1.1rem;">
                        <i class="fa-solid fa-check"></i> Simpan Tagihan
                    </button>
                </div>
            </div>
        </form>
    </main>

    <script src="assets/js/script.js"></script>
</body>
</html>
