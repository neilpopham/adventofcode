<?php

require 'libs/api.php';

$input = (new AdventOfCode())->input(4);
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

$total = 0;
foreach ($data as $y => $row) {
    foreach ($row as $x => $c) {
        if ($c == 'A') {
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
