<?php

require('libs/core.php');

$data = load_data("13.txt");

function fold_y($fold, $points) {
	foreach ($points as $y => $row) {
		if ($y > $fold) {
			$new = $fold - ($y - $fold);
			if (!isset($points[$new])) {
				$points[$new] = [];
			}
			$points[$new] = $points[$new] + $row;
			unset($points[$y]);
			ksort($points[$new]);
		}
	}
	return $points;
}

function fold_x($fold, $points) {
	foreach ($points as $y => $row) {
		foreach ($row as $x => $value) {
			if ($x > $fold) {
				$new = $fold - ($x - $fold);
				$points[$y][$new] = 1;
				unset($points[$y][$x]);
			}
		}
		ksort($points[$y]);
	}
	return $points;
}

function count_points($points) {
	return array_reduce($points, fn($t, $r) => $t += count($r));
}

function print_points($points) {
	$my = 0;
	$mx = 0;
	foreach ($points as $y => $row) {
		if ($y > $my) {
			$my = $y;
		}
		foreach ($row as $x => $value) {
			if ($x > $mx) {
				$mx = $x;
			}
		}
	}
	for ($y = 0; $y <= $my; $y++) {
		for ($x = 0; $x <= $mx; $x++) {
			print isset($points[$y]) && isset($points[$y][$x]) ? '#' : '.';
		}
		print "\n";
	}
	print "\n";
}

$points = [];
$folds = [];
foreach ($data as $value) {
	if (preg_match('/^(\d+),(\d+)$/', $value, $matches)) {
		if (!isset($points[$matches[2]])) {
			$points[$matches[2]] = [];
		}
		$points[$matches[2]][$matches[1]] = 1;
	} else if (preg_match('/^fold along (x|y)=(\d+)$/', $value, $matches)) {
		$folds[] = array_slice($matches, 1);
	}
}

ksort($points);
foreach ($points as $key => $value) {
	ksort($points[$key]);
}

foreach ($folds as $i => $fold) {
	$fold_function = "fold_{$fold[0]}";
	$points = $fold_function($fold[1], $points);
	if ($i == 0) {
		print count_points($points);
		print "\n";
	}
}

print_points($points);
