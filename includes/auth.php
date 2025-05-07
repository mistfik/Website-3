<?php
require_once 'db.php';
require_once 'functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $username = cleanInput($_POST['username']);
    $password = $_POST['password'];

    $stmt = $db->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && $password === $user['password']) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['is_admin'] = ($user['username'] === ADMIN_LOGIN);
        
        if ($_SESSION['is_admin']) {
            header('Location: /admin/index.php');
        } else {
            header('Location: /orders.php');
        }
        exit;
    } else {
        $_SESSION['error'] = 'Неверный логин или пароль';
        header('Location: /login.php');
        exit;
    }
}
?>
