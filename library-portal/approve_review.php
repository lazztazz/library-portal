<?php
require 'config.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    die("Доступ запрещён");
}

$review_id = (int) $_POST['review_id'];
$action = $_POST['action'];

if ($action === 'approve') {
    $stmt = $pdo->prepare("UPDATE reviews SET approved = 1 WHERE id = ?");
    $stmt->execute([$review_id]);
} elseif ($action === 'reject') {
    $stmt = $pdo->prepare("DELETE FROM reviews WHERE id = ?");
    $stmt->execute([$review_id]);
}

header("Location: moderate_reviews.php");
exit;
