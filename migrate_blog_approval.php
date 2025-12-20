<?php
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/app/Core/Database.php';

use App\Core\Database;

$db = new Database();

echo "Running blog approval migration...\n";

try {
    $sql = "ALTER TABLE posts ADD COLUMN status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending'";
    $db->query($sql);
    echo "Added status column to posts.\n";
    
    // Update existing posts to approved
    $sql = "UPDATE posts SET status = 'approved'";
    $db->query($sql);
    echo "Updated existing posts to approved.\n";
    
} catch (PDOException $e) {
    echo "Error (might already exist): " . $e->getMessage() . "\n";
}

echo "Blog approval migration complete.\n";
