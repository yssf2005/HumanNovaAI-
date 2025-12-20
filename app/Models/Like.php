<?php

namespace App\Models;

use App\Core\Model;
use PDO;

class Like extends Model {
    public function toggle($userId, $postId) {
        // Check if exists
        $sql = "SELECT * FROM likes WHERE user_id = :user_id AND post_id = :post_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['user_id' => $userId, 'post_id' => $postId]);
        
        if ($stmt->rowCount() > 0) {
            // Unlike
            $sql = "DELETE FROM likes WHERE user_id = :user_id AND post_id = :post_id";
            $stmt = $this->db->prepare($sql);
            $stmt->execute(['user_id' => $userId, 'post_id' => $postId]);
            return false; // unliked
        } else {
            // Like
            $sql = "INSERT INTO likes (user_id, post_id) VALUES (:user_id, :post_id)";
            $stmt = $this->db->prepare($sql);
            $stmt->execute(['user_id' => $userId, 'post_id' => $postId]);
            return true; // liked
        }
    }
}
