<?php

require('libs/core.php');

function check_1($data) {
    foreach ($data as $y => $row) {
        for ($x = 0; $x < strlen($row); $x++) {
            $cubes[0][$y][$x] = $row[$x] == "#";
        }
    }
    for ($t = 0; $t < 6; $t++) {
        $meta = [
            [array_keys($cubes)],
            [array_keys($cubes[0])],
            [array_keys($cubes[0][0])],
        ];
        foreach ($meta as $i => $dimension) {
            $meta[$i][] = reset($dimension[0]);
            $meta[$i][] = end($dimension[0]);
        }
        for ($z = $meta[0][1] - 1; $z <= $meta[0][2] + 1; $z++) {
            if (!isset($cubes[$z])) {
                foreach ($meta[1][0] as $y) {
                    foreach ($meta[2][0] as $x) {
                        $cubes[$z][$y][$x] = false;
                    }
                }
            }
            foreach ($meta[2][0] as $x) {
                $cubes[$z][$meta[1][1] - 1][$x] = false;
                $cubes[$z][$meta[1][2] + 1][$x] = false;
            }
            foreach (array_keys($cubes[$z]) as $y) {
                $cubes[$z][$y][$meta[2][1] - 1] = false;
                $cubes[$z][$y][$meta[2][2] + 1] = false;
                ksort($cubes[$z][$y]);
            }
            ksort($cubes[$z]);
        }
        ksort($cubes);
        $current = $cubes;
        foreach (array_keys($cubes) as $z) {
            foreach (array_keys($current[$z]) as $y) {
                foreach (array_keys($current[$z][$y]) as $x) {
                    $n = find_neighbours($z, $x, $y, $cubes);
                    if ($current[$z][$y][$x] && ($n < 2 || $n > 3)) {
                        $current[$z][$y][$x] = false;
                    } elseif ($n == 3) {
                        $current[$z][$y][$x] = true;
                    }
                }
            }
        }
        $cubes = $current;
    }
    $total = 0;
    foreach ($cubes as $z => $row) {
        foreach ($row as $y => $column) {
            foreach ($column as $x => $value) {
                if ($value) {
                    $total++;
                }
            }
        }
    }
    print "{$total} in total\n";
}

function find_neighbours($z, $x, $y, &$cubes) {
    $active = 0;
    for ($dz = -1; $dz <= 1; $dz++) {
        for ($dx = -1; $dx <= 1; $dx++) {
            for ($dy = -1; $dy <= 1; $dy++) {
                if (($dz+$z == $z) && ($dy+$y == $y) && ($dx+$x == $x)) {
                    continue;
                }
                if(isset($cubes[$z + $dz])
                    && isset($cubes[$z + $dz][$y + $dy])
                    && isset($cubes[$z + $dz][$y + $dy][$x + $dx])
                    && ($cubes[$z + $dz][$y + $dy][$x + $dx])) {
                    $active++;
                }
            }
        }
    }
    return $active;
}

function make_empty_2($meta) {
    foreach ($meta[2][0] as $y) {
        foreach ($meta[3][0] as $x) {
            $slice[$y][$x] = false;
        }
    }
    return $slice;
}

function check_2($data) {
    foreach ($data as $y => $row) {
        for ($x = 0; $x < strlen($row); $x++) {
            $cubes[0][0][$y][$x] = $row[$x] == "#";
        }
    }
    for ($t = 0; $t < 6; $t++) {
        $meta = [
            [array_keys($cubes)],
            [array_keys($cubes[0])],
            [array_keys($cubes[0][0])],
            [array_keys($cubes[0][0][0])],
        ];
        foreach ($meta as $i => $dimension) {
            $meta[$i][] = reset($dimension[0]);
            $meta[$i][] = end($dimension[0]);
        }
        for ($w = $meta[0][1] - 1; $w <= $meta[0][2] + 1; $w++) {
            if (!isset($cubes[$w])) {
                for ($z = $meta[0][1] - 1; $z <= $meta[0][2] + 1; $z++) {
                    $cubes[$w][$z] = make_empty_2($meta);
                }
            }
            for ($z = $meta[0][1] - 1; $z <= $meta[0][2] + 1; $z++) {
                if (!isset($cubes[$w][$z])) {
                    $cubes[$w][$z] = make_empty_2($meta);
                }
                foreach ($meta[3][0] as $x) {
                    $cubes[$w][$z][$meta[2][1] - 1][$x] = false;
                    $cubes[$w][$z][$meta[2][2] + 1][$x] = false;
                }
                foreach (array_keys($cubes[$w][$z]) as $y) {
                    $cubes[$w][$z][$y][$meta[3][1] - 1] = false;
                    $cubes[$w][$z][$y][$meta[3][2] + 1] = false;
                    ksort($cubes[$w][$z][$y]);
                }
                ksort($cubes[$w][$z]);
            }
            ksort($cubes[$w]);
        }
        ksort($cubes);
        $current = $cubes;
        foreach (array_keys($current) as $w) {
            foreach (array_keys($current[$w]) as $z) {
                foreach (array_keys($current[$w][$z]) as $y) {
                    foreach (array_keys($current[$w][$z][$y]) as $x) {
                        $n = find_neighbours_2($w, $z, $x, $y, $cubes);
                        if ($current[$w][$z][$y][$x] && ($n < 2 || $n > 3)) {
                            $current[$w][$z][$y][$x] = false;
                        } elseif ($n == 3) {
                            $current[$w][$z][$y][$x] = true;
                        }
                    }
                }
            }
        }
        $cubes = $current;
    }
    $total = 0;
    foreach ($cubes as $w => $slice) {
        foreach ($slice as $z => $row) {
            foreach ($row as $y => $column) {
                foreach ($column as $x => $value) {
                    if ($value) {
                        $total++;
                    }
                }
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
                    if (($dw+$w == $w) && ($dz+$z == $z) && ($dy+$y == $y) && ($dx+$x == $x)) {
                        continue;
                    }
                    if(isset($cubes[$w + $dw])
                        && isset($cubes[$w + $dw][$z + $dz])
                        && isset($cubes[$w + $dw][$z + $dz][$y + $dy])
                        && isset($cubes[$w + $dw][$z + $dz][$y + $dy][$x + $dx])
                        && ($cubes[$w + $dw][$z + $dz][$y + $dy][$x + $dx])) {
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
