<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Idea;
use App\Models\JobOffer;
use App\Models\Event;

class SearchController extends Controller {
    public function index() {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/login');
        }
        
        $query = $_GET['q'] ?? '';
        $page = max(1, intval($_GET['page'] ?? 1));
        $perPage = 6;
        $results = [];
        $totalPages = 0;

        if (!empty($query)) {
            $searchModel = new \App\Models\Search();
            $result = $searchModel->getPaginatedSearchAll($query, $page, $perPage);
            $results = $result['results'];
            $totalPages = $result['totalPages'];
        }

        $this->render('search/results', [
            'results' => $results, 
            'query' => $query,
            'page' => $page,
            'totalPages' => $totalPages
        ]);
    }
}
