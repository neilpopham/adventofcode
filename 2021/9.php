<?php

require('libs/core.php');

function get_lows($data) {
	$offsets = [[0, -1], [1, 0], [0, 1], [-1, 0]];
	$lows = [];
	foreach ($data as $y => $row) {
		foreach ($row as $x => $value) {
			$low = true;
			foreach ($offsets as $offset) {
				if (!isset($data[$y + $offset[1]])) {
					continue;
				}
				$neighbour = $data[$y + $offset[1]][$x + $offset[0]] ?? 9;
				if ($value > $neighbour) {
					$low = false;
					break;
				}
			}
			if ($low) {
				$lows[] = [$x, $y, $value];
			}
		}
	}
	return $lows;
}

function make_key($x, $y) {
	return 'P' . ($y * 1000 + $x);
}

function test_item($x, $y, $data, $done) {
	$key = make_key($x, $y);
	$values[$key] = 1;
	$done[$key] = 1;
	$offsets = [[0, -1], [1, 0], [0, 1], [-1, 0]];
	foreach ($offsets as $o => $offset) {
		$oy = $y + $offset[1];
		if (!isset($data[$oy])) {
			continue;
		}
		$ox = $x + $offset[0];
		if (isset($done[make_key($ox, $oy)])) {
			continue;
		}
		$neighbour = $data[$oy][$ox] ?? 9;
		if (($neighbour != 9) && ($neighbour > $data[$y][$x])) {
			$values = array_merge($values, test_item($ox, $oy, $data, $done));
		}
	}
	return $values;
}

function part1($data) {
	$lows = get_lows($data);
	return array_reduce(
		$lows,
		function($total, $item) {
			$total += $item[2] + 1;
			return $total;
		}
	);
}

function part2($data) {
	$offsets = [[0, -1], [1, 0], [0, 1], [-1, 0]];
	$sums = [];
	$lows = get_lows($data);
	foreach ($lows as $low) {
		list($x, $y, $value) = $low;
		$sums[] = count(test_item($x, $y, $data, []));
	}
	rsort($sums);
	return array_product(array_slice($sums, 0, 3));
}

$data = load_data("9.txt");

foreach ($data as &$value) {
	$value = str_split($value);
}

print part1($data);
print "\n";
print part2($data);
print "\n";
