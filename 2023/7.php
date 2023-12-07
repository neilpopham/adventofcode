<?php

require 'libs/api.php';

$input = (new AdventOfCode())->input(7);

$data = $input->lines()->regex('/(\w+) (\d+)/');

function get_type($cards)
{
    $chars = count_chars($cards, 1);
    $digits = array_fill(1, 5, 0);
    foreach ($chars as $code => $count) {
        $digits[$count]++;
    }
    krsort($digits);
    return (int) implode('', $digits);
}

foreach ($data as $key => $hand) {
    list($cards, $bid) = $hand;
    $cards = preg_replace(
        ['/A/', '/K/', '/Q/', '/J/', '/T/'],
        ['e', 'd', 'c', 'b', 'a'],
        $cards
    );
    $data[$key][2] = get_type($cards);
    $data[$key][3] = $cards;
}

function get_winnings($data)
{
    usort(
        $data,
        function ($a, $b) {
            if ($a[2] == $b[2]) {
                return hexdec($a[3]) <=> hexdec($b[3]);
            }
            return $a[2] <=> $b[2];
        }
    );
    $winnings = 0;
    foreach ($data as $key => $hand) {
        $winnings += (($key + 1) * $hand[1]);
    }
    return $winnings;
}

print get_winnings($data) . "\n";

function get_strongest($hand)
{
    $chars = count_chars($hand[3], 1);
    $jokers = $chars[98];
    if ($jokers == 5) {
        $cards = 'eeeee';
    } else {
        $norms = str_replace('b', '', $hand[3]);
        $chars = count_chars($norms, 1);
        arsort($chars);
        $key = key($chars);
        do {
            $chars[$key]++;
            if ($chars[$key] == 5) {
                next($chars);
                $key = key($chars);
            }
            $jokers--;
        } while ($jokers > 0);
        $cards = '';
        foreach ($chars as $c => $v) {
            $cards .= (str_repeat(chr($c), $v));
        }
    }
    $hand[2] = get_type($cards);
    $hand[3] = str_replace('b', '1', $hand[3]);
    return $hand;
}

foreach ($data as $key => $hand) {
    if (false !== strpos($hand[0], 'J')) {
        $data[$key] = get_strongest($hand);
    }
}

print get_winnings($data) . "\n";
