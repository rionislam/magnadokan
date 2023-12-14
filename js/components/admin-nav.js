/** @format */

//NOTE - Navigation
let navigate = (e) => {
  removeActive();
  e.classList.add('active');
  page = e.dataset.page;
  url = `includes/${page}.inc.php`;
  // window.history.pushState('', '', 'admin/' + page);
};
//NOTE - Make all the other navigation unactive
let removeActive = () => {
  actives = Array.from(document.getElementsByClassName('active'));
  actives.forEach((element) => {
    element.classList.remove('active');
  });
};
