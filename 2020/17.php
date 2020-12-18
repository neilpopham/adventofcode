<?php

require('libs/core.php');

/**
 * In this one we only worry about one z direction as they duplicate each other. This is why we double the count for non-zero z values.
 * When checking a z of -1 we use 1 instead.
 * We also keep z slices starting at 0,0, for clarity.
 */
function check_1($data) {

    $cubes[0] = $data;

    for ($t = 0; $t < 6; $t++) {

        $yc = count($cubes[0]);
        $xc = strlen($cubes[0][0]);

        for ($z = 0; $z <= $t + 1; $z++) {
            $cube = array_fill(0, $yc + 2, str_repeat(".", $xc + 2));
            if (isset($cubes[$z])) {
                foreach ($cubes[$z] as $y => $row) {
                    $cube[$y + 1] = substr_replace($cube[$y], $row, 1, strlen($row));
                }
            }
            $cubes[$z] = $cube;
        }

        $current = $cubes;
        foreach (array_keys($cubes) as $z) {
            foreach (array_keys($cubes[$z]) as $y) {
                for ($x = 0; $x < strlen($cubes[$z][$y]); $x++) {
                    $n = find_neighbours($z, $x, $y, $cubes);
                    if ($current[$z][$y][$x] == "#" && ($n < 2 || $n > 3)) {
                        $current[$z][$y][$x] = ".";
                    } elseif ($n == 3) {
                        $current[$z][$y][$x] = "#";
                    }
                }
            }
        }
        $cubes = $current;
    }

    $total = 0;
    foreach ($cubes as $z => $slice) {
        foreach ($slice as $y => $row) {
            $total += ($z == 0 ? 1 : 2) * substr_count($row, "#");
        }
    }

    print "{$total} in total\n";
}

function find_neighbours($z, $x, $y, $cubes) {
    $active = 0;
    for ($dz = -1; $dz <= 1; $dz++) {
        for ($dx = -1; $dx <= 1; $dx++) {
            for ($dy = -1; $dy <= 1; $dy++) {
                if (($dz + $z == $z) && ($dy + $y == $y) && ($dx + $x == $x)) {
                    continue;
                }
                if ($z + $dz == -1) {
                    $cube = $cubes[1];
                } elseif (!isset($cubes[$z + $dz])) {
                    continue;
                } else {
                    $cube = $cubes[$z + $dz];
                }
                if(isset($cube[$y + $dy])
                    && isset($cube[$y + $dy][$x + $dx])
                    && ($cube[$y + $dy][$x + $dx] == "#")) {
                    $active++;
                }
            }
        }
    }
    return $active;
}

function check_2($data) {
    $cubes[0][0] = $data;

    for ($t = 0; $t < 6; $t++) {

        $yc = count($cubes[0][0]);
        $xc = strlen($cubes[0][0][0]);

        for ($w = 0; $w <= $t + 1; $w++) {
            for ($z = 0; $z <= $t + 1; $z++) {
                $cube = array_fill(0, $yc + 2, str_repeat(".", $xc + 2));
                if (isset($cubes[$w][$z])) {
                    foreach ($cubes[$w][$z] as $y => $row) {
                        $cube[$y + 1] = substr_replace($cube[$y], $row, 1, strlen($row));
                    }
                }
                $cubes[$w][$z] = $cube;
            }
        }

        $current = $cubes;
        foreach (array_keys($cubes) as $w) {
            foreach (array_keys($cubes[$w]) as $z) {
                foreach (array_keys($cubes[$w][$z]) as $y) {
                    for ($x = 0; $x < strlen($cubes[$w][$z][$y]); $x++) {
                        $n = find_neighbours_2($w, $z, $x, $y, $cubes);
                        if ($current[$w][$z][$y][$x] == "#" && ($n < 2 || $n > 3)) {
                            $current[$w][$z][$y][$x] = ".";
                        } elseif ($n == 3) {
                            $current[$w][$z][$y][$x] = "#";
                        }
                    }
                }
            }
        }

        $cubes = $current;
    }

    $total = 0;
    foreach ($cubes as $w => $dimension) {
        foreach ($dimension as $z => $slice) {
            foreach ($slice as $y => $row) {
                $total += ($w == 0 ? 1 : 2) * ($z == 0 ? 1 : 2) * substr_count($row, "#");
            }
        }
    }

    print "{$total} in total\n";
}

function find_neighbours_2($w, $z, $x, $y, &$cubes) {
    $active = 0;
    for ($dw = -1; $dw <= 1; $dw++) {
        for ($dz = -1; $dz <= 1; $dz++) {
            for ($dx = -1; $dx <= 1; $dx++) {
                for ($dy = -1; $dy <= 1; $dy++) {
                    if (($dw + $w == $w) && ($dz + $z == $z) && ($dy + $y == $y) && ($dx + $x == $x)) {
                        continue;
                    }
                    if ($w + $dw == -1) {
                        $cube = $cubes[1];
                    } elseif (!isset($cubes[$w + $dw])) {
                        continue;
                    } else {
                        $cube = $cubes[$w + $dw];
                    }
                    if ($z + $dz == -1) {
                        $cube = $cube[1];
                    } elseif (!isset($cubes[$z + $dz])) {
                        continue;
                    } else {
                        $cube = $cube[$z + $dz];
                    }
                    if(isset($cube[$y + $dy])
                        && isset($cube[$y + $dy][$x + $dx])
                        && ($cube[$y + $dy][$x + $dx] == "#")) {
                        $active++;
                    }
                }
            }
        }
    }
    return $active;
}

$data = load_data("17.txt");

check_1($data);

check_2($data);
