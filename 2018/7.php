<?php

require 'libs/api.php';

$input = (new AdventOfCode())->input(7);

$data = $input->lines()->regex('/Step ([A-Z]) must be finished before step ([A-Z]) can begin/');

$steps = [];
$opens = [];
$blocks = [];
foreach ($data as $value) {
    $steps[$value[0]] = $value[0];
    $steps[$value[1]] = $value[1];
    $blocks[$value[0]][$value[1]] = $value[1];
    $opens[$value[1]][$value[0]] = $value[0];
}

$available = [];
foreach ($steps as $step) {
    if (false === isset($opens[$step])) {
        $available[] = $step;
    }
}

function part1($steps, $opens, $blocks, $available)
{
    $sequence = '';

    do {
        arsort($available);
        $step = array_pop($available);
        $sequence .= $step;

        foreach ($blocks[$step] as $value) {
            unset($opens[$value][$step]);
            if (empty($opens[$value])) {
                $available[] = $value;
                unset($opens[$value]);
            }
        }
    } while (!empty($opens));

    $step = array_pop($available);
    $sequence .= $step;

    print $sequence . "\n";
}


function part2($steps, $opens, $blocks, $available)
{
    $base = 60;
    $count = 10;

    $seconds = 0;
    $queue = $available;
    $done = [];
    $workers = array_fill(0, $count, null);

    do {
        // Assign step to worker
        foreach ($workers as $w => $worker) {
            if (false === is_array($worker)) {
                if (false === empty($queue)) {
                    $step = array_pop($queue);
                    $workers[$w] = [$step, $base + ord($step) - 64];
                }
            }
        }
        // Check worker progress
        foreach ($workers as $w => $worker) {
            if (is_array($worker)) {
                $workers[$w][1]--;
                if ($workers[$w][1] == 0) {
                    $done[] = $worker[0];
                    if (isset($blocks[$worker[0]])) {
                        foreach ($blocks[$worker[0]] as $step) {
                            if (in_array($step, $queue)) {
                                continue;
                            }
                            $add = true;
                            foreach ($opens[$step] as $possible) {
                                if (!in_array($possible, $done)) {
                                    $add = false;
                                    break;
                                }
                            }
                            if ($add) {
                                $queue[] = $step;
                            }
                        }
                        rsort($queue);
                    }
                    $workers[$w] = null;
                }
            }
        }

        $seconds++;
    } while (count($done) < count($steps));

    print $seconds . "\n";
}

part1($steps, $opens, $blocks, $available);
part2($steps, $opens, $blocks, $available);
exit;
