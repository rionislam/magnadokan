/** @format */
import dataConverter from '../utilities/dataConverter.js';
const tags = {
  //NOTE - Add Tag
  add: (tagInput, tag) => {
    let ul = tagInput.parentElement;
    let li = document.createElement('li');
    let text = document.createTextNode(tag);
    li.appendChild(text);
    let img = document.createElement('img');
    img.src = location.origin + '/assets/images/icons/close.svg';
    img.setAttribute('onclick', 'removeTag(this)');
    li.appendChild(img);

    ul.insertBefore(li, tagInput);
    window.tagsArray.push(tag);

    document.getElementsByName('tags')[0].value = dataConverter.arrayToString(
      window.tagsArray,
    );
    let change = new Event('change');
    document.getElementsByName('tags')[0].dispatchEvent(change);
    tagInput.value = '';
  },

  //NOTE - Remove the specific Tag
  remove: (tag) => {
    let index = window.tagsArray.indexOf(tag);
    window.tagsArray = [
      ...window.tagsArray.slice(0, index),
      ...window.tagsArray.slice(index + 1),
    ];
    document.getElementsByName('tags')[0].value = dataConverter.arrayToString(
      window.tagsArray,
    );
    let change = new Event('change');
    document.getElementsByName('tags')[0].dispatchEvent(change);
  },
};

export default tags;
