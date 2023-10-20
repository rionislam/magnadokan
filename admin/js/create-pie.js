/** @format */

//NOTE - Create the pie chart
const dataSet = {
  catagory1: '12',
  catagory2: '28',
  catagory4: '40',
  catagory5: '20',
};
const color = [];
let canvas = document.getElementById('pie_chart');
let c = canvas.getContext('2d');
let x = canvas.getBoundingClientRect().height / 2;
let y = canvas.getBoundingClientRect().width / 4;
let starting = -90;
let ending = 0;
color.push(
  getComputedStyle(document.documentElement).getPropertyValue('--accent-1'),
);
color.push(
  getComputedStyle(document.documentElement).getPropertyValue('--green'),
);
color.push(
  getComputedStyle(document.documentElement).getPropertyValue('--danger'),
);
color.push(
  getComputedStyle(document.documentElement).getPropertyValue('--dark-color'),
);

let create_pie_slice = (starting, ending, color) => {
  c.beginPath();
  c.arc(
    x,
    y,
    '70',
    (Math.PI / 180) * starting,
    (Math.PI / 180) * ending,
    false,
  );
  c.lineTo(x, y);
  c.fillStyle = color;
  c.fill();
  c.closePath();
};

let create_pie = () => {
  count = Object.keys(dataSet).length;
  for (i = 0; i < count; i++) {
    ending = starting + (Object.values(dataSet)[i] / 100) * 360;
    create_pie_slice(starting, ending, color[i]);
    starting = ending;
  }
};

create_pie();
