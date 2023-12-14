/** @format */
import cookieUtil from '../utilities/cookieUtil.js';

let download_textContainer = document.getElementsByClassName(
  'download_text-container',
)[0];

download_textContainer.style.opacity = 0;
let i = 0;
let interval = setInterval(function () {
  i++;
  switch (i) {
    case 1:
      download_textContainer.innerHTML = 'Downloading';
      break;
    case 2:
      download_textContainer.innerHTML = 'Downloading.';
      break;
    case 3:
      download_textContainer.innerHTML = 'Downloading..';
      break;
    case 4:
      download_textContainer.innerHTML = 'Downloading...';
      break;
    default:
      i = 0;
  }
  download_textContainer.style.opacity = 1;
}, 500);

setTimeout(function () {
  clearInterval(interval);
  download_textContainer.parentElement.innerHTML = `<span>Thanks for downloading. If the download hasn't started autometically, then <a href="https://drive.google.com/uc?export=download&id=${bookPdf}">click here.</a></span>`;
  let url = `https://drive.google.com/uc?export=download&id=${bookPdf}`;
  window.location.assign(url);
  let downloadsLeft = cookieUtil.read('DOWNLOADS_LEFT');
  downloadsLeft = downloadsLeft - 1;
  let expirationDate = new Date();
  expirationDate.setHours(23, 59, 59, 999);
  cookieUtil.create('DOWNLOADS_LEFT', downloadsLeft, expirationDate);
  let downloadsLeftBtn = document.getElementsByClassName('downloads-left-btn');
  let downloadsLeftNumber = document.getElementsByClassName(
    'downloads-left-number',
  )[0];
  downloadsLeftBtn[0].innerHTML = '+' + downloadsLeft;
  downloadsLeftBtn[1].innerHTML = '+' + downloadsLeft;
  downloadsLeftNumber.innerHTML = downloadsLeft;
  if (downloadsLeft == '0') {
    downloadsLeftBtn[0].style.background = 'var(--danger)';
    downloadsLeftBtn[1].style.background = 'var(--danger)';
    downloadsLeftNumber.style.color = 'var(--danger)';
  }
}, 10000);
