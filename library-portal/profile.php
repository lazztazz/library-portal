<?php
session_start();
require 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("
    SELECT o.order_date, o.status, b.title, b.author
    FROM orders o
    JOIN books b ON o.book_id = b.id
    WHERE o.user_id = ?
    ORDER BY o.order_date DESC
");
$stmt->execute([$user_id]);
$orders = $stmt->fetchAll();

include 'header.php';
?>

<div class="text-center mb-5">
    <h2 class="mb-2">👤 Личный кабинет</h2>
    <p class="lead">Здравствуйте, <strong><?= htmlspecialchars($_SESSION['username']) ?></strong>!</p>
</div>

<h4 class="mb-4">📖 Ваши заказы</h4>

<?php if ($orders): ?>
    <div class="row">
        <?php foreach ($orders as $order): ?>
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($order['title']) ?></h5>
                        <p class="card-text">
                            <strong>Автор:</strong> <?= htmlspecialchars($order['author']) ?><br>
                            <strong>Дата заказа:</strong> <?= date("d.m.Y H:i", strtotime($order['order_date'])) ?><br>
                            <strong>Статус:</strong> 
                            <span class="badge bg-<?= $order['status'] === 'одобрен' ? 'success' : ($order['status'] === 'в обработке' ? 'warning text-dark' : 'secondary') ?>">
                                <?= $order['status'] ?>
                            </span>
                        </p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <p>Вы пока не заказывали книги.</p>
<?php endif; ?>

<?php include 'footer.php'; ?>
