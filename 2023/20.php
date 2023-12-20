<?php

require 'libs/api.php';

$input = (new AdventOfCode())->input(20);

$data = $input->lines()->regex('/([%&]*)(.+) -> (.+)/');

$modules = [];
foreach ($data as $key => $value) {
    $value[2] = array_map(fn($v) => trim($v), explode(',', $value[2]));
    $modules[$value[1]] = $value;
    $modules[$value[1]][1] = 0;
}
unset($data);

foreach ($modules as $key => $module) {
    foreach ($module[2] as $receiver) {
        if (isset($modules[$receiver])) {
            $modules[$receiver][3][$key] = 0;
        }
    }
}

function process($modules, $max)
{
    $pulses = [0, 0];
    $sq = $modules['sq'][3];

    for ($press = 1; $press <= $max; $press++) {
        $queue = [['broadcaster', 0, 'button']];

        while (count($queue)) {
            list($index, $pulse, $sender) = array_shift($queue);
            $pulses[$pulse]++;

            if (!isset($modules[$index])) {
                continue;
            }

            $module = $modules[$index];
            list($type, $value, $receivers) = $module;

            if (empty($type)) {
                foreach ($receivers as $receiver) {
                    $queue[] = [$receiver, $pulse, $index];
                }
            } elseif ($type == '%') {
                if ($pulse == 0) {
                    $modules[$index][1] = $modules[$index][1] ^ 1;
                    foreach ($receivers as $receiver) {
                        $queue[] = [$receiver, $modules[$index][1], $index];
                    }
                }
            } elseif ($type == '&') {
                $modules[$index][3][$sender] = $pulse;
                $off = array_filter($modules[$index][3], fn($v) => $v == 0);
                $value = empty($off) ? 0 : 1;
                foreach ($receivers as $receiver) {
                    $queue[] = [$receiver, $value, $index];
                }

                if ($max == PHP_INT_MAX && $index == 'sq' && $pulse == 1 && $sq[$sender] == 0) {
                    $sq[$sender] = $press;
                    $seen = array_filter($sq);
                    if (count($seen) == count($sq)) {
                        return array_product($sq);
                    }
                }
            }
        }
    }

    return array_product($pulses);
}

print process($modules, 1000) . "\n";

print process($modules, PHP_INT_MAX) . "\n";
