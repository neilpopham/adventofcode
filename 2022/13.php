<?php
require 'libs/api.php';

$data = (new AdventOfCode())->input(13)->lines()->raw();

define('STATE_UNKNOWN', 0);
define('STATE_SUCCESS', 1);
define('STATE_FAIL', 2);

$packets = [];
for ($i = 1; $i < count($data); $i += 3) {
    $packets[] = [$data[$i - 1], $data[$i]];
}

$parts = [];
$parsed = [];
foreach ($packets as $p => $packet) {
    $parsed[$p] = [];
    $parts[$p] = [];
    foreach ($packet as $s => $side) {
        $parts[$p][$s] = [];
        $m = -1;
        while (preg_match_all('/\[[^\]\[]*\]/', $side, $matches)) {
            $matches = array_unique($matches[0]);
            foreach ($matches as $match) {
                $parts[$p][$s][++$m] = $match;
                $side = str_replace($match, "#{$m}#", $side);
            }
        }
        $parsed[$p][$s] = $side;
    }
}

function process_lists($part, $lists)
{
    $array = [];
    foreach ($lists as $s => $list) {
        if (preg_match('/^\[(.+)*\]$/', $list, $matches)) {
            $array[$s] = isset($matches[1]) ? explode(',', $matches[1]) : [];
        }
    }

    $left = current($array[0]);
    $right = current($array[1]);

    $state = STATE_UNKNOWN;
    while ($state == STATE_UNKNOWN) {
        if ($left === false) {
            return $right === false ? STATE_UNKNOWN : STATE_SUCCESS;
        } elseif ($right === false) {
            return STATE_FAIL;
        }
        if (preg_match('/^#(\d+)#$/', $left, $matches)) {
            $left = $part[0][$matches[1]];
            if (preg_match('/^#(\d+)#$/', $right, $matches)) {
                $right = $part[1][$matches[1]];
            } else {
                $right = "[{$right}]";
            }
            $return = process_lists($part, [$left, $right]);
            if ($return != STATE_UNKNOWN) {
                return $return;
            }
        } elseif (preg_match('/^#(\d+)#$/', $right, $matches)) {
            $right = $part[1][$matches[1]];
            $left = "[{$left}]";
            $return = process_lists($part, [$left, $right]);
            if ($return != STATE_UNKNOWN) {
                return $return;
            }
        } else {
            if ($right > $left) {
                return STATE_SUCCESS;
            } elseif ($right < $left) {
                return STATE_FAIL;
            }
        }
        $left = next($array[0]);
        $right = next($array[1]);
    }
}

$total = 0;
foreach ($parsed as $p => $packet) {
    $lists = [];
    foreach ($packet as $s => $side) {
        if (preg_match('/^#(\d+)#$/', $side, $matches)) {
            $i = $matches[1];
            $lists[] = $parts[$p][$s][$i];
        }
    }

    $state = process_lists($parts[$p], $lists);

    if ($state == STATE_SUCCESS) {
        $total += ($p + 1);
    }
}

print "{$total}\n";

$packets[] = ['[[2]]', '[[6]]'];

$packs = [];
foreach ($packets as $p => $packet) {
    foreach ($packet as $s => $side) {
        $packs[] = $side;
    }
}

usort(
    $packs,
    function ($a, $b) {
        $parts = [];
        $parsed = [];
        $lists = [];
        foreach ([$a, $b] as $s => $side) {
            $parts[$s] = [];
            $m = -1;
            while (preg_match_all('/\[[^\]\[]*\]/', $side, $matches)) {
                $matches = array_unique($matches[0]);
                foreach ($matches as $match) {
                    $parts[$s][++$m] = $match;
                    $side = str_replace($match, "#{$m}#", $side);
                }
            }
            $parsed[$s] = $side;
            $lists[$s] = $parts[$s][$m];
        }
        return process_lists($parts, $lists) == STATE_SUCCESS ? -1 : 1;
    }
);

print (array_search('[[2]]', $packs) + 1) * (array_search('[[6]]', $packs) + 1) . "\n";
