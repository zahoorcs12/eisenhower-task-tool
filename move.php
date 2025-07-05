<?php
require_once 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $category = $_POST['category'];

    $stmt = $pdo->prepare("UPDATE tasks SET category = ? WHERE id = ? AND user_id = ?");
    $stmt->execute([$category, $id, $_SESSION['user_id']]);
}
