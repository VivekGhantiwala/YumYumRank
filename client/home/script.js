const scroll = new LocomotiveScroll({
    el: document.querySelector('.main'),
    smooth: true
});

document.addEventListener('DOMContentLoaded', function () {
    const ctaButton = document.getElementById('cta-button');
    const cards = document.querySelectorAll('.card');

    cards.forEach(card => {
        card.addEventListener('mouseenter', function () {
            this.style.transform = 'scale(1.05)';
            this.style.transition = 'transform 0.3s ease';
        });

        card.addEventListener('mouseleave', function () {
            this.style.transform = 'scale(1)';
        });
    });
});
