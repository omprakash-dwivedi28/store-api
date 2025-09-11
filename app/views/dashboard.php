<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
<link rel="stylesheet" href="css/dashboard.css">
</head>
<body>
    <div class="container">
        <h2>Welcome, <?php echo htmlspecialchars($user['username']); ?> 🎉</h2>
        <p>Your role: <span class="role"><?php echo ucfirst($user['role']); ?></span></p>

        <?php if ($user['role'] === 'admin'): ?>
            <a href="#" class="button admin">Admin Panel</a>
        <?php else: ?>
            <a href="#" class="button user">User Dashboard</a>
        <?php endif; ?>

        <a href="index.php?route=logout" class="button logout">Logout</a>
    </div>
</body>
</html>
