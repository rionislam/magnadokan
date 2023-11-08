/** @format */
//SECTION - Variables
const slider_wrappers = Array.from(
  document.getElementsByClassName('slider-wrapper'),
);

slider_wrappers.forEach((element) => {
  const slides = element.getElementsByClassName('slide');
  let slideWidth = slides[0].offsetWidth;
  let mouseOldPosition = 0;
  let slideOldPosition = 0;
  let slideNewPosition = 0;
  let mouseDown = 0;
  //SECTION - Add active amd next classes to the slide
  slides[0].classList.add('slide-active');
  slides[1].classList.add('slide-next');

  element.addEventListener('mousedown', (e) => {
    slideWidth = slides[0].offsetWidth;

    mouseOldPosition = e.pageX;
    mouseDown = 1;

    window.addEventListener('mousemove', (e) => {
      if (mouseDown > 0) {
        element.classList.add('dragging');
        slideNewPosition = e.pageX - mouseOldPosition + slideOldPosition;
        if (
          slideNewPosition <
          slides.length * slideWidth * -1 + slideWidth * 4
        ) {
          slideNewPosition =
            (e.pageX - mouseOldPosition) / 2 + slideOldPosition;
        } else if (slideNewPosition > 0) {
          slideNewPosition =
            (e.pageX - mouseOldPosition) / 2 + slideOldPosition;
        }
        element.style.transform = `translate3d(${slideNewPosition}px, 0px, 0px)`;
      }
    });
  });

  window.addEventListener('mouseup', () => {
    element.classList.remove('dragging');
    mouseDown = 0;
    if (slideNewPosition % slideWidth != 0) {
      if (slideNewPosition > 0) {
        slideNewPosition = 0;
      } else if (
        slideNewPosition <
        slides.length * slideWidth * -1 + slideWidth * 4
      ) {
        slideNewPosition = slides.length * slideWidth * -1 + slideWidth * 4;
      } else if (
        -1 * (slideNewPosition % slideWidth) >= slideWidth / 2 &&
        slideNewPosition < slideOldPosition
      ) {
        slideNewPosition =
          slideNewPosition - (slideNewPosition % slideWidth) - slideWidth;
      } else if (
        -1 * (slideNewPosition % slideWidth) < slideWidth / 3 &&
        slideNewPosition > slideOldPosition
      ) {
        slideNewPosition =
          slideNewPosition - (slideNewPosition % slideWidth) - slideWidth;
      } else {
        slideNewPosition = slideNewPosition - (slideNewPosition % slideWidth);
      }
      element.style.transform = `translate3d(${slideNewPosition}px, 0px, 0px)`;
    }

    let slidePostion = (-1 * slideNewPosition) / slideWidth;
    if (slidePostion !== 0) {
      removeClass(slides, 'slide-active', 'slide-prev', 'slide-next');
      slides[slidePostion].classList.add('slide-active');
      slides[slidePostion + 1].classList.add('slide-next');
      slides[slidePostion - 1].classList.add('slide-prev');
    } else {
      slides[0].classList.add('slide-active');
      slides[1].classList.add('slide-next');
    }

    slideOldPosition = slideNewPosition;
    slideNewPosition = 0;
  });

  //NOTE - For mobile device
  element.addEventListener('touchstart', (e) => {
    slideWidth = slides[0].offsetWidth;
    mouseOldPosition = e.touches[0].pageX;
    element.addEventListener('touchmove', (e) => {
      slideNewPosition =
        e.touches[e.touches.length - 1].pageX -
        mouseOldPosition +
        slideOldPosition;
      element.style.transform = `translate3d(${slideNewPosition}px, 0px, 0px)`;
    });
  });

  window.addEventListener('touchend', () => {
    if (slideNewPosition % slideWidth != 0) {
      if (slideNewPosition > 0) {
        slideNewPosition = 0;
      } else if (
        slideNewPosition <
        slides.length * slideWidth * -1 + element.offsetWidth
      ) {
        slideNewPosition =
          slides.length * slideWidth * -1 + element.offsetWidth;
      } else if (
        -1 * (slideNewPosition % slideWidth) > slideWidth / 4 &&
        slideNewPosition < slideOldPosition
      ) {
        slideNewPosition =
          slideNewPosition - (slideNewPosition % slideWidth) - slideWidth;
      } else if (
        -1 * (slideNewPosition % slideWidth) < slideWidth / 4 &&
        slideNewPosition > slideOldPosition
      ) {
        slideNewPosition =
          slideNewPosition - (slideNewPosition % slideWidth) - slideWidth;
      } else {
        slideNewPosition = slideNewPosition - (slideNewPosition % slideWidth);
      }
      element.style.transform = `translate3d(${slideNewPosition}px, 0px, 0px)`;
    }

    let slidePostion = (-1 * slideNewPosition) / slideWidth;
    if (slidePostion !== 0) {
      removeClass(slides, 'slide-active', 'slide-prev', 'slide-next');
      slides[slidePostion].classList.add('slide-active');
      slides[slidePostion + 1].classList.add('slide-next');
      slides[slidePostion - 1].classList.add('slide-prev');
    } else {
      slides[0].classList.add('slide-active');
      slides[1].classList.add('slide-next');
    }

    slideOldPosition = slideNewPosition;
    slideNewPosition = 0;
  });
});

const removeClass = (elements, ...classNames) => {
  array = Array.from(elements);
  array.forEach((element) => {
    for (let i = 0; i < classNames.length; i++) {
      if (element.classList.contains(classNames[i])) {
        element.classList.remove(classNames[i]);
      }
    }
  });
};
