<?php

require('libs/core.php');

function part1($data) {
	$x = 0;
	$y = 0;

	foreach ($data as $value) {
		if (preg_match('/^(forward|down|up) (\d+)$/', $value, $matches)) {
			switch ($matches[1]) {
				case 'forward':
					$x += $matches[2];
					break;
				case 'down':
					$y += $matches[2];
					break;
				case 'up':
					$y -= $matches[2];
					break;
			}
		}
	}
	return $x * $y;
}

function part2($data) {
	$x = 0;
	$y = 0;
	$aim = 0;

	foreach ($data as $value) {
		if (preg_match('/^(forward|down|up) (\d+)$/', $value, $matches)) {
			switch ($matches[1]) {
				case 'forward':
					$x += $matches[2];
					$y += $aim * $matches[2];
					break;
				case 'down':
					$aim += $matches[2];
					break;
				case 'up':
					$aim -= $matches[2];
					break;
			}
		}
	}
	return $x * $y;
}

$data = load_data("2.txt");

print part1($data);
print "\n";
print part2($data);
print "\n";