<?php
require 'libs/api.php';

list($start, $end) = explode('-', (new AdventOfCode())->input(4)->raw());

$total = 0;
$total_2 = 0;

for ($i = $start; $i <= $end; $i++) {
    $i = (string) $i;

    if (!preg_match('/(\d)\1/', $i)) {
        continue;
    }
    for ($c = 0; $c < strlen($i); $c++) {
        $char = $i[$c];
        if (preg_match('/[0-' . ($char == 0 ? 0 : $char - 1) . ']/', substr($i, $c + 1))) {
            continue 2;
        }
    }
    $total++;
    
    if (!preg_match('/(?:^(\d)\1)(?!\1)|(\d)(?!\2)(\d)\3(?!\3)/', $i)) {
        continue;
    }
    $total_2++;    
}

print "{$total}\n";
print "{$total_2}\n";
