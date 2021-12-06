<?php

function part1($data) {
	for ($day = 0; $day < 80; $day++) {
		$add = 0; 
		foreach ($data as &$value) {
			if ($value == 0) {
				$add++;
				$value = 6;
			} else {
				$value--;	
			}
		}
		if ($add) {
			$data = array_merge($data, array_fill(0, $add, 8));
		}
	}
	return count($data);
}

function part2($data) {
	$days = 256;
	$cache = [];
	for ($remaining = 0; $remaining <= $days + 7; $remaining++) {
		$offspring = max(0, floor(($remaining - 2) / 7));
		$cache[$remaining] = $offspring;
		if ($offspring) {
			for ($offset = 1; $offset <= $offspring; $offset++) {
				$cache[$remaining] += $cache[max(0, $remaining - 2 - $offset * 7)];
			}
		}
	}
	$total = 0;
	foreach ($data as $value) {
		$total += (1 + $cache[$days + 8 - $value]);
	}
	return $total;
}

$raw = file_get_contents('data/6.txt');
$data = explode(',', $raw);

print part1($data);
print "\n";
print part2($data);
print "\n";
