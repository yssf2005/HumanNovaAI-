<div class="section-header">
    <h2>Edit Idea</h2>
    <a href="<?= BASE_URL ?>/ideas" class="btn btn-secondary">← Back to Ideas</a>
</div>

<div class="card" style="max-width: 600px;">
    <form action="<?= BASE_URL ?>/ideas/update" method="POST">
        <input type="hidden" name="id" value="<?= $idea['id'] ?>">
        <div class="form-group">
            <label for="title">Idea Title</label>
            <input type="text" id="title" name="title" value="<?= htmlspecialchars($idea['title']) ?>" required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea id="description" name="description" rows="6" required><?= htmlspecialchars($idea['description']) ?></textarea>
        </div>
        <button type="submit" class="btn">Save Changes</button>
        <a href="<?= BASE_URL ?>/ideas" class="btn btn-secondary">Cancel</a>
    </form>
</div>
