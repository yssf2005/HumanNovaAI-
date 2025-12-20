<h2>Invest in Idea: <?= htmlspecialchars($idea['title']) ?></h2>

<div class="card">
    <p>Support this innovation by investing.</p>
    <form action="<?= BASE_URL ?>/investments/store" method="POST">
        <input type="hidden" name="idea_id" value="<?= $idea['id'] ?>">
        <div class="form-group">
            <label for="amount">Investment Amount ($)</label>
            <input type="number" id="amount" name="amount" min="1" step="0.01" required>
        </div>
        <button type="submit" class="btn">Confirm Investment</button>
        <a href="<?= BASE_URL ?>/ideas" class="btn" style="background-color: #6c757d;">Cancel</a>
    </form>
</div>
