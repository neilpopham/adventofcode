<?php

require 'libs/api.php';

$input = (new AdventOfCode())->input(5);
$data = $input->lines()->raw();

$rules = [];
$list = [];
$p = false;
foreach ($data as $line) {
    if (empty($line)) {
        $p = true;
    } elseif ($p) {
        $list[] = explode(',', $line);
    } else {
        $rules[$line] = 1;
    }
}

$ordered = 0;
$unordered = 0;
foreach ($list as $pages) {
    $sorted = $pages;
    usort(
        $sorted,
        function ($a, $b) use ($rules) {
            if (isset($rules["{$a}|{$b}"])) {
                return -1;
            } elseif (isset($rules["{$b}|{$a}"])) {
                return 1;
            } else {
                return 0;
            }
        }
    );
    $middle = $sorted[floor(count($sorted) / 2)];
    if ($pages === $sorted) {
        $ordered += $middle;
    } else {
        $unordered += $middle;
    }
}
print $ordered . "\n";
print $unordered . "\n";
