<?php

function load_data($file) {
    $data = load_file($file);
    $data = preg_replace('/\r*\n/', "\n", trim($data));
    return explode("\n", $data);
}

function load_list($file) {
    $data = load_file($file);
    return array_map(fn($x) => (int) $x, explode(',', trim($data)));
}

function load_file($file) {
    return file_get_contents(dirname(__DIR__) . "/data/$file");
}
