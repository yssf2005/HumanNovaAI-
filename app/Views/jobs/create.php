<div class="section-header">
    <h2>💼 Post New Job</h2>
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
            <label for="title">💼 Job Title</label>
            <input type="text" id="title" name="title" placeholder="e.g. Senior Developer, Marketing Manager" required>
        </div>
        <div class="form-group">
            <label for="company">🏢 Company Name</label>
            <input type="text" id="company" name="company" placeholder="Your company name" required>
        </div>
        <div class="form-group">
            <label for="category">🏷️ Category</label>
            <select id="category" name="category" required>
                <option value="">Select a category</option>
                <option value="Technology">💻 Technology</option>
                <option value="Marketing">📢 Marketing</option>
                <option value="Finance">💰 Finance</option>
                <option value="Design">🎨 Design</option>
                <option value="Sales">📈 Sales</option>
                <option value="HR">👥 Human Resources</option>
                <option value="Other">📦 Other</option>
            </select>
        </div>
        <div class="form-group">
            <label for="description">📝 Job Description</label>
            <textarea id="description" name="description" rows="6" placeholder="Describe the role, responsibilities, requirements..." required></textarea>
        </div>
        <button type="submit" class="btn">📤 Post Job</button>
    </form>
</div>
<!-- Render job create form as a modal so visiting /jobs/create opens a popup -->
<div class="modal large" id="jobPageModal" role="dialog" aria-modal="true" aria-hidden="true">
  <div class="modal-inner">
  <button class="close-btn" data-close>&times;</button>
  <h3>Post New Job</h3>
  <?php if (isset($error)): ?>
    <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
  <?php endif; ?>
  <?php if (isset($success)): ?>
    <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
  <?php endif; ?>
  <form action="<?= BASE_URL ?>/jobs/store" method="POST">
    <div class="form-group">
      <label for="title">Job Title</label>
      <input type="text" id="title" name="title" placeholder="Job title" required>
    </div>
    <div class="form-group">
      <label for="company">Company</label>
      <input type="text" id="company" name="company" placeholder="Company name">
    </div>
    <div class="form-group">
      <label for="category">Category</label>
      <select id="category" name="category">
        <option value="">Select a category</option>
        <option value="Technology">Technology</option>
        <option value="Marketing">Marketing</option>
        <option value="Finance">Finance</option>
        <option value="Design">Design</option>
      </select>
    </div>
    <div class="form-group">
      <label for="description">Description</label>
      <textarea id="description" name="description" rows="6" placeholder="Describe the role" required></textarea>
    </div>
    <div style="margin-top:12px;"><button class="btn btn-solid" type="submit">Post Job</button> <button type="button" class="btn" data-close>Cancel</button></div>
  </form>
  </div>
</div>

<script>
// Open modal on page load
(function(){
  var m = document.getElementById('jobPageModal');
  var b = document.getElementById('modalBackdrop');
  if (m && b) {
  m.classList.add('open'); m.setAttribute('aria-hidden','false');
  b.classList.add('open'); b.setAttribute('aria-hidden','false');
  document.body.style.overflow = 'hidden';
  }
})();
</script>

<!-- Modal for quick-create job on jobs page -->
<div class="modal large" id="jobPageModal" role="dialog" aria-modal="true" aria-hidden="true">
  <div class="modal-inner">
    <button class="close-btn" data-close>&times;</button>
    <h3>Create a Job</h3>
    <form method="post" action="<?= BASE_URL ?>/jobs/store">
      <label>Title<br><input name="title" required></label>
      <label>Company<br><input name="company" required></label>
      <label>Category<br>
        <select name="category" required>
          <option value="">Select</option>
          <option>Technology</option>
          <option>Marketing</option>
          <option>Finance</option>
          <option>Design</option>
          <option>Sales</option>
          <option>HR</option>
        </select>
      </label>
      <label>Description<br><textarea name="description" rows="6" required></textarea></label>
      <div style="margin-top:12px;"><button class="btn btn-solid" type="submit">Create</button> <button type="button" class="btn" data-close>Cancel</button></div>
    </form>
  </div>
</div>
