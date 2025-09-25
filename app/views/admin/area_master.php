<?php
require_once __DIR__ . '/../../../config/db.php';
$db = new Database();
$pdo = $db->connect();

// Handle form submission for adding or updating an area
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add') {
    $area_name = trim($_POST['area_name']);
    if (!empty($area_name)) {
        $stmt = $pdo->prepare("INSERT INTO area_master (area_name) VALUES (?)");
        $stmt->execute([$area_name]);
        $success_message = "Area added successfully!";
    } else {
        $error_message = "Area name is required!";
    }
}

// Handle deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete') {
    $area_id = (int)$_POST['area_id'];
    // Check if area is assigned to any customers
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM customer_master WHERE area_id = ?");
    $stmt->execute([$area_id]);
    if ($stmt->fetchColumn() == 0) {
        $stmt = $pdo->prepare("DELETE FROM area_master WHERE area_id = ?");
        $stmt->execute([$area_id]);
        $success_message = "Area deleted successfully!";
    } else {
        $error_message = "Cannot delete area as it is assigned to customers!";
    }
}

// Fetch all areas
$stmt = $pdo->query("SELECT area_id, area_name FROM area_master ORDER BY area_name ASC");
$areas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Area Master</title>
    <link rel="stylesheet" href="css/billing.css">
    <style>
        .area-container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .form-section {
            margin-bottom: 20px;
        }
        .form-section label {
            display: block;
            margin: 10px 0 5px;
        }
        .form-section input, .form-section button {
            padding: 8px;
            margin: 5px 0;
            width: 100%;
            max-width: 300px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .form-section button {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
        .form-section button:hover {
            background-color: #45a049;
        }
        .message {
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 4px;
        }
        .success {
            background-color: #d4edda;
            color: #155724;
        }
        .error {
            background-color: #f8d7da;
            color: #721c24;
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
        .btn-delete {
            background-color: #f44336;
            color: white;
            padding: 8px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .btn-delete:hover {
            background-color: #da190b;
        }
    </style>
</head>
<body>
    <div class="area-container">
        <h2>🏠 Area Master Management</h2>

        <?php if (isset($success_message)): ?>
            <div class="message success"><?= htmlspecialchars($success_message) ?></div>
        <?php endif; ?>
        <?php if (isset($error_message)): ?>
            <div class="message error"><?= htmlspecialchars($error_message) ?></div>
        <?php endif; ?>

        <div class="form-section">
            <form action="area_master.php" method="POST">
                <input type="hidden" name="action" value="add">
                <label for="area_name">Area Name:</label>
                <input type="text" id="area_name" name="area_name" required>
                <button type="submit" class="btn">Add Area</button>
            </form>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Area Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($areas)): ?>
                    <tr><td colspan="2">No areas found.</td></tr>
                <?php else: ?>
                    <?php foreach ($areas as $area): ?>
                        <tr>
                            <td><?= htmlspecialchars($area['area_name']) ?></td>
                            <td>
                                <form action="area_master.php" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this area?');">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="area_id" value="<?= $area['area_id'] ?>">
                                    <button type="submit" class="btn-delete">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>