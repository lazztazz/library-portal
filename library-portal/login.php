<?php include 'header.php'; ?>

<div class="d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="card shadow-sm p-4" style="max-width: 400px; width: 100%;">
        <h3 class="text-center mb-4">🔐 Вход</h3>

        <form action="login_process.php" method="POST">
            <div class="mb-3">
                <label class="form-label">Email:</label>
                <input type="email" name="email" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Пароль:</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary w-100">Войти</button>

            <div class="text-center mt-3">
                <a href="register.php">Нет аккаунта? Зарегистрируйтесь</a>
            </div>
        </form>
    </div>
</div>

<?php include 'footer.php'; ?>
