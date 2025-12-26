document.addEventListener('DOMContentLoaded', () => {
    // Grid animations: only run if .gestions-grid exists, but do not bail out
    // early so modal and other UI handlers always initialize on every page.
    const grid = document.querySelector('.gestions-grid');
    const cards = grid ? Array.from(document.querySelectorAll('.gestion-card')) : [];

    if (grid && cards.length) {
        // Stagger entrance via IntersectionObserver
        const io = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const el = entry.target;
                    const idx = cards.indexOf(el);
                    el.classList.add('in-view');
                    el.style.animationDelay = `${idx * 80}ms`;
                    io.unobserve(el);
                }
            });
        }, { threshold: 0.15 });

        cards.forEach(c => {
            c.style.transformStyle = 'preserve-3d';
            c.style.willChange = 'transform';
            io.observe(c);
        });

        // subtle hover boost per card
        cards.forEach(card => {
            card.addEventListener('mouseenter', () => {
                card.style.transition = 'transform 280ms cubic-bezier(.2,.9,.2,1)';
            });
            card.addEventListener('mouseleave', () => {
                card.style.transition = 'transform 600ms cubic-bezier(.2,.9,.2,1)';
            });
        });
    }

    /* Modal handling: open/close by id, backdrop, escape key */
    const backdrop = document.getElementById('modalBackdrop');
    const openModal = (id) => {
        const m = document.getElementById(id);
        if (!m || !backdrop) return;
        m.classList.add('open');
        m.setAttribute('aria-hidden', 'false');
        backdrop.classList.add('open');
        backdrop.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';
    };
    const closeModal = (el) => {
        const m = el.closest('.modal') || document.querySelector('.modal.open');
        if (!m || !backdrop) return;
        m.classList.remove('open');
        m.setAttribute('aria-hidden', 'true');
        backdrop.classList.remove('open');
        backdrop.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = '';
    };

    // Expose minimal API to global scope as a fallback for inline handlers
    try {
        window.Pillar = window.Pillar || {};
        window.Pillar.openModal = openModal;
        window.Pillar.closeModal = closeModal;
    } catch (e) {}

    document.querySelectorAll('.modal-trigger').forEach(btn => {
        btn.addEventListener('click', (e) => {
            const id = btn.dataset.modal;
            if (id) openModal(id);
        });
    });

    // Delegated handler as a fallback: open modal when any .modal-trigger is clicked
    document.addEventListener('click', (e) => {
        const t = e.target.closest && e.target.closest('.modal-trigger');
        if (!t) return;
        e.preventDefault();
        const id = t.dataset && t.dataset.modal;
        if (id) openModal(id);
    });

    document.addEventListener('click', (e) => {
        if (e.target.matches('[data-close]')) {
            closeModal(e.target);
        }
    });

    if (backdrop) {
        backdrop.addEventListener('click', () => {
            const open = document.querySelector('.modal.open');
            if (open) closeModal(open);
        });
    }

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            const open = document.querySelector('.modal.open');
            if (open) closeModal(open);
        }
    });

    // Image error fallback: if a featured image fails to load, show a neutral placeholder state
    document.querySelectorAll('.card-figure img').forEach(img => {
        img.addEventListener('error', () => {
            const fig = img.parentNode;
            if (!fig) return;
            img.style.display = 'none';
            fig.classList.add('img-missing');
        });
    });
});
