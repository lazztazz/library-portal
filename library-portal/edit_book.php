<?php
session_start();
require 'config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    die("Доступ запрещён");
}

$id = $_GET['id'] ?? null;
if (!$id) {
    die("Книга не найдена");
}

$stmt = $pdo->prepare("SELECT * FROM books WHERE id = ?");
$stmt->execute([$id]);
$book = $stmt->fetch();

if (!$book) {
    die("Книга не найдена");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $genre = $_POST['genre'];
    $year = $_POST['year'];
    $description = $_POST['description'];
    $cover_image = $book['cover_image'];

    // Обновление обложки
    if (!empty($_FILES['cover']['name'])) {
        $upload_dir = 'uploads/';
        $filename = time() . '_' . basename($_FILES['cover']['name']);
        $target = $upload_dir . $filename;

        if (move_uploaded_file($_FILES['cover']['tmp_name'], $target)) {
            $cover_image = $filename;
        }
    }

    $stmt = $pdo->prepare("UPDATE books SET title=?, author=?, genre=?, year=?, description=?, cover_image=? WHERE id=?");
    $stmt->execute([$title, $author, $genre, $year, $description, $cover_image, $id]);

    header("Location: admin_panel.php");
    exit;
}

include 'header.php';
?>

<h2 class="mb-4">Редактировать книгу</h2>

<form method="POST" enctype="multipart/form-data">
    <div class="mb-3">
        <label class="form-label">Название:</label>
        <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($book['title']) ?>" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Автор:</label>
        <input type="text" name="author" class="form-control" value="<?= htmlspecialchars($book['author']) ?>" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Жанр:</label>
        <input type="text" name="genre" class="form-control" value="<?= htmlspecialchars($book['genre']) ?>">
    </div>

    <div class="mb-3">
        <label class="form-label">Год:</label>
        <input type="number" name="year" class="form-control" value="<?= htmlspecialchars($book['year']) ?>">
    </div>

    <div class="mb-3">
        <label class="form-label">Описание:</label>
        <textarea name="description" class="form-control" rows="5"><?= htmlspecialchars($book['description']) ?></textarea>
    </div>

    <div class="mb-3">
        <label class="form-label">Обложка (оставьте пустым, если не менять):</label>
        <input type="file" name="cover" class="form-control">
        <?php if ($book['cover_image']): ?>
            <img src="uploads/<?= $book['cover_image'] ?>" width="100" class="mt-2">
        <?php endif; ?>
    </div>

    <button type="submit" class="btn btn-success">Сохранить</button>
    <a href="admin_panel.php" class="btn btn-secondary">Назад</a>
</form>

<?php include 'footer.php'; ?>
