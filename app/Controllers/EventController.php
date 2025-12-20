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
        $result = $eventModel->getAllFiltered($search, $page, $perPage);
        $events = $result['events'];
        
        // Check participation status
        foreach ($events as &$event) {
            $event['is_participating'] = $eventModel->isParticipating($_SESSION['user_id'], $event['id']);
        }

        $this->render('events/index', [
            'events' => $events,
            'search' => $search,
            'page' => $page,
            'totalPages' => $result['totalPages']
        ]);
    }

    public function create() {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/login');
        }
        $this->render('events/create');
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
             $this->render('events/create', ['success' => 'Event submitted for approval.']);
        } else {
            $this->render('events/create', ['error' => 'Error creating event']);
        }
    }
    
    public function participate() {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/login');
        }
        $eventId = $_GET['id'] ?? null;
        if ($eventId) {
            $eventModel = new Event();
            $eventModel->participate($_SESSION['user_id'], $eventId);
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
