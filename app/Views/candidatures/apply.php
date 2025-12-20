<h2>Apply for: <?= htmlspecialchars($job['title']) ?></h2>
<p>at <?= htmlspecialchars($job['company']) ?></p>

<div class="card">
    <form action="<?= BASE_URL ?>/apply/store" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="job_id" value="<?= $job['id'] ?>">
        <div class="form-group">
            <label for="message">Cover Letter / Message</label>
            <textarea id="message" name="message" rows="5" required></textarea>
        </div>
        <!-- CV Upload Placeholder -->
        <div class="form-group">
            <label for="cv">Upload CV (PDF)</label>
            <input type="file" id="cv" name="cv">
        </div>
        
        <button type="submit" class="btn">Submit Application</button>
        <a href="<?= BASE_URL ?>/jobs" class="btn" style="background-color: #6c757d;">Cancel</a>
    </form>
</div>
