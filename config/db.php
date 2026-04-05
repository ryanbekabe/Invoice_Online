<?php
$host = 'localhost';
$user = 'root';
$pass = ''; // MySQL tanpa password
$dbname = 'invoice_app_db';

// Create connection to MySQL
$conn = new mysqli($host, $user, $pass);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database if not exists
$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
if ($conn->query($sql) !== TRUE) {
    die("Error creating database: " . $conn->error);
}

// Select the database
$conn->select_db($dbname);

// Create Invoices table
$sql_invoices = "CREATE TABLE IF NOT EXISTS invoices (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    invoice_number VARCHAR(50) NOT NULL,
    client_name VARCHAR(100) NOT NULL,
    client_email VARCHAR(100),
    client_address TEXT,
    issue_date DATE,
    due_date DATE,
    status ENUM('Draft', 'Terkirim', 'Lunas', 'Jatuh Tempo') DEFAULT 'Draft',
    notes TEXT,
    total_amount DECIMAL(10,2) DEFAULT 0.00,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
$conn->query($sql_invoices);

// Create Invoice Items table
$sql_items = "CREATE TABLE IF NOT EXISTS invoice_items (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    invoice_id INT(11) NOT NULL,
    description VARCHAR(255) NOT NULL,
    quantity INT(11) NOT NULL DEFAULT 1,
    unit_price DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    total DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    FOREIGN KEY (invoice_id) REFERENCES invoices(id) ON DELETE CASCADE
)";
$conn->query($sql_items);

// Create Users table
$sql_users = "CREATE TABLE IF NOT EXISTS users (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
$conn->query($sql_users);

// Add user_id to invoices if not exists
$check_user_inv = $conn->query("SHOW COLUMNS FROM invoices LIKE 'user_id'");
if($check_user_inv && $check_user_inv->num_rows == 0) {
    $conn->query("ALTER TABLE invoices ADD user_id INT(11) AFTER id");
}

// Ensure the status column uses the updated Indonesian ENUM translations
$conn->query("ALTER TABLE invoices MODIFY COLUMN status ENUM('Draft', 'Terkirim', 'Lunas', 'Jatuh Tempo') DEFAULT 'Draft'");

// Create Settings table User specific
$sql_settings = "CREATE TABLE IF NOT EXISTS user_settings (
    user_id INT(11) PRIMARY KEY,
    company_name VARCHAR(255) DEFAULT 'Perusahaan Anda',
    company_address1 VARCHAR(255) DEFAULT 'Jl. Bisnis No. 123',
    company_address2 VARCHAR(255) DEFAULT 'Kota Teknologi, 10101',
    company_email VARCHAR(100) DEFAULT 'halo@perusahaan.com'
)";
$conn->query($sql_settings);

// Add theme column to user_settings if not exists
$check_theme = $conn->query("SHOW COLUMNS FROM user_settings LIKE 'theme'");
if($check_theme && $check_theme->num_rows == 0) {
    $conn->query("ALTER TABLE user_settings ADD theme VARCHAR(50) DEFAULT 'theme-default' AFTER company_email");
}
?>
