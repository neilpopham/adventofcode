<?php

require('libs/core.php');

$data = load_data("11.txt");

$data = array_map(fn($x) => str_split($x), $data);

$total = 0;
$limit = 100;
$turn = 0;
$offsets = [];
for ($x = -1; $x <= 1; $x++) {
	for ($y = -1; $y <= 1; $y++) {
		if ($x == 0 && $y == 0) {
			continue;
		}
		$offsets[] = [$x, $y];
	}	
}

do {	
	$turn++;
	$queue = [];
	$flashes = 0;
	foreach ($data as $y => $row) {
		foreach (array_keys($row) as $x) {
			$data[$y][$x]++;
			$queue[] = [$x, $y];
		}
	}
	while (count($queue) > 0) {
		list($x, $y) = array_shift($queue);
		$energy = $data[$y][$x]; 
		if ($energy > 9) {
			$data[$y][$x] = 0;
			$flashes++;
			foreach ($offsets as $offset) {
				$oy = $y + $offset[1];
				if (!isset($data[$oy])) {
					continue;
				}
				$ox = $x + $offset[0];
				$energy = $data[$oy][$ox] ?? 0; 
				if ($energy > 0) {
					$data[$oy][$ox]++;
					$queue[] = [$ox, $oy];
				}
			} 
		}
	}
	$total += $flashes;
	if ($turn == $limit) {
		print "{$total} flashes after {$limit} turns\n";
	}
} while($flashes < 100);

print "synchronised on turn {$turn}\n";	 
