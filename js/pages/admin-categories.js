/** @format */
import file from '../utilities/file.js';

// SECTION - icon image
let icon = document.getElementById('icon');
let icon_img = document.getElementById('icon_img');

icon_img.addEventListener('click', () => {
  icon.click();
});

icon.addEventListener('change', () => {
  let img_url = URL.createObjectURL(icon.files[0]);
  let input = document.getElementsByName(icon.id)[0];
  if (typeof input == 'undefined') {
    input = document.createElement('input');
    input.type = 'hidden';
    input.name = icon.id;
    input.setAttribute('required', '');
    icon.parentElement.append(input);
  }

  file.uploadImage(icon.files[0], 'categoryIcon').then((data) => {
    input.value = data;
  });
  icon_img.getElementsByClassName(
    'label',
  )[0].innerHTML = `<img src="${img_url}"/>`;
});
