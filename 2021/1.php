<?php

require('libs/core.php');

function part1($numbers) {
	$previous = PHP_INT_MAX;
	$total = 0;
	foreach ($numbers as $value) {
		if ($value > $previous) {
			$total++;
		}
		$previous = $value;
	}
	return $total;
}

function part2($numbers) {
	$previous = PHP_INT_MAX;
	$total = 0;
	for ($i = 0; $i < count($numbers) - 2; $i++) {
		$value = $numbers[$i] + $numbers[$i + 1] + $numbers[$i + 2];
		if ($value > $previous) {
			$total++;
		}
		$previous = $value;
	}
	return $total;
}

$numbers = load_data("1.txt");

print part1($numbers);
print "\n";
print part2($numbers);
print "\n";
