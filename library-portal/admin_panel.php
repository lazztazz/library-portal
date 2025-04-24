<?php
session_start();
require 'config.php';
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    die("Доступ запрещён");
}
$stmt = $pdo->query("SELECT * FROM books ORDER BY id DESC");
$books = $stmt->fetchAll();
include 'header.php';
?>
<h2 class="mb-4">Админ-панель</h2>
<p>
    <a href="add_book.php" class="btn btn-primary mb-3">➕ Добавить книгу</a>
    <a href="moderate_reviews.php" class="btn btn-secondary mb-3">📝 Модерация отзывов</a>
</p>
<h4>Список книг:</h4>
<?php if ($books): ?>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Название</th>
                    <th>Автор</th>
                    <th>Жанр</th>
                    <th>Год</th>
                    <th>Обложка</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($books as $book): ?>
                    <tr>
                        <td><?= $book['id'] ?></td>
                        <td><?= htmlspecialchars($book['title']) ?></td>
                        <td><?= htmlspecialchars($book['author']) ?></td>
                        <td><?= htmlspecialchars($book['genre']) ?></td>
                        <td><?= htmlspecialchars($book['year']) ?></td>
                        <td>
                            <?php if ($book['cover_image']): ?>
                                <img src="uploads/<?= $book['cover_image'] ?>" width="50">
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="edit_book.php?id=<?= $book['id'] ?>" class="btn btn-sm btn-warning">✏️</a>
                            <a href="delete_book.php?id=<?= $book['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Удалить книгу?')">🗑️</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php else: ?>
    <p>Книги пока не добавлены.</p>
<?php endif; ?>

<?php include 'footer.php'; ?>
