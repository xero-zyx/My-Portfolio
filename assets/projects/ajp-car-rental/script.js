'use strict';

/* navbar toggle*/

const overlay = document.querySelector("[data-overlay]");
const navbar = document.querySelector("[data-navbar]");
const navToggleBtn = document.querySelector("[data-nav-toggle-btn]");
const navbarLinks = document.querySelectorAll("[data-nav-link]");

const navToggleFunc = function () {
  navToggleBtn.classList.toggle("active");
  navbar.classList.toggle("active");
  overlay.classList.toggle("active");
}

navToggleBtn.addEventListener("click", navToggleFunc);
overlay.addEventListener("click", navToggleFunc);

for (let i = 0; i < navbarLinks.length; i++) {
  navbarLinks[i].addEventListener("click", navToggleFunc);
}



/* header active on scroll */

const header = document.querySelector("[data-header]");

window.addEventListener("scroll", function () {
  window.scrollY >= 10 ? header.classList.add("active")
    : header.classList.remove("active");
});


/* Adds the 'active' class to elements with the 'reveal' class when they are scrolled into view */
window.addEventListener('scroll', reveal);

function reveal() {
  const reveals = document.querySelectorAll('.reveal');

  for (let i = 0; i < reveals.length; i++) {
    const windowHeight = window.innerHeight;
    const revealTop = reveals[i].getBoundingClientRect().top;
    const revealPoint = 150;

    if (revealTop < windowHeight - revealPoint) {
      reveals[i].classList.add('active');
    } else {
      reveals[i].classList.remove('active');
    }
  }
}


// Retrieve the message from the URL query parameter
const urlParams = new URLSearchParams(window.location.search);
const message = urlParams.get('message');

// Display the alert if a message is present
if (message) {
  alert(message);
}

// images carousel //

document.addEventListener("DOMContentLoaded", function () {
  const carouselImages = document.querySelectorAll(".hero-banner img");
  let currentIndex = 0;
  const intervalTime = 3000; // Delay between slide transitions in milliseconds

  function nextImage() {
    carouselImages[currentIndex].classList.remove("active");
    currentIndex = (currentIndex + 1) % carouselImages.length;
    carouselImages[currentIndex].classList.add("active");
  }

  setInterval(nextImage, intervalTime);
});