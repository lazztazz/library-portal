<?php
require 'config.php';
include 'header.php';

if (!isset($_GET['id'])) {
    die("Книга не найдена.");
}

$id = (int) $_GET['id'];

// Получение книги
$stmt = $pdo->prepare("SELECT * FROM books WHERE id = ?");
$stmt->execute([$id]);
$book = $stmt->fetch();

if (!$book) {
    die("Книга не найдена.");
}

// Получение отзывов
$reviewStmt = $pdo->prepare("SELECT r.review_text, r.rating, u.username FROM reviews r 
                             JOIN users u ON r.user_id = u.id 
                             WHERE r.book_id = ? AND r.approved = 1 
                             ORDER BY r.id DESC");
$reviewStmt->execute([$id]);
$reviews = $reviewStmt->fetchAll();
?>

<h2 class="mb-4"><?= htmlspecialchars($book['title']) ?></h2>

<!-- Обложка книги -->
<?php if (!empty($book['cover_image'])): ?>
    <img src="uploads/<?= htmlspecialchars($book['cover_image']) ?>" 
         alt="Обложка книги" 
         class="img-thumbnail mb-3" 
         style="max-width: 300px;">
<?php endif; ?>

<div class="mb-3">
    <p><strong>Автор:</strong> <?= htmlspecialchars($book['author']) ?></p>
    <p><strong>Жанр:</strong> <?= htmlspecialchars($book['genre']) ?></p>
    <p><strong>Год:</strong> <?= htmlspecialchars($book['year']) ?></p>
    <p><?= nl2br(htmlspecialchars($book['description'])) ?></p>
</div>

<!-- Заказ книги -->
<?php if (isset($_SESSION['user_id'])): ?>
    <form action="order_book.php" method="POST" class="mb-4">
        <input type="hidden" name="book_id" value="<?= $book['id'] ?>">
        <button class="btn btn-success" type="submit">📖 Заказать</button>
    </form>
<?php else: ?>
    <p><a href="login.php">Войдите</a>, чтобы заказать книгу.</p>
<?php endif; ?>

<hr>
<h4>Отзывы:</h4>
<?php if ($reviews): ?>
    <?php foreach ($reviews as $review): ?>
        <div class="border rounded p-3 mb-3">
            <strong><?= htmlspecialchars($review['username']) ?></strong> — 
            <em>Оценка: <?= $review['rating'] ?>/5</em><br>
            <?= nl2br(htmlspecialchars($review['review_text'])) ?>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <p>Отзывов пока нет.</p>
<?php endif; ?>

<!-- Оставить отзыв -->
<?php if (isset($_SESSION['user_id'])): ?>
    <hr>
    <h5>Оставить отзыв:</h5>
    <form action="add_review.php" method="POST">
        <input type="hidden" name="book_id" value="<?= $book['id'] ?>">
        <div class="mb-2">
            <label>Оценка (1–5):</label>
            <input type="number" name="rating" min="1" max="5" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Отзыв:</label>
            <textarea name="review_text" rows="4" class="form-control" required></textarea>
        </div>
        <button class="btn btn-primary" type="submit">Отправить</button>
    </form>
<?php else: ?>
    <p><a href="login.php">Войдите</a>, чтобы оставить отзыв.</p>
<?php endif; ?>

<?php include 'footer.php'; ?>
