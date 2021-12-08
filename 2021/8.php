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

function ag206($char) {
	return ord($char) - 97;
}

function part2($data) {
/*
 00000
11   22
 33333
44   55
 66666
*/
	$layout = [
	 	[0, 1, 2, 4, 5, 6],			// 0	6
	 	[2, 5],						// 1	2
	 	[0, 2, 3, 4, 6],			// 2	5
	 	[3, 2, 3, 5, 6],			// 3	5
	 	[1, 2, 3, 5],				// 4	4
	 	[0, 1, 3, 5, 6],			// 5	5
	 	[0, 1, 3, 4, 5, 6],			// 6	6
	 	[0, 2, 5],					// 7	3
	 	[0, 1, 2, 3, 4, 5, 6, 7],	// 8	7
	 	[0, 1, 2, 3, 5, 6],			// 9	6
	];

	foreach ($data as $parts) {
		$map = [];
		$digits = [];
		while (count($map) < 10) {
			$ordered = array_map(fn($x) => strlen($x), $parts[0]);
			asort($ordered);
			print_r($ordered);
			foreach ($parts[0] as $output) {
				$len = strlen($output);
				//$known = [1 => 2, 4 => 4, 7 => 3, 8 => 7];
				$known = [];
				foreach ([1 => 2, 4 => 4, 7 => 3, 8 => 7] as $n => $l) {
					$digits[$n] = [$parts[0][array_search($l, $ordered)]];
					$digits[$n][1] = str_split($digits[$n][0]);
				}
				$diff = array_diff($digits[7][1], $digits[1][1]);
				$map[0] = ag206(end($diff));
				$map[2] = $map[5] = array_map(fn($x) => ag206($x), $digits[1][1]);
				$diff = array_diff($digits[4][1], $digits[1][1]);
				$map[1] = $map[3] = array_map(fn($x) => ag206($x), $diff);
				print_r($digits);
				print_r($diff);
				print_r($map);

				exit;
				$seven = array_search(3, $ordered);
				var_dump($seven);
				$one = array_search(2, $ordered);
				var_dump($one);
			}			

			exit;
		}
	}			
}

$data = load_data("_8.txt");

$digits = [];
foreach ($data as $value) {
	if (preg_match('/^([\w ]+) \| ([\w ]+)$/', $value, $matches)) {
		$matches = array_slice($matches, 1);
		$matches[0] = explode(' ', $matches[0]);
		$matches[1] = explode(' ', $matches[1]);
		$digits[] = $matches;
	}
}

print_r($digits);

print part1($digits);
print "\n";
print part2($digits);
print "\n";
