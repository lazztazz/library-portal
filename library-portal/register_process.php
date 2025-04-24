<?php
require 'config.php';


$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];


$hashed_password = password_hash($password, PASSWORD_DEFAULT);

try {
 
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->rowCount() > 0) {
        die("Этот email уже используется.");
    }

   
    $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->execute([$username, $email, $hashed_password]);

    echo "Вы успешно зарегистрированы! <a href='login.php'>Войти</a>";
} catch (PDOException $e) {
    die("Ошибка регистрации: " . $e->getMessage());
}
?>
