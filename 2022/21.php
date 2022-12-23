<?php
require 'libs/api.php';

$data = (new AdventOfCode())->input(21)->lines()->regex('/(\w+): ([\d\w]+)(?: (.{1}) (\w+))*/');

$monkeys = array_combine(array_column($data, 0), $data);

function is_number($value)
{
    return preg_match('/^\-*[\d\.]+$/', $value);
}

function is_monkey($value)
{
    return preg_match('/^[a-z]+$/', $value);
}

function part1($monkeys)
{
    $replacing = true;
    while ($replacing) {
        $replacing = false;
        foreach ($monkeys as $id => &$monkey) {
            if (is_monkey($monkey[1])) {
                if (is_number($monkeys[$monkey[1]][1]) && empty($monkeys[$monkey[1]][3])) {
                    $monkey[1] = $monkeys[$monkey[1]][1];
                } else {
                    $replacing = true;
                }
            }
            if (!empty($monkey[3]) && is_monkey($monkey[3])) {
                if (is_number($monkeys[$monkey[3]][1]) && empty($monkeys[$monkey[3]][3])) {
                    $monkey[3] = $monkeys[$monkey[3]][1];
                } else {
                    $replacing = true;
                }
            }
            if (is_number($monkey[1]) && !empty($monkey[3]) && is_number($monkey[3])) {
                eval("\$eval = {$monkey[1]} {$monkey[2]} {$monkey[3]};");
                $monkey[1] = $eval;
                if ($id == 'root') {
                    return $monkey[1];
                }
                $monkey[3] = null;
            }
        }
    }

    return $monkeys['root'][1] . "\n";
}

function part2($monkeys)
{
    $monkeys['root'][2] = '==';
    $monkeys['humn'][1] = 1;
    $result = part1($monkeys);
    while ($result === false) {
        $monkeys['humn'][1]++;
        $result = part1($monkeys);
    }
    return $monkeys['humn'][1];
}

print part1($monkeys) . "\n";
print part2($monkeys) . "\n";
