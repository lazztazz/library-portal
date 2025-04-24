<?php
session_start();
require 'config.php';

$email = $_POST['email'];
$password = $_POST['password'];

try {

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
       
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        if ($user['role'] === 'admin') {
            header("Location: admin_panel.php");
        } else {
            header("Location: profile.php");
        }
        exit;
    } else {
        echo "Неверный email или пароль.";
    }
} catch (PDOException $e) {
    die("Ошибка входа: " . $e->getMessage());
}
?>
