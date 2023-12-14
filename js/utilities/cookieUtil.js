/** @format */

const cookieUtil = {
  create: (name, value, expirationDate) => {
    var expires = '';

    if (expirationDate instanceof Date) {
      expires = '; expires=' + expirationDate.toGMTString();
    }

    document.cookie =
      name + '=' + encodeURIComponent(value) + expires + '; path=/';

    // Also store the expiration date separately
    document.cookie =
      name + '_expires=' + expirationDate.toUTCString() + '; path=/';
  },

  read: (name) => {
    var nameEQ = name + '=';
    var cookies = document.cookie.split(';');

    for (var i = 0; i < cookies.length; i++) {
      var cookie = cookies[i].trim();
      if (cookie.indexOf(nameEQ) === 0) {
        var cookieValue = decodeURIComponent(cookie.substring(nameEQ.length));

        // Check if the cookie has expired
        if (cookieUtil.hasCookieExpired(name)) {
          // Remove expired cookie
          document.cookie =
            name + '=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;';
          document.cookie =
            name + '_expires=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;';
          return null;
        }

        return cookieValue;
      }
    }

    return null;
  },

  // Function to check if the date has changed since the cookie was created
  hasCookieExpired: (name) => {
    var expirationCookie = document.cookie
      .split(';')
      .map((cookie) => cookie.trim())
      .find((cookie) => cookie.startsWith(name + '_expires='));

    if (!expirationCookie) {
      // If the expiration date cookie is not found, consider the cookie expired
      return true;
    }

    // Extract the expiration date string
    var expirationDateString = expirationCookie.split('=')[1].trim();
    var expirationDate = expirationDateString
      ? new Date(expirationDateString)
      : null;

    return expirationDate && expirationDate < new Date();
  },

  getRemainingTime: (cookieName) => {
    var cookie = document.cookie
      .split(';')
      .map((cookie) => cookie.trim())
      .find((cookie) => cookie.startsWith(cookieName + '='));

    var expirationCookie = document.cookie
      .split(';')
      .map((cookie) => cookie.trim())
      .find((cookie) => cookie.startsWith(cookieName + '_expires='));

    if (!cookie || !expirationCookie) {
      // If the cookie with the specified name is not found, consider it expired
      return {
        expired: true,
        remainingHours: 0,
        remainingMinutes: 0,
        remainingSeconds: 0,
      };
    }

    // Extract the expiration date string
    var expirationDateString = expirationCookie.split('=')[1].trim();
    var expirationDate = expirationDateString
      ? new Date(expirationDateString)
      : null;

    // Check if the expiration date is valid
    if (!expirationDate || isNaN(expirationDate.getTime())) {
      return {
        expired: true,
        remainingHours: 0,
        remainingMinutes: 0,
        remainingSeconds: 0,
      };
    }

    var now = new Date();
    var remainingTime = expirationDate - now;

    if (remainingTime <= 0) {
      return {
        expired: true,
        remainingHours: 0,
        remainingMinutes: 0,
        remainingSeconds: 0,
      };
    }

    var remainingHours = Math.floor(remainingTime / (1000 * 60 * 60));
    var remainingMinutes = Math.floor(
      (remainingTime % (1000 * 60 * 60)) / (1000 * 60),
    );
    var remainingSeconds = Math.floor((remainingTime % (1000 * 60)) / 1000);

    return {
      expired: false,
      remainingHours,
      remainingMinutes,
      remainingSeconds,
    };
  },
};

export default cookieUtil;
