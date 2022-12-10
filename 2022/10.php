<?php
require 'libs/api.php';

$data = (new AdventOfCode())->input(10)->lines()->raw();

print_r($data);

$cycle = 0;
$tick = 0;
$ins = ['noop'];
$X = 1;
$total = 0;

$crt = array_fill(0, 6, array_fill(0, 40, '.'));

do {
    if ($cycle > 0 && $cycle <= 240) {
        $r = floor(($cycle - 1) / 40);
        $c = ($cycle - 1) % 40;
        foreach (range($X -1, $X + 1) as $p) {
            if ($p == $c) {
                $crt[$r][$c] = '#';
            }
        }
        if (($cycle + 20) % 40 == 0) {
            $total += ($cycle * $X);
        }
    }
    if ($tick == 0) {
        switch ($ins[0]) {
            case 'noop':
                break;
            case 'addx':
                $X += $ins[1];
                break;
        }
        $ins = $cycle == 0 ? current($data) : next($data);
        if (false !== $ins) {
            $ins = explode(' ', $ins);
            switch ($ins[0]) {
                case 'noop':
                    $tick = 1;
                    break;
                case 'addx':
                    $tick = 2;
                    break;
            }
        }
    }
    $cycle++;
    $tick--;
} while (false !== $ins);

print "{$total}\n";

foreach ($crt as $row) {
    foreach ($row as $pixel) {
        print $pixel;
    }
    print "\n";
}
