<?php

require 'libs/api.php';

$input = (new AdventOfCode())->input(19);
$input = (new AdventOfCode())->example(19, 0);

$data = $input->lines()->raw();

$parts = [];
$workflows = [];
foreach ($data as $key => $line) {
    if (preg_match('/^{(.+)}/', $line, $matches)) {
        if (preg_match_all('/(\w)=(\d+)/', $matches[1], $vars)) {
            foreach ($vars[1] as $key => $var) {
                $part[$var] = $vars[2][$key];
            }
            $parts[] = $part;
        }
    } elseif (preg_match('/^(\w+){(.+)}/', $line, $matches)) {
        $workflows[$matches[1]] = explode(',', $matches[2]);
    }
}

function action($part, $action)
{
    if ($action == 'A') {
        return true;
    } elseif ($action == 'R') {
        return false;
    } else {
        return process($part, $action);
    }
}

function process($part, $step)
{
    global $workflows;
    $workflow = $workflows[$step];
    foreach ($workflows[$step] as $s => $step) {
        if (preg_match('/^([xmas])([><])(\d+):(\w+)$/', $step, $matches)) {
            list(, $var, $operator, $value, $action) = $matches;
            if ($operator == '<') {
                $success = $part[$var] < $value;
            } else {
                $success = $part[$var] > $value;
            }
            if ($success) {
                return action($part, $action);
            }
        } else {
            return action($part, $step);
        }
    }
}

$accepted = [];
foreach ($parts as $key => $part) {
    if (process($part, 'in')) {
        $accepted[] = $part;
    }
}

$total = array_reduce($accepted, fn($t, $a) => $t + array_sum($a), 0);
print $total . "\n";
