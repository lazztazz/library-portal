<?php
require 'config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    die("Доступ запрещён");
}

$user_id = $_SESSION['user_id'];
$book_id = (int)$_POST['book_id'];

$stmt = $pdo->prepare("SELECT * FROM orders WHERE user_id = ? AND book_id = ? AND status = 'new'");
$stmt->execute([$user_id, $book_id]);

if ($stmt->rowCount() > 0) {
    die("Вы уже заказали эту книгу и заказ ещё не обработан.");
}

$stmt = $pdo->prepare("INSERT INTO orders (user_id, book_id) VALUES (?, ?)");
$stmt->execute([$user_id, $book_id]);

echo "Книга успешно заказана! <a href='profile.php'>Перейти в личный кабинет</a>";
