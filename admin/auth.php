<?php
require_once '../includes/config.php';
require_once '../includes/db.php';
require_once '../includes/functions.php';
require_once '../includes/auth.php';

if (isAdmin()) {
    header('Location: /admin/index.php');
    exit;
}

include '../templates/header.php';
?>

<div class="container">
    <h2>Вход для администратора</h2>
    
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($_SESSION['error']) ?></div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>
    
    <form method="POST">
        <input type="hidden" name="login" value="1">
        <div class="form-group">
            <label>Логин</label>
            <input type="text" name="username" class="form-control" required>
        </div>
        
        <div class="form-group">
            <label>Пароль</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        
        <button type="submit" class="btn btn-primary">Войти</button>
    </form>
</div>

<?php include '../templates/footer.php'; ?>