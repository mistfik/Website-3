<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= SITE_NAME ?></title>
    <link href="/assets/css/style.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="/index.php"><?= SITE_NAME ?></a>
            <div class="navbar-nav">
                <?php if (isLoggedIn()): ?>
                    <a class="nav-link" href="/orders.php">Мои заявки</a>
                    <a class="nav-link" href="/create_order.php">Новая заявка</a>
                    <a class="nav-link" href="/logout.php">Выйти</a>
                <?php else: ?>
                    <a class="nav-link" href="/register.php">Регистрация</a>
                    <a class="nav-link" href="/login.php">Вход</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>
    <div class="container mt-4"></div>