<?php
require_once 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $stmt->execute([$username, $password]);
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
    body, html {
            height: 100%;
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
        }

        body {
            background: linear-gradient(-45deg, #1e3c72, #2a5298, #6dd5ed, #2193b0);
            background-size: 400% 400%;
            animation: gradientMove 15s ease infinite;
        }

        @keyframes gradientMove {
            0% {background-position: 0% 50%;}
            50% {background-position: 100% 50%;}
            100% {background-position: 0% 50%;}
        }

    .register-container {
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .register-card {
        width: 100%;
        max-width: 400px;
        padding: 30px;
        border-radius: 1rem;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
        background-color: rgba(255, 255, 255, 0.9);
    }

    .form-control:focus {
        box-shadow: 0 0 0 0.2rem rgba(138, 43, 226, 0.25);
    }

    .btn-primary {
        background-color: #6a11cb;
        border: none;
    }

    .btn-primary:hover {
        background-color: #571ca6;
    }
</style>
</head>
<body>
<div class="register-container">
    <div class="register-card">
        <h3 class="text-center mb-4">Register</h3>
        <form method="POST" novalidate>
            <div class="mb-3">
                <input name="username" class="form-control" placeholder="Username" required>
            </div>
            <div class="mb-3">
                <input name="password" type="password" class="form-control" placeholder="Password" required>
            </div>
            <div class="d-grid mb-3">
                <button class="btn btn-primary" type="submit">Register</button>
            </div>
            <p class="text-center">Already have an account? <a href="login.php">Login here</a></p>
        </form>
    </div>
</div>

<!-- Bootstrap JS (optional) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
