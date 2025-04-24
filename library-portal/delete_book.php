<?php
session_start();
require 'config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    die("Доступ запрещён");
}

$id = $_GET['id'] ?? null;
if (!$id) {
    die("ID книги не указан");
}

// Удалим изображение (если есть)
$stmt = $pdo->prepare("SELECT cover_image FROM books WHERE id = ?");
$stmt->execute([$id]);
$book = $stmt->fetch();

if ($book && $book['cover_image']) {
    $path = 'uploads/' . $book['cover_image'];
    if (file_exists($path)) {
        unlink($path);
    }
}

// Удаляем запись из базы
$stmt = $pdo->prepare("DELETE FROM books WHERE id = ?");
$stmt->execute([$id]);

header("Location: admin_panel.php");
exit;
