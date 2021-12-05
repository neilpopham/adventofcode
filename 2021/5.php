<?php

require('libs/core.php');

function part1($coords, $ignore = true) {
	$vents = [];
	foreach ($coords as $p) {
		if ($ignore && ($p[0] != $p[2]) && ($p[1] != $p[3])) {
			continue;
		}
		$x1 = min($p[0], $p[2]);
		$x2 = max($p[0], $p[2]);
		$y1 = min($p[1], $p[3]);
		$y2 = max($p[1], $p[3]);
		for ($y = $y1; $y <= $y2; $y++) {
			if (!isset($vents[$y])) {
				$vents[$y] = [];
			}			
			for ($x = $x1; $x <= $x2; $x++) {	
				$vents[$y][$x] = ($vents[$y][$x] ?? 0) + 1;
			}
		}	
	}
	$total = 0;
	foreach ($vents as $y => $row) {
		$total += array_reduce($row, function($t, $x){ return $x > 1 ? ++$t : $t; });
	}
	return $total;
}

function part2($coords) {
	$vents = [];
	foreach ($coords as $p) {	
		$dx = $p[0] < $p[2] ? 1 : -1;
		$dy = $p[1] < $p[3] ? 1 : -1;
		list($x1, $y1, $x2, $y2) = $p;
		while ($y1 != $y2 || $x1 != $x2) {
			if (!isset($vents[$y1])) {
				$vents[$y1] = [];
			}
			$vents[$y1][$x1] = ($vents[$y1][$x1] ?? 0) + 1;
			if ($y1 != $y2) {
				$y1 += $dy;
			}
			if ($x1 != $x2) {
				$x1 += $dx;
			}
		}	
		if (!isset($vents[$y1])) {
			$vents[$y1] = [];
		}
		$vents[$y1][$x1] = ($vents[$y1][$x1] ?? 0) + 1;
	}	
	$total = 0;
	foreach ($vents as $y => $row) {
		$total += array_reduce($row, function($t, $x){ return $x > 1 ? ++$t : $t; });
	}
	return $total;		
}

$data = load_data("5.txt");

$coords = [];
foreach ($data as $value) {
	if (preg_match('/^(\d+),(\d+) \-> (\d+),(\d+)$/', $value, $matches)) {
		$coords[] = array_slice($matches, 1);
	}
}

print part1($coords);
print "\n";
print part2($coords);
print "\n";
