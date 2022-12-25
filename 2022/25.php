<?php
require 'libs/api.php';

$data = (new AdventOfCode())->input(25)->lines()->raw();

function dec2snafu(int $num)
{
    $map = ['5' => '0', '4' => '-', '3' => '='];
    $b5 = base_convert($num, 10, 5);
    for ($n = strlen($b5) - 1; $n >= 0; $n--) {
        if ($b5[$n] > 2) {
            $b5 = ($n == 0 ? '1' : substr($b5, 0, $n - 1) . ($b5[$n - 1] + 1))
                . $map[$b5[$n]] . substr($b5, $n + 1);
        }
    }
    return $b5;
}

function snafu2dec(string $num)
{
    $map = ['0' => 0, '1' => 1, '2' => 2, '-' => -1, '=' => -2];
    $total = 0;
    for ($n = strlen($num) - 1; $n >= 0; $n--) {
        $total += (pow(5, strlen($num) - $n - 1) * $map[$num[$n]]);
    }
    return $total;
}

$total = 0;
foreach ($data as $value) {
    $total += snafu2dec($value);
}

print dec2snafu($total) . "\n";
