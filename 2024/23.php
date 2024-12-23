<?php

require 'libs/api.php';

$input = (new AdventOfCode())->input(23);
$data = $input->lines()->regex('/(\w+)\-(\w+)/');

$links = [];
foreach ($data as $pair) {
    $links[$pair[0]][] = $pair[1];
    $links[$pair[1]][] = $pair[0];
}

foreach ($links as $c1 => $names) {
    foreach ($names as $c2) {
        foreach ($names as $c3) {
            if ($c2 == $c3) {
                continue;
            }
            if ($c1[0] !== 't' && $c2[0] !== 't' && $c3[0] !== 't') {
                continue;
            }
            if (
                in_array($c1, $links[$c2])
                && in_array($c3, $links[$c2])
                && in_array($c1, $links[$c3])
                && in_array($c2, $links[$c3])
            ) {
                $c = [$c1, $c2, $c3];
                sort($c);
                $triplets[implode('|', $c)] = 1;
            }
        }
    }
}
print count($triplets) . "\n";

function check($item)
{
    global $queue, $done, $links;
    list($linked, $check) = $item;
    foreach ($check as $name) {
        $valid = true;
        foreach ($linked as $link) {
            if (false === in_array($link, $links[$name])) {
                $valid = false;
                break;
            }
        }
        if ($valid) {
            $new = $linked;
            $new[] = $name;
            sort($new);
            $key = implode(',', $new);
            if (isset($done[$key])) {
                continue;
            }
            $siblings = $links[$name];
            foreach ($links[$name] as $i => $c) {
                if (in_array($c, $linked)) {
                    unset($siblings[$i]);
                }
            }
            $queue[] = [$new, $siblings];
            $done[$key] = 1;
        }
    }
}

$done = [];
$queue = [];
foreach ($links as $c1 => $names) {
    foreach ($names as $i => $c2) {
        $siblings = $names;
        unset($siblings[$i]);
        $queue[] = [[$c1, $c2], $siblings];
    }
}

$item = array_pop($queue);
while (!is_null($item)) {
    check($item);
    $item = array_pop($queue);
}

$done = array_keys($done);
usort($done, fn($a, $b) => strlen($b) <=> strlen($a));
print reset($done) . "\n";
