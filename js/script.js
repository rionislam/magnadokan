/** @format */

// //------ CAROUSEL ------//
// let slidePosition = 0;
// const slides = document.getElementsByClassName('carouselItem');
// let dots = Array.from(document.getElementsByClassName('dot'));
// const totalSlides = slides.length;

// function updateSlidePosition() {
//   for (let slide of slides) {
//     slide.classList.remove('carouselItem_visible');
//     slide.classList.add('carouselItem_hidden');
//   }
//   dots.forEach((element) => {
//     element.classList.remove('active');
//   });
//   slides[slidePosition].classList.remove('carouselItem_hidden');
//   slides[slidePosition].classList.add('carouselItem_visible');
//   dots[slidePosition].classList.add('active');
// }

// dots.forEach((element, i) => {
//   element.addEventListener('mouseover', () => {
//     slidePosition = i;
//     updateSlidePosition();
//   });
// });

// setInterval(function () {
//   if (slidePosition > totalSlides - 2) {
//     slidePosition = 0;
//   } else {
//     slidePosition++;
//   }

//   updateSlidePosition();
// }, 5000);
// let mousePosition = '';
// let mouseStatus = 0;
// let oldPosition = 0;
// let newPosition = 0;
// let booksWrapper = '';
// let article = '';
// let element = '';
// let element1 = '';
// let oldPosition1 = 0;
// let elements = [];

// let slide = (e, event) => {
//   if (mouseStatus) {
//     if (e == element1) {
//       oldPosition1 = oldPosition;
//     }
//     newPosition = event.clientX - mousePosition;
//     position = newPosition - oldPosition;
//     if (position > 0) {
//       position = 0;
//     } else if (
//       booksWrapper.scrollWidth - booksWrapper.clientWidth <
//       -1 * position
//     ) {
//       position = -1 * (booksWrapper.scrollWidth - booksWrapper.clientWidth);
//     }
//     booksWrapper.style.cursor = 'grabbing';
//     booksWrapper.style.transform = 'translateX(' + position + 'px)';
//     // element = e;
//   }
// };

// let mouseDown = (e) => {
//   mouseStatus = 1;
//   mousePosition = e.clientX;
//   target = e.target;
//   if (target.classList.contains('books-wrapper') && target !== element) {
//     element1 = element;
//     element = target;
//     oldPosition1 = oldPosition;
//     oldPosition = 0;
//     console.log('helloa');
//   } else if (
//     target.parentElement.classList.contains('books-wrapper') &&
//     target.parentElement !== element
//   ) {
//     element1 = element;
//     element = target.parentElement;
//     oldPosition1 = oldPosition;
//     oldPosition = 0;
//     console.log('hellob');
//   } else if (
//     target.parentElement.parentElement.classList.contains('books-wrapper') &&
//     target.parentElement.parentElement !== element
//   ) {
//     element1 = element;
//     element = target.parentElement.parentElement;
//     oldPosition1 = oldPosition;
//     oldPosition = 0;
//     console.log('helloc');
//   }
//   booksWrapper = element;
//   article = booksWrapper.getElementsByTagName('article')[0];
// };

// let mouseUp = (e) => {
//   mouseStatus = 0;
//   booksWrapper.style.cursor = 'grab';
//   mousePosition = e.clientX;
//   oldPosition = oldPosition - newPosition;
//   if (oldPosition < 0) {
//     oldPosition = 0;
//   } else if (
//     booksWrapper.scrollWidth - booksWrapper.clientWidth <
//     oldPosition
//   ) {
//     oldPosition = booksWrapper.scrollWidth - booksWrapper.clientWidth;
//   } else {
//     marginLeft = window.getComputedStyle(article).marginLeft;
//     marginRight = window.getComputedStyle(article).marginRight;
//     width =
//       article.offsetWidth + parseFloat(marginRight) + parseFloat(marginLeft);
//     modulas = oldPosition % width;
//     console.log(modulas);
//     if (modulas != 0) {
//       if (modulas < width / 2) {
//         position = oldPosition - modulas;
//       } else if (modulas > width / 2) {
//         position = oldPosition + (width - modulas);
//       } else {
//         position = oldPosition;
//       }
//       booksWrapper.style.transform = 'translateX(-' + position + 'px)';
//       oldPosition = position;
//     }
//   }
// };
window.addEventListener('load', () => {
  //------ SWIPER POPULAR ------//
  try {
    let swiper = new Swiper('.books-container', {
      spaceBetween: 0,
      grabCursor: true,
      centeredSlides: false,
      slidesPerView: 'auto',
      loop: false,
      speed: 400,
    });
  } catch {}

  // signup

  let signupForm = document.getElementById('signup-form');
  let confirmPassword = document.getElementById('confirm-password');
  signupForm.addEventListener('submit', (event) => {
    event.preventDefault();
    if (password.value == confirmPassword.value) {
      signupForm.submit();
    } else {
      alert("Password Doesn't match");
    }
  });
});
