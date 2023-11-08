/** @format */

window.addEventListener('load', () => {
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

const sliders = Array.from(document.getElementsByClassName('slider'));

sliders.forEach((slider) => {
  window.addEventListener('scroll', () => {
    if (isInViewport(slider)) {
      const slides = slider.getElementsByClassName('slide');
      let slideActive = slider.getElementsByClassName('slide-active')[0];
      let index = Array.from(slides).indexOf(slideActive);
      let slideWidth = slides[0].offsetWidth;
      let sliderWidth = slider.offsetWidth;
      let count = sliderWidth / slideWidth;
      for (let i = 0; i < count; i++) {
        let slide = slides[index + i];

        if (slide.dataset.impressionCollected == 'false') {
          slide.dataset.impressionCollected = true;
          collectImpression(slide.dataset.bookId, slide.dataset.bookCategory);
        }
      }
    }
  });
});
