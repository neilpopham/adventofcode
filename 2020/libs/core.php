<?php

function load_data($file) {
    $data = file_get_contents(dirname(__DIR__) . "/data/$file");
    $data = preg_replace('/[\n\r]+/', "\n", trim($data));
    return explode("\n", $data);
}
