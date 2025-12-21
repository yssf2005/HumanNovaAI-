<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Investment;
use App\Models\Idea;

class InvestmentController extends Controller {
    public function index() {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/login');
        }
        
        $page = max(1, intval($_GET['page'] ?? 1));
        $perPage = 10;
        
        $investmentModel = new Investment();
        if ($_SESSION['user_role'] == 'admin') {
            $result = $investmentModel->getPaginated($page, $perPage);
        } else {
            $result = $investmentModel->getByUserIdPaginated($_SESSION['user_id'], $page, $perPage);
        }
        
        $this->render('investments/index', [
            'investments' => $result['investments'],
            'page' => $page,
            'totalPages' => $result['totalPages']
        ]);
    }

    public function create() {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/login');
        }
        
        $ideaId = $_GET['idea_id'] ?? null;
        if (!$ideaId) {
            $this->redirect('/ideas');
        }
        
        // Fetch idea details to display
        $ideaModel = new Idea();
        $idea = $ideaModel->find($ideaId);
        
        if (!$idea) {
             $this->redirect('/ideas');
        }

        $this->render('investments/create', ['idea' => $idea]);
    }

    public function store() {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/login');
        }
        
        $ideaId = $_POST['idea_id'] ?? null;
        $amount = $_POST['amount'] ?? 0;
        
        if (!$ideaId || $amount <= 0) {
            // Should handle error better
            $this->redirect('/ideas');
        }
        
        $investmentModel = new Investment();
        if ($investmentModel->create($ideaId, $_SESSION['user_id'], $amount)) {
            // Send receipt to investor
            $ideaModel = new Idea();
            $idea = $ideaModel->find($ideaId);
            $investor = (new \App\Models\User())->findById($_SESSION['user_id']);
            if ($investor && !empty($investor['email'])) {
                $subject = 'Reçu de votre investissement';
                $body = \App\Services\MailTemplates::investmentReceipt($investor['name'] ?? '', $idea['title'] ?? '', (float)$amount, defined('MAIL_FROM_NAME') ? MAIL_FROM_NAME : null);
                \App\Services\Mailer::send($investor['email'], $subject, $body);
            }

            // Notify idea owner
            if ($idea && !empty($idea['user_id'])) {
                $owner = (new \App\Models\User())->findById($idea['user_id']);
                if ($owner && !empty($owner['email'])) {
                    $subject2 = 'Nouvel investissement reçu';
                    $body2 = \App\Services\MailTemplates::investmentReceipt($owner['name'] ?? '', $idea['title'] ?? '', (float)$amount, defined('MAIL_FROM_NAME') ? MAIL_FROM_NAME : null);
                    \App\Services\Mailer::send($owner['email'], $subject2, $body2);
                }
            }

            $this->redirect('/investments');
        } else {
            $this->redirect('/ideas');
        }
    }
}
