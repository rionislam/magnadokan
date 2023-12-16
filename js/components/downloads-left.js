/** @format */

let showDownloadsLeft = () => {
  let verticalMenu = document.getElementsByClassName('vertical')[0];
  if (verticalMenu.classList.contains('active')) {
    verticalMenu.classList.remove('active');
  }
  let downloadsLeft = document.getElementsByClassName('downloads-left')[0];
  downloadsLeft.style.display = 'flex';
};

window.showDownloadsLeft = showDownloadsLeft;

let hideDownloadsLeft = () => {
  let downloadsLeft = document.getElementsByClassName('downloads-left')[0];
  downloadsLeft.style.display = 'none';
};

window.hideDownloadsLeft = hideDownloadsLeft;

let changeTimer = (ints, value) => {
  value = value.toString().padStart(2, '0');
  let valueInts = value.split('');
  ints[0].innerHTML = valueInts[0];
  ints[1].innerHTML = valueInts[1];
};

import cookieUtil from '../utilities/cookieUtil.js';
window.addEventListener('load', () => {
  let cookieName = 'DOWNLOADS_LEFT';
  let timeLeft = cookieUtil.getRemainingTime(cookieName);
  let cookieValue = cookieUtil.read(cookieName);
  if (cookieValue > 0) {
    let downloadsLeftNumber = document.getElementsByClassName(
      'downloads-left-number',
    )[0];
    downloadsLeftNumber.innerHTML = cookieValue;
    downloadsLeftNumber.style.color = 'var(--green)';
  }
  let leftSecs = timeLeft.remainingSeconds;
  let leftMins = timeLeft.remainingMinutes;
  let leftHours = timeLeft.remainingHours;
  let hour = document.getElementsByClassName('hour')[0];
  let hourInts = hour.getElementsByClassName('int');
  let min = document.getElementsByClassName('min')[0];
  let minInts = min.getElementsByClassName('int');
  let sec = document.getElementsByClassName('sec')[0];
  let secInts = sec.getElementsByClassName('int');
  changeTimer(secInts, leftSecs);
  changeTimer(minInts, leftMins);
  changeTimer(hourInts, leftHours);
  setInterval(() => {
    if (leftMins == 0) {
      leftHours = leftHours - 1;
      changeTimer(hourInts, leftHours);
      leftMins = 59;
      changeTimer(minInts, leftMins);
    } else if (leftSecs == 0) {
      leftMins = leftMins - 1;
      changeTimer(minInts, leftMins);
      leftSecs = 59;
      changeTimer(secInts, leftSecs);
    } else {
      leftSecs = leftSecs - 1;
      changeTimer(secInts, leftSecs);
    }

    if (leftHours == 0 && leftMins == 0 && leftSecs == 0) {
      let expirationDate = new Date();
      expirationDate.setHours(23, 59, 59, 999);
      cookieUtil.create(cookieName, '2', expirationDate);
      leftSecs = 59;
      leftMins = 59;
      leftHours = 23;
    }
  }, 1000);

  window.addEventListener('click', (ev) => {
    let target = ev.target;
    let downloadsLeftContainer = document.getElementsByClassName(
      'downloads-left-container',
    )[0];
    if (
      target.classList.contains('downloads-left-btn') ||
      target.classList.contains('download-btn') ||
      target.parentElement.classList.contains('download-btn') ||
      target == downloadsLeftContainer ||
      target.parentElement == downloadsLeftContainer ||
      target.parentElement.parentElement.parentElement == downloadsLeftContainer
    ) {
    } else {
      hideDownloadsLeft();
    }
  });
});
