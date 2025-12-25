<div class="section-header">
    <h2>💡 Submit New Idea</h2>
    <a href="<?= BASE_URL ?>/ideas" class="btn btn-secondary">← Back to Ideas</a>
</div>

<div class="card" style="max-width: 600px;">
    <?php if (isset($error)): ?>
        <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <?php if (isset($success)): ?>
        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>
<!-- Render create form inside a modal so navigating to /ideas/create opens a popup -->
<div class="modal large" id="ideaModal" role="dialog" aria-modal="true" aria-hidden="true">
  <div class="modal-inner">
    <button class="close-btn" data-close>&times;</button>
    <h3>Submit New Idea</h3>
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
        <div style="margin-top:12px;"><button class="btn btn-solid" type="submit">Submit</button> <button type="button" class="btn" data-close>Cancel</button></div>
    </form>
  </div>
</div>

<script>
// Open modal on page load
(function(){
  var m = document.getElementById('ideaModal');
  var b = document.getElementById('modalBackdrop');
  if (m && b) {
    m.classList.add('open'); m.setAttribute('aria-hidden','false');
    b.classList.add('open'); b.setAttribute('aria-hidden','false');
    document.body.style.overflow = 'hidden';
  }
})();
</script>
</div>

<!-- Modal for quick create on ideas page -->
<div class="modal large" id="ideaPageModal" role="dialog" aria-modal="true" aria-hidden="true">
  <div class="modal-inner">
    <button class="close-btn" data-close>&times;</button>
    <h3>Submit an Idea</h3>
    <form method="post" action="<?= BASE_URL ?>/ideas/store">
      <label>Title<br><input name="title" required></label>
      <label>Description<br><textarea name="description" rows="6" required></textarea></label>
      <div style="margin-top:12px;"><button class="btn btn-solid" type="submit">Submit</button> <button type="button" class="btn" data-close>Cancel</button></div>
    </form>
  </div>
</div>
