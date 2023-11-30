<?php

require 'libs/api.php';

// Get live data
// $input = (new AdventOfCode())->input(1);

// Get example data
$input = (new AdventOfCode())->load('_1');

$data = $input->lines()->raw();

print_r($data);
