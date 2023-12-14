/** @format */

//NOTE - Checking for empty inputes
let form = document.getElementsByTagName('form')[0];

form.addEventListener('submit', (ev) => {
  ev.preventDefault();
  if (
    title.dataset.oldValue == title.value &&
    description.dataset.oldValue == description.value &&
    gtags.dataset.oldValue == gtags.value
  ) {
  } else {
    if (title.dataset.oldValue == title.value) {
      title.disabled = true;
    }
    if (description.dataset.oldValue == description.value) {
      description.disabled = true;
    }
    if (gtags.dataset.oldValue == gtags.value) {
      gtags.disabled = true;
    }
    form.submit();
  }
});
