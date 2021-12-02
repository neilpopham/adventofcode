<?php

function load_data($file) {
    $data = file_get_contents(dirname(__DIR__) . "/data/$file");
    $data = preg_replace('/\r*\n/', "\n", trim($data));
    return explode("\n", $data);
}
