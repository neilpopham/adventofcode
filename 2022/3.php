<?php
require 'libs/api.php';

$data = (new AdventOfCode())->input(3)->lines()->raw();

$total = 0;
foreach ($data as $key => $value) {
    $pockets = str_split($value, strlen($value) / 2);
    $intersect = array_intersect(
        str_split($pockets[0]),
        str_split($pockets[1])
    );
    $item = reset($intersect);
    $ord = ord($item);
    $total += ($ord > 90 ? $ord - 96 : $ord - 38);
}
print "{$total}\n";

$total = 0;
for ($i = 0; $i < count($data); $i += 3) {
    $intersect = array_intersect(
        str_split($data[$i]),
        str_split($data[$i + 1]),
        str_split($data[$i + 2])
    );
    $item = reset($intersect);
    $ord = ord($item);
    $total += ($ord > 90 ? $ord - 96 : $ord - 38);
}
print "{$total}\n";
