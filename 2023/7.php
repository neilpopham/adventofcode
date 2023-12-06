<?php

require 'libs/api.php';

$input = (new AdventOfCode())->input(7);
$input = (new AdventOfCode())->example(7, 0);

$data = $input->lines()->raw();

print_r($data);
