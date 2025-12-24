<?php

namespace App\Models;

use App\Core\Model;
use PDO;

class Notification extends Model {
    /**
     * Create a notification for a user
     * @param int $userId Recipient user id
     * @param int|null $actorId Actor who triggered the notification
     * @param string $type Type identifier (e.g., 'like', 'comment')
     * @param string $message Short message to display
     * @param string|null $link Optional link (relative) to the resource
     * @return bool
     */
    public function create($userId, $actorId, $type, $message, $link = null) {
        $sql = "INSERT INTO notifications (user_id, actor_id, type, message, `link`) VALUES (:user_id, :actor_id, :type, :message, :link)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'user_id' => $userId,
            'actor_id' => $actorId,
            'type' => $type,
            'message' => $message,
            'link' => $link
        ]);
    }

    public function markAsRead($id) {
        $sql = "UPDATE notifications SET is_read = 1 WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }

    public function getUnreadCount($userId) {
        $sql = "SELECT COUNT(*) FROM notifications WHERE user_id = :user_id AND is_read = 0";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['user_id' => $userId]);
        return (int) $stmt->fetchColumn();
    }

    public function getForUser($userId, $limit = 50) {
        $sql = "SELECT n.*, u.name as actor_name FROM notifications n LEFT JOIN users u ON n.actor_id = u.id WHERE n.user_id = :user_id ORDER BY n.created_at DESC LIMIT :limit";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
