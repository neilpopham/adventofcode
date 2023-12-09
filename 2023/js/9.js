const { AdventOfCode } = require("api");

const input = new AdventOfCode().input(9);

const data = input.lines().raw().map(v => v.split(' ').map(v => Number(v)));

Array.prototype.end = function(){
    return this[this.length - 1];
};

function get_total(reverse = false)
{
    var total = 0;
    data.forEach((sequence, s) => {
        if (reverse) {
            sequence = sequence.reverse();
        }
        const diffs = [sequence];
        var d = 0;
        var zeros = [];
        while (diffs[d].length !== zeros.length ) {
        	diffs[d + 1] = [];
            for (var i = 1; i < diffs[d].length; i++) {
                diffs[d + 1].push(diffs[d][i] - diffs[d][i - 1]);
            }
            d++;
            zeros = diffs[d].filter(v => v === 0);
        }
        diffs[d].push(0);
        for (var i = d; i > 0; i--) {
            const value = diffs[i - 1].end() + diffs[i].end();
            diffs[i - 1].push(value);
            if (i == 1) {
                total += value;
            }
        }
    });
    return total;
}

console.log(get_total());
console.log(get_total(true));
