<?php

function load_data($file) {
    $data = file_get_contents($file);
    $data = preg_replace('/[\n\r]+/', "\n", trim($data));
    return explode("\n", $data);
}
