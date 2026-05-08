/** 
 * UMKM Store - Navbar & Global Interactions
 */
document.addEventListener('DOMContentLoaded', function() {
    const navbar = document.querySelector('.navbar');
    const userDropdownBtn = document.getElementById('userDropdownBtn');
    const userDropdownMenu = document.getElementById('userDropdownMenu');

    // ── Sticky scroll effect ─────────────────────────────────────
    window.addEventListener('scroll', () => {
        if (navbar) navbar.classList.toggle('scrolled', window.scrollY > 50);
    });

    // ── User Dropdown Toggle ─────────────────────────────────────
    if (userDropdownBtn && userDropdownMenu) {
        userDropdownBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            userDropdownMenu.classList.toggle('show');
        });
    }

    // ── Close dropdown on outside click ──────────────────────────
    document.addEventListener('click', (e) => {
        if (userDropdownMenu && !e.target.closest('.user-dropdown-wrapper')) {
            userDropdownMenu.classList.remove('show');
        }
    });

    // ── Reset on desktop resize ───────────────────────────────────
    window.addEventListener('resize', () => {
        if (window.innerWidth > 768 && userDropdownMenu) {
            userDropdownMenu.classList.remove('show');
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
 * Toggle User Profile Dropdown (Legacy support)
 */
function toggleDropdown() {
    const menu = document.getElementById('userDropdownMenu');
    if (menu) menu.classList.toggle('show');
}
