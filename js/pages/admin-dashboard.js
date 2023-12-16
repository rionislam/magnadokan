/** @format */
import pie from '../utilities/pie.js';

const dataSet = {
  catagory1: '12',
  catagory2: '28',
  catagory4: '40',
  catagory5: '20',
};
let canvas = document.getElementById('pie_chart');
pie.createPie(canvas, dataSet);
