/** 
 * UMKM Store - Navbar & Global Interactions
 */
document.addEventListener('DOMContentLoaded', function() {
    const navbar = document.querySelector('.navbar');
    const navToggle = document.getElementById('navToggle');
    const userDropdown = document.getElementById('userDropdown');

    // Sticky Navbar Scroll Effect
    window.addEventListener('scroll', () => {
        if (navbar) {
            navbar.classList.toggle('scrolled', window.scrollY > 50);
        }
    });

    // Mobile Menu Toggle (Legacy check)
    if (navToggle) {
        navToggle.addEventListener('click', () => {
            const menu = document.querySelector('.nav-menu');
            if (menu) menu.classList.toggle('open');
        });
    }

    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            if (href === '#') return;
            
            const target = document.querySelector(href);
            if (target) {
                e.preventDefault();
                target.scrollIntoView({ 
                    behavior: 'smooth', 
                    block: 'start' 
                });
            }
        });
    });

    // Global Click Handler for Dropdowns
    document.addEventListener('click', e => {
        if (!e.target.closest('.dropdown')) {
            if (userDropdown) userDropdown.style.display = 'none';
        }
    });
});

/**
 * Toggle User Profile Dropdown
 */
function toggleDropdown() {
    const dd = document.getElementById('userDropdown');
    if (dd) {
        dd.style.display = dd.style.display === 'none' ? 'block' : 'none';
    }
}
