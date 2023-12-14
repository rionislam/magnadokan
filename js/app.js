/** @format */

import cookieUtil from './utilities/cookieUtil.js';

var cookieName = 'DOWNLOADS_LEFT';
var existingValue = cookieUtil.read(cookieName);
if (!existingValue) {
  var expirationDate = new Date();
  expirationDate.setHours(23, 59, 59, 999);
  cookieUtil.create(cookieName, '2', expirationDate);
}
