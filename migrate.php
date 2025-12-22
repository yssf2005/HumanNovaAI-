<?php
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/app/Core/Database.php';

use App\Core\Database;

$db = new Database();

echo "Running migration...\n";

// Add category to job_offers
try {
    $sql = "ALTER TABLE job_offers ADD COLUMN category VARCHAR(100) AFTER title";
    $db->query($sql);
    echo "Added category column to job_offers.\n";
} catch (PDOException $e) {
    echo "Column category likely exists or error: " . $e->getMessage() . "\n";
}

// Create event_participants table
try {
    $sql = "CREATE TABLE IF NOT EXISTS event_participants (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT,
        event_id INT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
        FOREIGN KEY (event_id) REFERENCES events(id) ON DELETE CASCADE
    )";
    $db->query($sql);
    echo "Created event_participants table.\n";
} catch (PDOException $e) {
    echo "Error creating table: " . $e->getMessage() . "\n";
}

    // Add phone column to users if not present
    try {
        $sql = "ALTER TABLE users ADD COLUMN phone VARCHAR(50) DEFAULT NULL AFTER email";
        $db->query($sql);
        echo "Added phone column to users table.\n";
    } catch (PDOException $e) {
        echo "Phone column likely exists or error: " . $e->getMessage() . "\n";
    }

echo "Migration complete.\n";
