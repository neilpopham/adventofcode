const { AdventOfCode } = require("api");

const input = new AdventOfCode().input(8);

const data = input.lines().raw();

const directions = data[0]
  .replace(/L/g, "0")
  .replace(/R/g, "1")
  .split("")
  .map((v) => Number(v));

var instructions = {};
for (i = 2; i < data.length; i++) {
  const matches = data[i].match(/(\w+) = \((\w+), (\w+)\)/);
  instructions[matches[1]] = [matches[2], matches[3]];
}

var steps = 0;
var d = 0;
for (var key = "AAA"; key !== "ZZZ"; ) {
  key = instructions[key][directions[d]];
  steps++;
  d++;
  if (d == directions.length) {
    d = 0;
  }
}
console.log(steps);

// const s = Date.now();
keys = Object.keys(instructions).filter((v) => v.endsWith("A"));

var d = 0;
const cycles = [];
keys.forEach((start) => {
  cycles[start] = 0;
  for (var key = start; false === key.endsWith("Z"); ) {
    key = instructions[key][directions[d]];
    d++;
    if (d == directions.length) {
      d = 0;
      cycles[start]++;
    }
  }
});
const loops = Object.values(cycles).reduce((total, value) => total * value, 1);
console.log(loops * directions.length);
// const e = Date.now();
// console.log(e - s);

const s = Date.now();
var steps = 0;
var d = 0;
var complete = [];
var threads = keys.length;
while (complete < threads) {
  keys = keys.map((key) => instructions[key][directions[d]]);
  steps++;
  d++;
  if (d == directions.length) {
    d = 0;
  }
  complete = keys.filter((key) => key.endsWith("Z")).length;
}
console.log(steps);
const e = Date.now();
console.log(e - s);
