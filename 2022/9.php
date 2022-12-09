<?php
require 'libs/api.php';

$data = (new AdventOfCode())->input(9)->lines()->regex('/^([RUDL]) (\d+)$/');

function check($data, $num)
{
    $pos["0|0"] = 1;
    $map = ['U' => [0, 1], 'D' => [0, -1], 'L' => [-1, 0], 'R' => [1, 0]];
    for ($i = 0; $i < $num; $i++) {
        $knots[$i] = [0, 0];
    }

    foreach ($data as $move) {
        $delta = $map[$move[0]];

        for ($m = 0; $m < $move[1]; $m++) {

            $knots[0][0] += $delta[0];
            $knots[0][1] += $delta[1];

            for ($i = 1; $i < $num; $i++) {
                $hx = $knots[$i - 1][0];
                $hy = $knots[$i - 1][1];
                $tx = $knots[$i][0];
                $ty = $knots[$i][1];
                $ox = $tx;
                $oy = $ty;

                $dx = $hx - $tx;
                $dy = $hy - $ty;

                if ($tx != $hx) {
                    $tx += ($hx > $tx ? 1 : -1);
                }
                if ($ty != $hy) {
                    $ty += ($hy > $ty ? 1 : -1);
                }
                if ($tx == $hx && $ty == $hy) {
                    $tx = $ox;
                    $ty = $oy;
                }

                $knots[$i] = [$tx, $ty];

                if ($i == $num - 1) {
                    $pos["{$tx}|{$ty}"] = 1;
                }
            }
        }
    }

    return count($pos);
}

print check($data, 2) . "\n";
print check($data, 10) . "\n";
