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
