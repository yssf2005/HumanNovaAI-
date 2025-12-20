<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Candidature;
use App\Models\JobOffer;

class CandidatureController extends Controller {
    public function apply() {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/login');
        }
        $jobId = $_GET['job_id'] ?? null;
        if (!$jobId) {
            $this->redirect('/jobs');
        }
        
        $jobModel = new JobOffer();
        $job = $jobModel->find($jobId);

        $this->render('candidatures/apply', ['job' => $job]);
    }

    public function store() {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/login');
        }
        $jobId = $_POST['job_id'] ?? null;
        $message = $_POST['message'] ?? '';
        
        // Handle file upload (CV) - Simplified for now (just message) or placeholder
        // In real app, we'd handle $_FILES['cv']
        
        $candidatureModel = new Candidature();
        if ($candidatureModel->create($_SESSION['user_id'], $jobId, $message)) {
            // Ideally show success message
            $this->redirect('/jobs');
        } else {
             $this->redirect('/jobs');
        }
    }
    
    public function myApplications() {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/login');
        }
        
        $page = max(1, intval($_GET['page'] ?? 1));
        $perPage = 6;
        
        $candidatureModel = new Candidature();
        $result = $candidatureModel->getByUserIdPaginated($_SESSION['user_id'], $page, $perPage);
        
        $this->render('candidatures/index', [
            'candidatures' => $result['candidatures'],
            'page' => $page,
            'totalPages' => $result['totalPages']
        ]);
    }
}
