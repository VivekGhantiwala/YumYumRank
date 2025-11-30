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
  
  


menuinfo();







// Scroll function for category panel
// const scrollContainer = document.querySelector('.move');
// const leftButton = document.querySelector('.scroll-button.left');
// const rightButton = document.querySelector('.scroll-button.right');

// leftButton.addEventListener('click', () => {
//     scrollContainer.scrollBy({
//         left: -215, // Scroll left by 150px
//         behavior: 'smooth'
//     });
// });

// rightButton.addEventListener('click', () => {
//     scrollContainer.scrollBy({
//         left: 215, // Scroll right by 150px
//         behavior: 'smooth'
//     });
// });

const textElements = document.querySelectorAll("text");
const pathElements = document.querySelectorAll("path");
console.log(textElements)
console.log(pathElements)
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