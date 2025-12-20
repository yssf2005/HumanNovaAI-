<?php

namespace App\Models;

use App\Core\Model;
use PDO;

class Event extends Model {
    public function getAll() {
        $sql = "SELECT * FROM events WHERE status = 'approved' ORDER BY date ASC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getAllFiltered($search = '', $page = 1, $perPage = 6) {
        $offset = ($page - 1) * $perPage;
        $params = [];
        
        $baseSql = "FROM events WHERE status = 'approved'";
        
        if (!empty($search)) {
            $baseSql .= " AND (title LIKE :search OR description LIKE :search OR location LIKE :search)";
            $params['search'] = "%$search%";
        }
        
        // Get total count
        $countStmt = $this->db->prepare("SELECT COUNT(*) " . $baseSql);
        $countStmt->execute($params);
        $total = $countStmt->fetchColumn();
        $totalPages = ceil($total / $perPage);
        
        // Get paginated results
        $sql = "SELECT * " . $baseSql . " ORDER BY date ASC LIMIT $perPage OFFSET $offset";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        
        return [
            'events' => $stmt->fetchAll(PDO::FETCH_ASSOC),
            'totalPages' => $totalPages
        ];
    }

    public function getPending() {
        $sql = "SELECT * FROM events WHERE status = 'pending' ORDER BY date ASC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function approve($id) {
        $sql = "UPDATE events SET status = 'approved' WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }

    public function reject($id) {
        $sql = "UPDATE events SET status = 'rejected' WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }

    public function create($title, $description, $date, $location, $status = 'pending') {
        $sql = "INSERT INTO events (title, description, date, location, status) VALUES (:title, :description, :date, :location, :status)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'title' => $title,
            'description' => $description,
            'date' => $date,
            'location' => $location,
            'status' => $status
        ]);
    }

    public function participate($userId, $eventId) {
        $sql = "INSERT INTO event_participants (user_id, event_id) VALUES (:user_id, :event_id)";
        $stmt = $this->db->prepare($sql);
        try {
            return $stmt->execute(['user_id' => $userId, 'event_id' => $eventId]);
        } catch (\PDOException $e) {
            return false;
        }
    }

    public function isParticipating($userId, $eventId) {
        $sql = "SELECT id FROM event_participants WHERE user_id = :user_id AND event_id = :event_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['user_id' => $userId, 'event_id' => $eventId]);
        return $stmt->fetch() !== false;
    }

    public function find($id) {
        $sql = "SELECT * FROM events WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $title, $description, $date, $location) {
        $sql = "UPDATE events SET title = :title, description = :description, date = :date, location = :location WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'id' => $id,
            'title' => $title,
            'description' => $description,
            'date' => $date,
            'location' => $location
        ]);
    }

    public function delete($id) {
         // Should delete participants too but foreign key cascade handles it usually.
        $sql = "DELETE FROM events WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }
}
