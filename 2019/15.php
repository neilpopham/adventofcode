<?php
require 'libs/api.php';

$data = (new AdventOfCode())->input(15)->csv();

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

class Robot extends IntCode
{
    public $x;
    public $y;
    public $next;
    public $path;
    public $t;
}

function process($robot)
{
    global $map, $cells, $g;
    $q = [];

    if (($g["{$robot->x},{$robot->y}"] ?? PHP_INT_MAX) < $robot->t) {
        return $q;
    }
    $g["{$robot->x},{$robot->y}"] = $robot->t;

    foreach ($map as $dir => $offset) {
        $mx = $robot->x + $offset[0];
        $my = $robot->y + $offset[1];
        if (($cells[$my][$mx] ?? 1) != 0) {
            $new = clone $robot;
            $new->x = $mx;
            $new->y = $my;
            $new->next = $dir;
            $new->t++;
            $new->path .= $dir;
            $q[] = $new;
        }
    }

    return $q;
}

$map = [1 => [0, -1], 2 => [0, 1], 3 => [-1, 0], 4 => [1, 0]];
$g = ['0,0' => 0];
$cells = [];

$robot = new Robot($data);
$robot->x = 0;
$robot->y = 0;
$robot->t = 0;
$robot->path = '';

$q = process($robot);
$robot = array_shift($q);

while (!is_null($robot)) {
    $robot->input($robot->next);
    $response = $robot->output();
    $cells[$robot->y][$robot->x] = $response;

    switch ($response) {
        case 2:
            $steps = strlen($robot->path);
            $o = [$robot->x, $robot->y];
            // no break
        case 1:
            $q = array_merge($q, process($robot));
            break;
    }

    $robot = array_shift($q);
}

print "{$steps}\n";

$t = 0;
$oxy = [$o[1] => [$o[0] => $o[0]]];
$moving = true;
while ($moving) {
    $moving = false;
    foreach ($oxy as $y => $row) {
        foreach ($row as $x) {
            foreach ($map as $offset) {
                $ox = $x + $offset[0];
                $oy = $y + $offset[1];
                if (isset($oxy[$oy][$ox])) {
                    continue;
                }
                if (($cells[$oy][$ox] ?? 1) != 0) {
                    $oxy[$oy][$ox] = $ox;
                    $cells[$oy][$ox] = 2;
                    $moving = true;
                }
            }
        }
    }
    if ($moving) {
        $t++;
    }
}

print "{$t}\n";
