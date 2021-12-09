<?php

require('libs/core.php');

function part1($data) {
	$offsets = [[0, -1], [1, 0], [0, 1], [-1, 0]];
	$lows = 0;
	foreach ($data as $y => $row) {
		foreach ($row as $x => $value) {
			$low = true;
			foreach ($offsets as $offset) {
				if (!isset($data[$y + $offset[1]])) {
					continue;
				}
				$ovalue = $data[$y + $offset[1]][$x + $offset[0]] ?? 9;
				if ($ovalue <= $value) {
					$low = false;
					break;
				}					
			}
			if ($low) {
				$lows += ++$value;
			}
		}
	}
	return $lows;
}

function test_item($x, $y, $data) {
	$values[] = (int) $data[$y][$x];
	$offsets = [[0, -1], [1, 0], [0, 1], [-1, 0]];
	foreach ($offsets as $o => $offset) {
		$oy = $y + $offset[1];
		if (!isset($data[$oy])) {
			continue;
		}
		$ox = $x + $offset[0];
		$value = $data[$oy][$ox] ?? PHP_INT_MAX;
		if ($value == $values[0] + 1) {
			$values = array_merge($values, test_item($ox, $oy, $data));
		}
	}
	return $values;
}

function part2($data) {
	$offsets = [[0, -1], [1, 0], [0, 1], [-1, 0]];
	$max = count($data[0]);
	foreach ($data as $y => $row) {
		$bowl = [];
		foreach ($row as $x => $value) {
			$matrix = test_item($x, $y, [$value], $data);
			print_r($matrix);
			
			
			/*
			$bowl[] = [$x, $y, $value];
			print "{$x},{$y}\n";
			$d = [1, 1, 1, 1];
			do {
				$valid = false;
				foreach ($offsets as $o => $offset) {
					if ($d[$o] == 0) {
						//print "d0\n";
						continue;
					}
					$oy = $y + ($offset[1] * $d[$o]);
					if (!isset($data[$oy])) {
						//print "invalid oy {$oy}\n";
						$d[$o] = 0;
						continue;
					}
					$ox = $x + ($offset[0] * $d[$o]);
					$ovalue = $data[$oy][$ox] ?? PHP_INT_MAX;
					if ($ovalue == ($value + $d[$o])) {
						print "{$x},{$y} -> {$ox},{$oy} ({$value} -> {$ovalue})\n";
						$valid = true;
						$bowl[] = [$ox, $oy, $ovalue];
						$d[$o]++;
					} else {
						$d[$o] = 0;
					}	
				}				
			} while($valid);
			*/
		}
		//print_r($bowl);
		exit;		
	}

}

$data = load_data("_9.txt");

foreach ($data as &$value) {
	$value = str_split($value);
}

print part1($data);
print "\n";
print part2($data);
print "\n";
