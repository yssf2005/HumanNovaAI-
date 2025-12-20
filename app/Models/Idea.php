<?php

namespace App\Models;

use App\Core\Model;
use PDO;

class Idea extends Model {
    public function getAll() {
        $sql = "SELECT ideas.*, users.name as author_name FROM ideas JOIN users ON ideas.user_id = users.id WHERE ideas.status = 'approved' ORDER BY created_at DESC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getAllFiltered($search = '', $page = 1, $perPage = 6) {
        $offset = ($page - 1) * $perPage;
        $params = [];
        
        $baseSql = "FROM ideas JOIN users ON ideas.user_id = users.id WHERE ideas.status = 'approved'";
        
        if (!empty($search)) {
            $baseSql .= " AND (ideas.title LIKE :search OR ideas.description LIKE :search)";
            $params['search'] = "%$search%";
        }
        
        // Get total count
        $countStmt = $this->db->prepare("SELECT COUNT(*) " . $baseSql);
        $countStmt->execute($params);
        $total = $countStmt->fetchColumn();
        $totalPages = ceil($total / $perPage);
        
        // Get paginated results
        $sql = "SELECT ideas.*, users.name as author_name " . $baseSql . " ORDER BY created_at DESC LIMIT $perPage OFFSET $offset";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        
        return [
            'ideas' => $stmt->fetchAll(PDO::FETCH_ASSOC),
            'totalPages' => $totalPages
        ];
    }

    public function getPending() {
        $sql = "SELECT ideas.*, users.name as author_name FROM ideas JOIN users ON ideas.user_id = users.id WHERE ideas.status = 'pending' ORDER BY created_at ASC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function approve($id) {
        $sql = "UPDATE ideas SET status = 'approved' WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }

    public function reject($id) {
        $sql = "UPDATE ideas SET status = 'rejected' WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }
    
    public function getByUserIdPaginated($userId, $page = 1, $perPage = 6) {
        $offset = ($page - 1) * $perPage;
        
        // Get total count
        $countSql = "SELECT COUNT(*) FROM ideas WHERE user_id = :user_id";
        $countStmt = $this->db->prepare($countSql);
        $countStmt->execute(['user_id' => $userId]);
        $total = $countStmt->fetchColumn();
        $totalPages = ceil($total / $perPage);
        
        // Get paginated results
        $sql = "SELECT * FROM ideas WHERE user_id = :user_id ORDER BY created_at DESC LIMIT $perPage OFFSET $offset";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['user_id' => $userId]);
        
        return [
            'ideas' => $stmt->fetchAll(PDO::FETCH_ASSOC),
            'totalPages' => $totalPages
        ];
    }

    public function find($id) {
        $sql = "SELECT * FROM ideas WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($title, $description, $userId, $status = 'pending') {
        $sql = "INSERT INTO ideas (title, description, user_id, status) VALUES (:title, :description, :user_id, :status)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'title' => $title,
            'description' => $description,
            'user_id' => $userId,
            'status' => $status
        ]);
    }

    public function update($id, $title, $description) {
        $sql = "UPDATE ideas SET title = :title, description = :description WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'title' => $title,
            'description' => $description,
            'id' => $id
        ]);
    }

    public function delete($id) {
        $sql = "DELETE FROM ideas WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }
}
