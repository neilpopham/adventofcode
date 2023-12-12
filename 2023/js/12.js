const { AdventOfCode } = require("api");

const input = new AdventOfCode().input(12);
// const input = new AdventOfCode().example(12, 1);

const data = input.lines().regex(/(.+) ([\d,]+)/);

data.forEach((line, key) => {
	data[key][0] = line[0].replace(/\./g, '0').replace(/#/g, '1');
	data[key][1] = line[1].split(',').map(v => Number(v));
	data[key][2] = {};
	chars = data[key][0];
	len = chars.length;
	max = parseInt('1'.repeat(len), 2);
	for (n = 1; n <= max; n++) {
		option = n.toString(2).padStart(len, '0');
		for (var o = 0; o < len; o++) {
			if (chars[o] == '1') {
				option = option.substring(0, o) + '1' + option.substring(o + 1);
			} else if (chars[o] == '0') {
				option = option.substring(0, o) + '0' + option.substring(o + 1);
			}
		}
		data[key][2][option] = option;
	}
    data[key][3] = 0;
    Object.values(data[key][2]).forEach(option => {
    	parts = option.split('0').filter(v => v.length).map(v => v.length);
    	matches = parts.length == data[key][1].length
    		? parts.every((v, k) => v == data[key][1][k])
    		: false;
    	if (matches) {
    		data[key][3]++;
    	}
    })
})

total = data.map(v => v[3]).reduce((t, v) => t + v)
console.log(total);
