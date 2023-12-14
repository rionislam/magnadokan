/** @format */
import dataConverter from '../utilities/dataConverter.js';
let showCategories = () => {
  categoriesDropdown.style.display = 'block';
};

window.showCategories = showCategories;

let hideCategories = () => {
  categoriesDropdown.style.display = 'none';
};

window.hideCategories = hideCategories;

let selectCategory = (e) => {
  category.value = e.innerHTML;
  // change = new Event('change');
  // category.dispatchEvent(change);
  hideCategories();
};

window.selectCategory = selectCategory;

//NOTE - Search options in input
let searchList = (e, type) => {
  let ul = document
    .getElementById(`${type}Dropdown`)
    .getElementsByTagName('ul')[0];
  let li = ul.getElementsByTagName('li');
  let inputVal = e.value.toUpperCase();
  if (inputVal !== '') {
    for (let i = 0; i < li.length; i++) {
      let textVal = li[i].textContent || li[i].innerText;
      if (textVal.toUpperCase().indexOf(inputVal) > -1) {
        li[i].style.display = '';
      } else {
        li[i].style.display = 'none';
      }
    }
  } else {
    for (let i = 0; i < li.length; i++) {
      li[i].style.display = '';
    }
  }
};

window.searchList = searchList;

//SECTION - Writters

let showWritters = () => {
  writtersDropdown.style.display = 'block';
};

window.showWritters = showWritters;

let hideWritters = () => {
  writtersDropdown.style.display = 'none';
};

window.hideWritters = hideWritters;

let selectWritter = (e) => {
  let ul = document.getElementById('writters').parentElement;
  let writters_input = document.getElementById('writters');
  let li = document.createElement('li');
  let text = document.createTextNode(e.innerHTML);
  li.appendChild(text);
  let img = document.createElement('img');
  img.src = location.origin + '/assets/images/icons/close.svg';
  img.setAttribute('onclick', `removeWritter(this)`);
  li.appendChild(img);

  ul.insertBefore(li, writters_input);
  writters.push(e.innerHTML);
  document.getElementsByName('writters')[0].value =
    dataConverter.arrayToString(writters);
  // change = new Event('change');
  // document.getElementsByName('writters')[0].dispatchEvent(change);
  e.remove();
  writters_input.value = '';
  hideWritters();
};

window.selectWritter = selectWritter;

let removeWritter = (e) => {
  e.parentElement.remove();
  let value = e.parentElement.textContent;
  let li = document.createElement('li');
  li.setAttribute('onclick', `selectWritter(this)`);
  let text = document.createTextNode(value);
  li.appendChild(text);
  writtersDropdown.getElementsByTagName('ul')[0].prepend(li);

  let index = writters.indexOf(value);
  writters = [...writters.slice(0, index), ...writters.slice(index + 1)];
  document.getElementsByName('writters')[0].value =
    dataConverter.arrayToString(writters);
  // change = new Event('change');
  // document.getElementsByName('writters')[0].dispatchEvent(change);
};

window.removeWritter = removeWritter;

//NOTE - Remove a tag
let removeTag = (e) => {
  let tag = e.parentElement.textContent;
  e.parentElement.remove();
  tags.remove(tag);
};

window.removeTag = removeTag;

//NOTE - Submit the update-book form
let updateBook = () => {
  let form = document.getElementsByTagName('form')[0];
  let input = document.createElement('input');
  input.style.display = 'none';
  input.type = 'submit';
  form.append(input);
  input.click();
};

window.updateBook = updateBook;

//NOTE - Submit the update-book form
let addBook = () => {
  let form = document.getElementsByTagName('form')[0];
  let input = document.createElement('input');
  input.style.display = 'none';
  input.type = 'submit';
  form.append(input);
  input.click();
};

window.addBook = addBook;

//NOTE - Check if anything changed
let isDataChanged = () => {
  let same = null;
  // check if the cover image is changed
  if (cover.files.length == 0) {
    cover.disabled = true;
    same += 1;
  }

  // check if the name is changed
  let name = document.getElementById('name');
  if (name.dataset.oldvalue == name.value) {
    name.disabled = true;
    same += 1;
  }

  // check if the pdfId is changed
  if (pdfId.dataset.oldvalue == pdfId.value) {
    pdfId.disabled = true;
    same += 1;
  }

  if (language.dataset.oldvalue == language.value) {
    language.disabled = true;
    same += 1;
  }

  let writters = document.getElementsByName('writters')[0];
  if (writters.dataset.oldvalue == writters.value) {
    writters.disabled = true;
    same += 1;
  }

  if (category.dataset.oldvalue == category.value) {
    category.disabled = true;
    same += 1;
  }

  if (description.dataset.oldvalue == description.value) {
    description.disabled = true;
    same += 1;
  }

  let tags = document.getElementsByName('tags')[0];
  if (tags.dataset.oldvalue == tags.value) {
    tags.disabled = true;
    same += 1;
  }

  return same;
};

window.isDataChanged = isDataChanged;
