<?php
require 'config.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    die("Доступ запрещён");
}

$title = $_POST['title'];
$author = $_POST['author'];
$genre = $_POST['genre'];
$year = $_POST['year'];
$price = $_POST['price'] ?? 0;
$description = $_POST['description'];
$cover_image = null;

if (!empty($_FILES['cover']['name'])) {
    $upload_dir = 'uploads/';
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir);
    }

    $filename = time() . '_' . basename($_FILES['cover']['name']);
    $target = $upload_dir . $filename;

    if (move_uploaded_file($_FILES['cover']['tmp_name'], $target)) {
        $cover_image = $filename;
    }
}

$stmt = $pdo->prepare("INSERT INTO books (title, author, genre, year, description, cover_image, price)
                       VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt->execute([$title, $author, $genre, $year, $description, $cover_image, $price]);
header("Location: admin_panel.php");
exit;
