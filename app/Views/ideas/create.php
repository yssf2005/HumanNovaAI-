<div class="section-header">
    <h2>Submit New Idea</h2>
    <a href="<?= BASE_URL ?>/ideas" class="btn btn-secondary">← Back to Ideas</a>
</div>

<div class="card" style="max-width: 600px;">
    <?php if (isset($error)): ?>
        <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <?php if (isset($success)): ?>
        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>
    <form action="<?= BASE_URL ?>/ideas/store" method="POST">
        <div class="form-group">
            <label for="title">Idea Title</label>
            <input type="text" id="title" name="title" placeholder="Enter your idea title" required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea id="description" name="description" rows="6" placeholder="Describe your idea" required></textarea>
        </div>
        <div style="margin-top:12px;"><button class="btn btn-solid" type="submit">Submit</button> <a href="<?= BASE_URL ?>/ideas" class="btn">Cancel</a></div>
    </form>

</div>
