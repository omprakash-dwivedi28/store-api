<?php
require_once __DIR__ . '/../../../config/db.php';
$db = new Database();
$pdo = $db->connect();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['customer_id'];
    $name = $_POST['customer_name'];
    $contact = $_POST['contact_no'];
    $email = $_POST['email'];
    $address = $_POST['address'];

    $sql = "UPDATE customer_master 
            SET customer_name=?, contact_no=?, email=?, address=? 
            WHERE customer_id=?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$name, $contact, $email, $address, $id]);

    // Redirect to detail page after update
    header("Location: index.php?route=customer_detail&id=" . $id . "&success=1");
    exit;
}
?>
