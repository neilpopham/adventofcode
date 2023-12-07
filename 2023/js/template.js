const { AdventOfCode } = require("api");

const input = (new AdventOfCode()).input(99);
// const input = (new AdventOfCode()).example(99, 0);

const data = input.lines().raw();

console.log(data);
