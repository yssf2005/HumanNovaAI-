<?php

namespace App\Controllers;

use App\Core\Controller;

class PageController extends Controller {
    public function footer() {
        $this->render('pages/footer');
    }

    public function about() {
        $this->render('pages/about');
    }

    public function contact() {
        $this->render('pages/contact');
    }

    public function privacy() {
        $this->render('pages/privacy');
    }

    public function pricing() {
        $this->render('pages/pricing');
    }

    public function payment() {
        $this->render('pages/payment');
    }
}
