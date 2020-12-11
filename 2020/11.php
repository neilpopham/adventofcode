<?php

require('libs/core.php');

function get_adjacent($x, $y, $data) {
    $total = 0;
    for ($dy = -1; $dy < 2; $dy++) {
        for ($dx = -1; $dx < 2; $dx++) {
            $ax = $x + $dx;
            $ay = $y + $dy;
            if (($ax == $x) && ($ay == $y)) {
                continue;
            }
            if (isset($data[$ay])
            && isset($data[$ay][$ax])
            && $data[$ay][$ax] == "#") {
                $total++;
            }
        }
    }
    return $total;
}

function get_nearest($x, $y, $data) {
    $total = 0;
    for ($dy = -1; $dy < 2; $dy++) {
        for ($dx = -1; $dx < 2; $dx++) {
            $ax = $x + $dx;
            $ay = $y + $dy;
            if (($ax == $x) && ($ay == $y)) {
                continue;
            }
            while (isset($data[$ay]) && isset($data[$ay][$ax])) {
                if ($data[$ay][$ax] != ".") {
                    if ($data[$ay][$ax] == "#") {
                        $total += 1;
                    }
                    $ay = -1;
                } else {
                    $ax += $dx;
                    $ay += $dy;
                }
            }
        }
    }
    return $total;
}

function check($data, $test, $max) {
    $changed = true;
    while ($changed) {
        $changed = false;
        $tmp = $data;
        for ($y = 0; $y < count($data); $y++) {
            for ($x = 0; $x < count($data[$y]); $x++) {
                $adjacent = call_user_func($test, $x, $y, $data);
                switch ($data[$y][$x]) {
                    case "L":
                        if ($adjacent == 0) {
                            $tmp[$y][$x] = "#";
                            $changed = true;
                        }
                        break;
                    case "#":
                        if ($adjacent >= $max) {
                            $tmp[$y][$x] = "L";
                            $changed = true;
                        }
                        break;
                }
            }
        }
        $data = $tmp;
    }

    $total = 0;
    foreach ($data as $i => $row) {
        $array = array_keys($row, "#");
        $total += count($array);
    }

    print "{$total}\n";
}

$data = load_data("11.txt");

foreach ($data as $i => $line) {
    $data[$i] = str_split($line);
}

check($data, "get_adjacent", 4);

check($data, "get_nearest", 5);
