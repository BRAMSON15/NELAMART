/**
 * UMKM Store - Sidebar Control
 */
document.addEventListener('DOMContentLoaded', () => {
    const sidebar = document.getElementById('sidebar');
    const toggle = document.querySelector('.mobile-toggle') || document.querySelector('.sidebar-toggle');

    if (toggle) {
        toggle.addEventListener('click', (e) => {
            e.stopPropagation();
            if (sidebar) sidebar.classList.toggle('active');
        });
    }

    // Close sidebar when clicking outside on mobile
    document.addEventListener('click', (event) => {
        if (!sidebar) return;
        
        if (window.innerWidth <= 768) {
            const toggle = document.querySelector('.mobile-toggle') || document.querySelector('.sidebar-toggle');
            if (toggle && !sidebar.contains(event.target) && !toggle.contains(event.target)) {
                sidebar.classList.remove('active');
            }
        }
    });
});

/**
 * Handle mobile toggle (helper for legacy calls)
 */
function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    if (sidebar) sidebar.classList.toggle('active');
}
