/** 
 * UMKM Store - Navbar & Global Interactions
 */
document.addEventListener('DOMContentLoaded', function() {
    const navbar    = document.querySelector('.navbar');
    const navToggle = document.getElementById('navToggle');
    const navMenu   = document.querySelector('.nav-menu');
    const userDropdown = document.getElementById('userDropdown');

    // ── Sticky scroll effect ─────────────────────────────────────
    window.addEventListener('scroll', () => {
        if (navbar) navbar.classList.toggle('scrolled', window.scrollY > 50);
    });

    // ── Hamburger / Mobile Menu Toggle ───────────────────────────
    if (navToggle && navMenu) {
        navToggle.addEventListener('click', (e) => {
            e.stopPropagation();
            const isOpen = navMenu.classList.toggle('open');
            navToggle.innerHTML = isOpen
                ? '<i class="fas fa-times"></i>'
                : '<i class="fas fa-bars"></i>';
        });

        // Close menu when any nav link is tapped
        navMenu.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', () => {
                navMenu.classList.remove('open');
                navToggle.innerHTML = '<i class="fas fa-bars"></i>';
            });
        });
    }

    // ── Close menus on outside click ─────────────────────────────
    document.addEventListener('click', (e) => {
        // Close hamburger menu
        if (navMenu && !e.target.closest('.nav-menu') && !e.target.closest('#navToggle')) {
            navMenu.classList.remove('open');
            if (navToggle) navToggle.innerHTML = '<i class="fas fa-bars"></i>';
        }
        // Close user dropdown
        if (!e.target.closest('.dropdown')) {
            if (userDropdown) userDropdown.style.display = 'none';
        }
    });

    // ── Reset on desktop resize ───────────────────────────────────
    window.addEventListener('resize', () => {
        if (window.innerWidth > 768 && navMenu) {
            navMenu.classList.remove('open');
            if (navToggle) navToggle.innerHTML = '<i class="fas fa-bars"></i>';
        }
    });

    // ── Smooth scroll anchor links ────────────────────────────────
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            if (href === '#') return;
            const target = document.querySelector(href);
            if (target) {
                e.preventDefault();
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });
});

/**
 * Toggle User Profile Dropdown
 */
function toggleDropdown() {
    const dd = document.getElementById('userDropdown');
    if (dd) dd.style.display = (dd.style.display === 'none' || dd.style.display === '') ? 'block' : 'none';
}
