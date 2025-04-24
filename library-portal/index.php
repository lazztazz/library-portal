<?php
require 'config.php';
include 'header.php';

// Получим 3 случайные книги
$stmt = $pdo->query("SELECT * FROM books ORDER BY RAND() LIMIT 3");
$books = $stmt->fetchAll();
?>

<div class="py-5 text-center bg-light rounded shadow-sm mb-5">
    <h1 class="display-5 fw-bold">📚 Добро пожаловать в библиотечный портал</h1>
    <p class="lead mb-4">Читайте, заказывайте, добавляйте отзывы — всё в одном месте.</p>
    <a href="catalog.php" class="btn btn-primary btn-lg">Перейти в каталог</a>
</div>

<h3 class="mb-4 text-center">🔥 Рекомендуемые книги</h3>

<div class="row">
    <?php foreach ($books as $book): ?>
        <div class="col-md-4 mb-4 fade-in">
            <div class="card book-card h-100 shadow-sm border-0">
                <?php if (!empty($book['cover_image'])): ?>
                    <img src="uploads/<?= htmlspecialchars($book['cover_image']) ?>" class="card-img-top book-cover" alt="Обложка книги">
                <?php endif; ?>
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title"><?= htmlspecialchars($book['title']) ?></h5>
                    <p class="card-text text-muted mb-1"><strong>Автор:</strong> <?= htmlspecialchars($book['author']) ?></p>
                    <p class="card-text text-muted mb-1"><strong>Жанр:</strong> <?= htmlspecialchars($book['genre']) ?></p>
                    <p class="card-text text-success mb-3"><strong>Цена:</strong> <?= number_format($book['price'], 2, ',', ' ') ?> ₽</p>
                    <a href="book.php?id=<?= $book['id'] ?>" class="btn btn-outline-primary mt-auto">Подробнее</a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php include 'footer.php'; ?>
