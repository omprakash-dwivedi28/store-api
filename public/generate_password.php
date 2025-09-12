<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = trim($_POST['password']);
    if (!empty($password)) {
        // Generate a secure bcrypt hash
        $hash = password_hash($password, PASSWORD_BCRYPT);
        echo "<p><b>Plain:</b> $password</p>";
        echo "<p><b>Hash:</b> $hash</p>";
        echo "<p>👉 Copy the hash into your database.</p>";
    } else {
        echo "<p style='color:red;'>Please enter a password!</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Password Hash Generator</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 50px;
            background: #f7f7f7;
            color: #333;
        }
        form {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.2);
            width: 300px;
        }
        input[type="text"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }
        button {
            padding: 10px 15px;
            background: #007BFF;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
    <h2>Password Hash Generator</h2>
    <form method="POST">
        <label for="password">Enter Password:</label><br>
        <input type="text" name="password" id="password" required>
        <button type="submit">Generate Hash</button>
    </form>
</body>
</html>
