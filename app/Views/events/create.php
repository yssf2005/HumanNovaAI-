<div class="section-header">
    <h2>📅 Create New Event</h2>
    <a href="<?= BASE_URL ?>/events" class="btn btn-secondary">← Back to Events</a>
</div>

<div class="card" style="max-width: 600px;">
    <?php if (isset($error)): ?>
        <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <?php if (isset($success)): ?>
        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>
    
    <p style="margin-bottom:12px;color:var(--muted);">Prefer the quick-create popup? Use it, or fill the full form below.</p>
    <button type="button" class="btn modal-trigger" data-modal="eventPageModal">🎉 Quick Create Event</button>

    <form action="<?= BASE_URL ?>/events/store" method="POST" style="margin-top:18px;">
        <div class="form-group">
            <label for="title">📅 Event Title</label>
            <input type="text" id="title" name="title" placeholder="e.g. Innovation Summit 2024" required>
        </div>
        <div class="form-group">
            <label for="date">🗓️ Date & Time</label>
            <input type="datetime-local" id="date" name="date" required>
        </div>
        <div class="form-group">
            <label for="location">📍 Location</label>
            <input type="text" id="location" name="location" placeholder="e.g. Conference Hall A, Virtual" required>
        </div>
        <div class="form-group">
            <label for="description">📝 Description</label>
            <textarea id="description" name="description" rows="5" placeholder="Describe your event, agenda, speakers..." required></textarea>
        </div>
        <button type="submit" class="btn">🎉 Create Event</button>
    </form>
</div>

<!-- Modal for quick-create event on events page -->
<div class="modal large" id="eventPageModal" role="dialog" aria-modal="true" aria-hidden="true">
<!-- Render event create form inside a modal so visiting /events/create opens a popup -->
<div class="modal large" id="eventPageModal" role="dialog" aria-modal="true" aria-hidden="true">
  <div class="modal-inner">
    <button class="close-btn" data-close>&times;</button>
    <h3>Create New Event</h3>
    <?php if (isset($error)): ?>
        <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <?php if (isset($success)): ?>
        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>
    <form action="<?= BASE_URL ?>/events/store" method="POST">
        <div class="form-group">
            <label for="title">Event Title</label>
            <input type="text" id="title" name="title" placeholder="Event title" required>
        </div>
        <div class="form-group">
            <label for="date">Date & Time</label>
            <input type="datetime-local" id="date" name="date" required>
        </div>
        <div class="form-group">
            <label for="location">Location</label>
            <input type="text" id="location" name="location" placeholder="Location" required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea id="description" name="description" rows="5" placeholder="Describe your event" required></textarea>
        </div>
        <div style="margin-top:12px;"><button class="btn btn-solid" type="submit">Create Event</button> <button type="button" class="btn" data-close>Cancel</button></div>
    </form>
  </div>
</div>

<script>
// Open modal on page load
(function(){
  var m = document.getElementById('eventPageModal');
  var b = document.getElementById('modalBackdrop');
  if (m && b) {
    m.classList.add('open'); m.setAttribute('aria-hidden','false');
    b.classList.add('open'); b.setAttribute('aria-hidden','false');
    document.body.style.overflow = 'hidden';
  }
})();
</script>
