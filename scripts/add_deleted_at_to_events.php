<?php
// Migration: add deleted_at column to events if missing
// Load config and register autoloader like the app's front controller
require_once __DIR__ . '/../config/config.php';

spl_autoload_register(function ($class) {
    $prefix = 'App\\';
    $base_dir = __DIR__ . '/../app/';
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }
    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';
    if (file_exists($file)) {
        require $file;
    }
});

try {
    $db = new \App\Core\Database();
    // Check whether column exists
    $checkSql = "SELECT COLUMN_NAME FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = '" . DB_NAME . "' AND TABLE_NAME = 'events' AND COLUMN_NAME = 'deleted_at'";
    $res = $db->query($checkSql)->fetchAll();
    if (empty($res)) {
        $db->query("ALTER TABLE events ADD COLUMN deleted_at DATETIME DEFAULT NULL");
        echo "OK: added deleted_at column to events\n";
    } else {
        echo "SKIP: deleted_at already exists\n";
    }
} catch (\PDOException $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}
