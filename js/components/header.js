/** @format */

let showMenu = (e) => {
  let verticalMenu = document.getElementsByClassName('vertical')[0];
  if (verticalMenu.classList.contains('active')) {
    verticalMenu.classList.remove('active');
    e.src = location.origin + '/assets/images/icons/menu.svg';
    e.style.transform = 'rotate(0)';
  } else {
    e.style.transform = 'rotate(90deg)';
    verticalMenu.classList.add('active');
    e.src = location.origin + '/assets/images/icons/close.svg';
  }
};

window.showMenu = showMenu;

import cookieUtil from '../utilities/cookieUtil.js';
window.addEventListener('load', () => {
  try {
    let accountMenu = document.getElementsByClassName('account_menu')[0];
    accountMenu
      .getElementsByTagName('li')[0]
      .addEventListener('mouseover', () => {
        accountMenu.classList.add('active');
      });

    accountMenu.addEventListener('mouseleave', (e) => {
      accountMenu.classList.remove('active');
    });
  } catch {}
  let cookieName = 'DOWNLOADS_LEFT';
  let cookieValue = cookieUtil.read(cookieName);
  if (cookieValue > 0) {
    let downloadsLeftBtn =
      document.getElementsByClassName('downloads-left-btn');
    downloadsLeftBtn[0].innerHTML = '+' + cookieValue;
    downloadsLeftBtn[0].style.background = 'var(--green)';
    downloadsLeftBtn[1].innerHTML = '+' + cookieValue;
    downloadsLeftBtn[1].style.background = 'var(--green)';
  } else {
  }
});
