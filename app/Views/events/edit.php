<h2>Edit Event</h2>

<div class="card">
    <form action="<?= BASE_URL ?>/events/update" method="POST">
        <input type="hidden" name="id" value="<?= $event['id'] ?>">
        <div class="form-group">
            <label for="title">Event Title</label>
            <input type="text" id="title" name="title" value="<?= htmlspecialchars($event['title']) ?>" required>
        </div>
        <div class="form-group">
            <label for="date">Date & Time</label>
            <input type="datetime-local" id="date" name="date" value="<?= date('Y-m-d\TH:i', strtotime($event['date'])) ?>" required>
        </div>
        <div class="form-group">
            <label for="location">Location</label>
            <input type="text" id="location" name="location" value="<?= htmlspecialchars($event['location']) ?>" required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea id="description" name="description" rows="5" required><?= htmlspecialchars($event['description']) ?></textarea>
        </div>
        <button type="submit" class="btn">Update Event</button>
        <a href="<?= BASE_URL ?>/events" class="btn" style="background-color: #6c757d;">Cancel</a>
    </form>
</div>
