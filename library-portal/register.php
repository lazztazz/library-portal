<?php include 'header.php'; ?>

<div class="d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="card shadow-sm p-4" style="max-width: 450px; width: 100%;">
        <h3 class="text-center mb-4">📝 Регистрация</h3>

        <form action="register_process.php" method="POST">
            <div class="mb-3">
                <label class="form-label">Имя пользователя:</label>
                <input type="text" name="username" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Email:</label>
                <input type="email" name="email" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Пароль:</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-success w-100">Зарегистрироваться</button>

            <div class="text-center mt-3">
                <a href="login.php">Уже есть аккаунт?</a>
            </div>
        </form>
    </div>
</div>

<?php include 'footer.php'; ?>
