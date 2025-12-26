<div class="section-header">
    <h2>Create New Event</h2>
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
    <button type="button" class="btn modal-trigger" data-modal="eventModal" onclick="(function(){ if(window.Pillar && window.Pillar.openModal){ window.Pillar.openModal('eventModal'); return; } var m=document.getElementById('eventModal'); var b=document.getElementById('modalBackdrop'); if(m && b){ m.classList.add('open'); m.setAttribute('aria-hidden','false'); b.classList.add('open'); b.setAttribute('aria-hidden','false'); document.body.style.overflow='hidden'; } })();">Quick Create Event</button>

    <form action="<?= BASE_URL ?>/events/store" method="POST" style="margin-top:18px;">
        <div class="form-group">
            <label for="title">Event Title</label>
            <input type="text" id="title" name="title" placeholder="e.g. Innovation Summit 2024" required>
        </div>
        <div class="form-group">
            <label for="date">Date & Time</label>
            <input type="datetime-local" id="date" name="date" required>
        </div>
        <div class="form-group">
            <label for="location">Location</label>
            <input type="text" id="location" name="location" placeholder="e.g. Conference Hall A, Virtual" required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea id="description" name="description" rows="5" placeholder="Describe your event, agenda, speakers..." required></textarea>
        </div>
        <button type="submit" class="btn">Create Event</button>
    </form>
</div>

<!-- quick-create modal removed from create page to avoid duplicate modals; form is shown inline above -->
