<h2>Edit Job Offer</h2>

<div class="card">
    <form action="<?= BASE_URL ?>/jobs/update" method="POST">
        <input type="hidden" name="id" value="<?= $job['id'] ?>">
        <div class="form-group">
            <label for="title">Job Title</label>
            <input type="text" id="title" name="title" value="<?= htmlspecialchars($job['title']) ?>" required>
        </div>
        <div class="form-group">
            <label for="company">Company Name</label>
            <input type="text" id="company" name="company" value="<?= htmlspecialchars($job['company']) ?>" required>
        </div>
        <div class="form-group">
            <label for="category">Category</label>
            <input type="text" id="category" name="category" value="<?= htmlspecialchars($job['category'] ?? '') ?>" placeholder="e.g. IT, Marketing, HR" required>
        </div>
        <div class="form-group">
            <label for="description">Job Description</label>
            <textarea id="description" name="description" rows="5" required><?= htmlspecialchars($job['description']) ?></textarea>
        </div>
        <button type="submit" class="btn">Update Job</button>
        <a href="<?= BASE_URL ?>/jobs" class="btn" style="background-color: #6c757d;">Cancel</a>
    </form>
</div>
