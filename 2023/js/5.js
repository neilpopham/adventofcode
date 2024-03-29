const { AdventOfCode } = require("api");

const input = (new AdventOfCode()).input(5);
// const input = (new AdventOfCode()).example(5, 0);

const data = input.lines().raw();

var seeds;
var maps = [];
var i = -1;
data.forEach(line => {
	if (line.length == 0) {
		return true;
	} else if (matches = line.match(/seeds: (.+)/)) {
		seeds = matches[1].split(' ').map(v => Number(v));
	} else if (matches = line.match(/(\w+)\-to\-(\w+) map/)) {
		i++;
		maps[i] = [];
	} else {
		maps[i].push(line.split(' ').map(v => Number(v)));
	}
});

function map(value)
{
	maps.forEach(map => {
		for (const range of map) {
			if (value >= range[1] && value < range[1] + range[2]) {
                value = range[0] + (value - range[1]);
                break;
            }
		}
	});
    return value;
}

var location = Number.MAX_SAFE_INTEGER;
seeds.forEach(seed => {
	location = Math.min(location, map(seed));
});
console.log(location);

location = Number.MAX_SAFE_INTEGER;
for (var i = 0; i < seeds.length; i++) {
    const start = seeds[i++];
    const end = start + seeds[i];
    for (var seed = start; seed < end; seed++) {
        location = Math.min(location, map(seed));
    }
}
console.log(location);
