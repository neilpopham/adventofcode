<?php

namespace AdventOfCode;

/**
 *
 */
class AdventofCodeLines implements \Iterator
{
    private $position;
    public $raw;

    /**
     * Instantiate using raw array from AdventOfCodeData::lines.
     *
     * @param  array $raw The array of lines of data.
     * @return void
     */
    public function __construct(array $raw)
    {
        $this->raw = $raw;
        $this->position = 0;
    }

    /**
     * Iterator methods
     */
    public function rewind(): void
    {
        $this->position = 0;
    }

    public function current(): mixed
    {
        return $this->raw[$this->position];
    }

    public function key(): mixed
    {
        return $this->position;
    }

    public function next(): void
    {
        ++$this->position;
    }

    public function valid(): bool
    {
        return isset($this->raw[$this->position]);
    }

    /**
     * Magic method so we can just use > echo $api->input(2)->lines();
     *
     * @return string The array of lines joined with a single line feed.
     */
    public function __toString(): string
    {
        return implode("\n", $this->raw);
    }

    /**
     * Return an array of lines.
     *
     * @return string[] An array of lines.
     */
    public function raw(): array
    {
        return $this->raw;
    }

    /**
     * Test each line for a regular expression and return a collection of matches.
     *
     * @param  string  $regex The regex to test.
     * @param  boolean $slice Whether to remove the full match at index 0.
     * @return array[] An array of matches.
     */
    public function regex(string $regex, bool $slice = true): array
    {
        $parsed = [];
        foreach ($this->raw as $i => $value) {
            if (preg_match($regex, $value, $matches)) {
                $parsed[$i] = array_map(
                    fn($x) => preg_match('/^(\d+)$/', $x) ? (int) $x : $x,
                    $slice ? array_slice($matches, 1) : $matches
                );
            }
        }
        return $parsed;
    }

    /**
     * Performs a function on each element of the array and returns that new array.
     * @param  object $callback The function to perform on each line.
     * @return mixed[] The new array.
     */
    public function map(object $callback): array
    {
        return array_map($callback, $this->raw);
    }    
}
