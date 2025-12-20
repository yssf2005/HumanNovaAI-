<?php

namespace App\Models;

use App\Core\Model;
use PDO;

class Investment extends Model {
    public function create($ideaId, $userId, $amount) {
        $sql = "INSERT INTO investments (idea_id, user_id, amount) VALUES (:idea_id, :user_id, :amount)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'idea_id' => $ideaId,
            'user_id' => $userId,
            'amount' => $amount
        ]);
    }

    public function getPaginated($page = 1, $perPage = 10) {
        $offset = ($page - 1) * $perPage;
        
        $countSql = "SELECT COUNT(*) FROM investments";
        $total = $this->db->query($countSql)->fetchColumn();
        $totalPages = ceil($total / $perPage);
        
        $sql = "SELECT investments.*, ideas.title as idea_title, users.name as investor_name 
                FROM investments 
                JOIN ideas ON investments.idea_id = ideas.id 
                JOIN users ON investments.user_id = users.id 
                ORDER BY investments.created_at DESC
                LIMIT $perPage OFFSET $offset";
        $stmt = $this->db->query($sql);
        
        return [
            'investments' => $stmt->fetchAll(PDO::FETCH_ASSOC),
            'totalPages' => $totalPages
        ];
    }

    public function getByUserIdPaginated($userId, $page = 1, $perPage = 10) {
        $offset = ($page - 1) * $perPage;
        
        $countSql = "SELECT COUNT(*) FROM investments WHERE user_id = :user_id";
        $stmt = $this->db->prepare($countSql);
        $stmt->execute(['user_id' => $userId]);
        $total = $stmt->fetchColumn();
        $totalPages = ceil($total / $perPage);
        
        $sql = "SELECT investments.*, ideas.title as idea_title 
                FROM investments 
                JOIN ideas ON investments.idea_id = ideas.id 
                WHERE investments.user_id = :user_id 
                ORDER BY investments.created_at DESC
                LIMIT $perPage OFFSET $offset";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['user_id' => $userId]);
        
        return [
            'investments' => $stmt->fetchAll(PDO::FETCH_ASSOC),
            'totalPages' => $totalPages
        ];
    }
}
