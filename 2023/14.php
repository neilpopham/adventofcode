<?php

require 'libs/api.php';

$input = (new AdventOfCode())->input(14);

$data = $input->lines()->raw();

$rlen = strlen($data[0]);

$columns = array_fill(0, $rlen, '');
for ($x = 0; $x < $rlen; $x++) {
    foreach (array_keys($data) as $y) {
        $columns[$rlen - $x - 1] .= $data[$y][$x];
    }
}
$data = $columns;

$total = 0;
foreach ($data as $y => $row) {
    if (preg_match_all('/(?:^|#)([^#]+)/', $row, $matches, PREG_OFFSET_CAPTURE)) {
        foreach ($matches[1] as $m => $match) {
            $blen = strlen($match[0]);
            $boulders = str_replace('.', '', $match[0]);
            for ($i = 0; $i < strlen($boulders); $i++) {
                $total += ($rlen - $i - $match[1]);
            }
            $row = substr($row, 0, $match[1])
                . str_pad($boulders, $blen, '.')
                . substr($row, $match[1] + $blen);
        }
    }
    $data[$y] = $row;
}

print $total . "\n";
