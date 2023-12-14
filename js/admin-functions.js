/** @format */
let formInputChanged = [];
let writters = [];

//NOTE - To fetch include files
let get = (url, target) => {
  let my_headers = new Headers();
  my_headers.append('pragma', 'no-cache');
  my_headers.append('cache-control', 'no-cache');
  fetch(url, {
    method: 'get',
    headers: my_headers,
  })
    .then(function (response) {
      if (response.status >= 200 && response.status < 300) {
        return response.text();
      }
      throw new Error(response.statusText);
    })
    .then(function (response) {
      target.innerHTML = response;
      return true;
    })
    .catch((err) => console.log('Request Failed', err));
};

//NOTE - Add books, catagories, writters etc
let addNew = (type) => {
  window.location.href = `/admin/add-${type}`;
};

//NOTE - Submit the add-book, add-writters etc forms
let submitForm = (type = null) => {
  form = document.getElementsByTagName('form')[0];
  input = document.createElement('input');
  input.style.display = 'none';
  input.type = 'submit';
  form.append(input);
  input.click();
};

//NOTE - Go back to the main page from the adding page
let back = (page) => {
  window.location.href = `/admin/${page}`;
};

//NOTE - Upload any file specialy picture
let uploadFile = (e, allowed, width = null) => {
  formData = new FormData();
  formData.append('file', e.files[0]);
  formData.append('allowed', JSON.stringify(allowed));
  input = document.createElement('input');
  input.type = 'text';
  input.style.display = 'none';
  input.name = e.id;
  input.setAttribute('required', '');
  // fetch(url, {
  //   method: 'POST',
  //   body: formData,
  // })
  //   .then((res) => res.text())
  //   .then((data) => {
  //     input.value = data;
  //     e.parentElement.append(input);
  //   })
  //   .catch((err) => console.log(err));
};

let showDetails = (e) => {
  main = document.getElementsByTagName('main')[0];
  url = `includes/${e.dataset.type}-details.inc.php?id=${e.dataset.id}`;
  get(url, main);
};

let updateFormInput = (e) => {
  if (e.value !== e.dataset.oldvalue) {
    if (!formInputChanged.includes(e.id)) {
      formInputChanged.push(e.id);
    }
    update.disabled = false;
  } else {
    if (formInputChanged.length == 1 && formInputChanged.includes(e.id)) {
      update.disabled = true;
    } else if (formInputChanged.includes(e.id)) {
      formInputChanged.splice(formInputChanged.indexOf(e.id), 1);
    }
  }
};
