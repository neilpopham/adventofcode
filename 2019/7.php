<?php
require 'libs/api.php';

$data = (new AdventOfCode())->input(7)->csv();

class IntCode
{
    public $data;
    public $input;
    public $output;
    public $ptr;

    public function __construct($data, $input = null)
    {
        $this->data = $data;
        $this->input = is_null($input) ? [] : $input;
        $this->output = [];
        $this->ptr = 0;
    }

    public function run()
    {
        $this->ptr = 0;
        $this->output = [];
        while ($this->ptr < count($this->data)) {
            $this->step();
        }
        return end($this->output);
    }

    public function step()
    {
        $ins = str_pad($this->data[$this->ptr], 5, '0', STR_PAD_LEFT);
        $op = $ins % 100;

        $values = [
            isset($this->data[$this->ptr + 1]) ? ($ins[2] == 1 ? $this->data[$this->ptr + 1] : $this->data[$this->data[$this->ptr + 1]] ?? 0) : null,
            isset($this->data[$this->ptr + 2]) ? ($ins[1] == 1 ? $this->data[$this->ptr + 2] : $this->data[$this->data[$this->ptr + 2]] ?? 0) : null,
        ];

        switch ($op) {
            case 1:
                if ($ins[0] == 0) {
                    $this->data[$this->data[$this->ptr + 3]] = $values[0] + $values[1];
                }
                $this->ptr += 4;
                break;
            case 2:
                if ($ins[0] == 0) {
                    $this->data[$this->data[$this->ptr + 3]] = $values[0] * $values[1];
                }
                $this->ptr += 4;
                break;
            case 3:
                if ($ins[2] == 0) {
                    $this->data[$this->data[$this->ptr + 1]] = array_shift($this->input);
                }
                $this->ptr += 2;
                break;
            case 4:
                $this->output[] = $ins[2] == 0 ? $this->data[$this->data[$this->ptr + 1]] : $this->data[$this->ptr + 1];
                $this->ptr += 2;
                break;
            case 5:
                if ($values[0] != 0) {
                    $this->ptr = $values[1];
                } else {
                    $this->ptr += 3;
                }
                break;
            case 6:
                if ($values[0] == 0) {
                    $this->ptr = $values[1];
                } else {
                    $this->ptr += 3;
                }
                break;
            case 7:
                if ($ins[0] == 0) {
                    $this->data[$this->data[$this->ptr + 3]] = $values[0] < $values[1] ? 1 : 0;
                }
                $this->ptr += 4;
                break;
            case 8:
                if ($ins[0] == 0) {
                    $this->data[$this->data[$this->ptr + 3]] = $values[0] == $values[1] ? 1 : 0;
                }
                $this->ptr += 4;
                break;
            case 99:
                $this->ptr = PHP_INT_MAX;
                break;
        }
    }

    public function complete()
    {
        return $this->ptr == PHP_INT_MAX;
    }

    public function input($value)
    {
        $this->input[] = $value;
    }

    public function output()
    {
        while (empty($this->output)) {
            if ($this->complete()) {
                return null;
            }
            $this->step();
        }
        return array_pop($this->output);
    }
}

$permutations = [];
for ($n = 194; $n <= 2930; $n++) {
    $phases = str_pad(base_convert($n, 10, 5), 5, '0', STR_PAD_LEFT);
    $chars = count_chars($phases, 1);
    if (count($chars) == 5) {
        $permutations[] = str_split($phases);
    }
}

$max = 0;
foreach ($permutations as $phases) {
    $output = 0;
    foreach ($phases as $phase) {
        $intcode = new IntCode($data, [$phase, $output]);
        $output = $intcode->run();
        if ($output > $max) {
            $max = $output;
        }
    }
}
print "{$max}\n";

$permutations = array_map(
    fn($v) => array_map(fn($p) => $p + 5, $v),
    $permutations
);

$max = 0;
foreach ($permutations as $phases) {
    foreach ($phases as $i => $phase) {
        $amp[$i] = new IntCode($data);
        $amp[$i]->input($phase);
    }
    $output = 0;
    $i = 0;
    $processing = true;
    while ($processing) {
        $result = $output;
        $amp[$i]->input($output);
        $output = $amp[$i]->output();
        if (is_null($output)) {
            $processing = false;
        }
        $i++;
        $i = $i % 5;
    }
    if ($result > $max) {
        $max = $result;
    }
}
print "{$max}\n";
