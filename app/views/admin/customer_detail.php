<?php
require_once __DIR__ . '/../../../config/db.php';
$db = new Database();
$pdo = $db->connect();

$id = $_GET['id'] ?? null;
if (!$id) {
    echo "<div class='error-box'>⚠ Invalid customer!</div>";
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM customer_master WHERE customer_id = ?");
$stmt->execute([$id]);
$customer = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Customer Details</title>
    <link rel="stylesheet" href="css/dashboard.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f9f9f9;
            margin: 30px;
            color: #333;
        }
        .card {
            max-width: 600px;
            margin: auto;
            background: #fff;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 3px 8px rgba(0,0,0,0.1);
        }
        h2 {
            margin-bottom: 20px;
            text-align: center;
            color: #444;
        }
        .detail-row {
            margin: 12px 0;
            padding: 10px;
            border-bottom: 1px solid #eee;
        }
        .detail-row strong {
            display: inline-block;
            width: 120px;
            color: #555;
        }
        .btn-back {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 15px;
            background: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
        }
        .btn-back:hover {
            background: #0056b3;
        }
        .error-box {
            max-width: 400px;
            margin: auto;
            padding: 15px;
            background: #ffe6e6;
            color: #b30000;
            border: 1px solid #ffb3b3;
            border-radius: 5px;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="card">
    <h2>👤 Customer Details</h2>

    <?php if ($customer): ?>
        <div class="detail-row"><strong>ID:</strong> <?= $customer['customer_id'] ?></div>
        <div class="detail-row"><strong>Name:</strong> <?= htmlspecialchars($customer['customer_name']) ?></div>
        <div class="detail-row"><strong>Contact:</strong> <?= htmlspecialchars($customer['contact_no']) ?></div>
        <div class="detail-row"><strong>Email:</strong> <?= htmlspecialchars($customer['email']) ?></div>
        <div class="detail-row"><strong>Address:</strong> <?= nl2br(htmlspecialchars($customer['address'])) ?></div>

        <a href="index.php?route=cust_master" class="btn-back">⬅ Back to List</a>
    <?php else: ?>
        <div class="error-box">❌ Customer not found.</div>
    <?php endif; ?>
</div>

</body>
</html>
