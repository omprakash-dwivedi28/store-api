<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="css/dashboard.css">
</head>
<body>
    <div class="container">
        <h2>Welcome Admin, <?php echo htmlspecialchars($user['username']); ?> 🎉</h2>
        <p>Your role: <span class="role"><?php echo ucfirst($user['role']); ?></span></p>

        <a href="index.php?route=area_master" class="button admin">Area Master</a>
        <a href="index.php?route=cust_master" class="button admin">Customer Master</a>
        <a href="index.php?route=logout" class="button logout">Logout</a>
    </div>
</body>
</html>
