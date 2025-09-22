// Banner Slider Functionality
let currentSlide = 0
const slides = document.querySelectorAll(".slide")
const dots = document.querySelectorAll(".dot")

function showSlide(index) {
  slides.forEach((slide) => slide.classList.remove("active"))
  dots.forEach((dot) => dot.classList.remove("active"))
  if (slides[index]) {
    slides[index].classList.add("active")
    dots[index].classList.add("active")
  }
}

function changeSlide(direction) {
  currentSlide += direction

  if (currentSlide >= slides.length) {
    currentSlide = 0
  } else if (currentSlide < 0) {
    currentSlide = slides.length - 1
  }

  showSlide(currentSlide)
}

function currentSlideIndex(index) {
  currentSlide = index - 1
  showSlide(currentSlide)
}

function autoSlide() {
  currentSlide++
  if (currentSlide >= slides.length) {
    currentSlide = 0
  }
  showSlide(currentSlide)
}

if (slides.length > 0) {
  setInterval(autoSlide, 5000)
}




