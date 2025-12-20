<?php

namespace App\Models;

use App\Core\Model;
use PDO;

class Candidature extends Model {
    public function create($userId, $jobOfferId, $message) {
        $sql = "INSERT INTO candidatures (user_id, job_offer_id, message) VALUES (:user_id, :job_offer_id, :message)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'user_id' => $userId,
            'job_offer_id' => $jobOfferId,
            'message' => $message
        ]);
    }

    public function getByJobId($jobId) {
        $sql = "SELECT candidatures.*, users.name, users.email 
                FROM candidatures 
                JOIN users ON candidatures.user_id = users.id 
                WHERE job_offer_id = :job_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['job_id' => $jobId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getByUserIdPaginated($userId, $page = 1, $perPage = 6) {
        $offset = ($page - 1) * $perPage;
        
        $countSql = "SELECT COUNT(*) FROM candidatures WHERE user_id = :user_id";
        $stmt = $this->db->prepare($countSql);
        $stmt->execute(['user_id' => $userId]);
        $total = $stmt->fetchColumn();
        $totalPages = ceil($total / $perPage);
        
        $sql = "SELECT candidatures.*, candidatures.message as cover_letter, 
                       job_offers.title as job_title, job_offers.company
                FROM candidatures 
                JOIN job_offers ON candidatures.job_offer_id = job_offers.id 
                WHERE candidatures.user_id = :user_id
                ORDER BY candidatures.created_at DESC
                LIMIT $perPage OFFSET $offset";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['user_id' => $userId]);
        
        return [
            'candidatures' => $stmt->fetchAll(PDO::FETCH_ASSOC),
            'totalPages' => $totalPages
        ];
    }
}
