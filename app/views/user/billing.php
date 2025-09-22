<?php
require_once __DIR__ . '/../../../config/db.php';
$db = new Database();

$pdo = $db->connect();   // ✅ Create the PDO object

// Fetch customer list
$stmt = $pdo->query("SELECT customer_id, customer_name FROM customer_master ORDER BY customer_name ASC");
$customers = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Bill</title>
    <link rel="stylesheet" href="css/billing.css">
</head>
<body>
    <div class="billing-container">
        <h2>🧾 Create New Bill</h2>
        <form action="save_bill.php" method="POST">
            <label for="customer">Customer Name:</label>
            <select name="customer_id" id="customer" required>
                <option value="">-- Select Customer --</option>
                <?php foreach ($customers as $c): ?>
                    <option value="<?= $c['customer_id'] ?>"><?= htmlspecialchars($c['customer_name']) ?></option>
                <?php endforeach; ?>
            </select>

            <label for="bill_no">Bill No:</label>
            <input type="text" id="bill_no" name="bill_no" required>

            <label for="bill_amount">Bill Amount (₹):</label>
            <input type="number" step="0.01" id="bill_amount" name="bill_amount" required>

            <label for="bill_date">Bill Date:</label>
            <input type="date" id="bill_date" name="bill_date" required>

            <label for="bill_type">Bill Type:</label>
            <select name="bill_type" id="bill_type" required>
                <option value="">-- Select Type --</option>
                <option value="d">Debit</option>
                <option value="c">Credit</option>
            </select>

            <label for="remark">Remark:</label>
            <textarea id="remark" name="remark"></textarea>

            <button type="submit" class="btn">Save Bill</button>
        </form>
    </div>
</body>
</html>
