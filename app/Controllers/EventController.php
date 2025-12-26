<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Event;

class EventController extends Controller {
    public function index() {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/login');
        }
        
        $search = $_GET['search'] ?? '';
        $page = max(1, intval($_GET['page'] ?? 1));
        $perPage = 6;

        $eventModel = new Event();

        // Upcoming events (soonest first)
        $upcoming = $eventModel->getUpcoming(6);

        // Recent events (most recently created)
        $recent = $eventModel->getRecent(6);

        // Past events (paginated)
        $pastPage = max(1, intval($_GET['past_page'] ?? 1));
        $pastPerPage = 8;
        $pastResult = $eventModel->getPastPaginated($pastPage, $pastPerPage, $search);
        $pastEvents = $pastResult['events'];

        // For participation flag on upcoming events
        foreach ($upcoming as &$event) {
            $event['is_participating'] = $eventModel->isParticipating($_SESSION['user_id'], $event['id']);
        }

        $this->render('events/index', [
            'upcoming' => $upcoming,
            'recent' => $recent,
            'pastEvents' => $pastEvents,
            'pastPage' => $pastPage,
            'pastTotalPages' => $pastResult['totalPages'],
            'search' => $search
        ]);
    }

    public function create() {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/login');
        }
        // Standalone create page removed; redirect to events index (use modal on index)
        $this->redirect('/events');
    }

    public function store() {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/login');
        }
        $title = $_POST['title'] ?? '';
        $description = $_POST['description'] ?? '';
        $date = $_POST['date'] ?? '';
        $location = $_POST['location'] ?? '';
        
        $eventModel = new Event();
        
        // All events require approval, even from admins
        if ($eventModel->create($title, $description, $date, $location, 'pending')) {
             $_SESSION['notification'] = ['type' => 'success', 'title' => 'Event submitted', 'message' => 'Event submitted for approval.'];
             $this->redirect('/events');
        } else {
            $_SESSION['notification'] = ['type' => 'error', 'title' => 'Error', 'message' => 'Error creating event'];
            $this->redirect('/events');
        }
    }
    
    public function participate() {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/login');
        }
        $eventId = $_GET['id'] ?? null;
        if ($eventId) {
            $eventModel = new Event();
            $ok = $eventModel->participate($_SESSION['user_id'], $eventId);

            // Send confirmation email to participant
            if ($ok) {
                $user = (new \App\Models\User())->findById($_SESSION['user_id']);
                $event = $eventModel->find($eventId);
                if ($user && !empty($user['email']) && $event) {
                    $subject = 'Inscription confirmée — ' . ($event['title'] ?? 'Événement');
                    $dateStr = isset($event['date']) ? date('F d, Y - H:i', strtotime($event['date'])) : '';
                    $body = \App\Services\MailTemplates::eventParticipationReceipt($user['name'] ?? '', $event['title'] ?? '', $dateStr, $event['location'] ?? '', defined('MAIL_FROM_NAME') ? MAIL_FROM_NAME : null);
                    if (class_exists('Mailer')) {
                        \Mailer::send($user['email'], $subject, $body);
                    }
                }
            }
        }
        $this->redirect('/events');
    }
    
    public function edit() {
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin') {
            $this->redirect('/events');
        }
        $id = $_GET['id'] ?? null;
        if (!$id) {
            $this->redirect('/events');
        }

        $eventModel = new Event();
        $event = $eventModel->find($id);
        
        if (!$event) {
             $this->redirect('/events');
        }

        $this->render('events/edit', ['event' => $event]);
    }

    public function update() {
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin') {
            $this->redirect('/events');
        }
        $id = $_POST['id'] ?? null;
        $title = $_POST['title'] ?? '';
        $description = $_POST['description'] ?? '';
        $date = $_POST['date'] ?? '';
        $location = $_POST['location'] ?? '';

        if ($id) {
            $eventModel = new Event();
            $eventModel->update($id, $title, $description, $date, $location);
        }
        $this->redirect('/events');
    }

    public function delete() {
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin') {
            $this->redirect('/events');
        }
        $id = $_GET['id'] ?? null;
        if ($id) {
            $eventModel = new Event();
            $eventModel->delete($id);
        }
        $this->redirect('/events');
    }
}
