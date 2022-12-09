<?php
require 'libs/api.php';

$data = (new AdventOfCode())->input(5)->csv();

function process($data, $noun, $verb)
{
    // $data[1] = $noun;
    // $data[2] = $verb;

    $input = [5];
    $output = [];

    $i = 0;
    while ($i < count($data)) {
        $ins = str_pad($data[$i], 5, '0', STR_PAD_LEFT);
        $op = $ins % 100;

        var_dump('ptr', $i, 'raw ' . $data[$i], 'ins ' . $ins, 'op ' . $op);

        $values = [
            isset($data[$i + 1]) ? ($ins[2] == 1 ? $data[$i + 1] : $data[$data[$i + 1]] ?? 0) : null,
            isset($data[$i + 2]) ? ($ins[1] == 1 ? $data[$i + 2] : $data[$data[$i + 2]] ?? 0) : null,
        ];

        var_dump($values);

        switch ($op) {
            case 1:
                if ($ins[0] == 0) {
                    $data[$data[$i + 3]] = $values[0] + $values[1];
                    var_dump('add', $values[0], $values[1]);
                }
                $i += 4;
                break;
            case 2:
                if ($ins[0] == 0) {
                    $data[$data[$i + 3]] = $values[0] * $values[1];
                }
                $i += 4;
                break;
            case 3:
                if ($ins[2] == 0) {
                    $data[$data[$i + 1]] = array_pop($input);
                }
                $i += 2;
                break;
            case 4:
                $output[] = $ins[2] == 0 ? $data[$data[$i + 1]] : $data[$i + 1];
                $i += 2;
                break;
            case 5:
                if ($values[0] != 0) {
                    $i = $values[1];
                    var_dump('5:ptr', $i);
                    //print_r($data); exit;
                } else {
                    $i += 3;
                }
                break;
            case 6:
                if ($values[0] == 0) {
                    $i = $values[1];
                } else {
                    $i += 3;
                }
                break;
            case 7:
                if ($ins[0] == 0) {
                    $data[$data[$i + 3]] = $values[0] < $values[1] ? 1 : 0;
                }
                $i += 4;
                break;
            case 8:
                if ($ins[0] == 0) {
                    $data[$data[$i + 3]] = $values[0] == $values[1] ? 1 : 0;
                }
                $i += 4;
                break;
            case 99:
                $i = PHP_INT_MAX;
                break;
        }
        // sleep(1);
    }

    print_r($data); print_r($output); exit;

    return $data[0];
}

print process($data, 12, 2) . "\n";

// for ($verb = 0; $verb < 100; $verb++) {
//     for ($noun = 0; $noun < 100; $noun++) {
//         $processed = process($data, $noun, $verb);
//         if ($processed == 19690720) {
//             print (100 * $noun + $verb) . "\n";
//             exit;
//         }
//     }
// }
