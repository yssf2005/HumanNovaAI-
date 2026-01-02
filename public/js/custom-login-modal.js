// Custom login modal logic from provided script.js, adapted for site
(function(){
  var body = document.body;
  var modal = document.getElementById('customLoginModal');
  var headerBtn = document.getElementById('customLoginModalBtn');
  var closeButton = modal ? modal.querySelector('.custom-close-button') : null;
  var isOpened = false;
  var loginForm = modal ? modal.querySelector('#custom-login-form') : null;
  var registerForm = modal ? modal.querySelector('#custom-register-form') : null;
  var switchToRegisterLinks = document.querySelectorAll('.open-register-modal');
  var switchToLoginLinks = document.querySelectorAll('.open-login-modal');

  function openModal() {
    if (!modal) return;
    modal.classList.add('is-open');
    modal.setAttribute('aria-hidden','false');
    body.style.overflow = 'hidden';
    var firstInput = modal.querySelector('input');
    if(firstInput) firstInput.focus();
  }
  function closeModal() {
    if (!modal) return;
    modal.classList.remove('is-open');
    modal.setAttribute('aria-hidden','true');
    body.style.overflow = '';
  }

  if (headerBtn) headerBtn.addEventListener('click', function(e){ e.preventDefault(); openModal(); });
  if (closeButton) closeButton.addEventListener('click', closeModal);

  document.addEventListener('keydown', function(evt){
    evt = evt || window.event;
    if (evt.key === 'Escape' || evt.keyCode === 27) closeModal();
  });

  // Optional: close on outside click
  modal && modal.addEventListener('click', function(e){
    if(e.target === modal) closeModal();
  });

  // Support switching between login and register inside modal
  function showRegister() {
    // prefer modal if present, otherwise operate on page sections
    var root = modal || document;
    root.querySelectorAll && root.querySelectorAll('.modal-section').forEach(s => s.classList.remove('visible'));
    var reg = root.querySelector && root.querySelector('.modal-section.register');
    if (reg) reg.classList.add('visible');
  }
  function showLogin() {
    var root = modal || document;
    root.querySelectorAll && root.querySelectorAll('.modal-section').forEach(s => s.classList.remove('visible'));
    var lg = root.querySelector && root.querySelector('.modal-section.login');
    if (lg) lg.classList.add('visible');
  }

  // Wire links/buttons that should open register or login inside modal
  switchToRegisterLinks.forEach(function(el){ el.addEventListener('click', function(e){ e.preventDefault(); openModal(); showRegister(); }); });
  switchToLoginLinks.forEach(function(el){ el.addEventListener('click', function(e){ e.preventDefault(); openModal(); showLogin(); }); });
})();
