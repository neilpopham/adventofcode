<?php
require 'libs/api.php';

$data = (new AdventOfCode())->input(9)->csv();

class IntCode
{
    public $data;
    public $input;
    public $output;
    public $ptr;
    public $base;

    public function __construct($data, $input = null)
    {
        $this->data = $data;
        $this->input = is_null($input) ? [] : $input;
        $this->output = [];
        $this->ptr = 0;
        $this->base = 0;
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

        $param = [0, 0, 0];
        foreach (array_keys($param) as $p) {
            $ptr = $this->ptr + $p + 1;
            if (isset($this->data[$ptr])) {
                $mode = $ins[2 - $p];
                switch ($mode) {
                    // position mode
                    case 0:
                        $param[$p] = $this->data[$ptr];
                        break;
                    // immediate mode
                    case 1:
                        $param[$p] = $ptr;
                        break;
                    // relative mode
                    case 2:
                        $param[$p] = $this->base + $this->data[$ptr];
                        break;
                }
            }
        }

        switch ($op) {
            case 1:
                $this->data[$param[2]] = $this->data[$param[0]] + $this->data[$param[1]];
                $this->ptr += 4;
                break;
            case 2:
                $this->data[$param[2]] = $this->data[$param[0]] * $this->data[$param[1]];
                $this->ptr += 4;
                break;
            case 3:
                $this->data[$param[0]] = array_shift($this->input);
                $this->ptr += 2;
                break;
            case 4:
                $this->output[] = $this->data[$param[0]];
                $this->ptr += 2;
                break;
            case 5:
                if ($this->data[$param[0]] != 0) {
                    $this->ptr = $this->data[$param[1]];
                } else {
                    $this->ptr += 3;
                }
                break;
            case 6:
                if ($this->data[$param[0]] == 0) {
                    $this->ptr = $this->data[$param[1]];
                } else {
                    $this->ptr += 3;
                }
                break;
            case 7:
                $this->data[$param[2]] = ($this->data[$param[0]] < $this->data[$param[1]] ? 1 : 0);
                $this->ptr += 4;
                break;
            case 8:
                $this->data[$param[2]] = ($this->data[$param[0]] == $this->data[$param[1]] ? 1 : 0);
                $this->ptr += 4;
                break;
            case 9:
                $this->base += $this->data[$param[0]];
                $this->ptr += 2;
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

$intcode = new IntCode($data, [1]);
print $intcode->run() . "\n";

$intcode = new IntCode($data, [2]);
print $intcode->run() . "\n";
