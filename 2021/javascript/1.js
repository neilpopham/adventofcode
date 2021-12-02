const fs = require('fs');

fs.readFile( __dirname + '/../data/1.txt', function (e, data) {
	if (e) {
		throw e;
		return; 
	}

	const lines = data.toString().replace(/\r/g, '').split("\n");

	console.log(part1(lines));
	console.log(part2(lines));
});

part1 = (data) => {
	let previous = Number.MAX_SAFE_INTEGER;
	let total = 0;
	data.forEach((value) => {
		if (Number(value) > previous) {
			total++;
		}
		previous = value;
	});
	return total;
}

part2 = (data) => {
	let previous = Number.MAX_SAFE_INTEGER;
	let total = 0;
	for (i = 0; i < data.length - 2; i++) {
		value = Number(data[i]) + Number(data[i + 1]) + Number(data[i + 2]);
		if (value > previous) {
			total++;
		}
		previous = value;		
	}
	return total;
}
