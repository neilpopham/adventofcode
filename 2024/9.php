<?php

require 'libs/api.php';

$input = (new AdventOfCode())->input(9);
$data = $input->raw();

$id = 0;
$files = [];
$spaces = [];
$ptr = 0;
for ($i = 0; $i < strlen($data); $i++) {
    $n = intval($data[$i]);
    if ($i % 2 == 0) {
        $files[$id] = [[$ptr, $ptr + $n - 1]];
        $id++;
    } elseif ($n > 0) {
        $spaces[] = [$ptr, $ptr + $n - 1];
    }
    $ptr += $n;
}

function checksum($files)
{
    $checksum = 0;
    foreach ($files as $id => $positions) {
        foreach ($positions as $blocks) {
            $checksum += array_sum(range($blocks[0], $blocks[1])) * $id;
        }
    }
    return $checksum;
}

function part_1($files, $spaces)
{
    $moving = true;
    $id = array_key_last($files);
    $s = 0;
    while ($moving) {
        $size = 1 + $files[$id][0][1] - $files[$id][0][0];
        $required = $size;
        while ($required > 0) {
            if ($spaces[$s][0] > $files[$id][0][0]) {
                $moving = false;
                break;
            }
            $space = 1 + $spaces[$s][1] - $spaces[$s][0];
            if ($space < $required) {
                $files[$id][] = $spaces[$s];
                $files[$id][0][1] -= $space;
                $required -= $space;
                $s++;
            } elseif ($space > $required) {
                $files[$id][0] = [$spaces[$s][0], $spaces[$s][0] + $required - 1];
                $spaces[$s][0] += $required;
                $required = 0;
            } else {
                $files[$id][0] = $spaces[$s];
                $required = 0;
                $s++;
            }
        }
        $id--;
    }

    return checksum($files);
}

function part_2($files, $spaces)
{
    krsort($files);

    foreach ($spaces as $s => $space) {
        $spaces[$s][2] = 1 + $spaces[$s][1] - $spaces[$s][0];
    }

    foreach ($files as $id => $positions) {
        $size = 1 + $files[$id][0][1] - $files[$id][0][0];
        $found = false;
        for ($s = 0; $s < count($spaces); $s++) {
            if ($spaces[$s][0] > $files[$id][0][0]) {
                break;
            }
            if ($spaces[$s][2] >= $size) {
                $found = true;
                break;
            }
        }
        if (!$found) {
            continue;
        }
        $files[$id][0] = [$spaces[$s][0], $spaces[$s][0] + $size - 1];
        $spaces[$s][0] += $size;
        $spaces[$s][2] -= $size;
    }

    return checksum($files);
}

print part_1($files, $spaces) . "\n";
print part_2($files, $spaces) . "\n";
