<?php

require('libs/api.php');

$data = (new AdventOfCode())->input(24)->lines()->regex('/^(\w{3}) (\w+)(?: (\w+))*$/');

$input = [];

$input = array_fill(0, 14, 9);

function decrease(array $input, int $index): array {
    $input[$index]--;
    if ($input[$index] == 0) {
        $input[$index] = 9;
        $input = decrease($input, $index - 1);
    }
    return $input;
}

$success = alu(implode('', $input));
while (false === $success) {
    $input = decrease($input, 13);
    $success = alu(implode('', $input));
}


/*
$input = '99999999999999';

$s = "inp z
inp x
mul z 3
eql z x";

$data = (new AdventOfCodeData($s))->lines()->regex('/^(\w{3}) (\w+)(?: (\w+))*$/');
$input = '39';
*/

function alu(string $input): bool {
    global $data;

    $p = 0;
    foreach(range('w', 'z') as $key) {
        $v[$key] = 0;
    }

    print "{$input}\n";

    foreach ($data as $key => $value) {
        array_shift($value);
        $operation = array_shift($value);
        if (isset($value[1]) && preg_match('/^[w-z]$/', $value[1])) {
            $value[1] = $v[$value[1]];
        }
        switch($operation) {
            case 'inp':
                $v[$value[0]] = (int) $input[$p++];
                break;
            case 'add':
                $v[$value[0]] += $value[1];
                break;
            case 'mul':
                $v[$value[0]] *= $value[1];
                break;
            case 'div':
                $v[$value[0]] = round($v[$value[0]] / $value[1]);
                break;
            case 'mod':
                $v[$value[0]] %= $value[1];
                break;
            case 'eql':
                $v[$value[0]] = ($v[$value[0]] == $value[1]) ? 1 : 0;
                break;     
        }
    }

    return $v['z'] = 0;
}
