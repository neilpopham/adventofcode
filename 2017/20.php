<?php

require 'libs/aoc.php';

$data = new AdventOfCode\AdventOfCode()->input(day: 20)->lines()->raw();

$particles = [];
foreach ($data as $i => $row) {
    preg_match_all('/([pva])=<([-\d]+),([-\d]+),([-\d]+)>/', $row, $matches, PREG_SET_ORDER);
    $particles[$i] = (object) [
        'p' => (object) ['x' => $matches[0][2], 'y' => $matches[0][3], 'z' => $matches[0][4]],
        'v' => (object) ['x' => $matches[1][2], 'y' => $matches[1][3], 'z' => $matches[1][4]],
        'a' => (object) ['x' => $matches[2][2], 'y' => $matches[2][3], 'z' => $matches[2][4]],
    ];
}

for ($t = 0; $t < 1000; $t++) {
    foreach ($particles as $i => $particle) {
        $particle->v->x += $particle->a->x;
        $particle->v->y += $particle->a->y;
        $particle->v->z += $particle->a->z;

        $particle->p->x += $particle->v->x;
        $particle->p->y += $particle->v->y;
        $particle->p->z += $particle->v->z;
    }
}

$min = PHP_INT_MAX;
$index = 0;
foreach ($particles as $i => $particle) {
    $d = abs($particle->p->x) + abs($particle->p->y) + abs($particle->p->z);
    if ($d < $min) {
        $min = $d;
        $index = $i;
    }
}

print $index . "\n";

$particles = [];
foreach ($data as $i => $row) {
    preg_match_all('/([pva])=<([-\d]+),([-\d]+),([-\d]+)>/', $row, $matches, PREG_SET_ORDER);
    $particles[$i] = (object) [
        'p' => (object) ['x' => $matches[0][2], 'y' => $matches[0][3], 'z' => $matches[0][4]],
        'v' => (object) ['x' => $matches[1][2], 'y' => $matches[1][3], 'z' => $matches[1][4]],
        'a' => (object) ['x' => $matches[2][2], 'y' => $matches[2][3], 'z' => $matches[2][4]],
    ];
}

for ($t = 0; $t < 1000; $t++) {
    foreach ($particles as $i => $particle) {
        $particle->v->x += $particle->a->x;
        $particle->v->y += $particle->a->y;
        $particle->v->z += $particle->a->z;

        $particle->p->x += $particle->v->x;
        $particle->p->y += $particle->v->y;
        $particle->p->z += $particle->v->z;
    }

    $unset = new AdventOfCode\Set();
    foreach ($particles as $i1 => $p1) {
        foreach ($particles as $i2 => $p2) {
            if ($i1 == $i2) {
                continue;
            }
            if (($p1->p->x == $p2->p->x) && ($p1->p->y == $p2->p->y) && ($p1->p->z == $p2->p->z)) {
                $unset->add($i1);
                $unset->add($i2);
            }
        }
    }
    foreach ($unset->entries() as $u) {
        unset($particles[$u]);
    }
}

print count($particles) . "\n";
