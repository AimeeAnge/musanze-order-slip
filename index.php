<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login & Signup</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="login-page">

    <div class="container">
        <!-- Messages -->
        <?php if (isset($_GET['error'])): ?>
            <p style="color: red; text-align: center;"><?php echo htmlspecialchars($_GET['error']); ?></p>
        <?php endif; ?>
        <?php if (isset($_GET['success'])): ?>
            <p style="color: green; text-align: center;"><?php echo htmlspecialchars($_GET['success']); ?></p>
        <?php endif; ?>

        <!-- Login Form -->
        <div id="login-form">
            <h2>Welcome To Musanze Order Slip System</h2>
            <form action="auth.php" method="POST">
                <input type="email" name="email" placeholder="Email Address" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit" name="login">Login</button>
            </form>
            <div class="toggle-link">
                Don't have an account? <a onclick="toggleForms()">Sign up</a>
            </div>
        </div>

        <!-- Signup Form -->
        <div id="signup-form" class="hidden">
            <h2>Create Account</h2>
            <form action="auth.php" method="POST">
                <input type="text" name="full_name" placeholder="Full Name" required>
                <input type="email" name="email" placeholder="Email Address" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit" name="register">Sign Up</button>
            </form>
            <div class="toggle-link">
                Already have an account? <a onclick="toggleForms()">Login</a>
            </div>
        </div>
    </div>

    <script src="js/login.js"></script>
</body>
</html>