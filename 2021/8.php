<?php

require('libs/core.php');

function part1($data) {
	$total = 0;
	foreach ($data as $parts) {
		foreach ($parts[1] as $output) {
			$len = strlen($output);
			if (in_array($len, [2, 3, 4, 7])) {
				$total++;
			}
		}
	}
	return $total;
}

// Returns an array of digits with the specified number of segments
function getlen($len, $array, $as_array = false) {
	$matches = [];
	foreach ($array as $key => $value) {
		if (strlen($value) == $len) {
			$matches[$key] = $as_array ? str_split($value) : $value;
		}
	}
	return $matches;
}

/**
 * 1. Find the difference between 1 and 7, to find segment 'a', and narrow down 'c' and 'f' to two values
 * 2. Test 0, 6, and 9 (which only miss one segment) against 1
 *    a. If we only have one segment of 1 this must be 6, and we can now work out 'c' and 'f'
 * 3. Test 0, 6, and 9 against 4
 *    a. If we can match all 4 segments of 4 this must be 9, and we can now work out 'e' and 'g'
 *    b. If we're not missing segment 'c' this must be 0, and we can now work out 'd'
 * 4. Deduce 'b', which is the only segment not yet mapped
 */
function part2($data) {
	$total = 0;

	// Ordered layout of each digit, 0-9
	$layout = [
		'abcefg', 'cf', 'acdeg', 'acdfg', 'bcdf', 'abdfg', 'abdefg', 'acf', 'abcdefg', 'abcdfg'
	];

	// Loop through input
	foreach ($data as $parts) {

		// This will contain our mapping between signal and segment
		$map = [];

		// This records segment information about the digits we know
		$segments = [];

		// Populate $segments for those digits with unique lengths (digit => length)
		foreach ([1 => 2, 4 => 4, 7 => 3, 8 => 7] as $n => $l) {
			$key = key(getlen($l, $parts[0]));
			$segments[$n] = str_split($parts[0][$key]);
		}

		// Find the difference between 1 and 7, to find segment 'a', and narrow down 'c' and 'f' to two values
		$diff = array_diff($segments[7], $segments[1]);
		$map['a'] = $diff;
		$map['c'] = $map['f'] = $segments[1];

		// Find those values that only have one segment missing (0, 6, 9)
		$missingone = getlen(6, $parts[0], true);

		// Use these to work out the other segments
		foreach ($missingone as $key => $value) {

			// Test segments against 1
			$intersect = array_intersect($value, $segments[1]);
			// If we only have one segment of 1 $value must be 6, and we can now work out 'c' and 'f'
			if (count($intersect) == 1) {
				$map['c'] = array_diff($segments[1], $intersect);
				$map['f'] = array_diff($segments[1], $map['c']);
			}

			// Test segments against 4
			$intersect = array_intersect($value, $segments[4]);
			// If we can match all 4 segments of 4 $value must be 9, and we can now work out 'e' and 'g'
			if (count($intersect) == 4) {
				$map['e'] = array_diff($segments[8], $value);
				$diff = array_values(array_diff($value, $intersect));
				$map['g'] = $diff[0] == end($map['a']) ? [$diff[1]] : [$diff[0]];
			} else {
				// Which one segment are we missing from 4?
				$missing = array_diff($segments[4], $value);
				$missing = end($missing);
				// If we're not missing segment 'c' $value must be 0, and we can now work out 'd'
				if (false === in_array($missing, $map['c'])) {
					$map['d'] = array_diff($segments[8], $value);
				}
			}
		}

		// Reduce map values to a string
		foreach ($map as $key => $value) {
			$map[$key] = end($value);
		}

		// We're only missing 'b', so use the 8 to work out which segment we're missing from our map
		$map['b'] = array_diff($segments[8], $map);
		$map['b'] = end($map['b']);

		// This will be our corrected 4 digits
		$correct = '';

		// Loop through our display
		foreach ($parts[1] as $key => $display) {
			$display = str_split($display);

			// Use $map to convert our output to the correct signal
			$mapped = [];
			foreach ($display as $key => $value) {
				$mapped[] = array_search($value, $map);
			}

			// Sort so we can compare
			sort($mapped);

			// Test the re-mapped segments against our layouts to find what number it is
			foreach ($layout as $number => $digit) {
				$digit = str_split($digit);
				if ($digit == $mapped) {
					$correct .= $number;
					break;
				}
			}
		}

		$total += (int) $correct;
	}

	return $total;
}


$data = load_data("8.txt");

$digits = [];
foreach ($data as $value) {
	if (preg_match('/^([\w ]+) \| ([\w ]+)$/', $value, $matches)) {
		$matches = array_slice($matches, 1);
		$matches[0] = explode(' ', $matches[0]);
		$matches[1] = explode(' ', $matches[1]);
		$digits[] = $matches;
	}
}

print part1($digits);
print "\n";
print part2($digits);
print "\n";
