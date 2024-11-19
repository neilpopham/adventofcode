<?php 

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
}

function red(string $string, bool $bright = false): void
{
    color($string, 'red', $bright);
}

function green(string $string, bool $bright = false): void
{
    color($string, 'green', $bright);
}

function yellow(string $string, bool $bright = false): void
{
    color($string, 'yellow', $bright);
}

function blue(string $string, bool $bright = false): void
{
    color($string, 'blue', $bright);
}

function magenta(string $string, bool $bright = false): void
{
    color($string, 'magenta', $bright);
}

function cyan(string $string, bool $bright = false): void
{
    color($string, 'cyan', $bright);
}

/**
 * Print a string with its foreground and background colours inverted.
 *
 * @param  string  $string The string to print.
 * @return void
 */
function invert(string $string): void
{
    print Formatting::format($string, 7);
}

/**
 * Print a string using color.
 *
 * @param  string  $string The string to print.
 * @param  string  $color  The colour to use.
 * @param  boolean $bright Whether to use the bright version of the colour.
 * @return void
 */
function color(string $string, string $color = 'default', bool $bright = false): void
{
    print Formatting::format($string, Formatting::code($color, $bright));
}

/**
 * Use markup to format text, e.g. <cyan bright>Hello</cyan> <red>World</red>!
 *
 * @param  string $string The markup string.
 * @return void
 */
function colup(string $string): void
{
    $color = implode('|', array_keys(Formatting::colors()));
    if (
        preg_match_all(
            '/<(' . $color . ')( bright)*>(.+?)<\/\1>/',
            $string,
            $matches,
            PREG_SET_ORDER
        )
    ) {
        foreach ($matches as $match) {
            $code = Formatting::code($match[1], !empty($match[2]));
            $string = str_replace(
                $match[0],
                Formatting::format($match[3], $code),
                $string
            );
        }
    }
    print $string;
}
