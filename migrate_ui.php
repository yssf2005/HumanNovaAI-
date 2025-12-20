<?php
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/app/Core/Database.php';

use App\Core\Database;

$db = new Database();

echo "Running UI migration...\n";

// Add image column to posts
try {
    $sql = "ALTER TABLE posts ADD COLUMN image VARCHAR(255) AFTER content";
    $db->query($sql);
    echo "Added image column to posts.\n";
} catch (PDOException $e) {
    echo "Column might exist: " . $e->getMessage() . "\n";
}

echo "UI migration complete.\n";
