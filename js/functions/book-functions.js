/** @format */
import cookieUtil from '../utilities/cookieUtil.js';

let download = (e, userId) => {
  let downloadLeft = cookieUtil.read('DOWNLOADS_LEFT');
  if (userId > 0 || downloadLeft > 0) {
    let span = e.getElementsByTagName('span')[0];
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
      let url = location.href + '/download';
      window.location.assign(url);
    }, 5000);
  } else {
    showDownloadsLeft();
  }
};

window.download = download;

let showMore = (e) => {
  if (e.innerHTML == 'Show more...') {
    e.innerHTML = 'Show less...';
    e.parentElement.getElementsByTagName('p')[0].classList.add('shown');
  } else {
    e.innerHTML = 'Show more...';
    e.parentElement.getElementsByTagName('p')[0].classList.remove('shown');
  }
};

window.showMore = showMore;
