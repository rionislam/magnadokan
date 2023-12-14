/** @format */

const request = {
  //NOTE - To send put request
  /**
   * @param {string} url
   * @param {JSON} data
   */
  put: (url, data) => {
    let my_headers = new Headers();
    my_headers.append('pragma', 'no-cache');
    my_headers.append('cache-control', 'no-cache');
    my_headers.append('Content-Type', 'application/json');
    return fetch(url, {
      method: 'PUT',
      headers: my_headers,
      body: data,
    })
      .then(function (response) {
        if (response.status >= 200 && response.status < 300) {
          return response.text();
        }
        throw new Error(response.statusText);
      })
      .then(function (response) {
        return response;
      })
      .catch((err) => console.log('Request Failed', err));
  },

  //NOTE - To send delete request
  /**
   * @param {string} url
   * @param {JSON} data
   */
  del: (url, data) => {
    let my_headers = new Headers();
    my_headers.append('pragma', 'no-cache');
    my_headers.append('cache-control', 'no-cache');
    my_headers.append('Content-Type', 'application/json');
    return fetch(url, {
      method: 'DELETE',
      headers: my_headers,
      body: data,
    })
      .then(function (response) {
        if (response.status >= 200 && response.status < 300) {
          return response.text();
        }
        throw new Error(response.statusText);
      })
      .then(function (response) {
        return response;
      })
      .catch((err) => console.log('Request Failed', err));
  },

  //NOTE - To send get request
  /**
   * @param {string} url
   */
  get: (url) => {
    let my_headers = new Headers();
    my_headers.append('pragma', 'no-cache');
    my_headers.append('cache-control', 'no-cache');
    return fetch(url, {
      method: 'get',
      headers: my_headers,
    })
      .then(function (response) {
        if (response.status >= 200 && response.status < 300) {
          return response.text();
        }
        throw new Error(response.statusText);
      })
      .then(function (response) {
        return response;
      })
      .catch((err) => console.log('Request Failed', err));
  },

  //NOTE - To send get request
  /**
   * @param {string} url
   * @param {FormData} data
   */
  post: (url, data) => {
    let my_headers = new Headers();
    my_headers.append('pragma', 'no-cache');
    my_headers.append('cache-control', 'no-cache');
    return fetch(url, {
      method: 'POST',
      headers: my_headers,
      body: data,
    })
      .then(function (response) {
        if (response.status >= 200 && response.status < 300) {
          return response.text();
        }
        throw new Error(response.statusText);
      })
      .then(function (response) {
        return response;
      })
      .catch((err) => console.log('Request Failed', err));
  },
};

export default request;
