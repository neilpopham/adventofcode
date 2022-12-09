<?php
require 'libs/api.php';

$data = (new AdventOfCode())->input(2)->csv();

function process($data, $noun, $verb)
{
    $data[1] = $noun;
    $data[2] = $verb;

    $i = 0;
    while ($i < count($data)) {
        switch($data[$i]) {
        case 1:
            $data[$data[$i + 3]] = $data[$data[$i + 1]] + $data[$data[$i + 2]];
            break;
        case 2:
            $data[$data[$i + 3]] = $data[$data[$i + 1]] * $data[$data[$i + 2]];
            break;      
        case 99:
            $i = PHP_INT_MAX;
            break;      
        }
        $i += 4;
    }
    
    return $data[0];
}

print process($data, 12, 2) . "\n";

for ($verb = 0; $verb < 100; $verb++) {
    for ($noun = 0; $noun < 100; $noun++) {
        $processed = process($data, $noun, $verb);
        if ($processed == 19690720) {
            print (100 * $noun + $verb) . "\n";
            exit;
        }
    }
}
