<?php
require 'config.php';
include 'header.php';

$search = $_GET['q'] ?? '';

if ($search) {
    $stmt = $pdo->prepare("SELECT * FROM books 
        WHERE title LIKE ? OR author LIKE ? OR genre LIKE ? 
        ORDER BY id DESC");
    $searchTerm = '%' . $search . '%';
    $stmt->execute([$searchTerm, $searchTerm, $searchTerm]);
} else {
    $stmt = $pdo->query("SELECT * FROM books ORDER BY id DESC");
}
$books = $stmt->fetchAll();
?>

<h2 class="mb-4 text-center">📚 Каталог книг</h2>

<form method="GET" class="mb-5">
    <div class="input-group">
        <input type="text" class="form-control" name="q" placeholder="Поиск по названию, автору или жанру" value="<?= htmlspecialchars($search) ?>">
        <button class="btn btn-primary" type="submit">🔍 Найти</button>
    </div>
</form>

<div class="row">
    <?php foreach ($books as $book): ?>
        <div class="col-md-4 mb-4">
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
