<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <!-- Link the shared stylesheet -->
<link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h2>🔐 Login</h2>

        <!-- Error Message -->
        <?php if (isset($error)) : ?>
            <p class="error"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>

        <!-- Login Form -->
        <form method="POST" action="index.php?route=login">
            <label for="username">Username</label>
            <input type="text" name="username" id="username" placeholder="Enter your username" required>

            <label for="password">Password</label>
            <input type="password" name="password" id="password" placeholder="Enter your password" required>

            <button type="submit">Login</button>
        </form>

        <!-- Footer Info -->
        <div class="footer">
            <p>Demo Roles → <span>admin / user</span></p>
        </div>
    </div>
</body>
</html>
