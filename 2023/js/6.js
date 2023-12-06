const s = Date.now();
const total = find(204171312101780, 34908986);
const e = Date.now();

console.log(total);
console.log(e - s);

function find(distance, time)
{
	const start = Math.floor(time / 2);
	var current = 0;
    var total = 1;
    var diff = 1;
    while (total > current) {
        current = total;
        [diff, -diff].forEach(offset => {
        	if ((start + offset) * (time - (start + offset)) > distance) {
                total++;
            }
        });
        diff++;
    }
    return total;
}
