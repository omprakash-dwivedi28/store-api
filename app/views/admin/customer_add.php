<?php
if (session_status() === PHP_SESSION_NONE) 
    session_start();

require_once __DIR__ . '/../../../config/db.php';
$db = new Database();
$pdo = $db->connect();

// Fetch all areas for the dropdown
$areas = $pdo->query("SELECT area_id, area_name FROM area_master ORDER BY area_name ASC")
             ->fetchAll(PDO::FETCH_ASSOC);

// ✅ Insert or Update Logic
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $customer_id   = $_POST['customer_id'] ?? null;
    $customer_name = $_POST['customer_name'];
    $contact_no    = $_POST['contact_no'];
    $email         = $_POST['email'];
    $address       = $_POST['address'];
    $area_id = $_POST['area_id'] ?? null;



    if ($customer_id) {
        // Update existing record
        $sql = "UPDATE customer_master 
                SET customer_name=?, contact_no=?, email=?, address=?,area_id=?  
                WHERE customer_id=?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$customer_name, $contact_no, $email, $address, $area_id,$customer_id]);

        // Redirect to detail page
        header("Location: ?detail=" . $customer_id . "&updated=1");
        exit;
    } else {
        // Insert new record
        $sql = "INSERT INTO customer_master (customer_name, contact_no, email, address,area_id) 
                VALUES (?, ?, ?, ?,?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$customer_name, $contact_no, $email, $address,$area_id]);

        header("Location: ?added=1");
        exit;
    }
}

// ✅ Fetch all customers
$customers = $pdo->query("SELECT * FROM customer_master ORDER BY customer_name ASC")
                 ->fetchAll(PDO::FETCH_ASSOC);

// ✅ Detail page
$detailCustomer = null;
if (isset($_GET['detail'])) {
    $stmt = $pdo->prepare("SELECT * FROM customer_master WHERE customer_id=?");
    $stmt->execute([$_GET['detail']]);
    $detailCustomer = $stmt->fetch(PDO::FETCH_ASSOC);
}

// ✅ Edit page
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
     <link rel="stylesheet" href="css/admin.css">

    <!-- <style>
        body { font-family: Arial; margin: 20px; }
        .container { max-width: 800px; margin: auto; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background: #f4f4f4; }
        .msg { padding: 10px; background: #e2ffe2; margin-bottom: 10px; }
        .form-box { border: 1px solid #ccc; padding: 15px; margin-bottom: 20px; }
        input, textarea { width: 100%; padding: 8px; margin: 5px 0; }
        button { padding: 10px 15px; background: green; color: white; border: none; cursor: pointer; }
        .btn-back { display: inline-block; margin-top: 10px; padding: 8px 12px; background: blue; color: #fff; text-decoration: none; }
    </style> -->
</head>
<body>
<div class="container">
    <h2>👥 Customer Master</h2>

    <?php if (isset($_GET['added'])) echo "<div class='msg'>✅ New customer added successfully</div>"; ?>
    <?php if (isset($_GET['updated'])) echo "<div class='msg'>✅ Customer updated successfully</div>"; ?>

    <?php if ($detailCustomer): ?>
        <!-- ✅ Detail Page -->
        <h3>📄 Customer Details</h3>
        <table>
   

            <tr><th>ID</th><td><?= $detailCustomer['customer_id'] ?></td></tr>
            <tr><th>Name</th><td><?= htmlspecialchars($detailCustomer['customer_name']) ?></td></tr>
            <tr><th>Contact</th><td><?= htmlspecialchars($detailCustomer['contact_no']) ?></td></tr>
            <tr><th>Email</th><td><?= htmlspecialchars($detailCustomer['email']) ?></td></tr>
            <tr><th>Address</th><td><?= htmlspecialchars($detailCustomer['address']) ?></td></tr>
        </table>
        <a href="?edit=<?= $detailCustomer['customer_id'] ?>" class="btn-back">✏️ Edit Again</a>
        <a href="?" class="btn-back">⬅ Back to List</a>

    <?php elseif ($editCustomer): ?>
        <!-- ✅ Edit Form -->
        <div class="form-box">
            <h3>✏️ Edit Customer</h3>
            <form method="POST">
                <input type="hidden" name="customer_id" value="<?= $editCustomer['customer_id'] ?>">

                <label>Customer Name</label>
                <input type="text" name="customer_name" required value="<?= $editCustomer['customer_name'] ?>">

                <label>Contact No</label>
                <input type="text" name="contact_no" value="<?= $editCustomer['contact_no'] ?>">

                <label>Email</label>
                <input type="email" name="email" value="<?= $editCustomer['email'] ?>">

                <label>Address</label>
                <textarea name="address"><?= $editCustomer['address'] ?></textarea>

                <button type="submit">Update</button>
            </form>
        </div>
        <a href="?" class="btn-back">⬅ Cancel</a>

    <?php else: ?>
        <!-- ✅ Add Form -->
        <div class="form-box">
            <h3>➕ Add Customer</h3>
            <form method="POST">
                         <label>Area</label>
            <select name="area_id" required>
             <option value="">-- Select Area --</option>
             <?php foreach ($areas as $area): ?>
             <option value="<?= $area['area_id'] ?>"><?= htmlspecialchars($area['area_name']) ?></option>
             <?php endforeach; ?>
            </select>
                <label>Customer Name</label>
                <input type="text" name="customer_name" required>

                <label>Contact No</label>
                <input type="text" name="contact_no">

                <label>Email</label>
                <input type="email" name="email">

                <label>Address</label>
                <textarea name="address"></textarea>

                <button type="submit">Save</button>
            </form>
        </div>

       
    <?php endif; ?>
</div>
</body>
</html>
