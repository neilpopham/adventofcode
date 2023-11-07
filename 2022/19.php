<?php
require 'libs/api.php';

$data = (new AdventOfCode())->input(19)->lines()
    ->regex('/Blueprint (\d+): Each ore robot costs (\d+) ore. Each clay robot costs (\d+) ore. Each obsidian robot costs (\d+) ore and (\d+) clay. Each geode robot costs (\d+) ore and (\d+) obsidian/');

$types = ['ore', 'clay', 'obsidian', 'geode'];

foreach ($data as $blueprint) {

    $inventory = array_combine($types, array_fill(0, count($types), 0));
    $robots = $inventory;
    $robots['ore'] = 1;
    $g = [];

    $costs = [
        'geode' => ['ore' => $blueprint[5], 'obsidian' => $blueprint[6]],
        'obsidian' => ['ore' => $blueprint[3], 'clay' => $blueprint[4]],
        'clay' => ['ore' => $blueprint[2]],
        'ore' => ['ore' => $blueprint[1]],
    ];
    $units = [
        'geode' => $costs['clay']['ore'] * $costs['obsidian']['clay'] * $costs['geode']['obsidian'] + $costs['geode']['ore'],
        'obsidian' => $costs['clay']['ore'] * $costs['obsidian']['clay'] + $costs['obsidian']['ore'],
        'clay' => $costs['clay']['ore'],
        'ore' => $costs['ore']['ore'],
    ];
    $limits = [
        'geode' => PHP_INT_MAX,
        'obsidian' => $costs['geode']['obsidian'],
        'clay' => $costs['obsidian']['clay'],
        'ore' => max($costs['ore']['ore'], $costs['clay']['ore'], $costs['obsidian']['ore'], $costs['geode']['ore']),
    ];

    // print_r($costs);
    // print_r($units);

    $options = process($inventory, $robots, 0);
    asort($options);
    $max = end($options);
    $options = array_filter($options, function($v) use($max) { return $v == $max; });
    print_r($options);
    // print "\n" . count($options). "\n";
    // print "\n" . end($options). "\n";

    $quality[$blueprint[0]] = end($options);
    print_r($quality);

    // print_r($costs);
    // print_r($units);
}

print_r($quality);

$total = 0;
foreach ($quality as $id => $max) {
    $total += ($id * $max);
}
print "{$total}\n";

exit;

function process($inventory, $robots, $t, $path = 'P')
{
    global $types, $costs, $units, $limits, $g;

    $key = "{$t}|". implode('|', $robots);
    $score = 0;
    foreach ($types as $i => $type) {
        $score += pow(10, $i * 3) * $inventory[$type];
    }
    if (($g[$key] ?? 0) > $score) {
        // return [];
    }
    $g[$key] = $score;


    $options = [];

    // $paths = [
    //     'P..1',
    //     'P..1.1',
    //     'P..1.1.1',
    //     'P..1.1.1...2',
    //     'P..1.1.1...21',
    //     'P..1.1.1...21..2',
    //     'P..1.1.1...21..2..3',
    //     'P..1.1.1...21..2..3..3',
    //     'P..1.1.1...21..2..3..3...',
    // ];
    // if (in_array($path, $paths)) {
    //     print str_pad($path, 25, ' ', STR_PAD_RIGHT) . ' ';
    //     print implode(', ', $inventory) . " | ";
    //     print implode(', ', $robots) . " | ";
    //     print $t . "\n";
    // }

    // $max = 0;

    while ($t < 24) {

        $purchase = [];
        foreach ($costs as $type => $cost) {
            $funds = true;
            foreach ($cost as $i => $amount) {
                if ($inventory[$i] < $amount) {
                    $funds = false;
                }
            }
            if ($funds) {
                $purchase[array_search($type, $types)] = $type;
                if ($type == 'geode') {
                    break;
                }
            }
        }
        // print 'purchase: ' . implode(', ', $purchase) . "\n";

        $t++;

        foreach ($types as $x => $type) {
            $inventory[$type] += $robots[$type];
        }

        foreach ($purchase as $x => $type) {
            if ($robots[$type] < $limits[$type]) {
                $ti = $inventory;
                $tr = $robots;
                foreach ($costs[$type] as $i => $amount) {
                    $ti[$i] -= $amount;
                }
                $tr[$type]++;
                // $children = array_filter(process($ti, $tr, $t, $path . $x));
                $children = process($ti, $tr, $t, $path . $x);

                // asort($children);
                // $max = end($children);
                // if ($max == 9) {
                //     print_r($inventory);
                //     print_r($robots);
                // }

                // asort($children);
                // $max = max($max, end($children));
                // $children = array_filter(
                //     $children,
                //     function($o) use ($max) {
                //         return $o == $max;
                //     }
                // );
                $options = array_merge($options, $children);
            }
        }

        $path .= '.';
    }

    if ($inventory['ore'] > (2 * $limits['ore'])) {
        $t = PHP_INT_MAX;
    }
    if ($inventory['clay'] > (2 * $limits['clay'])) {
        $t = PHP_INT_MAX;
    }
    if ($inventory['obsidian'] > (2 * $limits['obsidian'])) {
        $t = PHP_INT_MAX;
    }

    if (empty($options)) {
        $options[$path] = $inventory['geode'];
    }

    return $options;
}
