// Custom login modal logic from provided script.js, adapted for site
(function(){
  var body = document.body;
  var modal = document.getElementById('customLoginModal');
  var modalButton = document.getElementById('customLoginModalOpenBtn');
  var headerBtn = document.getElementById('customLoginModalBtn');
  var closeButton = modal ? modal.querySelector('.custom-close-button') : null;
  var isOpened = false;

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

  if (modalButton) modalButton.addEventListener('click', openModal);
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
})();
