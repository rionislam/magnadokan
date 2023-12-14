/** @format */
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
