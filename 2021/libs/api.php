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
    public function rewind():void { $this->position = 0; }
    public function current():mixed { return $this->raw[$this->position]; }
    public function key():mixed { return $this->position; }
    public function next():void { ++$this->position; }
    public function valid():bool { return isset($this->raw[$this->position]); }

    /**
     * Magic method so we can just use > echo $api->input(2)->lines();
     * @return  string                                      The array of lines joined with a single line feed.
     */
    function __toString() {
        return implode("\n", $this->raw);
    }

    /**
     * Return an array of lines.
     * @return  string[]                                    An array of lines.
     */
    function raw() {
        return $this->raw;
    }

    /**
     * Test each line for a regular expression and return a collection of matches.
     * @param   string              $regex                  The regex to test.
     * @param   bool                $slice                  Whether to remove the full match at index 0.
     * @return  string[]                                    An array of matches.
     */
    function regex($regex, $slice = true) {
        $parsed = [];
        foreach ($this->raw as $i => $value) {
            if (preg_match($regex, $value, $matches)) {
                $parsed[$i] = array_map(fn($x) => preg_match('/^(\d+)$/', $x) ? (int) $x : $x, $slice ? array_slice($matches, 1) : $matches);

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

    /**
     * Load data from file.
     * @param   string              $filename               The name of the file stored in the data folder.
     * @return  void
     */
    public function load($filename) {
        $path = __DIR__ . "data/{$filename}.txt";
        if (strrpos($path, '/') !== 0) {
            $path = __DIR__ . "/{$path}";
        }        
        $this->raw = file_get_contents($path);
    }
}

/**
 *
 */
class AdventOfCode {

    const YEAR = 2021;

    public $session;
    public $path = 'data/{name}.txt';
    public $cache = true;

    /**
     * Class constructor.
     * @param   string              $session                The session value. If omitted the method will look for session.txt.
     * @return  void
     */
    function __construct($session = null) {
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
     * @param   integer             $day                    The puzzle day.
     * @param   boolean             $force                  Whether to force requerying the live file.
     * @return  AdventOfCodeData                            A class that can provide further parsing of the data.
     */
    public function input(int $day, bool$force = false): AdventOfCodeData {
        $path = $this->calculatePath($day);
        $data = false;
        if (($this->cache) && (!$force) && file_exists($path)) {
            print "from cache\n";
            $data = file_get_contents($path);
        }
        if (false === $data) {
            $year = self::YEAR;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://adventofcode.com/{$year}/day/{$day}/input");
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

    /**
     * Load data from file.
     * @param   string              $filename               The name of the file stored in the data folder.
     * @return  void
     */
    public function load($filename) {     
        $data = file_get_contents($$this->calculatePath($filename));
        return new AdventOfCodeData($data);
    }

    /**
     * Calculates the path to a file.
     * @param   string              $name                   The puzzle day.
     * @return  string
     */
    public function calculatePath(?string $name): string {
        $path = str_replace('{name}', $name, $this->path);
        if (strrpos($path, '/') !== 0) {
            $path = __DIR__ . "/{$path}";
        }     
        return $path;   
    }
}
