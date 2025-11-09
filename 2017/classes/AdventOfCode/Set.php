<?php

namespace AdventOfCode;

class Set
{
    private array $items;

    public function __construct(?array $data = null)
    {
        $this->clear();

        if ($data) {
            foreach ($data as $value) {
                $this->items[$value] = 1;
            }
        }
    }

    public function __debugInfo()
    {
        return array_keys($this->items);
    }

    public function __toString()
    {
        return implode(', ', array_keys($this->items));
    }

    public function add(mixed $value): void
    {
        $this->items[$value] = 1;
    }

    public function clear(): void
    {
        $this->items = [];
    }

    public function delete($value): bool
    {
        if (isset($this->items[$value])) {
            unset($this->items[$value]);
            return true;
        } else {
            return false;
        }
    }

    public function entries(): array
    {
        return array_keys($this->items);
    }

    public function has($value): bool
    {
        return isset($this->items[$value]);
    }

    public function size(): int
    {
        return count($this->items);
    }
}
