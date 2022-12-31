<?php
require 'libs/api.php';

$data = (new AdventOfCode())->input(11)->csv();

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

        $parameter1 = $this->data[$param[0]] ?? 0;
        $parameter2 = $this->data[$param[1]] ?? 0;

        switch ($op) {
            case 1:
                $this->data[$param[2]] = $parameter1 + $parameter2;
                $this->ptr += 4;
                break;
            case 2:
                $this->data[$param[2]] = $parameter1 * $parameter2;
                $this->ptr += 4;
                break;
            case 3:
                $this->data[$param[0]] = array_shift($this->input);
                $this->ptr += 2;
                break;
            case 4:
                $this->output[] = $parameter1;
                $this->ptr += 2;
                break;
            case 5:
                if ($parameter1 != 0) {
                    $this->ptr = $parameter2;
                } else {
                    $this->ptr += 3;
                }
                break;
            case 6:
                if ($parameter1 == 0) {
                    $this->ptr = $parameter2;
                } else {
                    $this->ptr += 3;
                }
                break;
            case 7:
                $this->data[$param[2]] = ($parameter1 < $parameter2 ? 1 : 0);
                $this->ptr += 4;
                break;
            case 8:
                $this->data[$param[2]] = ($parameter1 == $parameter2 ? 1 : 0);
                $this->ptr += 4;
                break;
            case 9:
                $this->base += $parameter1;
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

function run_robot($data, $cells = [])
{
    $map = [[0, -1], [1, 0], [0, 1], [-1, 0]];
    $robot = (object) ['x' => 0, 'y' => 0, 'dir' => 0];
    $intcode = new IntCode($data);

    while ($intcode->complete() === false) {
        $intcode->input($cells[$robot->y][$robot->x] ?? 0);
        $colour = $intcode->output();
        if (!is_null($colour)) {
            $cells[$robot->y][$robot->x] = $colour;
            $turn = $intcode->output();
            $robot->dir += ($turn == 0 ? -1 : 1);
            $robot->dir = $robot->dir < 0 ? 4 + $robot->dir : $robot->dir % 4;
            $robot->x += $map[$robot->dir][0];
            $robot->y += $map[$robot->dir][1];
        }
    }
    return $cells;
}

function part_1($data)
{
    $cells = run_robot($data);
    $total = 0;
    foreach ($cells as $y => $row) {
        $total += count($row);
    }
    print "{$total}\n";
}

function part_2($data)
{
    $bounds = [PHP_INT_MAX, 0];
    $cells = run_robot($data, [0 => [0 => 1]]);
    ksort($cells);
    foreach ($cells as $y => $row) {
        ksort($row);
        $bounds[0] = min($bounds[0], key($row));
        end($row);
        $bounds[1] = max($bounds[1], key($row));
    }
    foreach ($cells as $y => $row) {
        for ($x = $bounds[0]; $x <= $bounds[1]; $x++) {
            print ($cells[$y][$x] ?? 0) == 1 ? '#' : '.';
        }
        print "\n";
    }
}

part_1($data);
part_2($data);
