<style>
.feed-container {
    max-width: 600px;
    margin: 0 auto;
    padding: 20px;
}

.create-post-card {
    background: white;
    border-radius: 12px;
    padding: 20px;
    margin-bottom: 20px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.post-card {
    background: white;
    border-radius: 12px;
    margin-bottom: 20px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    overflow: hidden;
}

.post-header {
    display: flex;
    align-items: center;
    padding: 15px;
    gap: 12px;
}

.post-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: linear-gradient(135deg, #e63946, #f77f00);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 700;
    font-size: 1.2rem;
}

.post-author-info h4 {
    margin: 0;
    font-size: 0.95rem;
    font-weight: 600;
}

.post-author-info p {
    margin: 0;
    font-size: 0.8rem;
    color: #999;
}

.post-image {
    width: 100%;
    max-height: 600px;
    object-fit: cover;
    background: #f5f5f5;
    display: flex;
    align-items: center;
    justify-content: center;
}

.post-image img {
    width: 100%;
    height: auto;
    display: block;
}

.post-image.no-image {
    min-height: 200px;
    font-size: 4rem;
}


.post-actions {
    display: flex;
    gap: 15px;
    padding: 12px 15px;
    border-bottom: none;
    box-shadow: 0 4px 6px -4px rgba(0,0,0,0.5);
    position: relative;
    z-index: 1;
}

.post-action-btn {
    background: none;
    border: none;
    cursor: pointer;
    font-size: 1.4rem;
    transition: transform 0.2s;
    color: #aaa;
}

.post-action-btn:hover {
    transform: scale(1.2);
    color: #fff;
}

.post-action-btn.liked {
    color: #e63946;
}

.post-content {
    padding: 15px 15px 12px;
}

.post-likes {
    font-weight: 600;
    font-size: 0.9rem;
    margin-bottom: 8px;
    color: #fff;
}

.post-caption {
    font-size: 0.95rem;
    line-height: 1.5;
    color: #ddd;
}

.post-caption strong {
    font-weight: 600;
    margin-right: 5px;
    color: #fff;
}

.post-comments {
    padding: 0 15px;
    max-height: 200px;
    overflow-y: auto;
}

.comment {
    font-size: 0.9rem;
    margin-bottom: 8px;
    line-height: 1.4;
    color: #aaa;
}

.comment strong {
    font-weight: 600;
    margin-right: 5px;
    color: #fff;
}

.add-comment-form {
    display: flex;
    padding: 12px 15px;
    border-top: none;
    box-shadow: 0 -4px 6px -4px rgba(0,0,0,0.5);
    gap: 10px;
    position: relative;
}

.add-comment-form input {
    flex: 1;
    border: none;
    outline: none;
    font-size: 0.9rem;
}

.add-comment-form button {
    background: none;
    border: none;
    color: var(--primary);
    font-weight: 600;
    cursor: pointer;
    font-size: 0.9rem;
}

.add-comment-form button:hover {
    color: var(--secondary);
}
</style>

<div class="feed-container">
    <!-- Create Post -->
    <div class="create-post-card">
        <form action="<?= BASE_URL ?>/feed/post" method="POST" enctype="multipart/form-data">
            <textarea name="content" rows="3" placeholder="What's on your mind? Share an innovation..." 
                      style="width: 100%; border: none; outline: none; resize: none; font-family: inherit; font-size: 0.95rem;" required></textarea>
            
            <!-- Image Preview -->
            <div id="imagePreviewContainer" style="display: none; margin-top: 15px; position: relative;">
                <img id="imagePreview" src="" alt="Preview" style="width: 100%; max-height: 400px; object-fit: cover; border-radius: 8px;">
                <button type="button" id="removeImage" style="position: absolute; top: 10px; right: 10px; background: rgba(0,0,0,0.7); color: white; border: none; border-radius: 50%; width: 30px; height: 30px; cursor: pointer; font-size: 1.2rem;">×</button>
            </div>
            
            <div style="display: flex; align-items: center; gap: 10px; margin-top: 15px; padding-top: 15px; border-top: none; box-shadow: 0 -4px 6px -4px rgba(0,0,0,0.5);">
                <label class="btn btn-secondary btn-sm" style="cursor: pointer; margin: 0;">
                    📷 Add Photo
                    <input type="file" name="image" accept="image/*" style="display: none;" id="imageInput">
                </label>
                <span id="fileName" style="font-size: 0.85rem; color: #666;"></span>
                <button type="submit" class="btn" style="margin-left: auto;">Post</button>
            </div>
        </form>
    </div>

    <!-- Posts Feed -->
    <?php foreach ($posts as $post): ?>
    <div class="post-card">
        <!-- Post Header -->
        <div class="post-header">
            <div class="post-avatar">
                <?= strtoupper(substr($post['author'] ?? 'U', 0, 1)) ?>
            </div>
            <div class="post-author-info">
                <h4><?= htmlspecialchars($post['author'] ?? 'User') ?></h4>
                <p><?= date('F d, Y', strtotime($post['created_at'])) ?></p>
            </div>
            <?php if (isset($_SESSION['user_id']) && ($post['user_id'] == $_SESSION['user_id'] || $_SESSION['user_role'] == 'admin')): ?>
                <a href="<?= BASE_URL ?>/feed/delete?id=<?= $post['id'] ?>" class="delete-link" style="margin-left: auto; background: none; border: none; font-size: 1.2rem; cursor: pointer; text-decoration: none;">🗑️</a>
            <?php endif; ?>
        </div>

        <!-- Post Image -->
        <?php if (!empty($post['image'])): ?>
        <div class="post-image">
            <img src="<?= BASE_URL ?>/uploads/<?= htmlspecialchars($post['image']) ?>" alt="Post image">
        </div>
        <?php endif; ?>

        <!-- Post Actions -->
        <div class="post-actions">
            <a href="<?= BASE_URL ?>/feed/like?id=<?= $post['id'] ?>" class="post-action-btn <?= ($post['user_liked'] ?? false) ? 'liked' : '' ?>">
                <?= ($post['user_liked'] ?? false) ? '❤️' : '🤍' ?>
            </a>
            <span class="post-action-btn">💬</span>
            <span class="post-action-btn">📤</span>
        </div>

        <!-- Post Content -->
        <div class="post-content">
            <div class="post-likes">
                <?= $post['like_count'] ?? 0 ?> likes
            </div>
            <div class="post-caption">
                <strong><?= htmlspecialchars($post['author'] ?? 'User') ?></strong>
                <?= nl2br(htmlspecialchars($post['content'])) ?>
            </div>
        </div>

        <!-- Comments -->
        <?php if (!empty($post['comments'])): ?>
        <div class="post-comments">
            <?php foreach ($post['comments'] as $comment): ?>
            <div class="comment">
                <strong><?= htmlspecialchars($comment['author']) ?></strong>
                <?= htmlspecialchars($comment['content']) ?>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <!-- Add Comment -->
        <form class="add-comment-form" action="<?= BASE_URL ?>/feed/comment" method="POST">
            <input type="hidden" name="post_id" value="<?= $post['id'] ?>">
            <input type="text" name="content" placeholder="Add a comment...">
            <button type="submit">Post</button>
        </form>
    </div>
    <?php endforeach; ?>

    <?php if (empty($posts)): ?>
    <div class="card" style="text-align: center; padding: 50px;">
        <h3>No posts yet!</h3>
        <p>Be the first to share something with the community.</p>
    </div>
    <?php endif; ?>
    <!-- Pagination -->
    <?php if (isset($totalPages) && $totalPages > 1): ?>
    <div style="display: flex; justify-content: center; gap: 10px; margin-top: 30px; margin-bottom: 50px;">
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="<?= BASE_URL ?>/feed?page=<?= $i ?>" 
               class="btn <?= ($page ?? 1) == $i ? '' : 'btn-secondary' ?> btn-sm">
                <?= $i ?>
            </a>
        <?php endfor; ?>
    </div>
    <?php endif; ?>
</div>

<script>
const imageInput = document.getElementById('imageInput');
const imagePreview = document.getElementById('imagePreview');
const imagePreviewContainer = document.getElementById('imagePreviewContainer');
const fileNameSpan = document.getElementById('fileName');
const removeImageBtn = document.getElementById('removeImage');

imageInput?.addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        // Show filename
        fileNameSpan.textContent = '📎 ' + file.name;
        
        // Show image preview
        const reader = new FileReader();
        reader.onload = function(e) {
            imagePreview.src = e.target.result;
            imagePreviewContainer.style.display = 'block';
        };
        reader.readAsDataURL(file);
    }
});

removeImageBtn?.addEventListener('click', function() {
    imageInput.value = '';
    imagePreview.src = '';
    imagePreviewContainer.style.display = 'none';
    fileNameSpan.textContent = '';
});
</script>
