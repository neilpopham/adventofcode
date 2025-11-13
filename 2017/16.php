<?php

require 'libs/aoc.php';

$data = new AdventOfCode\AdventOfCode()->input(day: 16)->raw();

$data = array_map(
    function ($value) {
        preg_match(
            '/(?:(s)(\d+)|(p)(\w)\/(\w)|(x)(\d+)\/(\d+))/',
            $value,
            $matches
        );
        return array_values(
            array_filter(
                $matches,
                fn ($v) => strlen($v)
            )
        );
    },
    explode(',', $data)
);

$programs = implode('', range('a', 'p'));

foreach ($data as $op) {
    switch ($op[1]) {
        case 's':
            $programs = substr($programs, -$op[2])
                . substr(string: $programs, offset: 0, length: 16 - $op[2]);
            break;
        case 'p':
            $programs = str_replace(
                [$op[2], $op[3], '?'],
                ['?', $op[2], $op[3]],
                $programs
            );
            break;
        case 'x':
            [$programs[$op[2]], $programs[$op[3]]] = [$programs[$op[3]], $programs[$op[2]]];
            break;
    }
}

print $programs . "\n";
