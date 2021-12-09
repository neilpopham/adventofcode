<?php

/**
 *
 */
class AdventofCodeLines implements Iterator {

    private $position = 0;
    public $raw;

    /**
     * Instantiate using raw array from AdventOfCodeData::lines.
     * @return  void
     */
    function __construct($raw) {
        $this->raw = $raw;
        $this->position = 0;
    }

    // Iterator methods
    public function rewind() { $this->position = 0; }
    public function current() { return $this->raw[$this->position]; }
    public function key() { return $this->position; }
    public function next() { ++$this->position; }
    public function valid() { return isset($this->raw[$this->position]); }

    /**
     * Magic method so we can just use > echo $api->input(2)->lines();
     * @return  string                                      The array of lines joined with a single line feed.
     */
    function __toString() {
        return implode("\n", $this->raw);
    }

    /**
     * Test each line for a regular expression and return a collection of matches.
     * @param   string              $regex                  The regex to test.
     * @return  array                                       An array of matches.
     */
    function regex($regex) {
        $parsed = [];
        foreach ($this->raw as $value) {
            if (preg_match($regex, $value, $matches)) {
                $parsed[] = array_map(fn($x) => preg_match('/^(\d+)$/', $x) ? (int) $x : $x, $matches);
            }
        }
        return $parsed;
    }
}

/**
 *
 */
class AdventOfCodeData {

    public $raw;

    /**
     * Instantiate using raw data from site.
     * @return  void
     */
    function __construct($raw) {
        $this->raw = $raw;
    }

    /**
     * Magic method so we can just use > echo $api->input(2);
     * @return  string                                      The raw data.
     */
    function __toString() {
        return $this->raw;
    }

    /**
     * Get the raw data.
     * @return  string                                      The raw data.
     */
    public function raw() {
        return $this->raw;
    }

    /**
     * Parse the data and return an array of lines.
     * @return  string[]                                       An array of lines.
     */
    public function lines() {
        $data = preg_replace('/\r*\n/', "\n", trim($this->raw));
        return new AdventofCodeLines(explode("\n", $data));
    }

    /**
     * Parse the data as one line of comma-separated values and return an array of values.
     * @return  int[]                                       An array of values.
     */
    public function csv() {
        return array_map(fn($x) => (int) $x, explode(',', $this->raw));
    }
}

/**
 *
 */
class AdventOfCode {

    public $session;
    public $path = 'data/{day}.txt';
    public $cache = true;

    /**
     * Class constructor.
     * @param   string              $session                The session value. If omitted the method will look for session.txt.
     * @return  void
     */
    function __construct($session = null) {
        if (is_null($session)) {
            if (file_exists('session.txt')) {
                $this->session = trim(file_get_contents('session.txt'));
            }
        } else {
            $this->session = $session;
        }
    }

    /**
     * Returns data fora given day. Can use a local cache and will revert to the live file.
     * @param   integer             $day                    The puzzle day.
     * @param   boolean             $force                  Whether to force requerying the live file.
     * @return  AdventOfCodeData                            A class that can provide further parsing of the data.
     */
    public function input($day, $force = false) {
        $path = str_replace('{day}', $day, $this->path);
        $data = false;
        if (($this->cache) && (!$force) && file_exists($path)) {
            print "from cache\n";
            $data = file_get_contents($path);
        }
        if (false === $data) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://adventofcode.com/2021/day/{$day}/input");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Cookie: session=' . $this->session]);
            $data = curl_exec($ch);
            curl_close($ch);
            if ($this->cache) {
                file_put_contents($path, $data);
            }
        }
        return new AdventOfCodeData($data);
    }
}

$api = new AdventOfCode();


print '|' . $api->session . "|\n";

echo $api->input(6);
print_r($api->input(5)->lines());

$lines = $api->input(5)->lines();
var_dump($lines);

foreach ($lines as $key => $value) {
    print "{$key} = {$value}\n";
}

exit;
echo $api->input(5)->lines();


exit;
var_dump($api->input(6)->csv());

exit;

print_r($api->input(5)->lines());

var_dump($api->input(5)->lines()->regex('/(\d+),(\d+)\s?\->\s?(\d+),(\d+)/'));

exit("\n");
