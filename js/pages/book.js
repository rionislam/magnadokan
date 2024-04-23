/** @format */

const articles = Array.from(document.getElementsByTagName('article'));

articles.forEach((article) => {
  window.addEventListener('scroll', () => {
    if (isInViewport(article)) {
      if (article.dataset.impressionCollected == 'false') {
        article.dataset.impressionCollected = true;
        collectImpression(article.dataset.bookId, article.dataset.bookCategory);
      }
    }
  });
});

let description = document.getElementsByClassName('description')[0];
let lineHeight = parseFloat(window.getComputedStyle(description).lineHeight);
let maxLines = parseInt(window.getComputedStyle(description).getPropertyValue('--max-lines'));
let maxHeight = lineHeight * maxLines;
if (description.scrollHeight > maxHeight) {
  showMoreBtn.style.display = 'block'; 
}


