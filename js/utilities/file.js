/** @format */
// this utility is only used for admin till now
import request from './request.js';
const file = {
  uploadImage: (file, purpous) => {
    let formData = new FormData();
    formData.append('file', file);
    formData.append('purpous', purpous);
    let url = location.origin + '/admin/upload-image';
    return request.post(url, formData).then((data) => {
      return data;
    });
  },
};

export default file;
