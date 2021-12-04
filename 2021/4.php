<?php

require('libs/core.php');

function check($board, $r, $c) {
	$found = true;				
	foreach ($board as $i => $row) {
		if ($row[$c] > -1) {
			$found = false;
			break;
		} 		
	}
	if (!$found) {
		$failed = array_filter($board[$r], function($x) { return $x > -1; });
		$found = count($failed) == 0;
	}
	return $found;
}

function part1($numbers, $boards) {
	return parts($numbers, $boards, false);
}

function part2($numbers, $boards) {
	return parts($numbers, $boards, true);
}

function parts($numbers, $boards, $part2) {
	$count = count($boards);
	$complete = array_fill(0, $count, false);
	foreach ($numbers as $number) {
		foreach ($boards as $b => &$board) {
			foreach ($board as $r => $row) {
				foreach($row as $c => $col) {
					if ($col == $number) {
						$board[$r][$c] = -1;
						if (check($board, $r, $c)) {
							$done = true;
							if ($part2) {
								$complete[$b] = true;	
								foreach ($complete as $value) {
									if (!$value) {
										$done = false;
									}
								}
							}
							if ($done) {
								$sum = 0;
								foreach ($board as $r => $row) {
									$row = array_map(function($x){ return $x == -1 ? 0 : $x; }, $row);
									$sum += array_sum($row);
								}
								return $sum * $number;								
							}
						}
					}
				}
			}
		}
	}
}

$data = load_data("4.txt");

$numbers = explode(',', array_shift($data));
$boards = [];
$board = -1;
foreach ($data as $value) {
	$value = trim($value);
	if (empty(trim($value))) {
		$board++;
		continue;
	}
	$boards[$board][] = explode(' ', preg_replace('/\s+/', ' ', $value)); 
}

print part1($numbers, $boards);
print "\n";
print part2($numbers, $boards);
print "\n";
