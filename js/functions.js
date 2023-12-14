/** @format */

//NOTE - To put data
/**
 * @param {string} url
 * @param {JSON} data
 */
let put = (url, data) => {
  let my_headers = new Headers();
  my_headers.append('pragma', 'no-cache');
  my_headers.append('cache-control', 'no-cache');
  my_headers.append('Content-Type', 'application/json');
  return fetch(url, {
    method: 'PUT',
    headers: my_headers,
    body: data,
  })
    .then(function (response) {
      if (response.status >= 200 && response.status < 300) {
        return response.text();
      }
      throw new Error(response.statusText);
    })
    .then(function (response) {
      return response;
    })
    .catch((err) => console.log('Request Failed', err));
};

//NOTE - To delete data
/**
 * @param {string} url
 * @param {JSON} data
 */
let del = (url, data) => {
  let my_headers = new Headers();
  my_headers.append('pragma', 'no-cache');
  my_headers.append('cache-control', 'no-cache');
  my_headers.append('Content-Type', 'application/json');
  return fetch(url, {
    method: 'DELETE',
    headers: my_headers,
    body: data,
  })
    .then(function (response) {
      if (response.status >= 200 && response.status < 300) {
        return response.text();
      }
      throw new Error(response.statusText);
    })
    .then(function (response) {
      return response;
    })
    .catch((err) => console.log('Request Failed', err));
};

// let buy = (e) => {
//   link = e.dataset.link;
//   if (link == '') {
//     console.log('No buying link');
//   } else {
//     window.open(link, '_blank');
//   }
// };

let collectImpression = (bookId, bookCategory) => {
  let event = 'impression';
  let data = {
    event: event,
    bookId: bookId,
    bookCategory: bookCategory,
  };
  put(location.origin + '/collect-book-log', JSON.stringify(data));
};

let isInViewport = (el) => {
  const rect = el.getBoundingClientRect();
  return (
    rect.top >= 0 &&
    rect.left >= 0 &&
    rect.bottom <=
      (window.innerHeight || document.documentElement.clientHeight) &&
    rect.right <= (window.innerWidth || document.documentElement.clientWidth)
  );
};

let addToLibrary = (el, userId) => {
  if (userId > 0) {
    let bookId = el.dataset.bookId;
    let data = {
      bookId: bookId,
    };
    put(location.origin + '/add-to-library', JSON.stringify(data)).then(
      (response) => {
        if (response == 'true') {
          showMessage('Added Successfuly', 'notification');
          el.disabled = true;
          el.innerHTML =
            '<svg class="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 60 60"><circle class="circle" cx="30" cy="30" r="30" fill="none"/><path class="check" fill="none" d="m12.5 28l10.0 13 24-22.2"/></svg>' +
            'Added To Library';
        } else {
          showMessage("Couldn't add. Please try again later!", 'error');
        }
      },
    );
  } else {
    showLoginSignup();
  }
};

let removeFromLibrary = (el) => {
  let libraryId = el.dataset.libraryId;
  let data = {
    libraryId: libraryId,
  };
  del(location.origin + '/remove-from-library', JSON.stringify(data)).then(
    (response) => {
      if (response == 'true') {
        el.parentElement.parentElement.remove();
        showMessage('Removed Successfuly', 'notification');
      } else {
        showMessage("Couldn't remove. Please try again later!", 'error');
      }
    },
  );
};
