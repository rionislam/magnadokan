/** @format */
let formInputChanged = [];
let tags = [];
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

//NOTE - Navigation
let navigate = (e) => {
  removeActive();
  e.classList.add('active');
  page = e.dataset.page;
  url = `includes/${page}.inc.php`;
  window.history.pushState('', '', 'p/' + page);
};
//NOTE - Make all the other navigation unactive
let removeActive = () => {
  actives = Array.from(document.getElementsByClassName('active'));
  actives.forEach((element) => {
    element.classList.remove('active');
  });
};

//NOTE - Add books, catagories, writters etc
let addNew = (type) => {
  window.location.href = `/admin/p/add-${type}`;
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
  window.location.href = `/admin/p/${page}`;
};

let showCategories = () => {
  categoriesDropdown.style.display = 'block';
};

let hideCategories = () => {
  categoriesDropdown.style.display = 'none';
};

let selectCategory = (e) => {
  category.value = e.innerHTML;
  change = new Event('change');
  category.dispatchEvent(change);
  hideCategories();
};

//NOTE - Search options in input
let searchList = (e, type) => {
  ul = document.getElementById(`${type}Dropdown`).getElementsByTagName('ul')[0];
  li = ul.getElementsByTagName('li');
  inputVal = e.value.toUpperCase();
  if (inputVal !== '') {
    for (i = 0; i < li.length; i++) {
      textVal = li[i].textContent || li[i].innerText;
      if (textVal.toUpperCase().indexOf(inputVal) > -1) {
        li[i].style.display = '';
      } else {
        li[i].style.display = 'none';
      }
    }
  } else {
    for (i = 0; i < li.length; i++) {
      li[i].style.display = '';
    }
  }
};

//NOTE - Upload any file specialy picture
let uploadFile = (e, allowed, width = null) => {
  formData = new FormData();
  formData.append('file', e.files[0]);
  formData.append('allowed', JSON.stringify(allowed));
  formData.append('width', width);
  url = location.origin + '/controllers/upload-file.controller.php';
  input = document.createElement('input');
  input.type = 'text';
  input.style.display = 'none';
  input.name = e.id;
  input.setAttribute('required', '');
  fetch(url, {
    method: 'POST',
    body: formData,
  })
    .then((res) => res.text())
    .then((data) => {
      input.value = data;
      e.parentElement.append(input);
    })
    .catch((err) => console.log(err));
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

//NOTE - Create sting from tags
let arrayToString = (array) => {
  string = '';
  for (i = 0; i < array.length; i++) {
    string += array[i] + ', ';
  }
  string = string.substring(0, string.length - 2);
  return string;
};

//SECTION - Tags

//NOTE - Remove the specific Tag
let removeTag = (e) => {
  e.parentElement.remove();
  value = e.parentElement.textContent;
  index = tags.indexOf(value);
  tags = [...tags.slice(0, index), ...tags.slice(index + 1)];
  document.getElementsByName('tags')[0].value = arrayToString(tags);
  change = new Event('change');
  document.getElementsByName('tags')[0].dispatchEvent(change);
};

//NOTE - Add Tag
let addTag = (e, event) => {
  if (event.key == 'Enter' || event.key == ',' || event.key == ';') {
    tag = e.value.replace(/\s+/g, ' ');
    tag = tag.replace(',', '');
    tag = tag.trim();
    ul = e.parentElement;
    tags_input = document.getElementById('tags');
    li = document.createElement('li');
    text = document.createTextNode(tag);
    li.appendChild(text);
    img = document.createElement('img');
    img.src = location.origin + '/imgs/close.svg';
    img.setAttribute('onclick', 'removeTag(this)');
    li.appendChild(img);

    ul.insertBefore(li, tags_input);
    tags.push(tag);
    document.getElementsByName('tags')[0].value = arrayToString(tags);
    change = new Event('change');
    document.getElementsByName('tags')[0].dispatchEvent(change);
    e.value = '';
  }
};

//SECTION - Writters

let showWritters = () => {
  writtersDropdown.style.display = 'block';
};

let hideWritters = () => {
  writtersDropdown.style.display = 'none';
};

let selectWritter = (e) => {
  ul = document.getElementById('writters').parentElement;
  writters_input = document.getElementById('writters');
  li = document.createElement('li');
  text = document.createTextNode(e.innerHTML);
  li.appendChild(text);
  img = document.createElement('img');
  img.src = location.origin + '/imgs/close.svg';
  img.setAttribute('onclick', `removeWritter(this)`);
  li.appendChild(img);

  ul.insertBefore(li, writters_input);
  writters.push(e.innerHTML);
  document.getElementsByName('writters')[0].value = arrayToString(writters);
  change = new Event('change');
  document.getElementsByName('writters')[0].dispatchEvent(change);
  e.remove();
  writters_input.value = '';
  hideWritters();
};

let removeWritter = (e) => {
  e.parentElement.remove();
  value = e.parentElement.textContent;
  li = document.createElement('li');
  li.setAttribute('onclick', `selectWritter(this)`);
  text = document.createTextNode(value);
  li.appendChild(text);
  writtersDropdown.getElementsByTagName('ul')[0].prepend(li);

  index = writters.indexOf(value);
  writters = [...writters.slice(0, index), ...writters.slice(index + 1)];
  document.getElementsByName('writters')[0].value = arrayToString(writters);
  change = new Event('change');
  document.getElementsByName('writters')[0].dispatchEvent(change);
};
