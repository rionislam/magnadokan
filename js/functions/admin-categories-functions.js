/** @format */

//NOTE - Submit the add-category form
let addCategory = () => {
  let form = document.getElementsByTagName('form')[0];
  let input = document.createElement('input');
  input.style.display = 'none';
  input.type = 'submit';
  form.append(input);
  input.click();
};

window.addCategory = addCategory;
