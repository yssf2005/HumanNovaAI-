<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Notification;
use App\Models\User;

class BlogController extends Controller {
    public function index() {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/login');
        }
        
        $page = max(1, intval($_GET['page'] ?? 1));
        $perPage = 5;
        
        $postModel = new Post();
        $result = $postModel->getPaginated($page, $perPage);
        $posts = $result['posts'];
        $totalPages = $result['totalPages'];
        
        $commentModel = new Comment();
        
        // Attach comments to posts
        foreach ($posts as &$post) {
            $post['comments'] = $commentModel->getByPostId($post['id']);
        }
        
        $this->render('blog/index', [
            'posts' => $posts,
            'page' => $page,
            'totalPages' => $totalPages
        ]);
    }

    public function store() {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/login');
        }
        $content = $_POST['content'] ?? '';
        $imageName = null;
        
        // Handle image upload
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . '/../../public/uploads/';
            $fileExtension = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
            
            if (in_array($fileExtension, $allowedExtensions)) {
                $imageName = uniqid('post_') . '.' . $fileExtension;
                $uploadPath = $uploadDir . $imageName;
                
                if (!move_uploaded_file($_FILES['image']['tmp_name'], $uploadPath)) {
                    $imageName = null; // Upload failed
                }
            }
        }
        
        if (!empty($content)) {
            $postModel = new Post();
            // Blog posts are always approved (no moderation needed)
            $postModel->create($_SESSION['user_id'], $content, 'approved', $imageName);
        }
        $this->redirect('/feed');
    }

    public function comment() {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/login');
        }
        $postId = $_POST['post_id'] ?? null;
        $content = $_POST['content'] ?? '';
        
        if ($postId && !empty($content)) {
            $commentModel = new Comment();
            $created = $commentModel->create($_SESSION['user_id'], $postId, $content);

            // create notification for post owner (don't notify if user comments on their own post)
            $postModel = new Post();
            $post = $postModel->find($postId);
            if ($created && $post && isset($post['user_id']) && $post['user_id'] != $_SESSION['user_id']) {
                $userModel = new User();
                $actor = $userModel->findById($_SESSION['user_id']);
                $actorName = $actor ? $actor['name'] : 'Someone';
                $notif = new Notification();
                $message = $actorName . ' commented on your post: ' . (strlen($content) > 100 ? substr($content,0,100) . '...' : $content);
                $notif->create($post['user_id'], $_SESSION['user_id'], 'comment', $message, '/feed#post-' . $postId);
            }
        }
        $this->redirect('/feed');
    }

    public function like() {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/login');
        }
        $postId = $_GET['id'] ?? null;
        if ($postId) {
            $likeModel = new Like();
            $liked = $likeModel->toggle($_SESSION['user_id'], $postId);

            // if liked (not unliked), create a notification for post owner
            if ($liked) {
                $postModel = new Post();
                $post = $postModel->find($postId);
                if ($post && isset($post['user_id']) && $post['user_id'] != $_SESSION['user_id']) {
                    $userModel = new User();
                    $actor = $userModel->findById($_SESSION['user_id']);
                    $actorName = $actor ? $actor['name'] : 'Someone';
                    $notif = new Notification();
                    $message = $actorName . ' liked your post';
                    $notif->create($post['user_id'], $_SESSION['user_id'], 'like', $message, '/feed#post-' . $postId);
                }
            }
        }
        $this->redirect('/feed');
    }

    public function delete() {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/login');
        }
        $id = $_GET['id'] ?? null;
        if ($id) {
            $postModel = new Post();
            $post = $postModel->find($id);
            
            if ($post && ($_SESSION['user_id'] == $post['user_id'] || $_SESSION['user_role'] == 'admin')) {
                // Delete associated image if exists
                if (!empty($post['image'])) {
                    $imagePath = __DIR__ . '/../../public/uploads/' . $post['image'];
                    if (file_exists($imagePath)) {
                        unlink($imagePath);
                    }
                }
                
                $postModel->delete($id);
                $_SESSION['notification'] = [
                    'type' => 'success',
                    'title' => 'Post Deleted',
                    'message' => 'Your post has been removed successfully.'
                ];
            }
        }
        $this->redirect('/feed');
    }
}
