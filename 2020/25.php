<?php

require(__DIR__ . '/libs/core.php');

function transform($loop, $subject) {
    $number = 1;
    for($i = 0; $i < $loop; $i++) {
        $number *= $subject;
        $number = fmod($number, 20201227);
    }
    return $number;
}

function loop($key, $subject = 7) {
    $number = 1;
    $loop = 0;
    while ($number != $key) {
        $number *= $subject;
        $number = fmod($number, 20201227);
        $loop++;
    }
    return $loop;
}

$data = load_data("25.txt");

$card = ['public' => $data[0]];
$door = ['public' => $data[1]];

$card['loop'] = loop($card['public'], 7);
$door['loop'] = loop($door['public'], 7);

$card['encryption'] = transform($door['loop'], $card['public']);
$door['encryption'] = transform($card['loop'], $door['public']);

print_r($card);
print_r($door);
