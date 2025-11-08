<?php

require 'libs/aoc.php';

$data = new AdventOfCode\AdventOfCode()->input(day: 9)->raw();

$data = preg_replace('/!./', '', $data);

preg_match_all('/<(.*?)>/', $data, $matches);

$garbage = array_sum(
    array_map(
        fn($v) => strlen($v),
        $matches[1]
    )
);

$data = preg_replace(['/<.*?>/', '/,/'], '', $data);

$l = strlen($data);
$o = [];
$total = 0;
for ($i = 0; $i < $l; $i++) {
    if ($data[$i] == '{') {
        $o[] = $i;
    } elseif ($data[$i] == '}') {
        $total += count($o);
        array_pop($o);
    }
}

print $total . "\n";
print $garbage . "\n";