<?php
require 'libs/api.php';

$data = (new AdventOfCode())->input(8)->lines()->raw();

$xl = strlen($data[0]);
$xm = $xl - 1;
$yl = count($data);
$ym = $yl - 1;

$col = [];
for ($c = 0; $c < $xl; $c++) {
    $col[$c] = '';
    foreach ($data as $r => $line) {
        $col[$c] .= $line[$c];
    }
}

$total = 0;

foreach ($data as $r => $row) {
    for ($c = 0; $c < $xl; $c++) {
        $t = $data[$r][$c];
        if ($r == 0 || $r == $ym || $c == 0 || $c == $xm) {
            $total += 1;
            continue;
        }
        $regex = "/[{$t}-9]/";
        if (!preg_match($regex, substr($row, 0, $c))
            || !preg_match($regex, substr($row, $c + 1))
            || !preg_match($regex, substr($col[$c], 0, $r))
            || !preg_match($regex, substr($col[$c], $r + 1))
        ) {
            $total += 1;
        }
    }
}

print "{$total}\n";

$distance = [];
foreach ($data as $r => $row) {
    for ($c = 0; $c < $xl; $c++) {
        $t = $data[$r][$c];

        if ($t == 0) {
            continue;
        }

        $distance["{$r}|{$c}"] = 1;

        $reg1 = "/[" . $t . "-9]*[0-" . ($t - 1) . "]+$/";
        $reg2 = "/^[0-" . ($t - 1) . "]+[" . $t . "-9]*/";

        if ($r > 0) {
            if (preg_match($reg1, substr($row, 0, $c), $matches)) {
                $distance["{$r}|{$c}"] *= strlen($matches[0]);
            }
        }
        if ($r < $yl) {
            if (preg_match($reg2, substr($row, $c + 1), $matches)) {
                $distance["{$r}|{$c}"] *= strlen($matches[0]);
            }
        }
        if ($c > 0) {
            if (preg_match($reg1, substr($col[$c], 0, $r), $matches)) {
                $distance["{$r}|{$c}"] *= strlen($matches[0]);
            }
        }
        if ($c < $xl) {
            if (preg_match($reg2, substr($col[$c], $r + 1), $matches)) {
                $distance["{$r}|{$c}"] *= strlen($matches[0]);
            }
        }
    }
}

rsort($distance);
print $distance[0];
