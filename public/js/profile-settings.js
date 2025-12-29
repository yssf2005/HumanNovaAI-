(function(){
  // Minimal, dependency-free JS to power the profile settings page.
  function qs(sel, ctx){ return (ctx||document).querySelector(sel); }
  function qsa(sel, ctx){ return Array.from((ctx||document).querySelectorAll(sel)); }

  function toast(msg, type){
    alert(msg); // simple fallback; integrate with site's toast system if available
  }

  function serializeForm(form){
    const data = new FormData(form);
    return data;
  }

  // Avatar upload & preview
  const avatarInput = qs('#avatar-input');
  const avatarPreview = qs('#avatar-preview img');
  const removeAvatarBtn = qs('#remove-avatar-btn');
  if(avatarInput){
    avatarInput.addEventListener('change', async function(e){
      const file = this.files[0];
      if(!file) return;
      const reader = new FileReader();
      reader.onload = function(ev){ avatarPreview.src = ev.target.result; };
      reader.readAsDataURL(file);

      const fd = new FormData(); fd.append('avatar', file);
      try{
        const res = await fetch(window.BASE_URL + '/profile/uploadAvatar', { method:'POST', body: fd });
        const json = await res.json();
        if(json.error) return toast(json.error, 'error');
        toast('Avatar uploaded', 'success');
      }catch(err){ console.error(err); toast('Upload failed', 'error'); }
    });
  }
  if(removeAvatarBtn){
    removeAvatarBtn.addEventListener('click', async function(){
      if(!confirm('Remove your avatar?')) return;
      try{
        const res = await fetch(window.BASE_URL + '/profile/removeAvatar', { method:'POST' });
        const json = await res.json();
        if(json.success){ avatarPreview.src = '/images/default-avatar.png'; toast('Avatar removed'); }
      }catch(e){ toast('Could not remove avatar'); }
    });
  }

  // Personal info save
  const personalForm = qs('#personal-info-form');
  if(personalForm){
    personalForm.addEventListener('submit', async function(e){
      e.preventDefault();
      const fd = serializeForm(this);
      try{
        const res = await fetch(window.BASE_URL + '/profile/update', { method:'POST', body: fd });
        if(res.redirected) return window.location = res.url;
        // fallback: reload
        toast('Profile saved');
      }catch(err){ console.error(err); toast('Save failed'); }
    });
  }

  // Password form with strength indicator
  const newPw = qs('#new-password');
  const pwStrengthValue = qs('#pw-strength-value');
  function strength(pw){
    let score = 0; if(!pw) return '—';
    if(pw.length >= 8) score++; if(/[A-Z]/.test(pw)) score++; if(/[0-9]/.test(pw)) score++; if(/[^A-Za-z0-9]/.test(pw)) score++;
    return ['Very weak','Weak','Fair','Good','Strong'][score];
  }
  if(newPw && pwStrengthValue){
    newPw.addEventListener('input', function(){ pwStrengthValue.textContent = strength(this.value); });
  }

  const pwForm = qs('#password-form');
  if(pwForm){
    pwForm.addEventListener('submit', async function(e){
      e.preventDefault();
      const fd = new FormData(this);
      try{
        const res = await fetch(window.BASE_URL + '/profile/changePassword', { method:'POST', body: fd });
        const json = await res.json();
        if(json.error) return toast(json.error, 'error');
        toast('Password changed', 'success');
        this.reset();
      }catch(err){ toast('Request failed'); }
    });
  }

  // 2FA toggle
  const toggle2fa = qs('#toggle-2fa');
  if(toggle2fa){
    toggle2fa.addEventListener('change', async function(){
      const fd = new FormData(); fd.append('enable', this.checked ? '1' : '0');
      try{
        const res = await fetch(window.BASE_URL + '/profile/toggle2fa', { method:'POST', body: fd });
        const json = await res.json();
        if(json.error) return toast(json.error, 'error');
        toast('Two-factor updated');
      }catch(e){ toast('Could not update 2FA'); }
    });
  }

  // Sessions list
  const sessionsList = qs('#sessions-list');
  const logoutOthersBtn = qs('#logout-others');
  async function loadSessions(){
    if(!sessionsList) return;
    sessionsList.textContent = 'Loading…';
    try{
      const res = await fetch(window.BASE_URL + '/profile/sessions');
      const json = await res.json();
      sessionsList.innerHTML = '';
      json.sessions.forEach(s => {
        const div = document.createElement('div');
        div.textContent = s.device + ' — ' + s.last_seen + ' ('+s.ip+')';
        sessionsList.appendChild(div);
      });
    }catch(e){ sessionsList.textContent = 'Could not load sessions'; }
  }
  if(logoutOthersBtn){ logoutOthersBtn.addEventListener('click', async function(){ if(!confirm('Log out other sessions?')) return; const res = await fetch(window.BASE_URL + '/profile/logoutOtherSessions', { method:'POST' }); const j = await res.json(); if(j.success) { toast('Logged out other sessions'); loadSessions(); } }); }
  loadSessions();

  // Danger zone
  const deactivateBtn = qs('#deactivate-account');
  const deleteBtn = qs('#delete-account');
  if(deactivateBtn){ deactivateBtn.addEventListener('click', async function(){ if(!confirm('Are you sure you want to deactivate your account?')) return; const res = await fetch(window.BASE_URL + '/profile/deactivate', { method:'POST' }); const j = await res.json(); if(j.success) { toast('Account deactivated'); } else toast(j.error || 'Failed'); }); }
  if(deleteBtn){ deleteBtn.addEventListener('click', async function(){ if(!confirm('Delete account permanently? This cannot be undone.')) return; if(!confirm('This is final. Are you absolutely sure?')) return; const res = await fetch(window.BASE_URL + '/profile/deleteAccount', { method:'POST' }); const j = await res.json(); if(j.success){ toast('Account deleted'); window.location = '/'; } else toast(j.error || 'Failed'); }); }

  // Bio counter
  const bio = qs('#bio'); const bioCount = qs('#bio-count'); if(bio && bioCount){ bio.addEventListener('input', function(){ bioCount.textContent = this.value.length + '/200'; }); }

})();
