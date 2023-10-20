/** @format */
// SECTION - Cover image
let cover = document.getElementById('cover');
let cover_img = document.getElementById('cover_img');

cover_img.addEventListener('click', () => {
  cover.click();
});

cover.addEventListener('change', () => {
  img_url = URL.createObjectURL(cover.files[0]);
  uploadFile(cover, ['jpg', 'jpeg', 'png'], '250');
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
  if (tags.length == 0 || writters.length == 0) {
    ev.preventDefault();
  } else {
    form.submit();
  }
});
