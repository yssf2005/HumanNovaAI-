<?php

namespace App\Models;

use App\Core\Model;
use PDO;

class JobOffer extends Model {
    public function getAll() {
        $sql = "SELECT * FROM job_offers WHERE status = 'approved' ORDER BY created_at DESC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getAllFiltered($search = '', $category = '', $page = 1, $perPage = 6) {
        $offset = ($page - 1) * $perPage;
        $params = [];
        
        $sql = "SELECT * FROM job_offers WHERE status = 'approved'";
        $countSql = "SELECT COUNT(*) FROM job_offers WHERE status = 'approved'";
        
        if (!empty($search)) {
            $sql .= " AND (title LIKE :search OR description LIKE :search OR company LIKE :search)";
            $countSql .= " AND (title LIKE :search OR description LIKE :search OR company LIKE :search)";
            $params['search'] = "%$search%";
        }
        
        if (!empty($category)) {
            $sql .= " AND category = :category";
            $countSql .= " AND category = :category";
            $params['category'] = $category;
        }
        
        // Get total count
        $countStmt = $this->db->prepare($countSql);
        $countStmt->execute($params);
        $total = $countStmt->fetchColumn();
        $totalPages = ceil($total / $perPage);
        
        // Get paginated results
        $sql .= " ORDER BY created_at DESC LIMIT $perPage OFFSET $offset";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        
        return [
            'jobs' => $stmt->fetchAll(PDO::FETCH_ASSOC),
            'totalPages' => $totalPages,
            'total' => $total
        ];
    }

    public function getPending() {
        $sql = "SELECT * FROM job_offers WHERE status = 'pending' ORDER BY created_at ASC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function approve($id) {
        $sql = "UPDATE job_offers SET status = 'approved' WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }

    public function reject($id) {
        $sql = "UPDATE job_offers SET status = 'rejected' WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }

    public function create($title, $category, $description, $company, $status = 'pending') {
        $sql = "INSERT INTO job_offers (title, category, description, company, status) VALUES (:title, :category, :description, :company, :status)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'title' => $title,
            'category' => $category,
            'description' => $description,
            'company' => $company,
            'status' => $status
        ]);
    }
    
    public function find($id) {
        $sql = "SELECT * FROM job_offers WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $title, $category, $description, $company) {
        $sql = "UPDATE job_offers SET title = :title, category = :category, description = :description, company = :company WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'id' => $id,
            'title' => $title,
            'category' => $category,
            'description' => $description,
            'company' => $company
        ]);
    }

    public function delete($id) {
        $sql = "DELETE FROM job_offers WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }
}
