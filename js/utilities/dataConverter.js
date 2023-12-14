/** @format */
const dataConverter = {
  arrayToString: (array) => {
    let string = '';
    for (let i = 0; i < array.length; i++) {
      string += array[i] + ', ';
    }
    string = string.substring(0, string.length - 2);
    return string;
  },
};

export default dataConverter;
