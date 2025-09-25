<?php
require_once __DIR__ . '/../../../config/db.php';
$db = new Database();
$pdo = $db->connect();

// Fetch customer-wise due amounts
$stmt = $pdo->query("
    SELECT 
        c.customer_id,
        c.customer_name,
        COALESCE(SUM(CASE WHEN b.bill_type = 'd' THEN b.bill_amount ELSE 0 END), 0) AS total_debit,
        COALESCE(SUM(CASE WHEN b.bill_type = 'c' THEN b.bill_amount ELSE 0 END), 0) AS total_credit,
        COALESCE(SUM(CASE WHEN b.bill_type = 'd' THEN b.bill_amount ELSE -b.bill_amount END), 0) AS due_amount
    FROM customer_master c
    LEFT JOIN billing b ON c.customer_id = b.customer_id
    GROUP BY c.customer_id, c.customer_name
    ORDER BY c.customer_name ASC
");
$due_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Customer Due Report</title>
    <link rel="stylesheet" href="css/billing.css">
    <style>
        .due-container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        tr:hover {
            background-color: #f5f5f5;
        }
        .negative {
            color: red;
        }
        .positive {
            color: green;
        }
    </style>
</head>
<body>
    <div class="due-container">
        <h2>📊 Customer Due Report</h2>
        <table>
            <thead>
                <tr>
                    <th>Customer Name</th>
                    <th>Total Debit (₹)</th>
                    <th>Total Credit (₹)</th>
                    <th>Net Due (₹)</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($due_list as $row): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['customer_name']) ?></td>
                        <td><?= number_format($row['total_debit'], 2) ?></td>
                        <td><?= number_format($row['total_credit'], 2) ?></td>
                        <td class="<?= $row['due_amount'] >= 0 ? 'positive' : 'negative' ?>">
                            <?= number_format($row['due_amount'], 2) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>