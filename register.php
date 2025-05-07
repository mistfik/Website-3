<?php
require_once 'includes/config.php';
require_once 'includes/db.php';
require_once 'includes/functions.php';

if (isLoggedIn()) {
    header('Location: /orders.php');
    exit;
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = cleanInput($_POST['username']);
    $password = $_POST['password'];
    $full_name = cleanInput($_POST['full_name']);
    $phone = cleanInput($_POST['phone']);
    $email = cleanInput($_POST['email']);
    if (!validateUsername($username)) {
        $errors[] = 'Логин должен содержать не менее 6 символов кириллицы';
    }

    if (strlen($password) < 6) {
        $errors[] = 'Пароль должен содержать не менее 6 символов';
    }

    if (!validateFullName($full_name)) {
        $errors[] = 'ФИО должно содержать только буквы и пробелы';
    }

    if (!validatePhone($phone)) {
        $errors[] = 'Телефон должен быть в формате +7(XXX)-XXX-XX-XX';
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Некорректный email';
    }
    $stmt = $db->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->execute([$username]);
    if ($stmt->fetch()) {
        $errors[] = 'Этот логин уже занят';
    }

    if (empty($errors)) {
        $stmt = $db->prepare("INSERT INTO users (username, password, full_name, phone, email) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$username, $password, $full_name, $phone, $email]);

        $_SESSION['success'] = 'Регистрация прошла успешно! Теперь вы можете войти.';
        header('Location: /login.php');
        exit;
    }
}

include 'templates/header.php';
?>

<div class="container">
    <h2>Регистрация</h2>
    
    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <?php foreach ($errors as $error): ?>
                <p><?= htmlspecialchars($error) ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    
    <form method="POST" id="register-form">
        <div class="form-group">
            <label>Логин (кириллица, ≥6 символов)</label>
            <input type="text" name="username" class="form-control" required pattern="[а-яА-ЯёЁ]{6,}">
        </div>
        
        <div class="form-group">
            <label>Пароль (≥6 символов)</label>
            <input type="password" name="password" class="form-control" required minlength="6">
        </div>
        
        <div class="form-group">
            <label>ФИО</label>
            <input type="text" name="full_name" class="form-control" required pattern="[а-яА-ЯёЁ\s]+">
        </div>
        
        <div class="form-group">
            <label>Телефон (+7(XXX)-XXX-XX-XX)</label>
            <input type="text" name="phone" id="phone" class="form-control" required pattern="\+7\(\d{3}\)-\d{3}-\d{2}-\d{2}">
        </div>
        
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        
        <button type="submit" class="btn btn-primary">Зарегистрироваться</button>
    </form>
    
    <p class="mt-3">Уже зарегистрированы? <a href="/login.php">Войдите</a></p>
</div>

<?php include 'templates/footer.php'; ?>
