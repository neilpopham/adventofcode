var api = require("api");
const AdventOfCode = api.AdventOfCode;

const input = (new AdventOfCode()).input(99);
// const input = (new AdventOfCode()).example(99, 0);

const data = input.lines().raw();

console.log(data);
