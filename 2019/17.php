<?php
require 'libs/api.php';

$data = (new AdventOfCode())->input(17)->csv();

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

$intcode = new IntCode($data);
$response = true;
$y = 0;
$x = 0;
$cells = [];
while (!is_null($response)) {
    $response = $intcode->output();
    switch ($response) {
        case null:
            // ignore
            break;
        case 10:
            $y++;
            $x = 0;
            break;
        default:
            $char = chr($response);
            if ($char == '#') {
                $cells[$y][$x] = 1;
            } else if (false !== $d = array_search($char, ['^', '>', 'v', '<'])) {
                $rx = $x;
                $ry = $y;
                $rd = $d;
            }
            $x++;
    }
}

$map = [[0, -1], [1, 0], [0, 1], [-1, 0]];

$intersects = [];
foreach ($cells as $y => $row) {
    foreach ($row as $x => $value) {
        $intersect = true;
        foreach ($map as $offset) {
            $ox = $x + $offset[0];
            $oy = $y + $offset[1];
            if (($cells[$oy][$ox] ?? 0) != 1) {
                $intersect = false;
                break;
            }
        }
        if ($intersect) {
            $intersects[] = [$x, $y];
        }
    }
}

$total = 0;
foreach ($intersects as $pos) {
    $total += ($pos[0] * $pos[1]);
}
print "{$total}\n";

$data[0] = 2;

$dir = [[[-1, 0], [1, 0]], [[0, -1], [0, 1]], [[1, 0], [-1, 0]], [[0, 1], [0, -1]]];
$path = [];
$max = 0;
$turn = true;
while ($turn) {
    $turn = false;
    foreach ($dir[$rd] as $d => $offset) {
        if (($cells[$ry + $offset[1]][$rx + $offset[0]] ?? 0) == 1) {
            $path[] = $d == 0 ? 'L' : 'R';
            $rd += ($d == 0 ? -1 : 1);
            $rd = $rd < 0 ? 3 : $rd % 4;
            $turn = true;
        }
    }
    if ($turn) {
        $ox = $map[$rd][0];
        $oy = $map[$rd][1];
        $s = 0;
        while(($cells[$ry + $oy][$rx + $ox] ?? 0) == 1) {
            $rx += $ox;
            $ry += $oy;
            $s++;
        }
        $path[] = $s;
        $max = max($max, $s);
    }
}
$string = implode(',', $path);

$patterns = [];
$max = 12;
$width = [];
$start = [];
for ($width[0] = 4; $width[0] < $max; $width[0] += 2) {
    for ($start[0] = 0; $start[0] < count($path) - $width[0]; $start[0] += 2) {
        for ($width[1] = 4; $width[1] < $max; $width[1] += 2) {
            for ($start[1] = 0; $start[1] < count($path) - $width[1]; $start[1] += 2) {
                for ($width[2] = 4; $width[2] < $max; $width[2] += 2) {
                    for ($start[2] = 0; $start[2] < count($path) - $width[2]; $start[2] += 2) {
                        for ($i = 0; $i < 3; $i++) {
                            $slice[$i] = array_slice($path, $start[$i], $width[$i]);
                            $pattern[$i] = implode(',', $slice[$i]);
                        }
                        $replaces = [
                            [$pattern[0], $pattern[1], $pattern[2], ','],
                            [$pattern[0], $pattern[2], $pattern[1], ','],
                            [$pattern[1], $pattern[0], $pattern[2], ','],
                            [$pattern[1], $pattern[2], $pattern[0], ','],
                            [$pattern[2], $pattern[0], $pattern[1], ','],
                            [$pattern[2], $pattern[1], $pattern[0], ','],
                        ];
                        foreach ($replaces as $replace) {
                            $tmp = str_replace($replace, '', $string);
                            if (empty($tmp)) {
                                $patterns[] = $replace;
                                break;
                            }
                        }
                    }
                }
            }
        }
    }
}

$pattern = reset($patterns);

$routine = $string;
for ($i = 0; $i < 3; $i++) {
    $routine = str_replace($pattern[$i], chr(65 + $i), $routine);
}
$routine = explode(',', $routine);

$intcode = new IntCode($data);
foreach ($routine as $key => $value) {
    $intcode->input(ord($value));
    $intcode->input($key == count($routine) - 1 ? 10 : 44);
}
for ($i = 0; $i < 3; $i++) {
    $function = explode(',', $pattern[$i]);
    foreach ($function as $key => $value) {
        for ($n = 0; $n < strlen($value); $n++) {
            $intcode->input(ord($value[$n]));
        }
        $intcode->input($key == count($function) - 1 ? 10 : 44);
    }
}
$intcode->input(ord('n'));
$intcode->input(10);
$response = $intcode->run();
print "{$response}\n";
