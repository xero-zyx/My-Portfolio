document.addEventListener("DOMContentLoaded", () => {
  const menuBtn = document.querySelector(".menu-btn");
  const navigation = document.querySelector(".navigation");

  menuBtn.addEventListener("click", () => {
    menuBtn.classList.toggle("active");
    navigation.classList.toggle("active");
  });
});


// submit form 
function submitForm() {
  var form = document.getElementById("myForm");
  var xhr = new XMLHttpRequest();
  xhr.open("POST", form.action, true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.onreadystatechange = function () {
    if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
      alert(xhr.responseText);
      closePopup();
    }
  };
  xhr.send(new FormData(form));
}

function showPopup() {
  document.getElementById("popup-booking").style.display = "block";
}

function closePopup() {
  document.getElementById("popup-booking").style.display = "none";
}

function submitForm() {

  alert("Form submitted successfully!");
  closePopup();
}


// reveal content
window.addEventListener('scroll', reveal);
function reveal() {
  const reveals = document.querySelectorAll('.reveal');
  for (let i = 0; i < reveals.length; i++) {
    const windowheight = window.innerHeight;
    const revealtop = reveals[i].getBoundingClientRect().top;
    const revealpoint = 150;
    if (revealtop < windowheight - revealpoint) {
      reveals[i].classList.add('active');
    }
    else {
      reveals[i].classList.remove('active');
    }
  }
}

/**
 * Gets the navLinks element and shows the navbar by setting its right style property to 0
 */
function showNavbar() {
  const navLinks = document.getElementById("navLinks");
  navLinks.style.right = "0";
}

/**
* Gets the navLinks element and hides the navbar by setting its right style property to -200px
*/
function hideNavbar() {
  const navLinks = document.getElementById("navLinks");
  navLinks.style.right = "-200px";
}

// check box for accepting term and condition
function toggleButton() {
  var checkbox = document.getElementById("Checkbox");
  var button = document.getElementById("submitButton");

  if (checkbox.checked) {
    button.disabled = false;
    button.classList.remove("disabled");
  } else {
    button.disabled = true;
    button.classList.add("disabled");
  }
}

function toggleButton() {
  var checkbox = document.getElementById("Checkbox0");
  var button = document.getElementById("submitButton0");

  if (checkbox.checked) {
    button.disabled = false;
    button.classList.remove("disabled");
  } else {
    button.disabled = true;
    button.classList.add("disabled");
  }
}

// images carousel //

document.addEventListener("DOMContentLoaded", function () {
  const carouselImages = document.querySelectorAll(".right img");
  let currentIndex = 0;
  const intervalTime = 3000; // Delay between slide transitions in milliseconds

  function nextImage() {
    carouselImages[currentIndex].classList.remove("active");
    currentIndex = (currentIndex + 1) % carouselImages.length;
    carouselImages[currentIndex].classList.add("active");
  }

  setInterval(nextImage, intervalTime);
});
