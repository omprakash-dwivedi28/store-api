<?php
require_once __DIR__ . '/../../../config/db.php';
$db = new Database();
$pdo = $db->connect();

// ✅ Insert or Update Logic
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $customer_id   = $_POST['customer_id'] ?? null;
    $customer_name = $_POST['customer_name'];
    $contact_no    = $_POST['contact_no'];
    $email         = $_POST['email'];
    $address       = $_POST['address'];

    if ($customer_id) {
        // Update existing record
        $sql = "UPDATE customer_master 
                SET customer_name=?, contact_no=?, email=?, address=? 
                WHERE customer_id=?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$customer_name, $contact_no, $email, $address, $customer_id]);
        $msg = "Customer updated successfully!";
    } else {
        // Insert new record
        $sql = "INSERT INTO customer_master (customer_name, contact_no, email, address) 
                VALUES (?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$customer_name, $contact_no, $email, $address]);
        $msg = "New customer added successfully!";
    }
}

// ✅ Fetch all customers
$customers = $pdo->query("SELECT * FROM customer_master ORDER BY customer_name ASC")->fetchAll(PDO::FETCH_ASSOC);

// ✅ Fetch single customer for editing
$editCustomer = null;
if (isset($_GET['edit'])) {
    $stmt = $pdo->prepare("SELECT * FROM customer_master WHERE customer_id=?");
    $stmt->execute([$_GET['edit']]);
    $editCustomer = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Customer Master</title>
    <style>
        body { font-family: Arial; margin: 20px; }
        .container { max-width: 800px; margin: auto; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background: #f4f4f4; }
        .msg { padding: 10px; background: #e2ffe2; margin-bottom: 10px; }
        .form-box { border: 1px solid #ccc; padding: 15px; margin-bottom: 20px; }
        input, textarea { width: 100%; padding: 8px; margin: 5px 0; }
        button { padding: 10px 15px; background: green; color: white; border: none; cursor: pointer; }
    </style>
</head>
<body>
<div class="container">
    <h2>👥 Customer Master</h2>

    <?php if (!empty($msg)) echo "<div class='msg'>$msg</div>"; ?>

    <div class="form-box">
        <h3><?= $editCustomer ? "✏️ Edit Customer" : "➕ Add Customer"; ?></h3>
        <form method="POST">
            <input type="hidden" name="customer_id" value="<?= $editCustomer['customer_id'] ?? ''; ?>">

            <label>Customer Name</label>
            <input type="text" name="customer_name" required value="<?= $editCustomer['customer_name'] ?? ''; ?>">

            <label>Contact No</label>
            <input type="text" name="contact_no" value="<?= $editCustomer['contact_no'] ?? ''; ?>">

            <label>Email</label>
            <input type="email" name="email" value="<?= $editCustomer['email'] ?? ''; ?>">

            <label>Address</label>
            <textarea name="address"><?= $editCustomer['address'] ?? ''; ?></textarea>

            <button type="submit"><?= $editCustomer ? "Update" : "Save"; ?></button>
        </form>
    </div>

    <h3>📋 Customer List</h3>
    <table>
        <thead>
            <tr>
                <th>ID</th><th>Name</th><th>Contact</th><th>Email</th><th>Address</th><th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($customers as $c): ?>
                <tr>
                    <td><?= $c['customer_id'] ?></td>
                    <td><?= htmlspecialchars($c['customer_name']) ?></td>
                    <td><?= htmlspecialchars($c['contact_no']) ?></td>
                    <td><?= htmlspecialchars($c['email']) ?></td>
                    <td><?= htmlspecialchars($c['address']) ?></td>
                    <td>
                        <a href="?edit=<?= $c['customer_id'] ?>">✏️ Edit</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>
