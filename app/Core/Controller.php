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
        
        // Determine which layout to use. Priority:
        // 1. If caller passed a $layout param, use it.
        // 2. If view is under the "auth/" folder, use the auth layout.
        // 3. Otherwise use the main layout.
        $layoutToUse = 'main';
        if (isset($layout) && is_string($layout) && !empty($layout)) {
            $layoutToUse = $layout;
        } elseif (strpos($view, 'auth/') === 0) {
            $layoutToUse = 'auth';
        }

        include_once __DIR__ . "/../Views/layouts/{$layoutToUse}.php";
    }
    
    public function redirect($url) {
        header("Location: " . BASE_URL . $url);
        exit;
    }
}
