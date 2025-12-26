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
        
        if ($type === 'idea') {
            $ideaModel = new \App\Models\Idea();
            if ($ideaModel->approve($id)) {
                $idea = $ideaModel->find($id);
                if ($idea && !empty($idea['user_id'])) {
                    $user = (new \App\Models\User())->findById($idea['user_id']);
                    if ($user && !empty($user['email'])) {
                        $subject = 'Votre idée a été approuvée';
                        $body = \App\Services\MailTemplates::ideaApproved($user['name'] ?? '', $idea['title'] ?? '', defined('MAIL_FROM_NAME') ? MAIL_FROM_NAME : null);
                        $headers = "MIME-Version: 1.0\r\n";
                        $headers .= "Content-type: text/html; charset=UTF-8\r\n";
                        $from = defined('MAIL_FROM_ADDRESS') ? MAIL_FROM_ADDRESS : 'no-reply@example.com';
                        $fromName = defined('MAIL_FROM_NAME') ? MAIL_FROM_NAME : 'No Reply';
                        $headers .= "From: {$fromName} <{$from}>\r\n";
                        @mail($user['email'], $subject, $body, $headers);
                    }
                }
            }
        }

        if ($type === 'job') {
            $jobModel = new \App\Models\JobOffer();
            if ($jobModel->approve($id)) {
                $job = $jobModel->find($id);
                if ($job && !empty($job['user_id'])) {
                    $user = (new \App\Models\User())->findById($job['user_id']);
                    if ($user && !empty($user['email'])) {
                        $subject = 'Votre offre d\'emploi a été approuvée';
                        $body = \App\Services\MailTemplates::jobApproved($user['name'] ?? '', $job['title'] ?? '', defined('MAIL_FROM_NAME') ? MAIL_FROM_NAME : null);
                        $headers = "MIME-Version: 1.0\r\n";
                        $headers .= "Content-type: text/html; charset=UTF-8\r\n";
                        $from = defined('MAIL_FROM_ADDRESS') ? MAIL_FROM_ADDRESS : 'no-reply@example.com';
                        $fromName = defined('MAIL_FROM_NAME') ? MAIL_FROM_NAME : 'No Reply';
                        $headers .= "From: {$fromName} <{$from}>\r\n";
                        @mail($user['email'], $subject, $body, $headers);
                    }
                }
            }
        }

        if ($type === 'event') {
            $eventModel = new \App\Models\Event();
            if ($eventModel->approve($id)) {
                $event = $eventModel->find($id);
                if ($event && !empty($event['user_id'])) {
                    $user = (new \App\Models\User())->findById($event['user_id']);
                    if ($user && !empty($user['email'])) {
                        $subject = 'Votre événement a été approuvé';
                        $body = \App\Services\MailTemplates::eventApproved($user['name'] ?? '', $event['title'] ?? '', defined('MAIL_FROM_NAME') ? MAIL_FROM_NAME : null);
                        $headers = "MIME-Version: 1.0\r\n";
                        $headers .= "Content-type: text/html; charset=UTF-8\r\n";
                        $from = defined('MAIL_FROM_ADDRESS') ? MAIL_FROM_ADDRESS : 'no-reply@example.com';
                        $fromName = defined('MAIL_FROM_NAME') ? MAIL_FROM_NAME : 'No Reply';
                        $headers .= "From: {$fromName} <{$from}>\r\n";
                        @mail($user['email'], $subject, $body, $headers);
                    }
                }
            }
        }
        
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
