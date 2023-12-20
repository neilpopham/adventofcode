<?php

/**
 *
 */
class AdventofCodeLines implements Iterator
{
    private $position;
    public $raw;

    /**
     * Instantiate using raw array from AdventOfCodeData::lines.
     *
     * @param array $raw
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
     * @param string $regex The regex to test.
     * @param bool $slice Whether to remove the full match at index 0.
     * @return string[] An array of matches.
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
}

/**
 *
 */
class AdventOfCodeData
{
    public $raw;

    /**
     * Instantiate using raw data from site.
     *
     * @param string|null $raw
     * @return void
     */
    public function __construct(?string $raw)
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
     * @param bool $trim Whether to trim the raw text.
     * @return string The raw data.
     */
    public function raw(bool $trim = true): string
    {
        return $trim ? trim($this->raw) : $this->raw;
    }

    /**
     * Parse the data and return an array of lines.
     *
     * @param bool $trim Whether to trim the raw text.
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
}

/**
 *
 */
class AdventOfCode
{
    public const YEAR = 2023;

    public $session;
    public $path = 'data/{name}.txt';
    public $cache = true;

    /**
     * Class constructor.
     *
     * @param string $session The session value. If omitted the method will look for session.txt.
     * @return void
     */
    public function __construct(?string $session = null)
    {
        if (is_null($session)) {
            if (file_exists(__DIR__ . '/session.txt')) {
                $this->session = trim(file_get_contents(__DIR__ . '/session.txt'));
            }
        } else {
            $this->session = $session;
        }
    }

    /**
     * Returns data for a given day. Can use a local cache and will revert to the live file.
     *
     * @param integer $day The puzzle day.
     * @param boolean $force Whether to force requerying the live file.
     * @return AdventOfCodeData A class that can provide further parsing of the data.
     */
    public function input(int $day, bool $force = false): AdventOfCodeData
    {
        $path = $this->calculatePath($day);
        $data = false;
        if (($this->cache) && (!$force) && file_exists($path)) {
            $data = file_get_contents($path);
        }
        if (false === $data) {
            $year = self::YEAR;
            $url = "github.com/neilpopham/adventofcode/blob/master/{$year}/libs/api.php";
            $email = 'neilpopham@gmail.com';
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://adventofcode.com/{$year}/day/{$day}/input");
            curl_setopt($ch, CURLOPT_HTTPHEADER, ["Cookie: session={$this->session}"]);
            curl_setopt($ch, CURLOPT_USERAGENT, "{$url} by {$email}");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_AUTOREFERER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            $data = curl_exec($ch);
            curl_close($ch);
            if ($this->cache) {
                file_put_contents($path, $data);
            }
            $this->examples($day, $force);
        }
        return new AdventOfCodeData($data);
    }

    /**
     * Scrapes the question page for example data and saves it in the data folder.
     *
     * @param integer $day The puzzle day.
     * @param boolean $force Whether to force requerying the live file.
     * @return void
     */
    public function examples(int $day, bool $force = false): void
    {
        $path = $this->calculatePath("{$day}.html");
        if (file_exists($path) && (!$force)) {
            return;
        }
        $year = self::YEAR;
        $url = "github.com/neilpopham/adventofcode/blob/master/{$year}/libs/api.php";
        $email = 'neilpopham@gmail.com';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://adventofcode.com/{$year}/day/{$day}");
        curl_setopt($ch, CURLOPT_HTTPHEADER, ["Cookie: session={$this->session}"]);
        curl_setopt($ch, CURLOPT_USERAGENT, "{$url} by {$email}");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_AUTOREFERER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $data = curl_exec($ch);
        curl_close($ch);
        file_put_contents($path, $data);
        if (preg_match_all('/<pre>\s*<code>\s*(.+?)\s*<\/code>\s*<\/pre>/ms', $data, $matches)) {
            foreach ($matches[1] as $i => $value) {
                $value = html_entity_decode($value);
                $path = $this->calculatePath("{$day}.{$i}");
                file_put_contents($path, $value);
            }
        }
    }

    /**
     * Returns example data for a given day.
     *
     * @param integer $day The puzzle day.
     * @param integer $index The example index.
     * @return AdventOfCodeData
     */
    public function example(int $day, int $index): AdventOfCodeData
    {
        $this->examples($day);
        return $this->load("{$day}.{$index}");
    }

    /**
     * Load data from file.
     *
     * @param string $filename The name of the file stored in the data folder.
     * @return AdventOfCodeData
     */
    public function load(string $filename): AdventOfCodeData
    {
        if (false === $data = file_get_contents($this->calculatePath($filename))) {
            return new AdventOfCodeData();
        }
        return new AdventOfCodeData($data);
    }

    /**
     * Calculates the path to a file.
     *
     * @param string $name Replaces the {name} token in the file path.
     * @return string
     */
    public function calculatePath(?string $name): string
    {
        $path = str_replace('{name}', $name, $this->path);
        if (strrpos($path, '/') !== 0) {
            $path = __DIR__ . "/{$path}";
        }
        return $path;
    }
}
