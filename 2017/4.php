<?php

require 'libs/aoc.php';

$data = new AdventOfCode\AdventOfCode()->input(day: 4)->lines();

$total = 0;
foreach ($data as $row) {
    $words = explode(' ', $row);
    $okay = true;
    foreach ($words as $i => $word) {
        for ($j = $i + 1; $j < count($words); $j++) {
            if (strcmp($word, $words[$j]) == 0) {
                $okay = false;
                break 2;
            }
        }
    }
    if ($okay) {
        $total++;
    }
}

print $total . "\n";

$total = 0;
foreach ($data as $row) {
    $words = explode(' ', $row);
    $words = array_map(
        function ($word) {
            $letters = str_split($word);
            sort($letters);
            return implode('', $letters);
        },
        $words
    );
    $okay = true;
    foreach ($words as $i => $word) {
        for ($j = $i + 1; $j < count($words); $j++) {
            if (strcmp($word, $words[$j]) == 0) {
                $okay = false;
                break 2;
            }
        }
    }
    if ($okay) {
        $total++;
    }
}

print $total . "\n";
