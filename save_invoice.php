<?php
require_once 'config/db.php';
require_once 'config/auth.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $user_id = $_SESSION['user_id'];
    $invoice_number = $conn->real_escape_string($_POST['invoice_number']);
    $status = $conn->real_escape_string($_POST['status']);
    $issue_date = $conn->real_escape_string($_POST['issue_date']);
    $due_date = $conn->real_escape_string($_POST['due_date']);
    
    $client_name = $conn->real_escape_string($_POST['client_name']);
    $client_email = $conn->real_escape_string($_POST['client_email']);
    $client_address = $conn->real_escape_string($_POST['client_address']);
    
    $notes = $conn->real_escape_string($_POST['notes']);
    $total_amount = floatval($_POST['total_amount']);

    $sql = "INSERT INTO invoices (user_id, invoice_number, client_name, client_email, client_address, issue_date, due_date, status, notes, total_amount) 
            VALUES ($user_id, '$invoice_number', '$client_name', '$client_email', '$client_address', '$issue_date', '$due_date', '$status', '$notes', $total_amount)";
            
    if ($conn->query($sql) === TRUE) {
        $invoice_id = $conn->insert_id;
        
        $hash_id = md5($invoice_id . $invoice_number);
        $conn->query("UPDATE invoices SET hash_id = '$hash_id' WHERE id = $invoice_id");
        
        if(isset($_POST['items']) && is_array($_POST['items'])){
            foreach($_POST['items'] as $item){
                $desc = $conn->real_escape_string($item['description']);
                $qty = intval($item['qty']);
                $price = floatval($item['price']);
                $total = $qty * $price;
                
                $sql_item = "INSERT INTO invoice_items (invoice_id, description, quantity, unit_price, total) 
                             VALUES ($invoice_id, '$desc', $qty, $price, $total)";
                $conn->query($sql_item);
            }
        }
        
        header("Location: view.php?id=" . $hash_id);
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>
