<div class="dashboard-header">
    <h2>Profile Settings</h2>
    <p>Manage your personal information, security, preferences and connected accounts.</p>
</div>

<div class="profile-settings" style="max-width:1100px; margin: 0 auto; display: grid; grid-template-columns: 1fr 380px; gap: 24px;">
    <main aria-labelledby="profile-main-heading">
        <section aria-labelledby="personal-info-heading" class="card" style="padding:20px; margin-bottom:16px;">
            <h3 id="personal-info-heading">Personal Information</h3>
            <form id="personal-info-form" novalidate>
                <div style="display:flex; gap:16px; align-items:center; margin-top:12px;">
                    <div style="flex:0 0 110px; text-align:center;">
                        <div id="avatar-preview" style="width:110px; height:110px; border-radius:8px; overflow:hidden; background:#111; display:inline-block;">
                            <img src="<?= htmlspecialchars($user['avatar'] ?? '/images/default-avatar.png') ?>" alt="Profile avatar" style="width:100%; height:100%; object-fit:cover;" />
                        </div>
                        <div style="margin-top:8px; display:flex; gap:8px; justify-content:center;">
                            <label for="avatar-input" class="btn btn-sm">Change</label>
                            <button id="remove-avatar-btn" type="button" class="btn btn-sm btn-outline">Remove</button>
                        </div>
                        <input id="avatar-input" name="avatar" type="file" accept="image/*" style="display:none;">
                    </div>

                    <div style="flex:1;">
                        <div style="margin-bottom:12px;">
                            <label for="full-name">Full name</label>
                            <input id="full-name" name="name" type="text" value="<?= htmlspecialchars($user['name'] ?? '') ?>" required aria-required="true">
                        </div>
                        <div style="display:flex; gap:12px;">
                            <div style="flex:1;">
                                <label for="username">Username</label>
                                <input id="username" name="username" type="text" value="<?= htmlspecialchars($user['username'] ?? '') ?>" aria-describedby="username-help">
                                <div id="username-help" class="muted">Your public handle. Editing may affect links.</div>
                            </div>
                            <div style="flex:1;">
                                <label for="phone">Phone (optional)</label>
                                <input id="phone" name="phone" type="tel" value="<?= htmlspecialchars($user['phone'] ?? '') ?>">
                            </div>
                        </div>
                        <div style="margin-top:12px;">
                            <label for="bio">Bio / About me</label>
                            <textarea id="bio" name="bio" maxlength="200" rows="3"><?= htmlspecialchars($user['bio'] ?? '') ?></textarea>
                            <div class="muted" id="bio-count"><?= strlen($user['bio'] ?? '') ?>/200</div>
                        </div>
                        <div style="margin-top:12px;">
                            <label for="email">Email address</label>
                            <div style="display:flex; gap:12px; align-items:center;">
                                <input id="email" name="email" type="email" value="<?= htmlspecialchars($user['email'] ?? '') ?>" required>
                                <div class="muted" aria-live="polite">Verification: <?= isset($user['email_verified']) && $user['email_verified'] ? 'Verified' : 'Unverified' ?></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div style="display:flex; gap:12px; margin-top:18px;">
                    <button id="save-personal" class="btn" type="submit">Save</button>
                    <button id="cancel-personal" class="btn btn-secondary" type="button">Cancel</button>
                </div>
            </form>
        </section>

        <section aria-labelledby="security-heading" class="card" style="padding:20px; margin-bottom:16px;">
            <h3 id="security-heading">Account & Security</h3>

            <form id="password-form" style="margin-top:12px;" novalidate>
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
                    <div>
                        <label for="current-password">Current password</label>
                        <input id="current-password" name="current_password" type="password" required>
                    </div>
                    <div>
                        <label for="new-password">New password</label>
                        <input id="new-password" name="new_password" type="password" aria-describedby="pw-strength">
                        <div id="pw-strength" class="muted">Strength: <span id="pw-strength-value">—</span></div>
                    </div>
                </div>
                <div style="margin-top:12px;">
                    <label for="confirm-password">Confirm new password</label>
                    <input id="confirm-password" name="confirm_password" type="password">
                </div>
                <div style="display:flex; gap:12px; margin-top:12px;">
                    <button id="change-password-btn" class="btn" type="submit">Change password</button>
                </div>
            </form>

            <div style="margin-top:18px; display:flex; justify-content:space-between; align-items:center;">
                <div>
                    <strong>Two-factor authentication</strong>
                    <div class="muted">Add an extra layer of account security</div>
                </div>
                <div>
                    <label class="switch">
                        <input id="toggle-2fa" type="checkbox" <?= isset($_SESSION['2fa_enabled']) && $_SESSION['2fa_enabled'] ? 'checked' : '' ?> />
                        <span class="slider"></span>
                    </label>
                </div>
            </div>

            <div style="margin-top:18px;">
                <h4 style="margin:0 0 8px 0">Active sessions</h4>
                <div id="sessions-list" class="muted">Loading sessions…</div>
                <div style="margin-top:8px;"><button id="logout-others" class="btn btn-outline">Log out other sessions</button></div>
            </div>
        </section>

        <section aria-labelledby="preferences-heading" class="card" style="padding:20px; margin-bottom:16px;">
            <h3 id="preferences-heading">Preferences</h3>
            <form id="preferences-form" novalidate>
                <div style="display:flex; gap:12px; flex-wrap:wrap; margin-top:8px;">
                    <div style="flex:1; min-width:200px;">
                        <label for="language">Language</label>
                        <select id="language" name="language">
                            <option value="en">English</option>
                            <option value="es">Español</option>
                        </select>
                    </div>
                    <div style="flex:1; min-width:200px;">
                        <label for="timezone">Timezone</label>
                        <select id="timezone" name="timezone">
                            <option value="UTC">UTC</option>
                            <option value="America/New_York">America / New_York</option>
                        </select>
                    </div>
                    <div style="flex:1; min-width:200px;">
                        <label for="theme">Theme mode</label>
                        <select id="theme" name="theme">
                            <option value="system">System</option>
                            <option value="light">Light</option>
                            <option value="dark">Dark</option>
                        </select>
                    </div>
                </div>

                <fieldset style="margin-top:12px; border:none; padding:0;">
                    <legend>Notifications</legend>
                    <label><input type="checkbox" name="notify_email" checked> Email</label>
                    <label style="margin-left:12px;"><input type="checkbox" name="notify_inapp" checked> In-app</label>
                    <label style="margin-left:12px;"><input type="checkbox" name="notify_push"> Push</label>
                </fieldset>

                <div style="margin-top:12px;"><button id="save-preferences" class="btn" type="submit">Save preferences</button></div>
            </form>
        </section>

        <section aria-labelledby="privacy-heading" class="card" style="padding:20px; margin-bottom:16px;">
            <h3 id="privacy-heading">Privacy Settings</h3>
            <form id="privacy-form" novalidate>
                <div>
                    <label>Profile visibility</label>
                    <select name="visibility">
                        <option value="public">Public</option>
                        <option value="private">Private</option>
                    </select>
                </div>
                <div style="margin-top:8px;">
                    <label><input type="checkbox" name="show_email"> Show email</label>
                    <label style="margin-left:12px;"><input type="checkbox" name="show_online"> Show online status</label>
                </div>
                <div style="margin-top:12px;"><button class="btn" type="submit">Save privacy</button></div>
            </form>
        </section>

        <section aria-labelledby="connected-heading" class="card" style="padding:20px; margin-bottom:16px;">
            <h3 id="connected-heading">Connected Accounts</h3>
            <div style="display:flex; gap:12px; flex-wrap:wrap; margin-top:8px;">
                <div>
                    <div>Google</div>
                    <div class="muted">Not connected</div>
                    <div style="margin-top:6px;"><button class="btn btn-outline">Connect</button></div>
                </div>
                <div>
                    <div>GitHub</div>
                    <div class="muted">Connected as githubuser</div>
                    <div style="margin-top:6px;"><button class="btn btn-outline">Disconnect</button></div>
                </div>
                <div>
                    <div>LinkedIn</div>
                    <div class="muted">Not connected</div>
                    <div style="margin-top:6px;"><button class="btn btn-outline">Connect</button></div>
                </div>
            </div>
        </section>
    </main>

    <aside aria-labelledby="danger-zone-heading">
        <section class="card" style="padding:20px; margin-bottom:16px;">
            <h3 id="danger-zone-heading">Danger Zone</h3>
            <div style="margin-top:12px;">
                <button id="deactivate-account" class="btn btn-outline">Deactivate account</button>
            </div>
            <div style="margin-top:12px;">
                <button id="delete-account" class="btn btn-danger">Delete account permanently</button>
            </div>
        </section>

        <section class="card" style="padding:20px;">
            <h4>Account activity</h4>
            <div class="muted" id="activity-log" style="margin-top:8px;">Last login: <?= htmlspecialchars($user['created_at'] ?? '') ?> from IP: —</div>
        </section>
    </aside>
</div>

<link rel="stylesheet" href="<?= BASE_URL ?>/css/style.css">
<script>window.BASE_URL = '<?= BASE_URL ?>';</script>
<script src="<?= BASE_URL ?>/js/profile-settings.js" defer></script>
