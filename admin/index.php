<?php
require_once '../includes/config.php';
require_once '../includes/db.php';
require_once '../includes/functions.php';

if (!isAdmin()) {
    header('Location: /login.php');
    exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order_id = (int)$_POST['order_id'];
    
    if (isset($_POST['approve'])) {
        $stmt = $db->prepare("UPDATE orders SET status = 'approved' WHERE id = ?");
        $stmt->execute([$order_id]);
    } elseif (isset($_POST['reject'])) {
        $stmt = $db->prepare("UPDATE orders SET status = 'rejected' WHERE id = ?");
        $stmt->execute([$order_id]);
    } elseif (isset($_POST['delete'])) {
        $stmt = $db->prepare("DELETE FROM orders WHERE id = ?");
        $stmt->execute([$order_id]);
    }
    
    header('Location: /admin/index.php');
    exit;
}

$orders = $db->query("
    SELECT o.*, u.username, u.full_name, u.phone, u.email 
    FROM orders o
    JOIN users u ON o.user_id = u.id
    ORDER BY o.created_at DESC
")->fetchAll();

include '../templates/admin_header.php';
?>

<div class="container">
    <h2>Панель администратора</h2>
    
    <div class="mb-4">
        <a href="/logout.php" class="btn btn-danger">Выйти</a>
    </div>
    
    <h3>Все заявки</h3>
    
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Пользователь</th>
                    <th>Дата/время</th>
                    <th>Тип груза</th>
                    <th>Вес</th>
                    <th>Откуда</th>
                    <th>Куда</th>
                    <th>Статус</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                <tr>
                    <td><?= $order['id'] ?></td>
                    <td>
                        <?= htmlspecialchars($order['full_name']) ?><br>
                        <?= htmlspecialchars($order['phone']) ?><br>
                        <?= htmlspecialchars($order['email']) ?>
                    </td>
                    <td><?= date('d.m.Y H:i', strtotime($order['date_time'])) ?></td>
                    <td><?= htmlspecialchars($order['cargo_type']) ?></td>
                    <td><?= $order['weight'] ?> кг</td>
                    <td><?= htmlspecialchars($order['from_address']) ?></td>
                    <td><?= htmlspecialchars($order['to_address']) ?></td>
                    <td>
                        <span class="badge bg-<?= 
                            $order['status'] === 'approved' ? 'success' : 
                            ($order['status'] === 'rejected' ? 'danger' : 'warning')
                        ?>">
                            <?= $order['status'] === 'pending' ? 'На рассмотрении' : 
                               ($order['status'] === 'approved' ? 'Одобрена' : 'Отклонена') ?>
                        </span>
                    </td>
                    <td>
                        <form method="POST" class="d-inline">
                            <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                            <?php if ($order['status'] === 'pending'): ?>
                                <button type="submit" name="approve" class="btn btn-sm btn-success">Одобрить</button>
                                <button type="submit" name="reject" class="btn btn-sm btn-danger">Отклонить</button>
                            <?php endif; ?>
                            <button type="submit" name="delete" class="btn btn-sm btn-dark">Удалить</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include '../templates/footer.php'; ?>
