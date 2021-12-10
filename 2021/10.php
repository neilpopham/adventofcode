<?php

require('libs/core.php');

$data = load_data("10.txt");

$brackets = ['(' => ')', '<' => '>', '[' => ']', '{' => '}'];
$scores = [')' => 3, '>' => 25137, ']' => 57, '}' => 1197, '(' => 1, '<' => 4, '[' => 2, '{' => 3];
$corrupted = 0;
$incomplete = [];
$pairs = array_map(fn($c, $o) => $o . $c, $brackets, array_keys($brackets));

foreach ($data as $line => $value) {
	
	do {
		$value = str_replace($pairs, '', $value, $count);
	} while ($count);

	$values = str_split($value);
	$counts = array_count_values($values);

	$corrupt = false;
	foreach ($brackets as $o => $c) {
		if (isset($counts[$c])) {
			$corrupt = true;
			break;
		}
	}

	if ($corrupt) {
		foreach ($values as $p => $chr) {
			if (in_array($chr, $brackets)) {
				$corrupted += $scores[$chr];
				break;
			}
		}
	} else {
		krsort($values);
		$incomplete[$line] = 0;
		foreach ($values as $p => $chr) {
			$incomplete[$line] *= 5;
			$incomplete[$line] += $scores[$chr];
		}
	}
}

sort($incomplete);
$incomplete = $incomplete[floor(count($incomplete)/2)];

print "corrupted:  {$corrupted}\n";
print "incomplete: {$incomplete}\n";
