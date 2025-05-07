<?php
require_once 'includes/config.php';
require_once 'includes/db.php';
require_once 'includes/functions.php';

if (!isLoggedIn()) {
    header('Location: /login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $date_time = $_POST['date_time'];
    $weight = (float)$_POST['weight'];
    $dimensions = cleanInput($_POST['dimensions']);
    $cargo_type = cleanInput($_POST['cargo_type']);
    $from_address = cleanInput($_POST['from_address']);
    $to_address = cleanInput($_POST['to_address']);

    $stmt = $db->prepare("INSERT INTO orders (user_id, date_time, weight, dimensions, cargo_type, from_address, to_address) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([
        $_SESSION['user_id'],
        $date_time,
        $weight,
        $dimensions,
        $cargo_type,
        $from_address,
        $to_address
    ]);

    $_SESSION['success'] = 'Заявка успешно создана и отправлена на рассмотрение';
    header('Location: /orders.php');
    exit;
}

include 'templates/header.php';
?>

<div class="container">
    <h2>Создание заявки на перевозку</h2>
    
    <form method="POST">
        <div class="form-group">
            <label>Дата и время перевозки</label>
            <input type="datetime-local" name="date_time" class="form-control" required>
        </div>
        
        <div class="form-group">
            <label>Вес груза (кг)</label>
            <input type="number" step="0.01" name="weight" class="form-control" required min="0.1">
        </div>
        
        <div class="form-group">
            <label>Габариты груза</label>
            <input type="text" name="dimensions" class="form-control" required placeholder="Например: 2м x 1.5м x 1м">
        </div>
        
        <div class="form-group">
            <label>Тип груза</label>
            <select name="cargo_type" class="form-control" required>
                <option value="">Выберите тип груза</option>
                <option value="Мебель">Мебель</option>
                <option value="Бытовая техника">Бытовая техника</option>
                <option value="Строительные материалы">Строительные материалы</option>
                <option value="Продукты питания">Продукты питания</option>
                <option value="Документы">Документы</option>
                <option value="Другое">Другое</option>
            </select>
        </div>
        
        <div class="form-group">
            <label>Адрес отправления</label>
            <input type="text" name="from_address" class="form-control" required>
        </div>
        
        <div class="form-group">
            <label>Адрес доставки</label>
            <input type="text" name="to_address" class="form-control" required>
        </div>
        
        <button type="submit" class="btn btn-primary">Отправить заявку</button>
    </form>
</div>

<?php include 'templates/footer.php'; ?>