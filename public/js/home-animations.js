document.addEventListener('DOMContentLoaded', () => {
    const grid = document.querySelector('.gestions-grid');
    if (!grid) return;

    const cards = Array.from(document.querySelectorAll('.gestion-card'));

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

    // 3D tilt effect per card on mousemove
    const maxRotate = 9; // degrees
    grid.addEventListener('mousemove', (e) => {
        const rect = grid.getBoundingClientRect();
        const gx = e.clientX - rect.left;
        const gy = e.clientY - rect.top;

        cards.forEach(card => {
            const r = card.getBoundingClientRect();
            const cx = r.left + r.width/2;
            const cy = r.top + r.height/2;
            const rx = (e.clientY - cy) / (r.height/2);
            const ry = (e.clientX - cx) / (r.width/2);
            const rotX = Math.max(Math.min(-rx * maxRotate, maxRotate), -maxRotate);
            const rotY = Math.max(Math.min(ry * maxRotate, maxRotate), -maxRotate);
            card.style.transform = `perspective(1200px) rotateX(${rotX}deg) rotateY(${rotY}deg) translateZ(6px)`;
            const preview = card.querySelector('.card-preview');
            if (preview) preview.style.transform = `translateZ(26px) scale(1.02)`;
        });
    });

    grid.addEventListener('mouseleave', () => {
        cards.forEach(card => {
            card.style.transform = '';
            const preview = card.querySelector('.card-preview');
            if (preview) preview.style.transform = '';
        });
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

    document.querySelectorAll('.modal-trigger').forEach(btn => {
        btn.addEventListener('click', (e) => {
            const id = btn.dataset.modal;
            if (id) openModal(id);
        });
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
