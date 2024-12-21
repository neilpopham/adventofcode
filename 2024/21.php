<?php

require 'libs/api.php';

$input = (new AdventOfCode())->input(21);
$data = $input->lines()->raw();

$numpad = [[1, 3], [0, 2], [1, 2], [2, 2], [0, 1], [1, 1], [2, 1], [0, 0], [1, 0], [2, 0], [2, 3]];

$cursorpad = [[1, 0], [2, 1], [1, 1], [0, 1], [2, 0]];

function get_moves($start, $end, $numpad)
{
    $dx = $end[0] - $start[0];
    $dy = $end[1] - $start[1];

    $d[0] = $dy < 0 ? abs($dy) : 0;
    $d[1] = $dx > 0 ? $dx : 0;
    $d[2] = $dy > 0 ? $dy : 0;
    $d[3] = $dx < 0 ? abs($dx) : 0;

    $sequences = [$d, $d];

    if ($dx != 0 && $dy != 0) {
        if (
            ($numpad && ($start[1] != 3 || $end[0] != 0))
            || (!$numpad && ($start[1] != 0 || $end[0] != 0))
        ) {
            $sequences[1] = [];
            $sequences[1][3] = $d[3];
            $sequences[1][2] = $d[2];
            $sequences[1][1] = $d[1];
            $sequences[1][0] = $d[0];
        }
    }

    return [$sequences, $end];
}

function cursorpad_numpad($start, $value)
{
    global $numpad;
    $end = $numpad[hexdec($value)];
    return get_moves($start, $end, true);
}

function cursorpad_cursorpad($start, $value)
{
    global $cursorpad;
    $end = $cursorpad[$value];
    return get_moves($start, $end, false);
}

function use_numpad($input, $bots)
{
    $pos = [2, 3];
    $sequences = ['', ''];
    for ($i = 0; $i < strlen($input); $i++) {
        list($patterns, $pos) = cursorpad_numpad($pos, $input[$i]);
        foreach ($patterns as $p => $moves) {
            foreach ($moves as $m => $count) {
                $sequences[$p] .= str_repeat($m, $count);
            }
        }
        $sequences[0] .= '4'; // A
        $sequences[1] .= '4'; // A
    }

    foreach ($sequences as $i => &$sequence) {
        for ($s = 0; $s < $bots; $s++) {
            $sequence = use_cursorpad($sequence);
        }
    }
    usort($sequences, fn($a, $b) => strlen($a) <=> strlen($b));
    return reset($sequences);
}

function use_cursorpad($input)
{
    $pos = [2, 0];
    $sequences = ['', ''];
    for ($i = 0; $i < strlen($input); $i++) {
        list($patterns, $pos) = cursorpad_cursorpad($pos, $input[$i]);
        foreach ($patterns as $p => $moves) {
            foreach ($moves as $m => $count) {
                $sequences[$p] .= str_repeat($m, $count);
            }
        }
        $sequences[0] .= '4'; // A
        $sequences[1] .= '4'; // A
    }
    usort($sequences, fn($a, $b) => strlen($a) <=> strlen($b));
    return reset($sequences);
}

function complexities($bots)
{
    global $data;
    $total = 0;
    foreach ($data as $code) {
        $total += (strlen(use_numpad($code, $bots)) * (int) preg_replace('/[A-Z]/', '', $code));
    }
    return $total;
}

print complexities(2) . "\n";
print complexities(25) . "\n";
