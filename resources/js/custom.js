document.addEventListener('DOMContentLoaded', () => {
    const toggle = document.getElementById('sidebarToggle');
    const sidebar = document.getElementById('sidebar');
    const app = document.getElementById('app');

    if (toggle && sidebar && app) {
        toggle.addEventListener('click', () => {
            sidebar.classList.toggle('collapsed');
            app.classList.toggle('sidebar-collapsed');
        });
    }
});
