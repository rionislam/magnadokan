/** @format */

// SECTION - icon image
let icon = document.getElementById('icon');
let icon_img = document.getElementById('icon_img');

icon_img.addEventListener('click', () => {
  icon.click();
});

icon.addEventListener('change', () => {
  img_url = URL.createObjectURL(icon.files[0]);
  uploadFile(icon, ['jpg', 'jpeg', 'png'], '250');
  icon_img.getElementsByClassName(
    'label',
  )[0].innerHTML = `<img src="${img_url}"/>`;
});
