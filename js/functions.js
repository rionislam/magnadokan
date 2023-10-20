/** @format */

let download = (e, sessionId) => {
  span = e.getElementsByTagName('span')[0];
  if (sessionId == '0') {
    showLoginSignup();
  } else {
    span.style.opacity = 0;
    let i = 0;
    let interval = setInterval(function () {
      i++;
      switch (i) {
        case 1:
          span.innerHTML = 'Generating Link';
          break;
        case 2:
          span.innerHTML = 'Generating Link.';
          break;
        case 3:
          span.innerHTML = 'Generating Link..';
          break;
        case 4:
          span.innerHTML = 'Generating Link...';
          break;
        default:
          i = 0;
      }
      span.style.opacity = 1;
    }, 500);

    setTimeout(function () {
      clearInterval(interval);
      url = location.href + '/download';
      window.location.assign(url);
    }, 5000);
  }
};

let buy = (e) => {
  link = e.dataset.link;
  if (link == '') {
    console.log('No buying link');
  } else {
    window.open(link, '_blank');
  }
};

let showLoginSignup = () => {
  let loginSignup = document.getElementsByClassName('login-signup')[0];
  loginSignup.style.display = 'flex';
  let verticalMenu = document.getElementsByClassName('vertical')[0];
  verticalMenu.classList.remove('active');
  menuBtn.src = 'imgs/menu.svg';
  menuBtn.style.transform = 'rotate(0)';
};

let hideLoginSignup = () => {
  let loginSignup = document.getElementsByClassName('login-signup')[0];
  loginSignup.style.display = 'none';
};

let showMenu = (e) => {
  let verticalMenu = document.getElementsByClassName('vertical')[0];
  if (verticalMenu.classList.contains('active')) {
    verticalMenu.classList.remove('active');
    e.src = 'imgs/menu.svg';
    e.style.transform = 'rotate(0)';
  } else {
    e.style.transform = 'rotate(90deg)';
    verticalMenu.classList.add('active');
    e.src = 'imgs/close.svg';
  }
};

let showMessage = () => {
  message.style.display = 'flex';
  setTimeout(function () {
    messageContainer = document.getElementById('message-container');
    messageContainer.style.marginTop = '2rem';
  }, 100);
  setTimeout(function () {
    hideMessage();
  }, 5000);
};

let hideMessage = () => {
  message.style.display = 'none';
};

let togglePassword = (e) => {
  input = e.parentElement.getElementsByTagName('input')[0];
  if (input.type == 'password') {
    input.type = 'text';
    e.src = location.origin + '/imgs/hidden.svg';
  } else {
    input.type = 'password';
    e.src = location.origin + '/imgs/visible.svg';
  }
};
