<?php
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/app/Core/Database.php';

use App\Core\Database;

$db = new Database();

echo "Running approval migration...\n";

$tables = ['ideas', 'job_offers', 'events'];

foreach ($tables as $table) {
    try {
        $sql = "ALTER TABLE $table ADD COLUMN status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending'";
        $db->query($sql);
        echo "Added status to $table.\n";
        
        // Update existing records to approved
        $sql = "UPDATE $table SET status = 'approved'";
        $db->query($sql);
        echo "Updated existing records in $table to approved.\n";
        
    } catch (PDOException $e) {
        echo "Error handling $table (might already exist): " . $e->getMessage() . "\n";
    }
}

echo "Approval migration complete.\n";
