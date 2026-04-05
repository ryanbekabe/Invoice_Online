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
    status ENUM('Draft', 'Sent', 'Paid', 'Overdue') DEFAULT 'Draft',
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
?>
