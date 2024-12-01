<?php

require 'libs/api.php';

$input = (new AdventOfCode())->input(1);
$example = (new AdventOfCode())->example(1, 0);

$data = $example->lines()->raw();

// $data = $input->lines()->raw();

print_r($data);
