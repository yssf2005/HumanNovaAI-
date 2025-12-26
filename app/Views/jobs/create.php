<div class="section-header">
    <h2>Post New Job</h2>
    <a href="<?= BASE_URL ?>/jobs" class="btn btn-secondary">← Back to Jobs</a>
</div>

<div class="card" style="max-width: 600px;">
    <?php if (isset($error)): ?>
        <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <?php if (isset($success)): ?>
        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>
    
    <form action="<?= BASE_URL ?>/jobs/store" method="POST" style="margin-top:18px;">
        <div class="form-group">
            <label for="title">Job Title</label>
            <input type="text" id="title" name="title" placeholder="e.g. Senior Developer, Marketing Manager" required>
        </div>
        <div class="form-group">
            <label for="company">Company Name</label>
            <input type="text" id="company" name="company" placeholder="Your company name" required>
        </div>
        <div class="form-group">
            <label for="category">Category</label>
            <select id="category" name="category" required>
                <option value="">Select a category</option>
                <option value="Technology">Technology</option>
                <option value="Marketing">Marketing</option>
                <option value="Finance">Finance</option>
                <option value="Design">Design</option>
                <option value="Sales">Sales</option>
                <option value="HR">Human Resources</option>
                <option value="Other">Other</option>
            </select>
        </div>
        <div class="form-group">
            <label for="description">Job Description</label>
            <textarea id="description" name="description" rows="6" placeholder="Describe the role, responsibilities, requirements..." required></textarea>
        </div>
        <button type="submit" class="btn">Post Job</button>
    </form>
</div>
<!-- quick-create modal removed from create page to avoid duplicate modals; form is shown inline above -->
