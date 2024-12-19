<?php

require 'libs/api.php';

$input = (new AdventOfCode())->input(19);
$data = $input->lines()->raw();

$patterns = array_map(fn($v) => trim($v), explode(',', $data[0]));
$towels = array_slice($data, 2);

function check($item)
{
    global $queue, $options;
    list($towel, $haystack, $patterns) = $item;
    foreach ($options as $pattern) {
        if (strpos($haystack, $pattern) === 0) {
            $remaining = substr($haystack, strlen($pattern));
            if (empty($remaining)) {
                return array_merge($patterns, [$pattern]);
            }
            $queue[] = [$towel, $remaining, array_merge($patterns, [$pattern])];
        }
    }
}

$found = 0;
foreach ($towels as $t => $towel) {
    $options = [];
    $queue = [];
    foreach ($patterns as $p => $pattern) {
        if (false !== $pos = strpos($towel, $pattern)) {
            $options[] = $pattern;
            if ($pos === 0) {
                $remaining = substr($towel, strlen($pattern));
                $queue[] = [$towel, $remaining, [$pattern]];
            }
        }
    }
    $item = array_pop($queue);
    while (!is_null($item)) {
        if (check($item)) {
            $found++;
            break;
        }
        $item = array_pop($queue);
    }
}
print $found . "\n";
