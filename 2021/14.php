<?php

require('libs/core.php');

$data = load_data("_14.txt");

$template = str_split(array_shift($data));
$formulae = [];
foreach ($data as $value) {
    if (preg_match('/^(\w{2}) \-> (\w)$/', $value, $matches)) {
        $formulae[$matches[1]] = $matches[2];
    }
}
ksort($formulae);

function part1($template, $formulae, $max = 10) {
    $polymer = $template;
    for ($turn = 0; $turn < $max; $turn++) {
        $len = count($polymer);
        $new = [$polymer[0]];
        for ($i = 0; $i < $len - 1; $i++) {
            $key = $polymer[$i] . $polymer[$i + 1];
            $new[] = $formulae[$key];
            $new[] = $polymer[$i + 1];
        }
        $polymer = $new;
    }

    $counts = array_count_values($polymer);
    $max = max($counts);
    $min = min($counts);

    print_r($counts);
    print implode('', $polymer) . "\n";
    print $max - $min;
    print "\n";

}

function get_totals($pair, $formulae, $turn, $max) {
    static $totals = [];
    if ($turn == $max) {
        return count_chars($pair, 1);
    }
    $next = $turn + 1;
    if (isset($totals[$pair][$next])) {
        print "from cache {$pair} {$next}\n";
        print_r($totals[$pair][$next]);
        return $totals[$pair][$next];
    } else {
        list($c1, $c2) = str_split($pair);
        $new = $formulae[$pair];
        $pair1 = $c1 . $new;
        $pair2 = $new . $c2;
        $next = $turn + 1;

        $total = []; // count_chars($pair, 1);
        $sub[0] = get_totals($pair1, $formulae, $next, $max);
        $sub[1] = get_totals($pair2, $formulae, $next, $max);
        $sub[1][ord($new)]--;

        foreach ($sub as $subtotal) {
            foreach ($subtotal as $char => $count) {
                if (!isset($total[$char])) {
                    $total[$char] = 0;
                }
                $total[$char] += $count;
            }
        }

        $totals[$pair][$turn] = $total;
        return $totals[$pair][$turn];
    }
}

function part2($template, $formulae, $max = 40) {
    print "{$max} =============================================\n";
    $polymer = [];
    for ($i = 0; $i < count($template) - 1; $i++) {
        $polymer[] = $template[$i] . $template[$i + 1];
    }

    //print_r($polymer);

    $combined = [];
    foreach ($polymer as $i => $pair) {
        $totals = get_totals($pair, $formulae, 1, $max);
        list($c1, $c2) = str_split($pair);

        if ($i > 0) {
            //$totals[ord($c1)]--;
        }


        print "==\n{$pair}\n";
        foreach ($totals as $char => $count) {
            print chr($char) . " ({$char}) = {$count}\n";
        }
        print "\n";


        foreach ($totals as $ord => $count) {
            if (!isset($combined[$ord])) {
                $combined[$ord] = 0;
            }
            $combined[$ord] += $count;
        }
    }

    print "combined\n";
    foreach ($combined as $char => $count) {
        print chr($char) . " ({$char}) = {$count}\n";
    }

}
//part1($template, $formulae);


part2($template, $formulae, 1);
part2($template, $formulae, 2);
part2($template, $formulae, 3);
//part2($template, $formulae, 4);
