<?php

namespace App\Models;

use App\Core\Model;
use PDO;

class Search extends Model {
    public function getPaginatedSearchAll($query, $page = 1, $perPage = 10) {
        $term = "%$query%";
        $offset = ($page - 1) * $perPage;
        
        // This is a bit tricky because we're merging results from multiple tables.
        // For true pagination, we should use a UNION.
        
        $sql = "(SELECT id, title, description, 'Idea' as type, created_at FROM ideas WHERE (title LIKE :term OR description LIKE :term) AND status = 'approved')
                UNION
                (SELECT id, title, description, 'Job' as type, created_at FROM job_offers WHERE (title LIKE :term OR description LIKE :term) AND status = 'approved')
                UNION
                (SELECT id, title, description, 'Event' as type, created_at FROM events WHERE (title LIKE :term OR description LIKE :term) AND status = 'approved')
                ORDER BY created_at DESC";
        
        // Count total
        $countSql = "SELECT COUNT(*) FROM ($sql) as combined";
        $countStmt = $this->db->prepare($countSql);
        $countStmt->execute(['term' => $term]);
        $total = $countStmt->fetchColumn();
        $totalPages = ceil($total / $perPage);
        
        // Get paginated results
        $pagedSql = $sql . " LIMIT $perPage OFFSET $offset";
        $stmt = $this->db->prepare($pagedSql);
        $stmt->execute(['term' => $term]);
        
        return [
            'results' => $stmt->fetchAll(PDO::FETCH_ASSOC),
            'totalPages' => $totalPages
        ];
    }
}
