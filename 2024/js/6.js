const { AdventOfCode } = require("api");

const input = new AdventOfCode().input(6);
var data = input.lines().raw();

var sx, sy;

data.forEach((line, i) => {
  p = line.search(/\^/);
  if (-1 !== p) {
    sx = p;
    sy = i;
  }
  data[i] = line.split("");
});

offsets = [
  [0, -1],
  [1, 0],
  [0, 1],
  [-1, 0],
];

let x = sx;
let y = sy;
let d = 0;
let steps = new Set();
steps.add(`${x}|${y}`);
let done = false;
do {
  const nx = x + offsets[d][0];
  const ny = y + offsets[d][1];

  if (data[ny] && data[ny][nx]) {
    if (data[ny][nx] == "#") {
      d = ++d % 4;
    } else {
      x = nx;
      y = ny;
      steps.add(`${x}|${y}`);
    }
  } else {
    done = true;
  }
} while (!done);
steps = [...steps];
console.log(steps.length);
// process.exit(0);

const jsonclone = (a) => {
  return JSON.parse(JSON.stringify(a));
};

const template = jsonclone(data);
total = 0;
for (let i = 1; i < steps.length; i++) {
  data = jsonclone(template);
  [bx, by] = steps[i].split("|");
  data[by][bx] = "#";

  x = sx;
  y = sy;
  d = 0;
  previous = {};
  done = false;
  do {
    const nx = x + offsets[d][0];
    const ny = y + offsets[d][1];

    if (data[ny] && data[ny][nx]) {
      if (data[ny][nx] == "#") {
        d = ++d % 4;
        if (previous[y] === undefined) {
          previous[y] = {};
        }
        if (previous[y][x] === undefined) {
          previous[y][x] = d;
        } else if (previous[y][x] == d) {
          done = true;
          total++;
        }
      } else {
        x = nx;
        y = ny;
      }
    } else {
      done = true;
    }
  } while (!done);
}
console.log(total);
