<?php

namespace App\Core;

class Controller {
    public function render($view, $params = []) {
        // Extract params to variables
        foreach ($params as $key => $value) {
            $$key = $value;
        }
        
        // Start buffering
        ob_start();
        include_once __DIR__ . "/../Views/$view.php";
        $content = ob_get_clean();
        
        // Check if we should use the main layout
        // For partials or AJAX, might want different behavior
        include_once __DIR__ . "/../Views/layouts/main.php";
    }
    
    public function redirect($url) {
        header("Location: " . BASE_URL . $url);
        exit;
    }
}
