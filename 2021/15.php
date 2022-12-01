<?php

ini_set('memory_limit','8000M');

require('libs/core.php');

$data = load_data("_15.txt");

foreach ($data as $y => $row) {
	$data[$y] = str_split($row);
}

$g = [[0 => 0]];
$offsets = [[0, 1], [1, 0], [0, -1], [-1, 0]];
$checks = 0;
$checked = [];
$queue = [];

function check_pos($x, $y, $parent) {
    global $queue, $g, $offsets, $data, $checks, $checked;


	$risk = $parent + $data[$y][$x];
	if (isset($g[$y][$x]) && $g[$y][$x] <= $risk) {
		return;
	}
    $g[$y][$x] = $risk;

	$checks++;
	$checked[$y][$x] = ($checked[$y][$x] ?? 0) + 1;

    foreach ($offsets as $offset) {
        $dx = $x + $offset[0];
        $dy = $y + $offset[1];
        if (isset($data[$dy]) && isset($data[$dy][$dx])) {
            $risk = $g[$y][$x] + $data[$dy][$dx];
            if (!isset($g[$dy][$dx]) || $g[$dy][$dx] > $risk) {
				//$g[$dy][$dx] = $risk;
				$queue[] = [$dx, $dy, $g[$y][$x]];
            }
        }
    }
}

function enqueue($x, $y, $parent) {
	global $queue;
	$queue[] = [$x, $y, $parent];
	while (count($queue) > 0) {
		list($x, $y, $parent) = array_shift($queue);
		check_pos($x, $y, $parent);
	}
}


function find_path($x, $y, $path = []) {
    global $offsets, $g;
    $path[] = [$x, $y];
    if ($x == 0 && $y == 0) {
        return $path;
    }
    $min = PHP_INT_MAX;
    foreach ($offsets as $offset) {
        $dx = $x + $offset[0];
        $dy = $y + $offset[1];
        if (isset($g[$dy]) && isset($g[$dy][$dx]) && $g[$dy][$dx] < $min) {
            $min = $g[$dy][$dx];
            $mx = $dx;
            $my = $dy;
        }
    }
    return find_path($mx, $my, $path);
}

function part1() {
    global $g;
    $g = []; // [[0 => 0]];
    enqueue(0, 0, -1);
    ksort($g);
    foreach ($g as $y => $row) {
        ksort($g[$y]);
    }
    print_r($g);
}


function part2() {
    global $g, $data;
    $g = [];

    $my = count($data);
    $mx = count($data[0]);
    for ($dx = 1; $dx <= 4; $dx++) {
        for ($y = 0; $y < $my; $y++) {
            for ($x = 0; $x < $mx; $x++) {
                $value = $data[$y][$x] + $dx;
                if ($value > 9) {
                    $value = $value % 9;
                }
                $data[$y][] = $value;
            }
        }
    }
    $mx = count($data[0]);
    for ($dy = 1; $dy <= 4; $dy++) {
        for ($y = 0; $y < $my; $y++) {
            $row = [];
            for ($x = 0; $x < $mx; $x++) {
                $value = $data[$y][$x] + $dy;
                if ($value > 9) {
                    $value = $value % 9;
                }
                $row[] = $value;
            }
            $data[] = $row;
        }
    }

	/*
	foreach ($data as $row) {
		print implode('', $row) . "\n";
	}
	*/

    check_pos(0, 0, -1);
    ksort($g);
    foreach ($g as $y => $row) {
        ksort($g[$y]);
    }
    print_r($g);

	//print_r(find_path(count($data[0]) - 1, count($data) - 1));
}

// $path = find_path(count($data[0]) - 1, count($data) - 1, []);
// print_r($path);

$checks = 0;
$checked = [];
part1();
print "checks: {$checks}\n";
ksort($checked);
foreach (array_keys($checked) as $key) {
	ksort($checked[$key]);
}
print_r($checked);
exit;

$checks = 0;
$checked = [];
part2();
print "checks: {$checks}\n";
ksort($checked);
foreach (array_keys($checked) as $key) {
	ksort($checked[$key]);
}
//print_r($checked);
