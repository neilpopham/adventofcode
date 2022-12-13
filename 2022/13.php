<?php
require 'libs/api.php';

$data = (new AdventOfCode())->input(13)->lines()->raw();

define('STATE_UNKNOWN', 0);
define('STATE_SUCCESS', 1);
define('STATE_FAIL', 2);

$packets = [];
for ($i = 1; $i < count($data); $i += 3) {
    $packets[] = [json_decode($data[$i - 1]), json_decode($data[$i])];
}

function compare($a, $b)
{
    $left = current($a);
    $right = current($b);
    $state = STATE_UNKNOWN;
    while ($state == STATE_UNKNOWN) {
        if ($left === false) {
            return $right === false ? STATE_UNKNOWN : STATE_SUCCESS;
        }
        if ($right === false) {
            return STATE_FAIL;
        }
        if (is_array($left) || is_array($right)) {
            $left = is_array($left) ? $left : [$left];
            $right = is_array($right) ? $right : [$right];
            $return = compare($left, $right);
            if ($return != STATE_UNKNOWN) {
                return $return;
            }
        } elseif ($right > $left) {
            return STATE_SUCCESS;
        } elseif ($right < $left) {
            return STATE_FAIL;
        }

        $left = next($a);
        $right = next($b);
    }
}

$total = 0;
foreach ($packets as $p => $packet) {
    if (compare($packet[0], $packet[1]) == STATE_SUCCESS) {
        $total += ($p + 1);
    }
}

print "{$total}\n";

$packets[] = [[[2]], [[6]]];
$packs = [];
foreach ($packets as $p => $packet) {
    foreach ($packet as $s => $side) {
        $packs[] = $side;
    }
}

usort($packs, fn($a, $b) => (compare($a, $b) == STATE_SUCCESS ? -1 : 1));

$keys = array_filter($packs, fn($v) => in_array($v, [[[2]], [[6]]]));
print array_reduce(array_keys($keys), fn($t, $v) => $t * ($v + 1), 1) . "\n";

