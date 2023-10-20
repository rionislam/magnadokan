/** @format */

window.addEventListener('load', () => {
  let nav = document.getElementsByTagName('nav')[0];
  let menuItems = nav.getElementsByTagName('li');
  menuItems = Array.from(menuItems);

  // let url = window.location;
  // let path = url.pathname;
  // let pattern = /\/p\/(.*)/g;
  // if (pattern.test(path)) {
  //   result = path.match(pattern);
  //   p = result[0].split('/')[2];
  //   removeActive();
  //   menuItems.forEach((e) => {
  //     if (p == e.dataset.page) {
  //       e.classList.add('active');
  //     }
  //   });
  // }

  document.addEventListener('click', (e) => {
    try {
      if (
        e.target.id != 'writters' &&
        e.target.id != 'writtersDropdown' &&
        e.target.parentElement.className != 'writters-container' &&
        e.target.parentElement.id != 'writtersDropdown' &&
        e.target.parentElement.parentElement.id != 'writtersDropdown'
      ) {
        writtersDropdown.style.display = 'none';
      }

      if (
        e.target.id != 'category' &&
        e.target.id != 'categoriesDropdown' &&
        e.target.parentElement.id != 'categoriesDropdown' &&
        e.target.parentElement.parentElement.id != 'categoriesDropdown'
      ) {
        categoriesDropdown.style.display = 'none';
      }
    } catch {}
  });

  window.addEventListener('popstate', () => {
    let url = window.location;
    let path = url.pathname;
    let pattern = /\/p\/(.*)/g;
    main = document.getElementsByTagName('main')[0];
    if (pattern.test(path)) {
      result = path.match(pattern);
      p = result[0].split('/')[2];
      url = `includes/${p}.inc.php`;
      get(url, main);
      removeActive();
      menuItems.forEach((e) => {
        if (p == e.dataset.page) {
          e.classList.add('active');
        }
      });
    } else {
      url = `includes/dashboard.inc.php`;
      get(url, main);
      removeActive();
      menuItems.forEach((e) => {
        if ('dashboard' == e.dataset.page) {
          e.classList.add('active');
        }
      });
    }
  });
});
