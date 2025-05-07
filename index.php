<?php
// Включение настроек и подключения к БД
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';

// Старт сессии (если еще не начата)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Подключение шапки сайта
include __DIR__ . '/templates/header.php';
?>

<div class="container">
    <h1>Добро пожаловать в систему грузоперевозок</h1>
    
    <?php if (isset($_SESSION['user_id'])): ?>
        <p>Вы авторизованы как: <?= htmlspecialchars($_SESSION['username'] ?? 'Пользователь') ?></p>
        <a href="orders.php" class="btn btn-primary">Мои заявки</a>
        <a href="logout.php" class="btn btn-secondary">Выйти</a>
    <?php else: ?>
        <p>Пожалуйста, авторизуйтесь или зарегистрируйтесь</p>
        <a href="login.php" class="btn btn-primary">Вход</a>
        <a href="register.php" class="btn btn-success">Регистрация</a>
    <?php endif; ?>
</div>

<?php
// Подключение подвала сайта
include __DIR__ . '/templates/footer.php';
?>