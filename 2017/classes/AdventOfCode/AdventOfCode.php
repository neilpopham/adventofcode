<?php

namespace AdventOfCode;

/**
 *
 */
class AdventOfCode
{
    public const YEAR = YEAR;

    public $session;
    public $path = 'data/{name}.txt';
    public $cache = true;

    /**
     * Class constructor.
     *
     * @param  string $session The session value. If omitted the method will look for session.txt.
     * @return void
     */
    public function __construct(?string $session = null)
    {
        if (is_null($session)) {
            if (file_exists(ROOT . '/data/session.txt')) {
                $this->session = trim(file_get_contents(ROOT . '/data/session.txt'));
            }
        } else {
            $this->session = $session;
        }
    }

    /**
     * Returns the body of a URL.
     *
     * @param  string $url The url to curl.
     * @return string|null The body of the url.
     */
    public function getResponse(string $url): ?string
    {
        $year = self::YEAR;
        $app = "github.com/neilpopham/adventofcode/blob/master/{$year}/libs/api.php";
        $email = 'neilpopham@gmail.com';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ["Cookie: session={$this->session}"]);
        curl_setopt($ch, CURLOPT_USERAGENT, "{$app} by {$email}");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_AUTOREFERER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }

    /**
     * Returns data for a given day. Can use a local cache and will revert to the live file.
     *
     * @param  integer $day   The puzzle day.
     * @param  boolean $force Whether to force requerying the live file.
     * @return AdventOfCodeData A class that can provide further parsing of the data.
     */
    public function input(int $day, bool $force = false): AdventOfCodeData
    {
        $year = self::YEAR;
        $path = $this->calculatePath($day);
        $data = false;
        if ($this->cache && !$force && file_exists($path)) {
            $data = file_get_contents($path);
        }
        if (false === $data) {
            $data = $this->getResponse("https://adventofcode.com/{$year}/day/{$day}/input");
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
     * @param  integer $day   The puzzle day.
     * @param  boolean $force Whether to force requerying the live file.
     * @return void
     */
    public function examples(int $day, bool $force = false): void
    {
        $year = self::YEAR;
        $path = $this->calculatePath("{$day}.html");
        if (file_exists($path) && !$force) {
            return;
        }
        $data = $this->getResponse("https://adventofcode.com/{$year}/day/{$day}");
        file_put_contents($path, $data);
        if (preg_match_all('/<pre>\s*<code>\s*(.+?)\s*<\/code>\s*<\/pre>/ms', $data, $matches)) {
            foreach ($matches[1] as $i => $value) {
                $value = strip_tags(html_entity_decode($value));
                $path = $this->calculatePath("{$day}.{$i}");
                file_put_contents($path, $value);
            }
        }
    }

    /**
     * Returns example data for a given day.
     *
     * @param  integer $day   The puzzle day.
     * @param  integer $index The example index.
     * @return AdventOfCodeData
     */
    public function example(int $day, int $index, bool $force = false): AdventOfCodeData
    {
        $this->examples($day, $force);
        return $this->load("{$day}.{$index}");
    }

    /**
     * Load data from file.
     *
     * @param  string $filename The name of the file stored in the data folder.
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
     * @param  string $name Replaces the {name} token in the file path.
     * @return string
     */
    public function calculatePath(?string $name): string
    {
        $path = str_replace('{name}', $name, $this->path);
        if (strrpos($path, '/') !== 0) {
            $path = ROOT . "/{$path}";
        }
        return $path;
    }
}
