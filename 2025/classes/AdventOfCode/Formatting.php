<?php

namespace AdventOfCode;

// https://learn.microsoft.com/en-us/windows/console/console-virtual-terminal-sequences?redirectedfrom=MSDN#text-formatting

class Formatting
{
    public static function colors(): array
    {
        return [
            'black' => 30,
            'red' => 31,
            'green' => 32,
            'yellow' => 33,
            'blue' => 34,
            'magenta' => 35,
            'cyan' => 36,
            'white' => 37,
        ];
    }

    public static function code(string $id, bool $bright = false): int
    {
        $colors = self::colors();

        return ($colors[$id] ?? $colors['cyan']) + ($bright ? 60 : 0);
    }

    public static function format(string $string, int $code): string
    {
        return chr(27) . '[' . $code . 'm' . $string . chr(27) . '[0m';
    }

    /**
     * Magic method to cover all colours, e.g. Formatting:green('foo')
     */
    public static function __callStatic(string $name, array $arguments): string
    {
        return self::format(
            $arguments[0] ?? '',
            self::code($name, $arguments[1] ?? false)
        );
    }
}
