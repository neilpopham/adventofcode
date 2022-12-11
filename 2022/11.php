<?php
require 'libs/api.php';

$data = (new AdventOfCode())->input(11)->lines();

$monkeys = [];
$m = -1;
foreach ($data as $line) {
    if (preg_match('/Monkey (\d)/', $line, $matches)) {
        $m = $matches[1];
        $monkeys[$m]['inspected'] = 0;
    } elseif (preg_match('/Starting items: (.+)/', $line, $matches)) {
        $monkeys[$m]['items'] = explode(', ', $matches[1]);
    } elseif (preg_match('/Operation\: new = old ([\*\+\/\-]) (old|\d+)/', $line, $matches)) {
        $monkeys[$m]['operation'] = array_slice($matches, 1);
    } elseif (preg_match('/Test\: divisible by (\d+)/', $line, $matches)) {
        $monkeys[$m]['test'][0] = $matches[1];
    } elseif (preg_match('/If true\: throw to monkey (\d)/', $line, $matches)) {
        $monkeys[$m]['test'][1] = $matches[1];
    } elseif (preg_match('/If false\: throw to monkey (\d)/', $line, $matches)) {
        $monkeys[$m]['test'][2] = $matches[1];
    }
}

function check($monkeys, $rounds, $part = 1)
{
    $modulo = 1;
    foreach ($monkeys as $monkey) {
        $modulo *= $monkey['test'][0];
    }

    $round = 0;
    while ($round < $rounds) {
        foreach ($monkeys as $m => &$monkey) {
            $item = array_shift($monkey['items']);
            while (!is_null($item)) {
                $monkey['inspected']++;
                $value = $monkey['operation'][1] == 'old' ?  $item : $monkey['operation'][1];

                if ($monkey['operation'][0] == '+') {
                    $item += $value;
                } elseif ($monkey['operation'][0] == '*') {
                    $item *= $value;
                }

                if ($part == 1) {
                    $item = floor($item / 3);
                } else {
                    $item = $item % $modulo;
                }

                $recipient = $item % $monkey['test'][0] == 0 ? $monkey['test'][1] : $monkey['test'][2];
                $monkeys[$recipient]['items'][] = $item;

                $item = array_shift($monkey['items']);
            }
        }
        unset($monkey);
        $round++;
    }

    usort($monkeys, fn($a, $b) => $b['inspected'] <=> $a['inspected']);

    return $monkeys;
}

$checked = check($monkeys, 20, 1);
print ($checked[0]['inspected'] * $checked[1]['inspected']) . "\n";

$checked = check($monkeys, 10000, 2);
print ($checked[0]['inspected'] * $checked[1]['inspected']) . "\n";
