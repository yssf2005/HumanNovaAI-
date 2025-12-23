<?php
// Create notifications table using project's DB config
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../app/Core/Database.php';

try {
    $db = new \App\Core\Database();
    $sql = "CREATE TABLE IF NOT EXISTS notifications (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        actor_id INT DEFAULT NULL,
        type VARCHAR(50) DEFAULT NULL,
        message TEXT,
        `link` VARCHAR(255) DEFAULT NULL,
        is_read TINYINT(1) NOT NULL DEFAULT 0,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        INDEX (user_id),
        INDEX (actor_id)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

    $stmt = $db->prepare($sql);
    $stmt->execute();

    echo "notifications table created or already exists.\n";
} catch (Exception $e) {
    echo "Error creating notifications table: " . $e->getMessage() . "\n";
    exit(1);
}
