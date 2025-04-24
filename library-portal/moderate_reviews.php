<?php
session_start();
require 'config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    die("Доступ запрещён");
}

// Получаем все необработанные отзывы
$stmt = $pdo->query("
    SELECT r.id, r.review_text, r.rating, u.username, b.title
    FROM reviews r
    JOIN users u ON r.user_id = u.id
    JOIN books b ON r.book_id = b.id
    WHERE r.approved = 0
    ORDER BY r.id DESC
");

$reviews = $stmt->fetchAll();

include 'header.php';
?>

<h2 class="mb-4">Модерация отзывов</h2>

<?php if ($reviews): ?>
    <?php foreach ($reviews as $review): ?>
        <div class="border p-3 mb-3 rounded">
            <p><strong><?= htmlspecialchars($review['username']) ?></strong> о книге <em><?= htmlspecialchars($review['title']) ?></em></p>
            <p><strong>Оценка:</strong> <?= $review['rating'] ?>/5</p>
            <p><?= nl2br(htmlspecialchars($review['review_text'])) ?></p>

            <form action="approve_review.php" method="POST" class="d-inline">
                <input type="hidden" name="review_id" value="<?= $review['id'] ?>">
                <button type="submit" name="action" value="approve" class="btn btn-success btn-sm">Одобрить</button>
            </form>

            <form action="approve_review.php" method="POST" class="d-inline">
                <input type="hidden" name="review_id" value="<?= $review['id'] ?>">
                <button type="submit" name="action" value="reject" class="btn btn-danger btn-sm">Удалить</button>
            </form>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <p>Нет отзывов на модерации.</p>
<?php endif; ?>

<a href="admin_panel.php" class="btn btn-secondary mt-3">Назад в админку</a>

<?php include 'footer.php'; ?>
