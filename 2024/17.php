<?php

require 'libs/api.php';

$input = (new AdventOfCode())->input(17);
$data = $input->lines()->raw();

$registers = [];
$program = [];
$output = [];
$ptr = 0;

for ($i = 0; $i < 3; $i++) {
    if (preg_match('/Register [ABC]: (\d+)/', $data[$i], $matches)) {
        $registers[$i] = $matches[1];
    }
}

$program = explode(',', str_replace('Program: ', '', $data[4]));

function combo($value, $registers)
{
    if ($value < 4) {
        return $value;
    } elseif ($value < 7) {
        return $registers[$value - 4];
    }
    exit('bad op ' . $value);
}

function run($registers)
{
    global $program;
    $output = [];
    $ptr = 0;

    while (isset($program[$ptr])) {
        $move = true;

        $instruction = $program[$ptr];
        $operand = $program[$ptr + 1];

        switch ($instruction) {
            case 0:
                $registers[0] = intval($registers[0] / pow(2, combo($operand, $registers)));
                break;
            case 1:
                $registers[1] = $registers[1] ^ $operand;
                break;
            case 2:
                $registers[1] = combo($operand, $registers) % 8;
                break;
            case 3:
                if ($registers[0] > 0) {
                    $ptr = $operand;
                    $move = false;
                }
                break;
            case 4:
                $registers[1] = $registers[1] ^ $registers[2];
                break;
            case 5:
                $output[] = combo($operand, $registers) % 8;
                break;
            case 6:
                $registers[1] = intval($registers[0] / pow(2, combo($operand, $registers)));
                break;
            case 7:
                $registers[2] = intval($registers[0] / pow(2, combo($operand, $registers)));
                break;
        }

        if ($move) {
            $ptr += 2;
        }
    }
    return $output;
}

$output = run($registers);
print implode(',', $output) . "\n";
