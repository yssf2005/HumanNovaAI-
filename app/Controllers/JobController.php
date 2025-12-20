<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\JobOffer;

class JobController extends Controller {
    public function index() {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/login');
        }
        
        $search = $_GET['search'] ?? '';
        $category = $_GET['category'] ?? '';
        $page = max(1, intval($_GET['page'] ?? 1));
        $perPage = 6;
        
        $jobModel = new JobOffer();
        $result = $jobModel->getAllFiltered($search, $category, $page, $perPage);
        
        $this->render('jobs/index', [
            'jobs' => $result['jobs'],
            'search' => $search,
            'category' => $category,
            'page' => $page,
            'totalPages' => $result['totalPages']
        ]);
    }

    public function create() {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/login');
        }
        $this->render('jobs/create');
    }

    public function store() {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/login');
        }
        $title = $_POST['title'] ?? '';
        $category = $_POST['category'] ?? 'General';
        $company = $_POST['company'] ?? '';
        $description = $_POST['description'] ?? '';

        $jobModel = new JobOffer();
        
        // All jobs require approval, even from admins
        if ($jobModel->create($title, $category, $description, $company, 'pending')) {
             $this->render('jobs/create', ['success' => 'Job submitted for approval.']);
        } else {
            $this->render('jobs/create', ['error' => 'Error creating job']);
        }
    }
    public function edit() {
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin') {
            $this->redirect('/jobs');
        }
        $id = $_GET['id'] ?? null;
        if (!$id) {
            $this->redirect('/jobs');
        }

        $jobModel = new JobOffer();
        $job = $jobModel->find($id);
        
        if (!$job) {
             $this->redirect('/jobs');
        }

        $this->render('jobs/edit', ['job' => $job]);
    }

    public function update() {
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin') {
            $this->redirect('/jobs');
        }
        $id = $_POST['id'] ?? null;
        $title = $_POST['title'] ?? '';
        $category = $_POST['category'] ?? '';
        $company = $_POST['company'] ?? '';
        $description = $_POST['description'] ?? '';

        if ($id) {
            $jobModel = new JobOffer();
            $jobModel->update($id, $title, $category, $description, $company);
        }
        $this->redirect('/jobs');
    }

    public function delete() {
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin') {
            $this->redirect('/jobs');
        }
        $id = $_GET['id'] ?? null;
        if ($id) {
            $jobModel = new JobOffer();
            $jobModel->delete($id);
        }
        $this->redirect('/jobs');
    }
}
