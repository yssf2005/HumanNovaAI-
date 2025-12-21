<?php
// Create password_resets table using project's DB config
require_once __DIR__ . '/../config/config.php';

// Load Database class if available
require_once __DIR__ . '/../app/Core/Database.php';

try {
    $db = new \App\Core\Database();
    $sql = "CREATE TABLE IF NOT EXISTS password_resets (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        selector CHAR(24) NOT NULL,
        validator_hash CHAR(64) NOT NULL,
        expires_at DATETIME NOT NULL,
        used TINYINT(1) NOT NULL DEFAULT 0,
        ip_address VARCHAR(45),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        INDEX (selector),
        INDEX (user_id)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

    $stmt = $db->prepare($sql);
    $stmt->execute();

    echo "password_resets table created or already exists.\n";
} catch (Exception $e) {
    echo "Error creating table: " . $e->getMessage() . "\n";
    exit(1);
}
