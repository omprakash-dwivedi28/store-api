<?php
require_once __DIR__ . '/../../../config/db.php';
$db = new Database();
$pdo = $db->connect();

$stmt = $pdo->query("SELECT * FROM customer_master");
$customers = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>Customer Master</h2>
     <link rel="stylesheet" href="css/admin.css">

<a href="index.php?route=customer_add" class="btn btn-primary">Add Customer</a>
<br><br>

<table border ="1" cellpadding="10" cellspacing="0">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Contact No</th>
        <th>Email</th>
        <th>Address</th>
        <th>Actions</th>
    </tr>
    <?php foreach ($customers as $row): ?>
        <tr>
            <td><?= $row['customer_id'] ?></td>
            <td><?= $row['customer_name'] ?></td>
            <td><?= $row['contact_no'] ?></td>
            <td><?= $row['email'] ?></td>
            <td><?= $row['address'] ?></td>
            <td>
                <a href="index.php?route=customer_edit&id=<?= $row['customer_id'] ?>">Edit</a> |
                <a href="index.php?route=customer_detail&id=<?= $row['customer_id'] ?>">View</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
