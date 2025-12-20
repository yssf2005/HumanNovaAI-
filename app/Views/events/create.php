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
    
    <form action="<?= BASE_URL ?>/events/store" method="POST">
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
