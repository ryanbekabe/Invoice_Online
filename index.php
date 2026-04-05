<?php
require_once 'config/db.php';

// Fetch all invoices
$sql = "SELECT * FROM invoices ORDER BY created_at DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Manager - Dashboard</title>
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
            <a href="index.php" class="active"><i class="fa-solid fa-table-cells-large"></i> Dashboard</a>
            <a href="create.php"><i class="fa-solid fa-plus"></i> New Invoice</a>
        </nav>
    </div>

    <main class="content">
        <header>
            <div class="header-left">
                <h1>Dashboard</h1>
                <p>Manage your invoices and payments</p>
            </div>
            <div class="header-right">
                <a href="create.php" class="btn btn-primary"><i class="fa-solid fa-plus"></i> Create Invoice</a>
            </div>
        </header>

        <section class="invoice-list-container">
            <div class="card">
                <div class="card-header">
                    <h2>Recent Invoices</h2>
                </div>
                <div class="table-responsive">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Invoice Number</th>
                                <th>Client Name</th>
                                <th>Issue Date</th>
                                <th>Due Date</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($result->num_rows > 0): ?>
                                <?php while($row = $result->fetch_assoc()): ?>
                                    <tr>
                                        <td><strong><?= htmlspecialchars($row['invoice_number']) ?></strong></td>
                                        <td><?= htmlspecialchars($row['client_name']) ?></td>
                                        <td><?= date('M d, Y', strtotime($row['issue_date'])) ?></td>
                                        <td><?= date('M d, Y', strtotime($row['due_date'])) ?></td>
                                        <td>$<?= number_format($row['total_amount'], 2) ?></td>
                                        <td>
                                            <span class="badge badge-<?= strtolower($row['status']) ?>">
                                                <?= htmlspecialchars($row['status']) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <div class="actions">
                                                <a href="view.php?id=<?= $row['id'] ?>"><i class="fa-regular fa-eye"></i></a>
                                                <a href="#" class="text-danger"><i class="fa-regular fa-trash-can"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" class="empty-state">
                                        <i class="fa-regular fa-folder-open empty-icon"></i>
                                        <p>No invoices found. <a href="create.php">Create your first invoice</a>.</p>
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
