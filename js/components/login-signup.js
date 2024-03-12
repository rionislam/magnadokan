/** @format */
import formUtil from '../utilities/formUtil.js';

let showLoginSignup = () => {
  let loginSignup = document.getElementsByClassName('login-signup')[0];
  loginSignup.style.display = 'flex';
  let verticalMenu = document.getElementsByClassName('vertical')[0];
  verticalMenu.classList.remove('active');
  menuBtn.src = location.origin + '/assets/images/icons/menu.svg';
  menuBtn.style.transform = 'rotate(0)';
};

window.showLoginSignup = showLoginSignup;

let hideLoginSignup = () => {
  let loginSignup = document.getElementsByClassName('login-signup')[0];
  loginSignup.style.display = 'none';
};

window.hideLoginSignup = hideLoginSignup;

let togglePassword = (e) => {
  let input = e.parentElement.getElementsByTagName('input')[0];
  if (input.type == 'password') {
    input.type = 'text';
    e.src = 'assets/images/icons/hidden.svg';
  } else {
    input.type = 'password';
    e.src = 'assets/images/icons/visible.svg';
  }
};

window.togglePassword = togglePassword;

document.addEventListener('click', (ev) => {
  let target = ev.target;
  window.test = target;
  let formsContainer = document.getElementsByClassName('forms-container')[0];
  if (
    target.classList.contains('login-btn') ||
    target.classList.contains('add-to-libray-btn') ||
    target.parentElement.classList.contains('add-to-libray-btn') ||
    target.tagName == 'A' ||
    target == formsContainer ||
    target.parentElement.parentElement == formsContainer ||
    target.parentElement.parentElement.parentElement == formsContainer
  ) {
  } else {
    hideLoginSignup();
  }
});

fullName.addEventListener('input', () => {
  if (fullName.classList.contains('invalid')) {
    formUtil.validateFullname(fullName);
  }
});

username.addEventListener('input', () => {
  if (username.classList.contains('invalid')) {
    formUtil.validateUsername(username);
  }
});

email.addEventListener('input', () => {
  if (email.classList.contains('invalid')) {
    formUtil.validateEmail(email);
  }
});

password.addEventListener('input', () => {
  if (password.classList.contains('invalid')) {
    formUtil.validatePassword(password);
  }
});

confirmPassword.addEventListener('input', () => {
  if (confirmPassword.classList.contains('invalid')) {
    formUtil.validateConfirmPassword(confirmPassword, password);
  }
});

let signupForm = document.getElementById('signup-form');

signupBtn.addEventListener('click', (event) => {
  event.preventDefault();
  if (formUtil.validateFullname(fullName)) {
    if (formUtil.validateUsername(username)) {
      if (formUtil.validateEmail(email)) {
        if (formUtil.validatePassword(password)) {
          if (formUtil.validateConfirmPassword(confirmPassword, password)) {
            signupForm.submit();
          }
        }
      }
    }
  }
});
// signupForm.addEventListener('submit', (event) => {
//   event.preventDefault();
//   formUtil.validateUsername(username);
//   console.log('hello');
//   if (password.value == confirmPassword.value) {
//     signupForm.submit();
//   } else {
//     alert("Password Doesn't match");
//   }
// });
