<?php

require('libs/core.php');

function check_1($data) {
    $x = 0;
    $y = 0;
    $a = 1;
    $vector = [[0, -1], [1, 0], [0, 1], [-1, 0]];
    foreach ($data as $key => $line) {
        $dx =0;
        $dy = 0;
        if (preg_match('/^([NESWLRF])(\d+)$/', $line, $matches)) {
            list(, $action, $value) = $matches;
            if (false !== $direction = array_search($action, ['N', 'E', 'S', 'W'])) {
                $dx = $value * $vector[$direction][0];
                $dy = $value * $vector[$direction][1];
            } elseif (false !== $angle = array_search($action, ['L', 'R'])) {
                $a += [-1,1][$angle] * $value/90;
                $a = ($a + 4) % 4;
            } elseif ($action == "F") {
                $dx = $value * $vector[$a][0];
                $dy = $value * $vector[$a][1];
            }
            $x += $dx;
            $y += $dy;
        }
    }
    print (abs($x) + abs($y)) . "\n";
}

function check_2($data) {
    $x = 0;
    $y = 0;
    $wx = 10;
    $wy = -1;
    $vector = [[0, -1], [1, 0], [0, 1], [-1, 0]];
    foreach ($data as $key => $line) {
        $dx = 0;
        $dy = 0;
        if (preg_match('/^([NESWLRF])(\d+)$/', $line, $matches)) {
            list(, $action, $value) = $matches;
            if (false !== $direction = array_search($action, ['N', 'E', 'S', 'W'])) {
                $wx += $value * $vector[$direction][0];
                $wy += $value * $vector[$direction][1];
            } elseif (false !== $angle = array_search($action, ['L', 'R'])) {
                $current = rad2deg(atan2($wy, $wx));
                $updated = deg2rad($current + [-1, 1][$angle] * $value);
                $vx = cos($updated) <=> 0;
                $vy = sin($updated) <=> 0;
                $tx = abs($value % 180 == 0 ? $wx : $wy) * $vx;
                $wy = abs($value % 180 == 0 ? $wy : $wx) * $vy;
                $wx = $tx;
            } elseif ($action == "F") {
                $dx = $wx * $value;
                $dy = $wy * $value;
            }
            $x += $dx;
            $y += $dy;
        }
    }
    print (abs($x) + abs($y)) . "\n";
}

$data = load_data("12.txt");

check_1($data);

check_2($data);
