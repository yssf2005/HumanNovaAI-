<?php

namespace App\Models;

use App\Core\Model;
use PDO;

class Post extends Model {
    public function getPaginated($page = 1, $perPage = 10) {
        $offset = ($page - 1) * $perPage;
        
        // Get total count
        $countSql = "SELECT COUNT(*) FROM posts WHERE status = 'approved'";
        $total = $this->db->query($countSql)->fetchColumn();
        $totalPages = ceil($total / $perPage);
        
        // Get paginated results
        $sql = "SELECT posts.*, users.name as author, 
                (SELECT COUNT(*) FROM likes WHERE likes.post_id = posts.id) as like_count
                FROM posts 
                JOIN users ON posts.user_id = users.id 
                WHERE posts.status = 'approved'
                ORDER BY created_at DESC
                LIMIT $perPage OFFSET $offset";
        $stmt = $this->db->query($sql);
        
        return [
            'posts' => $stmt->fetchAll(PDO::FETCH_ASSOC),
            'totalPages' => $totalPages
        ];
    }
    
    public function getPending() {
        $sql = "SELECT posts.*, users.name as author
                FROM posts 
                JOIN users ON posts.user_id = users.id 
                WHERE posts.status = 'pending'
                ORDER BY created_at ASC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function approve($id) {
        $sql = "UPDATE posts SET status = 'approved' WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }
    
    public function reject($id) {
        $sql = "UPDATE posts SET status = 'rejected' WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }

    public function find($id) {
        $sql = "SELECT * FROM posts WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function delete($id) {
        $sql = "DELETE FROM posts WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }

    public function create($userId, $content, $status = 'pending', $image = null) {
        $sql = "INSERT INTO posts (user_id, content, status, image) VALUES (:user_id, :content, :status, :image)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'user_id' => $userId,
            'content' => $content,
            'status' => $status,
            'image' => $image
        ]);
    }
}
