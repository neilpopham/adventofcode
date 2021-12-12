<?php

require('libs/core.php');

$data = load_data("12.txt");

$lower = [];
$caves = [];
foreach ($data as $key => $value) {
	if (preg_match('/^(\w+)\-(\w+)$/', $value, $matches)) {
		if (!isset($caves[$matches[1]])) {
			$caves[$matches[1]] = [];
		}
		if (!isset($caves[$matches[2]])) {
			$caves[$matches[2]] = [];
		}
		$caves[$matches[1]][] = $matches[2];
		$caves[$matches[2]][] = $matches[1];
		if (strtolower($matches[1]) === $matches[1]) {
			$lower[$matches[1]] = true;
		}	
		if (strtolower($matches[2]) === $matches[2]) {
			$lower[$matches[2]] = true;
		}	
	}
}
unset($lower['start']);
unset($lower['end']);
$lower = array_keys($lower);

function follow1($cave, $caves, $existing = []) {
	static $paths = 0;
	$existing[] = $cave;
	if ($cave == 'end') {
		$paths++;
	}
	foreach ($caves[$cave] as $value) {				
		$is_small = strtolower($value) === $value;
		if (!$is_small || !in_array($value, $existing)) {
			follow1($value, $caves, $existing);
		}
	}
	return $paths;
}

function follow2($cave, $caves, $special, $existing = []) {
	static $complete = [];
	$existing[] = $cave;
	if ($cave == 'end') {
		$key = implode('', $existing);
		$complete[$key] = $existing;
	}
	foreach ($caves[$cave] as $value) {				
		$is_small = strtolower($value) === $value;
		if ($is_small) {
			if ($value === $special) {
				$is_small = false;
				$count = array_count_values($existing);
				if (isset($count[$value]) && $count[$value] > 1) {
					$is_small = true;
				}
			}
		}
		if (!$is_small || !in_array($value, $existing)) {
			follow2($value, $caves, $special, $existing);
		}
	}
	return $complete;
}

function part1($caves) {
	return follow1('start', $caves); 
}

function part2($caves, $lower) {
	foreach ($lower as $special) {
		$complete = follow2('start', $caves, $special);
	}
	return count($complete);
}

print part1($caves);
print "\n";
print part2($caves, $lower);
print "\n";
