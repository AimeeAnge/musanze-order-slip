<?php
session_start();
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // --- REGISTER ---
    if (isset($_POST['register'])) {
        $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $email = mysqli_real_escape_string($conn, $email);
        $password = $_POST['password'];

        // Check if email already exists
        $sql = "SELECT id FROM users WHERE email = '$email'";
        $query = mysqli_query($conn, $sql);
        
        if (mysqli_num_rows($query) > 0) {
            header("Location: index.php?error=Email already exists");
            exit();
        }

        // Hash password and insert
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (fullname, email, password) VALUES ('$full_name', '$email', '$hashed_password')";
        $query = mysqli_query($conn, $sql);
        
        if ($query) {
            header("Location: index.php?success=Registration successful! Please login.");
        } else {
            header("Location: index.php?error=Registration failed");
        }

    // --- LOGIN ---
    } elseif (isset($_POST['login'])) {
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $email = mysqli_real_escape_string($conn, $email);
        $password = $_POST['password'];

        $sql = "SELECT * FROM users WHERE email = '$email'";
        $query = mysqli_query($conn, $sql);
        $result = mysqli_fetch_assoc($query);

        if ($result && password_verify($password, $result['password'])) {
            $_SESSION['user_id'] = $result['id'];
            $_SESSION['full_name'] = $result['fullname'];
            header("Location: dashboard.php");
        } else {
            header("Location: index.php?error=Invalid email or password");
        }
    }
}
?>