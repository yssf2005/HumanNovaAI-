<?php

namespace App\Models;

use App\Core\Model;
use PDO;

class Comment extends Model {
    public function getByPostId($postId) {
        $sql = "SELECT comments.*, users.name as author 
                FROM comments 
                JOIN users ON comments.user_id = users.id 
                WHERE post_id = :post_id 
                ORDER BY created_at ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['post_id' => $postId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($userId, $postId, $content) {
        $sql = "INSERT INTO comments (user_id, post_id, content) VALUES (:user_id, :post_id, :content)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'user_id' => $userId,
            'post_id' => $postId,
            'content' => $content
        ]);
    }
}
