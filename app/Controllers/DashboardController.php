<?php

namespace App\Controllers;

use App\Core\Controller;

class DashboardController extends Controller {
    public function index() {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/login');
        }

        if ($_SESSION['user_role'] !== 'admin') {
            $this->redirect('/');
        }
        
        $stats = $this->getAdminStats();
        $this->render('dashboard/admin', ['stats' => $stats]);
    }
    
    private function getUserStats($userId) {
        $db = new \App\Core\Database();
        $stats = [];
        
        // Ideas count
        $stmt = $db->prepare("SELECT COUNT(*) as count FROM ideas WHERE user_id = :uid");
        $stmt->execute(['uid' => $userId]);
        $stats['ideas'] = $stmt->fetch(\PDO::FETCH_ASSOC)['count'];
        
        // Investments count
        $stmt = $db->prepare("SELECT COUNT(*) as count FROM investments WHERE user_id = :uid");
        $stmt->execute(['uid' => $userId]);
        $stats['investments'] = $stmt->fetch(\PDO::FETCH_ASSOC)['count'];
        
        // Events participated
        $stmt = $db->prepare("SELECT COUNT(*) as count FROM event_participants WHERE user_id = :uid");
        $stmt->execute(['uid' => $userId]);
        $stats['events'] = $stmt->fetch(\PDO::FETCH_ASSOC)['count'];
        
        // Posts count
        $stmt = $db->prepare("SELECT COUNT(*) as count FROM posts WHERE user_id = :uid");
        $stmt->execute(['uid' => $userId]);
        $stats['posts'] = $stmt->fetch(\PDO::FETCH_ASSOC)['count'];
        
        // Comments count
        $stmt = $db->prepare("SELECT COUNT(*) as count FROM comments WHERE user_id = :uid");
        $stmt->execute(['uid' => $userId]);
        $stats['comments'] = $stmt->fetch(\PDO::FETCH_ASSOC)['count'];
        
        return $stats;
    }
    
    private function getAdminStats() {
        $db = new \App\Core\Database();
        $stats = [];
        
        // Total users
        $stmt = $db->query("SELECT COUNT(*) as count FROM users");
        $stats['users'] = $stmt->fetch(\PDO::FETCH_ASSOC)['count'];
        
        // Total ideas
        $stmt = $db->query("SELECT COUNT(*) as count FROM ideas WHERE status = 'approved'");
        $stats['ideas'] = $stmt->fetch(\PDO::FETCH_ASSOC)['count'];
        
        // Total jobs
        $stmt = $db->query("SELECT COUNT(*) as count FROM job_offers WHERE status = 'approved'");
        $stats['jobs'] = $stmt->fetch(\PDO::FETCH_ASSOC)['count'];
        
        // Total events
        $stmt = $db->query("SELECT COUNT(*) as count FROM events WHERE status = 'approved'");
        $stats['events'] = $stmt->fetch(\PDO::FETCH_ASSOC)['count'];
        
        // Pending approvals (all types)
        $pending = 0;
        $stmt = $db->query("SELECT COUNT(*) as count FROM ideas WHERE status = 'pending'");
        $pending += $stmt->fetch(\PDO::FETCH_ASSOC)['count'];
        $stmt = $db->query("SELECT COUNT(*) as count FROM job_offers WHERE status = 'pending'");
        $pending += $stmt->fetch(\PDO::FETCH_ASSOC)['count'];
        $stmt = $db->query("SELECT COUNT(*) as count FROM events WHERE status = 'pending'");
        $pending += $stmt->fetch(\PDO::FETCH_ASSOC)['count'];
        $stats['pending'] = $pending;
        
        return $stats;
    }

    public function approvals() {
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin') {
            $this->redirect('/dashboard');
        }
        
        $ideaModel = new \App\Models\Idea();
        $jobModel = new \App\Models\JobOffer();
        $eventModel = new \App\Models\Event();

        $data = [
            'ideas' => $ideaModel->getPending(),
            'jobs' => $jobModel->getPending(),
            'events' => $eventModel->getPending()
        ];

        $this->render('dashboard/approvals', $data);
    }
    
    public function approve() {
         if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin') {
            $this->redirect('/dashboard');
        }
        $type = $_GET['type'] ?? '';
        $id = $_GET['id'] ?? '';
        
        if ($type === 'idea') (new \App\Models\Idea())->approve($id);
        if ($type === 'job') (new \App\Models\JobOffer())->approve($id);
        if ($type === 'event') (new \App\Models\Event())->approve($id);
        
        $this->redirect('/admin/approvals');
    }
    
    public function reject() {
         if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin') {
            $this->redirect('/dashboard');
        }
        $type = $_GET['type'] ?? '';
        $id = $_GET['id'] ?? '';
        
        if ($type === 'idea') (new \App\Models\Idea())->reject($id);
        if ($type === 'job') (new \App\Models\JobOffer())->reject($id);
        if ($type === 'event') (new \App\Models\Event())->reject($id);
        
        $this->redirect('/admin/approvals');
    }
}
