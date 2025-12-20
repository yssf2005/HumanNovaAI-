<div class="dashboard-header">
    <h2>👤 Edit Profile</h2>
    <p>Update your personal information</p>
</div>

<div class="create-post-card" style="max-width: 600px; margin: 0 auto;">
    <form action="<?= BASE_URL ?>/profile/update" method="POST">
        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 500;">Full Name</label>
            <input type="text" name="name" value="<?= htmlspecialchars($user['name'] ?? '') ?>" 
                   style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid #333; background: #222; color: white;" required>
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 500;">Email Address</label>
            <input type="email" name="email" value="<?= htmlspecialchars($user['email'] ?? '') ?>" 
                   style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid #333; background: #222; color: white;" required>
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 500;">New Password <small style="color: #bbb;">(Leave blank to keep current)</small></label>
            <input type="password" name="new_password" placeholder="Enter new password"
                   style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid #333; background: #222; color: white;">
        </div>

        <div style="margin-bottom: 30px; padding-top: 20px; border-top: 1px solid #333;">
            <label style="display: block; margin-bottom: 8px; font-weight: 500; color: #e63946;">Current Password (Required to save changes)</label>
            <input type="password" name="current_password" placeholder="Enter current password to verify"
                   style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid #e63946; background: #222; color: white;" required>
        </div>

        <div style="display: flex; gap: 15px;">
            <button type="submit" class="btn" style="flex: 1;">Save Changes</button>
            <a href="<?= BASE_URL ?>/dashboard" class="btn btn-secondary" style="flex: 1; text-align: center;">Cancel</a>
        </div>
    </form>
</div>
