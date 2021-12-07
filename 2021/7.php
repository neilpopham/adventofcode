<?php

function calc($n) {
	$sum = 0;
	for ($i = $n; $i >= 1; $i--) {
		$sum = $sum + $i;
	}
	return $sum;
}

function parts($data, $func) {
	sort($data);
	$min = reset($data);
	$max = end($data);
	$count = array_fill($min, $max - $min + 1, 0);
	for ($i = $min; $i <= $max; $i++) {
		foreach ($data as $value) {
			$count[$i] += $func(abs($value - $i));
		}
	}
	$min = PHP_INT_MAX;
	foreach ($count as $i => $fuel) {
		if ($fuel < $min) {
			$min = $fuel;
		}
	}
	return $min;
}

$raw = file_get_contents('data/7.txt');
$data = explode(',', $raw);

$func = function($n) { return $n; };
print parts($data, $func);
print "\n";

$func = function($n) {
	$sum = 0;
	for ($i = $n; $i >= 1; $i--) {
		$sum += $i;
	}
	return $sum;
};
print parts($data, $func);
print "\n";
