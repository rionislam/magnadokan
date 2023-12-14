/** @format */
import tags from '../utilities/tags.js';
import file from '../utilities/file.js';

/** @format */
// SECTION - Cover image
let cover = document.getElementById('cover');
let cover_img = document.getElementById('cover_img');

cover_img.addEventListener('click', () => {
  cover.click();
});

cover.addEventListener('change', () => {
  let img_url = URL.createObjectURL(cover.files[0]);
  let input = document.getElementsByName(cover.id)[0];
  if (typeof input == 'undefined') {
    input = document.createElement('input');
    input.type = 'hidden';
    input.name = cover.id;
    input.setAttribute('required', '');
    cover.parentElement.append(input);
  }

  file.uploadImage(cover.files[0], 'bookCover').then((data) => {
    input.value = data;
  });
  cover_img.getElementsByClassName(
    'label',
  )[0].innerHTML = `<img src="${img_url}"/>`;
});

//SECTION - PDF file
let pdf = document.getElementById('pdf');
let pdf_file = document.getElementById('pdf_file');

pdf_file.addEventListener('click', () => {
  pdf.click();
});

pdf.addEventListener('change', () => {
  pdf_file.getElementsByClassName(
    'label',
  )[0].innerHTML = `<iframe src='${URL.createObjectURL(
    pdf.files[0],
  )}'></iframe>`;
});

//NOTE - Checking for empty inputes
let form = document.getElementsByTagName('form')[0];

form.addEventListener('submit', (ev) => {
  ev.preventDefault();
  let sameData = isDataChanged();
  if (sameData == 8) {
    ev.preventDefault();
  } else {
    form.submit();
  }
});

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

//NOTE -  For tags input
let tagInput = document.getElementById('tagInput');

tagInput.addEventListener('keyup', (event) => {
  if (typeof window.tagsArray == 'undefined') {
    window.tagsArray = [];
  }
  if (event.key == 'Enter' || event.key == ',' || event.key == ';') {
    if (tagInput.value != '') {
      let tag = tagInput.value.replace(/\s+/g, ' ');
      tag = tag.replace(',', '');
      tag = tag.trim();
      tags.add(tagInput, tag);
    }
  } else if (event.key == 'Backspace' && tagInput.value == '') {
    let lis = tagInput.parentElement.getElementsByTagName('li');
    let lastTag = lis[lis.length - 1];
    let tag = lastTag.textContent;
    lastTag.remove();
    tagInput.value = tag;
  }
});
