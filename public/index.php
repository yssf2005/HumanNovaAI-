<?php

require_once __DIR__ . '/../config/config.php';

// Autoloader
spl_autoload_register(function ($class) {
    $prefix = 'App\\';
    $base_dir = __DIR__ . '/../app/';
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }
    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';
    if (file_exists($file)) {
        require $file;
    }
});

use App\Core\Application;

$app = new Application();

// Routes -- Will be moved to a routes file later or kept here
$app->router->get('/', [App\Controllers\HomeController::class, 'index']);
$app->router->get('/login', [App\Controllers\AuthController::class, 'login']);
$app->router->post('/login', [App\Controllers\AuthController::class, 'handleLogin']);
$app->router->get('/register', [App\Controllers\AuthController::class, 'register']);
$app->router->post('/register', [App\Controllers\AuthController::class, 'handleRegister']);
$app->router->get('/logout', [App\Controllers\AuthController::class, 'logout']);
// Forgot password
$app->router->get('/forgot', [App\Controllers\AuthController::class, 'forgot']);
$app->router->post('/forgot', [App\Controllers\AuthController::class, 'handleForgot']);
// Reset password (show form + handle submission)
$app->router->get('/reset', [App\Controllers\AuthController::class, 'showReset']);
$app->router->post('/reset', [App\Controllers\AuthController::class, 'handleReset']);

// Dashboard
$app->router->get('/dashboard', [App\Controllers\DashboardController::class, 'index']);

// Ideas
$app->router->get('/ideas', [App\Controllers\IdeaController::class, 'index']);
$app->router->get('/ideas/create', [App\Controllers\IdeaController::class, 'create']);
$app->router->post('/ideas/store', [App\Controllers\IdeaController::class, 'store']);
$app->router->get('/ideas/edit', [App\Controllers\IdeaController::class, 'edit']);
$app->router->post('/ideas/update', [App\Controllers\IdeaController::class, 'update']);
$app->router->get('/ideas/delete', [App\Controllers\IdeaController::class, 'delete']);

// Investments
$app->router->get('/investments', [App\Controllers\InvestmentController::class, 'index']);
$app->router->get('/investments/create', [App\Controllers\InvestmentController::class, 'create']);
$app->router->post('/investments/store', [App\Controllers\InvestmentController::class, 'store']);

// Jobs
$app->router->get('/jobs', [App\Controllers\JobController::class, 'index']);
$app->router->get('/jobs/create', [App\Controllers\JobController::class, 'create']);
$app->router->post('/jobs/store', [App\Controllers\JobController::class, 'store']); // Was verify in plan, assuming store
// My offers (applications) under jobs
$app->router->get('/jobs/my_offers', [App\Controllers\JobController::class, 'my_offers']);

// Applications
$app->router->get('/apply', [App\Controllers\CandidatureController::class, 'apply']);
$app->router->post('/apply/store', [App\Controllers\CandidatureController::class, 'store']);
$app->router->get('/my-applications', [App\Controllers\CandidatureController::class, 'myApplications']);

// Admin Approvals
$app->router->get('/admin/approvals', [App\Controllers\DashboardController::class, 'approvals']);
$app->router->get('/admin/approve', [App\Controllers\DashboardController::class, 'approve']);
$app->router->get('/admin/reject', [App\Controllers\DashboardController::class, 'reject']);

// Events
$app->router->get('/events', [App\Controllers\EventController::class, 'index']);
$app->router->get('/events/create', [App\Controllers\EventController::class, 'create']);
$app->router->get('/events/participate', [App\Controllers\EventController::class, 'participate']);
$app->router->post('/events/store', [App\Controllers\EventController::class, 'store']);
$app->router->get('/events/edit', [App\Controllers\EventController::class, 'edit']);
$app->router->post('/events/update', [App\Controllers\EventController::class, 'update']);
$app->router->get('/events/delete', [App\Controllers\EventController::class, 'delete']);

// Jobs CRUD
$app->router->get('/jobs/edit', [App\Controllers\JobController::class, 'edit']);
$app->router->post('/jobs/update', [App\Controllers\JobController::class, 'update']);
$app->router->get('/jobs/delete', [App\Controllers\JobController::class, 'delete']);

// Blog / Feed
$app->router->get('/feed', [App\Controllers\BlogController::class, 'index']);
$app->router->post('/feed/post', [App\Controllers\BlogController::class, 'store']);
$app->router->post('/feed/store', [App\Controllers\BlogController::class, 'store']);
$app->router->post('/feed/comment', [App\Controllers\BlogController::class, 'comment']);
$app->router->get('/feed/like', [App\Controllers\BlogController::class, 'like']);
$app->router->get('/feed/delete', [App\Controllers\BlogController::class, 'delete']);

// Profile
$app->router->get('/profile', [App\Controllers\ProfileController::class, 'edit']);
$app->router->post('/profile/update', [App\Controllers\ProfileController::class, 'update']);

// Pages
$app->router->get('/about', [App\Controllers\PageController::class, 'about']);
$app->router->get('/contact', [App\Controllers\PageController::class, 'contact']);
$app->router->get('/privacy', [App\Controllers\PageController::class, 'privacy']);
$app->router->get('/pricing', [App\Controllers\PageController::class, 'pricing']);
$app->router->get('/payment', [App\Controllers\PageController::class, 'payment']);

// Chat API
$app->router->post('/api/chat', [App\Controllers\ChatController::class, 'chat']);

// My Items (Dashboard links)
$app->router->get('/my-ideas', [App\Controllers\IdeaController::class, 'myIdeas']);
$app->router->get('/my-investments', [App\Controllers\InvestmentController::class, 'index']);
$app->router->get('/invest', [App\Controllers\InvestmentController::class, 'create']);
$app->router->post('/invest/store', [App\Controllers\InvestmentController::class, 'store']);

// Search
$app->router->get('/search', [App\Controllers\SearchController::class, 'index']);

// Static pages
$app->router->get('/about', [App\Controllers\PageController::class, 'about']);
$app->router->get('/contact', [App\Controllers\PageController::class, 'contact']);
$app->router->get('/privacy', [App\Controllers\PageController::class, 'privacy']);
// keep legacy footer route for compatibility
$app->router->get('/footer', [App\Controllers\PageController::class, 'footer']);

$app->run();
