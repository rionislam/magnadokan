/** @format */

const pie = {
  createPieSlice: (starting, ending, color, c, x, y) => {
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
  },

  createPie: (canvas, dataSet) => {
    const colors = [];
    let c = canvas.getContext('2d');
    let x = canvas.getBoundingClientRect().height / 2;
    let y = canvas.getBoundingClientRect().width / 4;
    let starting = -90;
    let ending = 0;
    colors.push(
      getComputedStyle(document.documentElement).getPropertyValue('--danger'),
    );
    colors.push(
      getComputedStyle(document.documentElement).getPropertyValue('--green'),
    );
    colors.push(
      getComputedStyle(document.documentElement).getPropertyValue('--accent-1'),
    );
    colors.push(
      getComputedStyle(document.documentElement).getPropertyValue(
        '--dark-color',
      ),
    );
    let count = Object.keys(dataSet).length;
    for (let i = 0; i < count; i++) {
      ending = starting + (Object.values(dataSet)[i] / 100) * 360;
      pie.createPieSlice(starting, ending, colors[i], c, x, y);
      starting = ending;
    }
  },
};

export default pie;
