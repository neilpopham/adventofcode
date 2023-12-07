<?php

require 'libs/api.php';

$input = (new AdventOfCode())->input(99);
$input = (new AdventOfCode())->example(99, 0);

$data = $input->lines()->raw();

print_r($data);
