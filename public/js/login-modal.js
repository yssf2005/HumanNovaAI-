// Simple modal handling for site login modal
(function(){
  function openModal(id){
    var el = document.getElementById(id); if(!el) return;
    el.classList.add('open'); el.setAttribute('aria-hidden','false');
    var backdrop = document.getElementById('modalBackdrop'); if(backdrop) backdrop.classList.add('open');
    document.body.style.overflow = 'hidden';
    var firstInput = el.querySelector('input'); if(firstInput) firstInput.focus();
  }
  function closeModal(el){
    if(!el) return; el.classList.remove('open'); el.setAttribute('aria-hidden','true');
    var backdrop = document.getElementById('modalBackdrop'); if(backdrop) backdrop.classList.remove('open');
    document.body.style.overflow = '';
  }

  document.addEventListener('click', function(e){
    var t = e.target;
    var trigger = t.closest && t.closest('.modal-trigger');
    if(trigger){ e.preventDefault(); var id = trigger.getAttribute('data-modal'); if(id) openModal(id); return; }

    if(t.closest && t.closest('.modal') && t.hasAttribute('data-close')){
      var modal = t.closest('.modal'); closeModal(modal); return;
    }
    // backdrop click closes modal
    if(t.id === 'modalBackdrop'){
      document.querySelectorAll('.modal.open').forEach(function(m){ closeModal(m); });
    }
  });

  // Close on Escape
  document.addEventListener('keydown', function(e){ if(e.key === 'Escape'){ document.querySelectorAll('.modal.open').forEach(function(m){ m.classList.remove('open'); m.setAttribute('aria-hidden','true'); }); var backdrop=document.getElementById('modalBackdrop'); if(backdrop) backdrop.classList.remove('open'); document.body.style.overflow=''; } });

  // handle internal close buttons
  document.addEventListener('click', function(e){ var c = e.target.closest && e.target.closest('[data-close]'); if(c){ var modal = c.closest('.modal'); if(modal) modal.classList.remove('open'); var backdrop=document.getElementById('modalBackdrop'); if(backdrop) backdrop.classList.remove('open'); document.body.style.overflow=''; } });

  // Enhance login form: submit normally, but show loading state
  document.addEventListener('submit', function(e){
    var f = e.target;
    if(f && f.id === 'site-login-form'){
      var btn = f.querySelector('button[type=submit]');
      if(btn){ btn.disabled = true; btn.dataset.orig = btn.innerHTML; btn.innerHTML = 'Connexion...'; }
    }
  });
})();
