/** @format */

let showMessage = (messageTxt, messageType) => {
  message.style.display = 'flex';
  let imgSrc = location.origin + '/assets/images/icons/close.svg';
  message.innerHTML = `<div class="${messageType}" id="message-container"><span>${messageTxt}</span><img onclick="hideMessage()" src="${imgSrc}"></div>`;
  setTimeout(function () {
    let messageContainer = document.getElementById('message-container');
    messageContainer.style.opacity = 1;
  }, 100);
  setTimeout(function () {
    hideMessage();
  }, 2400);
};

window.showMessage = showMessage;

let hideMessage = () => {
  let messageContainer = document.getElementById('message-container');
  messageContainer.remove();
};

window.hideMessage = hideMessage;
