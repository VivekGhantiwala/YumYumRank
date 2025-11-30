







const scroll = new LocomotiveScroll({
  el: document.querySelector('.main'),
  smooth: true,
  multiplier: 1, // This slows down the scroll speed
  lerp: 0.5, // This makes the scrolling feel smoother and slower
  scrollFromAnywhere: true, // Allows scrolling from anywhere on the page
  smartphone: {
    smooth: true,
    multiplier: 0.5,
  },
  tablet: {
    smooth: true,
    multiplier: 0.5,
  }
});

// Optional: Adjust scroll speed based on scroll direction
scroll.on('scroll', (instance) => {
  const direction = instance.direction;
  if (direction === 'down') {
    instance.multiplier = 0.4; // Even slower when scrolling down
  } else if (direction === 'up') {
    instance.multiplier = 0.6; // Slightly faster when scrolling up
  }
});



const textElements = document.querySelectorAll("text");
const pathElements = document.querySelectorAll("path");
// console.log(textElements)
// console.log(pathElements)
textElements.forEach((textElement, index) => {
  const pathElement = pathElements[index];

  const scoreValue = parseInt(textElement.textContent);
  if (scoreValue <= 3) {
    pathElement.setAttribute("fill", "  #cd0001");
  } else if (scoreValue <= 7) {
    pathElement.setAttribute("fill", "#b3b201");
  } else if (scoreValue <= 10) {
    pathElement.setAttribute("fill", " #008c3e");
  } else {
    pathElement.setAttribute("fill", "#008c3e");
  }
});

const dollarPrice = document.querySelector(".product-data h2");

const INR = document.querySelector(".price p");
// console.log(Math.floor());

// console.log(INR)

let rupee = Math.floor(dollarPrice.textContent.slice(1)) * 83.88;
// console.log(rupee)
INR.innerHTML = "(" + rupee + " / INR)";

const scoreH1 = document.querySelector("#score");
const scoreText = document.querySelector("#score-text");
const scoreDiv = document.querySelector(".score");
// console.log(scoreText.innerHTML);
// scoreH1.textContent = "hi";

// console.log(scoreH1.innerHTML);

if (scoreH1.innerHTML <= 3) {
  scoreText.innerHTML = "Not Recommended";
  scoreText.style.color = "rgb(204, 0, 0)";
  scoreH1.style.color = "rgb(204, 0, 0)";
  scoreDiv.style.backgroundColor = "rgb(255, 204, 204)";
} else if (scoreH1.innerHTML <= 7) {
  scoreText.innerHTML = "Moderate Choice";
  scoreText.style.color = "rgb(204, 153, 0)";
  scoreH1.style.color = "rgb(204, 153, 0)";
  scoreDiv.style.backgroundColor = "rgb(255, 255, 204)";
} else if (scoreH1.innerHTML <= 10) {
  scoreText.innerHTML = "Excellent Choice";
  scoreText.style.color = "rgb(20, 128, 60)";
  scoreH1.style.color = "rgb(20, 128, 60)";
  scoreDiv.style.backgroundColor = "rgb(220, 252, 231)";
}
// Show the popup when the "Rate This Product" button is clicked
document
  .getElementById("openRatingPopupBtn")
  .addEventListener("click", function (event) {
    event.stopPropagation(); // Prevent this click from bubbling to the document
    document.getElementById("ratingPopup").classList.remove("hidden"); // Show popup
  });

// Close the popup when the close button (×) is clicked
document.getElementById("closePopupBtn").addEventListener("click", function () {
  document.getElementById("ratingPopup").classList.add("hidden"); // Hide popup
});

// Close the popup if clicking outside the popup form
document.addEventListener("click", function (event) {
  const popup = document.getElementById("ratingPopup");
  const form = document.querySelector(".reviewForm");

  // If the popup is visible and the click is outside the form, hide the popup
  if (!form.contains(event.target) && !popup.classList.contains("hidden")) {
    popup.classList.add("hidden"); // Hide popup
  }
});

// Prevent closing the popup when clicking inside the .reviewForm
document
  .querySelector(".reviewForm")
  .addEventListener("click", function (event) {
    event.stopPropagation(); // Prevent the click from bubbling up to the document
  });

const stars = document.querySelectorAll(".star");

stars.forEach((star, index) => {
  star.addEventListener("mouseover", function () {
    for (let i = 0; i <= index; i++) {
      stars[i].classList.add("text-yellow-500");
      stars[i].classList.remove("text-gray-400");
    }
    for (let i = index + 1; i < stars.length; i++) {
      stars[i].classList.remove("text-yellow-500");
      stars[i].classList.add("text-gray-400");
    }
  });

  star.addEventListener("mouseout", function () {
    const checkedStar = document.querySelector('input[name="rating"]:checked');
    if (!checkedStar) {
      stars.forEach((star) => {
        star.classList.remove("text-yellow-500");
        star.classList.add("text-gray-400");
      });
    } else {
      const checkedIndex = Array.from(stars).indexOf(
        checkedStar.nextElementSibling
      );
      for (let i = 0; i <= checkedIndex; i++) {
        stars[i].classList.add("text-yellow-500");
        stars[i].classList.remove("text-gray-400");
      }
      for (let i = checkedIndex + 1; i < stars.length; i++) {
        stars[i].classList.remove("text-yellow-500");
        stars[i].classList.add("text-gray-400");
      }
    }
  });

  star.addEventListener("click", function () {
    const checkedStar = document.querySelector('input[name="rating"]:checked');
    stars.forEach((s, i) => {
      if (i <= index) {
        s.classList.add("text-yellow-500");
        s.classList.remove("text-gray-400");
      } else {
        s.classList.remove("text-yellow-500");
        s.classList.add("text-gray-400");
      }
    });
  });
});
