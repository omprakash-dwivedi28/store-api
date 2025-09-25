
<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="css/dashboard.css">
</head>
<body>
    <div class="container">
        <h2>Welcome, <?php echo htmlspecialchars($user['username']); ?> 🎉</h2>
        <p>Your role: <span class="role"><?php echo ucfirst($user['role']); ?></span></p>

       <a href="index.php?route=billing" class="button user">Billing Page</a>
        <a href="index.php?route=cust_wise_due" class="button user">Customer wise Due</a>
        <a href="index.php?route=settings" class="button user">Settings</a>
        <a href="index.php?route=logout" class="button logout">Logout</a>
    </div>
</body>
</html>
