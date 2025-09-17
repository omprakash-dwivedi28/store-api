<?php
require_once __DIR__ . '/../config/db.php';
$db = new Database();

$pdo = $db->connect();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $customer_id = $_POST['customer_id'] ?? null;
    $bill_no     = $_POST['bill_no'] ?? null;
    $bill_amount = $_POST['bill_amount'] ?? null;
    $bill_date   = $_POST['bill_date'] ?? null;
    $remark      = $_POST['remark'] ?? null;

    if ($customer_id && $bill_no && $bill_amount && $bill_date) {
        $sql = "INSERT INTO billing (customer_id, bill_no, bill_amount, bill_date, remark) 
                VALUES (?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$customer_id, $bill_no, $bill_amount, $bill_date, $remark]);

        // ✅ Redirect to billing.php (correct path)
        header("Location: /app/views/user/billing.php?success=1");
        exit;
    } else {
        header("Location: /app/views/user/billing.php?error=1");
        exit;
    }
}
