<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../app/Core/Database.php';

header('Content-Type: application/json; charset=utf-8');

session_start();
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Not authenticated']);
    exit;
}

try {
    $db = new \App\Core\Database();
    $sql = "UPDATE notifications SET is_read = 1 WHERE user_id = :user_id AND is_read = 0";
    $stmt = $db->prepare($sql);
    $stmt->execute(['user_id' => $_SESSION['user_id']]);
    echo json_encode(['success' => true]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
