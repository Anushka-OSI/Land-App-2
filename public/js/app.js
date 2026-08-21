/* ============================================================
   Department of Land Title Settlement – JavaScript
   ============================================================ */

document.addEventListener('DOMContentLoaded', () => {

    /* ── Scroll-reveal with Intersection Observer ────────── */
    const revealEls = document.querySelectorAll('.reveal, .reveal-left, .reveal-right');
    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry, i) => {
            if (entry.isIntersecting) {
                setTimeout(() => entry.target.classList.add('visible'), i * 80);
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.12 });
    revealEls.forEach(el => observer.observe(el));

    /* ── Navbar scroll shadow ────────────────────────────── */
    const navbar = document.querySelector('.navbar');
    window.addEventListener('scroll', () => {
        navbar?.classList.toggle('scrolled', window.scrollY > 60);
        document.querySelector('.back-to-top')?.classList.toggle('visible', window.scrollY > 400);
    }, { passive: true });

    /* ── Desktop & Mobile Dropdown Enhancements ──────────── */
    const navItemsWithDropdown = document.querySelectorAll('.nav-item');
    navItemsWithDropdown.forEach(item => {
        const dropdown = item.querySelector('.dropdown');
        if (!dropdown) return;

        let closeTimer = null;

        // Desktop hover with grace period to prevent flickering
        item.addEventListener('mouseenter', () => {
            if (window.innerWidth > 768) {
                clearTimeout(closeTimer);
                item.classList.add('is-open');
            }
        });

        item.addEventListener('mouseleave', () => {
            if (window.innerWidth > 768) {
                closeTimer = setTimeout(() => {
                    item.classList.remove('is-open');
                }, 150);
            }
        });

        // Mobile touch toggle
        const link = item.querySelector('.nav-link');
        link?.addEventListener('click', (e) => {
            if (window.innerWidth <= 768) {
                e.preventDefault();
                const wasOpen = item.classList.contains('mobile-open');
                document.querySelectorAll('.nav-item.mobile-open').forEach(i => i.classList.remove('mobile-open'));
                if (!wasOpen) item.classList.add('mobile-open');
            }
        });
    });

    /* ── Mobile hamburger ────────────────────────────────── */
    const hamburger = document.querySelector('.nav-hamburger');
    const navMenu   = document.querySelector('.nav-menu');
    const overlay   = document.createElement('div');
    overlay.className = 'nav-overlay';
    overlay.style.cssText = 'position:fixed;inset:0;background:rgba(0,0,0,.45);z-index:9997;display:none;';
    document.body.appendChild(overlay);

    hamburger?.addEventListener('click', () => {
        const open = navMenu.classList.toggle('open');
        hamburger.classList.toggle('open', open);
        overlay.style.display = open ? 'block' : 'none';
        document.body.style.overflow = open ? 'hidden' : '';
    });
    overlay.addEventListener('click', closeMenu);
    function closeMenu() {
        navMenu?.classList.remove('open');
        hamburger?.classList.remove('open');
        overlay.style.display = 'none';
        document.body.style.overflow = '';
    }

    /* ── Animated number counters ────────────────────────── */
    const counters = document.querySelectorAll('.counter');
    const counterObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                animateCounter(entry.target);
                counterObserver.unobserve(entry.target);
            }
        });
    }, { threshold: 0.5 });
    counters.forEach(el => counterObserver.observe(el));

    function animateCounter(el) {
        const target = parseInt(el.dataset.target, 10);
        if (isNaN(target)) return;
        const duration = 2000;
        const steps    = 60;
        const step     = duration / steps;
        let current    = 0;
        const increment = target / steps;
        const timer = setInterval(() => {
            current += increment;
            if (current >= target) {
                current = target;
                clearInterval(timer);
            }
            el.textContent = formatNumber(Math.floor(current));
        }, step);
    }

    function formatNumber(n) {
        if (n >= 1000000) return (n / 1000000).toFixed(1) + 'M';
        if (n >= 1000)    return (n / 1000).toFixed(0) + 'K';
        return n.toString();
    }

    /* ── News & Events tabs ──────────────────────────────── */
    const tabBtns   = document.querySelectorAll('.tab-btn');
    const tabPanels = document.querySelectorAll('.news-panel');

    tabBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            const target = btn.dataset.tab;

            tabBtns.forEach(b => b.classList.remove('active'));
            tabPanels.forEach(p => p.classList.remove('active'));

            btn.classList.add('active');
            const panel = document.getElementById('tab-' + target);
            if (panel) {
                panel.classList.add('active');
                panel.querySelectorAll('.news-card').forEach((card, i) => {
                    card.style.opacity = '0';
                    card.style.transform = 'translateY(16px)';
                    setTimeout(() => {
                        card.style.transition = 'opacity .35s ease, transform .35s ease';
                        card.style.opacity = '1';
                        card.style.transform = 'translateY(0)';
                    }, i * 80);
                });
            }
        });
    });

    /* ── Back to top ─────────────────────────────────────── */
    document.querySelector('.back-to-top')?.addEventListener('click', () => {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });

    /* ── Smooth scroll for anchor CTA ────────────────────── */
    document.querySelectorAll('a[href^="#"]').forEach(a => {
        a.addEventListener('click', e => {
            const href = a.getAttribute('href');
            if (href === '#' || !href) return;
            const target = document.querySelector(href);
            if (target) {
                e.preventDefault();
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });

    /* ── Seamless marquee cloning on all pages ───────────── */
    const marqueeTrack = document.querySelector('.marquee-track');
    if (marqueeTrack && !marqueeTrack.dataset.duplicated) {
        marqueeTrack.dataset.duplicated = 'true';
        marqueeTrack.innerHTML += marqueeTrack.innerHTML;
    }

});
