let currentHeroSlide = 0;
const heroSlides = document.querySelectorAll('.hero-slide');
const heroDots = document.querySelectorAll('.hero-dots .dot');

function showHeroSlide(index) {
    heroSlides.forEach(slide => slide.classList.remove('active'));
    heroDots.forEach(dot => dot.classList.remove('active'));
    
    heroSlides[index].classList.add('active');
    heroDots[index].classList.add('active');
}

function changeHeroSlide(direction) {
    currentHeroSlide += direction;
    if (currentHeroSlide >= heroSlides.length) currentHeroSlide = 0;
    if (currentHeroSlide < 0) currentHeroSlide = heroSlides.length - 1;
    showHeroSlide(currentHeroSlide);
}

function setHeroSlide(index) {
    currentHeroSlide = index;
    showHeroSlide(currentHeroSlide);
}

// Auto-play hero slider
setInterval(() => {
    changeHeroSlide(1);
}, 5000);

// Save property functionality
function toggleSave(button) {
    const icon = button.querySelector('i');
    if (icon.classList.contains('far')) {
        icon.classList.remove('far');
        icon.classList.add('fas');
        button.classList.add('saved');
    } else {
        icon.classList.remove('fas');
        icon.classList.add('far');
        button.classList.remove('saved');
    }
}