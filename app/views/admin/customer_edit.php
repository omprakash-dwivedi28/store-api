<?php
require_once __DIR__ . '/../../../config/db.php';
$db = new Database();
$pdo = $db->connect();

$id = $_GET['id'] ?? null;

if (!$id) {
    echo "Invalid customer!";
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM customer_master WHERE customer_id = ?");
$stmt->execute([$id]);
$customer = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$customer) {
    echo "Customer not found!";
    exit;
}
?>

<h2>Edit Customer</h2>
     <link rel="stylesheet" href="css/admin.css">

<form method="POST" action="index.php?route=customer_update">
    <input type="hidden" name="customer_id" value="<?= $customer['customer_id'] ?>">

    <label>Name:</label>
    <input type="text" name="customer_name" value="<?= htmlspecialchars($customer['customer_name']) ?>" required><br><br>

    <label>Contact No:</label>
    <input type="text" name="contact_no" value="<?= htmlspecialchars($customer['contact_no']) ?>" required><br><br>

    <label>Email:</label>
    <input type="email" name="email" value="<?= htmlspecialchars($customer['email']) ?>" required><br><br>

    <label>Address:</label>
    <textarea name="address" required><?= htmlspecialchars($customer['address']) ?></textarea><br><br>

    <button type="submit">Update</button>
</form>
