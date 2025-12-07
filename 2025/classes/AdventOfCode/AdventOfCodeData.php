<?php

namespace AdventOfCode;

/**
 *
 */
class AdventOfCodeData
{
    public $raw;

    /**
     * Instantiate using raw data from site.
     *
     * @param  string|null $raw The raw data.
     * @return void
     */
    public function __construct(?string $raw = null)
    {
        $this->raw = $raw;
    }

    /**
     * Magic method so we can just use > echo $api->input(2);
     *
     * @return string The raw data.
     */
    public function __toString(): string
    {
        return $this->raw;
    }

    /**
     * Get the raw data.
     *
     * @param  boolean $trim Whether to trim the raw text.
     * @return string        The raw data.
     */
    public function raw(bool $trim = true): string
    {
        return $trim ? trim($this->raw) : $this->raw;
    }

    /**
     * Parse the data and return an array of lines.
     *
     * @param  boolean $trim Whether to trim the raw text.
     * @return object An array of lines.
     */
    public function lines(bool $trim = true): AdventofCodeLines
    {
        $data = preg_replace('/\r*\n/', "\n", $trim ? trim($this->raw) : $this->raw);
        return new AdventofCodeLines(explode("\n", $data));
    }

    /**
     * Parse the data as one line of comma-separated values and return an array of values.
     *
     * @return int[] An array of values.
     */
    public function csv(): array
    {
        return array_map(fn($x) => (int) $x, explode(',', $this->raw));
    }

    /**
     * Parse the data as a grid.
     *
     * @return Grid
     */
    public function grid(): Grid
    {
        return new Grid(
            array_map(
                fn ($line) => str_split($line),
                $this->lines()->raw()
            )
        );
    }
}
