<?php
require_once 'config.php';

try {
    $db = new PDO(
        "mysql:host=127.127.126.25;dbname=gruzovozoff;charset=utf8mb4",
        'root',
        '', 
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_TIMEOUT => 5 
        ]
    );
    
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    die("Ошибка подключения к базе данных: " . $e->getMessage());
}
try {
    $db->exec("CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) UNIQUE NOT NULL,
        password VARCHAR(255) NOT NULL,
        full_name VARCHAR(100) NOT NULL,
        phone VARCHAR(20) NOT NULL,
        email VARCHAR(120) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

    $db->exec("CREATE TABLE IF NOT EXISTS orders (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        date_time DATETIME NOT NULL,
        weight DECIMAL(10,2) NOT NULL,
        dimensions VARCHAR(50) NOT NULL,
        cargo_type VARCHAR(50) NOT NULL,
        from_address VARCHAR(200) NOT NULL,
        to_address VARCHAR(200) NOT NULL,
        status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
    $stmt = $db->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->execute(['admin']);
    if (!$stmt->fetch()) {
        $stmt = $db->prepare("INSERT INTO users (username, password, full_name, phone, email) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([
            'admin',
            password_hash('gruzovik2024', PASSWORD_DEFAULT),
            'Администратор',
            '+7(999)-999-99-99',
            'admin@gruzovozoff.ru'
        ]);
    }

} catch (PDOException $e) {
    die("Ошибка при создании таблиц: " . $e->getMessage());
}
?>
