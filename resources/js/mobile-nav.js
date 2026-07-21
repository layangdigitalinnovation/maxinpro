document.addEventListener('DOMContentLoaded', () => {
    const toggle = document.getElementById('mobile-nav-toggle');
    const panel = document.getElementById('mobile-nav-panel');
    if (!toggle || !panel) return;

    toggle.addEventListener('click', () => {
        panel.classList.toggle('hidden');
    });
});
