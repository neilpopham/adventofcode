<?php

require('libs/core.php');

function part1($data) {
	$position = 0;
	$total = count($data);
	$gamma = '';
	$epsilon = '';

	while (isset($data[0][$position])) {
		$ones = 0;	

		foreach ($data as $value) {
			if ($value[$position] == '1') {
				$ones++;
			}
		}

		if ($ones >= ($total / 2)) {
			$gamma .= '1';
			$epsilon .= '0';
		} else {
			$gamma .= '0';
			$epsilon .= '1';
		}

		$position++;
	}

	return bindec($gamma) * bindec($epsilon);
}

function part2($data) {
	$oxygen = filter_data($data, '1');
	$co2 = filter_data($data, '0');
	return $oxygen * $co2;	
}

function filter_data($data, $keep = '1') {
	$len = strlen($data[0]);
	
	for ($position = 0; $position < $len; $position++) {
		$ones = 0;	
		$total = count($data);
		if ($total == 1) {
			continue;
		}
		$avg = $total / 2;

		foreach ($data as $value) {
			if ($value[$position] == '1') {
				$ones++;
			}
		}

		if ($ones >= $avg) {
			$bit = $keep;
		} else {
			$bit = $keep == '1' ? '0' : '1';
		}

		foreach ($data as $key => $value) {
			if ($value[$position] != $bit) {
				unset($data[$key]);
			}
		}
	}

	return bindec(end($data));
}

$data = load_data("3.txt");

print part1($data);
print "\n";
print part2($data);
print "\n";