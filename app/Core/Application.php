<?php

namespace App\Core;

class Application {
    public $router;
    public $db;

    public function __construct() {
        session_start();
        $this->db = new Database();
        $this->router = new Router();
    }

    public function run() {
        $this->router->resolve();
    }
}
