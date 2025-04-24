<?php
require 'config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    die("Доступ запрещён.");
}

$user_id = $_SESSION['user_id'];
$book_id = (int) $_POST['book_id'];
$rating = (int) $_POST['rating'];
$review_text = trim($_POST['review_text']);

if ($rating < 1 || $rating > 5 || empty($review_text)) {
    die("Некорректные данные.");
}

$stmt = $pdo->prepare("INSERT INTO reviews (user_id, book_id, review_text, rating) VALUES (?, ?, ?, ?)");
$stmt->execute([$user_id, $book_id, $review_text, $rating]);

echo "Отзыв отправлен на модерацию. <a href='book.php?id=$book_id'>Вернуться к книге</a>";
