<?php

require 'libs/api.php';

$input = (new AdventOfCode())->input(4);

$example = (new AdventOfCode())->example(4, 1);
$data = $example->lines()->raw();

$data = $input->lines()->raw();

$word = 'XMAS';

$data = array_map(fn($row) => str_split($row), $data);

$total = 0;
foreach ($data as $y => $row) {
    foreach ($row as $x => $c) {
        if ($c == $word[0]) {
            for ($dy = -1; $dy <= 1; $dy++) {
                for ($dx = -1; $dx <= 1; $dx++) {
                    if ($dy == 0 && $dx == 0) {
                        continue;
                    }
                    for ($o = 1; $o < 4; $o++) {
                        $cx = $x + ($dx * $o);
                        $cy = $y + ($dy * $o);
                        $v = isset($data[$cy][$cx]) ? $data[$cy][$cx] : ' ';
                        if ($v != $word[$o]) {
                            continue 2;
                        }
                    }
                    $total++;
                }
            }
        }
    }
}
print $total . "\n";

$s = microtime(true);
$total = 0;
foreach ($data as $y => $row) {
    foreach ($row as $x => $c) {
        if ($c == 'A') {
            // $masses = 0;
            // foreach ([-1, 1] as $dy) {
            //     foreach ([-1, 1] as $dx) {
            //         $cx = $x + $dx;
            //         $cy = $y + $dy;
            //         if (!isset($data[$cy][$cx])) {
            //             continue 2;
            //         }
            //         if (!in_array($data[$cy][$cx], ['M', 'S'])) {
            //             continue 2;
            //         }
            //         $v = $data[$cy][$cx];
            //         $ox = $x + $dx + (-2 * $dx);
            //         $oy = $y + $dy + (-2 * $dy);
            //         if (!isset($data[$oy][$ox])) {
            //             continue 2;
            //         }
            //         if ($v == 'M' & $data[$oy][$ox] == 'S') {
            //             $masses++;
            //         }
            //     }
            // }
            // if ($masses == 2) {
            //     $total++;
            // }


            if (
                !isset($data[$y - 1][$x - 1])
                || !isset($data[$y - 1][$x + 1])
                || !isset($data[$y + 1][$x - 1])
                || !isset($data[$y + 1][$x + 1])
            ) {
                continue;
            }

            if (
                (
                    ($data[$y - 1][$x - 1] == 'M' && $data[$y + 1][$x + 1] == 'S')
                    || ($data[$y - 1][$x - 1] == 'S' && $data[$y + 1][$x + 1] == 'M')
                )
                && (
                    ($data[$y - 1][$x + 1] == 'M' && $data[$y + 1][$x - 1] == 'S')
                    || ($data[$y - 1][$x + 1] == 'S' && $data[$y + 1][$x - 1] == 'M')
                )
            ) {
                $total++;
            }
        }
    }
}
print $total . "\n";
$t = microtime(true);
print ($t - $s) . "\n";
