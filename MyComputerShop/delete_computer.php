<?php
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $stmt = $pdo->prepare("DELETE FROM computers WHERE id = :id");
    $stmt->execute(['id' => $_GET['id']]);
}

header("Location: index.php?message=Computer deleted successfully");
exit();
