<?php

namespace AdventOfCode;

class Grid
{
    public array $cells;
    public int $height;
    public int $width;

    public function __construct(mixed $data = null)
    {
        if (is_string($data)) {
            $data = preg_replace('/\r*\n/', "\n", $data);
            $data = explode("\n", $data);
        }
        if (is_array($data)) {
            foreach ($data as $y => $row) {
                if (!is_array($row)) {
                    $data[$y] = str_split($row);
                }
            }
            $this->cells = $data;
            $this->dimensions();
        }
    }

    private function dimensions(): void
    {
        $this->height = count($this->cells);
        $this->width = count($this->cells[0]);
    }

    public function cell(int $x, int $y, mixed $default = null): mixed
    {
        return $this->cells[$y][$x] ?? $default;
    }

    public function pad(string $char = '.', int $size = 1): void
    {
        if (!is_array($this->cells)) {
            return;
        }

        // Add rows
        for ($p = -1; $p >= -$size; $p--) {
            $this->cells[$p] = array_fill(0, $this->width, $char);
        }
        for ($p = 1; $p <= $size; $p++) {
            $this->cells[$this->height + $p - 1] = array_fill(0, $this->width, $char);
        }
        ksort($this->cells);

        // Add columns
        foreach ($this->cells as $y => $row) {
            for ($p = -1; $p >= -$size; $p--) {
                $this->cells[$y][$p] = $char;
            }
            for ($p = 1; $p <= $size; $p++) {
                $this->cells[$y][$this->width + $p - 1] = $char;
            }
            ksort($this->cells[$y]);
        }

    }
}
