<?php

require('libs/core.php');

$data = load_data("__19.txt");

$scanners = [];
foreach ($data as $value) {
    if (preg_match('/^--- scanner (\d+) ---$/', $value, $matches)) {
        print_r($matches);
        $scanner = $matches[1];
    }
    if (preg_match('/^([\-\d]+),([\-\d]+),([\-\d]+)$/', $value, $matches)) {
        print_r($matches);
        $scanners[$scanner]['beacons'][] = ['coords' => array_slice($matches, 1)];
    }
}

print_r($scanners);



function get_rotations($coords) {
    $rotations = [];
    foreach ([1, -1] as $z) {
        foreach ([1, -1] as $y) {
            foreach ([1, -1] as $x) {
                $rotations[] = [$x * $coords[0], $y * $coords[1], $x * $coords[2]];
                $rotations[] = [$x * $coords[1], $y * $coords[2], $x * $coords[0]];
                $rotations[] = [$x * $coords[2], $y * $coords[0], $x * $coords[1]];
            }
        }
    }
    return $rotations;
}


foreach ($scanners as $s => $scanner) {
    print "Scanner {$s}\n";
    foreach ($scanner['beacons'] as $b1 => $beacon1) {
        $scanners[$s]['beacons'][$b1]['siblings'] = [];
        foreach ($scanner['beacons'] as $b2 => $beacon2) {
            if ($b1 == $b2) {
                continue;
            }
            if (!isset($scanners[$s]['beacons'][$b2]['siblings'][$b1])) {
                $scanners[$s]['beacons'][$b1]['siblings'][$b2] = [
                    $beacon2['coords'][0] - $beacon1['coords'][0],
                    $beacon2['coords'][1] - $beacon1['coords'][1],
                    $beacon2['coords'][2] - $beacon1['coords'][2],
                ];
            }
        }
    }
}

print_r($scanners);
//exit;

$matches = [];
$rotations = [];
foreach ($scanners as $s1 => $scanner1) {
    print "==========================\n";
    print "Scanner 1 is {$s1}\n";
    foreach ($scanners as $s2 => $scanner2) {
        //print "--------------------------\n";
        //print "Scanner 2 is {$s2}\n";
        if ($s1 == $s2) {
            continue;
        }
        $scanner_total = 0;
        foreach ($scanner1['beacons'] as $b1 => $beacon1) {
            //print "Scanner 1 beacon is {$b1}\n";
            foreach ($scanner2['beacons'] as $b2 => $beacon2) {
                //print "Scanner 2 beacon is {$b2}\n";
                foreach ($beacon1['siblings'] as $l1 => $matrix1) {
                    //print "Scanner 1 beacon sibling is {$l1}\n";
                    foreach ($beacon2['siblings'] as $l2 => $matrix2) {
                        //print "Scanner 2 beacon sibling is {$l2}\n";
                        $sum1 = array_reduce($matrix1, fn($t, $v) => $t += abs($v));
                        $sum2 = array_reduce($matrix2, fn($t, $v) => $t += abs($v));
                        if ($sum1 != $sum2) {
                            continue;
                        }

                        $rotations2 = get_rotations($matrix2);
                        foreach ($rotations2 as $r2 => $m2) {
                            //print implode(',', $matrix1) . ' -> ' . implode(',', $m2) . "\n";
                            if ($matrix1 == $m2) {
                                print "match {$s1} {$s2} {$b1} {$b2} {$l1} {$l2} {$r2}\n";
                                $scanner_total++;
                                $matches[$s1][$s2][$b1][] = [$b1, $b2, $l1 ,$l2, $r2];
                                $rotations[$s1][$s2][$b1][$r2] = ($rotations[$s1][$s2][$b1][$r2] ?? 0) + 1;
                                break;
                            }
                        }
                        /*
                        $rotations1 = get_rotations($matrix1);
                        $rotations2 = get_rotations($matrix2);
                        foreach ($rotations1 as $r1 => $m1) {
                            foreach ($rotations2 as $r2 => $m2) {
                                print implode(',', $m1) . ' -> ' . implode(',', $m2) . "\n";
                                if ($m1 == $m2) {
                                    print "match {$s1} {$s2} {$b1} {$b2} {$l1} {$l2} {$r1} {$r1}\n";
                                    $scanner_total++;
                                    $matches[$s1][$s2][] = [$b1, $b2, $l1 ,$l2, $r1, $r1];
                                    break 2;
                                }
                            }
                        }
                        */
                    }
                }
            }
        }
        //print "scanner total: {$scanner_total}\n";
    }
}

print_r($matches);
print_r($rotations);


//print_r(get_rotations($scanners[0]['beacons'][0]['coords']));

//print_r($scanners);

/*
    Loop through each beacon and calculate distance/matrix to its peers
    Check this matrix in all rotations between scanners

*/
