<?php
require_once 'includes/config.php';
require_once 'includes/db.php';
require_once 'includes/functions.php';

if (!isLoggedIn()) {
    header('Location: login.php');
    exit;
}

$stmt = $db->prepare("SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC");
$stmt->execute([$_SESSION['user_id']]);
$orders = $stmt->fetchAll();

include 'templates/header.php';
?>

<div class="container">
    <h2>Мои заявки</h2>
    
    <?php if (empty($orders)): ?>
        <div class="alert alert-info">У вас пока нет заявок</div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>Дата создания</th>
                        <th>Дата перевозки</th>
                        <th>Тип груза</th>
                        <th>Вес (кг)</th>
                        <th>Габариты</th>
                        <th>Откуда</th>
                        <th>Куда</th>
                        <th>Статус</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order): ?>
                    <tr>
                        <td><?= date('d.m.Y H:i', strtotime($order['created_at'])) ?></td>
                        <td><?= date('d.m.Y H:i', strtotime($order['date_time'])) ?></td>
                        <td><?= htmlspecialchars($order['cargo_type']) ?></td>
                        <td><?= $order['weight'] ?></td>
                        <td><?= htmlspecialchars($order['dimensions']) ?></td>
                        <td><?= htmlspecialchars($order['from_address']) ?></td>
                        <td><?= htmlspecialchars($order['to_address']) ?></td>
                        <td class="status-<?= $order['status'] ?>">
                            <?= $order['status'] === 'pending' ? 'На рассмотрении' : 
                               ($order['status'] === 'approved' ? 'Одобрена' : 'Отклонена') ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
    
    <a href="/create_order.php" class="btn btn-primary">Создать новую заявку</a>
</div>

<?php include 'templates/footer.php'; ?>