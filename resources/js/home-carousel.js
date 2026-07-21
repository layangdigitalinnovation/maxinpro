// Horizontal scroll-by-arrow-button for the "Proyek Baru" carousel on the homepage.
// Deliberately plain scrollBy() rather than a carousel library — one section,
// one behavior, doesn't justify a new dependency.
document.addEventListener('DOMContentLoaded', () => {
    const scroller = document.getElementById('proyek-baru-scroller');
    if (!scroller) return;

    document.querySelectorAll('.proyek-baru-nav').forEach((btn) => {
        btn.addEventListener('click', () => {
            const direction = Number(btn.dataset.scrollDir);
            const cardWidth = 270 + 20; // card width + gap-5 (20px)
            scroller.scrollBy({ left: direction * cardWidth * 2, behavior: 'smooth' });
        });
    });
});
