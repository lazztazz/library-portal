<?php
session_start();
require 'config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    die("Доступ запрещён");
}

include 'header.php';
?>

<h2 class="mb-4">Добавить книгу</h2>

<form action="add_book_process.php" method="POST" enctype="multipart/form-data">
    <div class="mb-3">
        <label class="form-label">Название:</label>
        <input type="text" name="title" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Автор:</label>
        <input type="text" name="author" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Жанр:</label>
        <input type="text" name="genre" class="form-control">
    </div>

    <div class="mb-3">
        <label class="form-label">Год:</label>
        <input type="number" name="year" class="form-control">
    </div>

    <div class="mb-3">
        <label class="form-label">Стоимость (₽):</label>
        <input type="number" name="price" class="form-control" step="0.01" min="0">
    </div>

    <div class="mb-3">
        <label class="form-label">Описание:</label>
        <textarea name="description" class="form-control" rows="5"></textarea>
    </div>

    <div class="mb-3">
        <label class="form-label">Обложка (JPG, PNG):</label>
        <input type="file" name="cover" class="form-control" accept="image/*">
    </div>

    <button type="submit" class="btn btn-success">Сохранить</button>
    <a href="admin_panel.php" class="btn btn-secondary">Назад</a>
</form>

<?php include 'footer.php'; ?>