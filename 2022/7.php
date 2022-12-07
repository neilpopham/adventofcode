<?php
require 'libs/api.php';

$data = (new AdventOfCode())->input(7)->lines();

$dirs = ['/' => 0];
$pwd = '/';

foreach ($data as $line) {
    if (preg_match('/^\$\s(cd|ls)(?:\s(.+))*$/', $line, $matches)) {
        print_r($matches);
        if ($matches[1] == 'cd') {
            switch ($matches[2]) {
                case '/':
                    $pwd = '/';
                    break;
                case '..':
                    $folders = explode('/', $pwd);
                    $pwd = implode('/', array_slice($folders, 0, -1)) ?: '/';
                    break;
                default:
                    $pwd .= (($pwd == '/' ? '' : '/') . $matches[2]);
                    $dirs[$pwd] = 0;
                    break;
            }
        }
    } elseif (preg_match('/^dir\s(.+)$/', $line, $matches)) {
        // We're handling this on cd
    } elseif (preg_match('/^(\d+)\s(.+)$/', $line, $matches)) {
        $dirs[$pwd] += $matches[1];
    }
}

krsort($dirs);

$pwd = key($dirs);
while ($pwd != '/') {
    $folders = explode('/', $pwd);
    $cwd = implode('/', array_slice($folders, 0, -1)) ?: '/';
    $dirs[$cwd] += $dirs[$pwd];
    next($dirs);
    $pwd = key($dirs);
}

$total = 0;
foreach ($dirs as $value) {
    if ($value < 100000) {
        $total += $value;
    }
}
print "{$total}\n";

$free = 70000000 - $dirs['/'];
$required = 30000000 - $free;

$min = PHP_INT_MAX;
foreach ($dirs as $key => $value) {
    if (($value >= $required) && ($value < $min)) {
        $min = $value;
    }
}
print "{$min}\n";
