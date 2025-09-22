<?php
require_once __DIR__ . '/../config/db.php';
$db = new Database();

$pdo = $db->connect();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $customer_id = $_POST['customer_id'] ?? null;
    $bill_no     = $_POST['bill_no'] ?? null;
    $bill_amount = $_POST['bill_amount'] ?? null;
    $bill_date   = $_POST['bill_date'] ?? null;
     $bill_type = $_POST['bill_type'];
    $remark      = $_POST['remark'] ?? null;

    if ($customer_id && $bill_no && $bill_amount && $bill_date) {
        $sql = "INSERT INTO billing (customer_id, bill_no, bill_amount, bill_date,bill_type, remark) 
                VALUES (?,?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$customer_id, $bill_no, $bill_amount, $bill_date,$bill_type,$remark]);

        // ✅ Show message before redirect
        echo "<h2 style='color:green;'>✅ Bill saved successfully!</h2>";
        echo "<p>Redirecting to billing page...</p>";
        echo "<script>
                setTimeout(function(){
                    window.location.href = 'index.php?route=billing&success=1';
                }, 2000); // 2 seconds delay
              </script>";
        exit;
    } else {
        echo "<h2 style='color:red;'>❌ Failed to save bill. Missing required fields.</h2>";
        echo "<p>Redirecting back to billing page...</p>";
        echo "<script>
                setTimeout(function(){
                    window.location.href = 'index.php?route=billing&error=1';
                }, 2000);
              </script>";
        exit;
    }
}
?>
