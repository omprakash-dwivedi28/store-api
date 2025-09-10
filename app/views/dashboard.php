<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
</head>
<body>
    <h2>Welcome, <?php echo htmlspecialchars($user['username']); ?>!</h2>
    <p>Your role: <b><?php echo $user['role']; ?></b></p>

    <?php if ($user['role'] === 'admin'): ?>
        <p><a href="#">Admin Panel</a></p>
    <?php else: ?>
        <p><a href="#">User Dashboard</a></p>
    <?php endif; ?>

    <p><a href="index.php?route=logout">Logout</a></p>
</body>
</html>
