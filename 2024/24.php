<?php

require 'libs/api.php';

$input = (new AdventOfCode())->input(24);
$data = $input->lines()->raw();

$queue = [];
$values = [];
$gates = [];
$g = false;
foreach ($data as $value) {
    if (empty($value)) {
        $g = true;
    } elseif ($g) {
        preg_match('/(\w+) (AND|OR|XOR) (\w+) -> (\w+)/', $value, $matches);
        $gates[$matches[1]][] = [$matches[3], $matches[2], $matches[4]];
        $gates[$matches[3]][] = [$matches[1], $matches[2], $matches[4]];
    } else {
        preg_match('/(\w+): ([10])/', $value, $matches);
        $queue[] = [$matches[1], $matches[2]];
    }
}

$item = array_shift($queue);
while (!is_null($item)) {
    list($wire, $bit) = $item;
    $values[$wire] = intval($bit);
    if (isset($gates[$wire])) {
        foreach ($gates[$wire] as $data) {
            list($partner, $type, $output) = $data;
            if (isset($values[$partner])) {
                switch ($type) {
                    case 'AND':
                        $queue[] = [$output, $values[$wire] & $values[$partner]];
                        break;
                    case 'OR':
                        $queue[] = [$output, $values[$wire] | $values[$partner]];
                        break;
                    case 'XOR':
                        $queue[] = [$output, $values[$wire] ^ $values[$partner]];
                        break;
                }
            }
        }
    }
    $item = array_shift($queue);
}

$bits = [];
foreach ($values as $wire => $value) {
    if ($wire[0] == 'z') {
        $bits[intval(substr($wire, 1))] = $value;
    }
}
krsort($bits);
print bindec(implode('', $bits)) . "\n";
