<?php

require('libs/core.php');

$data = load_data("5.txt");

$seats = [];

foreach ($data as $key => $value) {
    $value = str_replace(["F", "B", "L", "R"], ["0", "1", "0", "1"], $value);
    $row = bindec(substr($value, 0, 7));
    $column = bindec(substr($value, 7));
    $id = $row * 8 + $column;
    $seats[] = $id;
}

sort($seats);

$max = end($seats);
$min = reset($seats);

print "Max is {$max}\n";

for ($i=$min; $i < $max; $i++) {
    if (!in_array($i, $seats)) {
       print "Seat $i is missing\n";
    }
}
