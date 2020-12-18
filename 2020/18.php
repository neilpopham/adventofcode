<?php

require('libs/core.php');



function check($data, $function) {
    $total = 0;

    foreach ($data as $key => $line) {

        $parsed = brackets($line);
        $result = parse($parsed, $function);
        $total += $result;
    }

    print "{$total} total\n";
}

function brackets($line) {
    $parsed = "";
    $b = -1;
    $bi = [];
    for ($x = 0; $x < strlen($line); $x++) {
        if ($line[$x] == "(") {
            $i = $bi[++$b] = $x;
            $parsed .= "{b" . $i . "}";
        } elseif ($line[$x] == ")") {
            $parsed .= "{/b" . ( $bi[$b--]) . "}";
        } else {
            $parsed .= $line[$x];
        }
    }
    return $parsed;
}

function operate_1($string) {
    $numbers = [];
    $operators = [];
    $string = str_replace(" ", "", $string);
    if (preg_match_all('/[\+\*]/', $string, $matches)) {
        $operators = $matches[0];
    } else {
        return $string;
    }
    if (preg_match_all('/\d+/', $string, $matches)) {
        $numbers = $matches[0];
    }
    $n = 0;
    foreach ($operators as $o => $operator) {
        if (isset($numbers[$o + 1])) {
            $sum = $numbers[$n] . $operator . $numbers[++$n];
            $numbers[$n] = eval("return {$sum};");
            $string = preg_replace('/^' . preg_quote($sum) . '/', $numbers[$n], $string);
        }

    }
    return $string;
}

function operate_2($string) {
    $numbers = [];
    $operators = [];
    $string = str_replace(" ", "", $string);
    if (preg_match_all('/[\+\*]/', $string, $matches)) {
        $operators = $matches[0];
    } else {
        return $string;
    }
    if (preg_match_all('/\d+/', $string, $matches)) {
        $numbers = $matches[0];
    }
    $ordered = [];
    foreach (["+", "*"] as $value) {
        $i = array_search($value, $operators);
        while(false !== $i) {
            $ordered[$i] = $value;
            unset($operators[$i]);
            $i = array_search($value, $operators);
        }
    }
    $operators = $ordered;
    foreach ($operators as $o => $operator) {
        $n1 = $o;
        $n2 = $n1 + 1;
        while (is_null($numbers[$n2])) {
            $n2++;
        }
        $sum = $numbers[$n1] . $operator . $numbers[$n2];
        $numbers[$n2] = eval("return {$sum};");
        $string = preg_replace('/' . preg_quote($sum) . '/', $numbers[$n2], $string, 1);
        $numbers[$n1] = null;
    }
    return $string;
}

function parse($string, $function) {
    if (preg_match_all('/{b(\d+)}(.+?){\/b\1}/', $string, $matches)) {
        foreach ($matches[2] as $i => $match) {
            $b = $matches[1][$i];
            $parse = parse($match, $function);
            $string = preg_replace("/{b{$b}}(.+?){\/b{$b}}/", call_user_func($function, $parse), $string);
        }
    }
    return call_user_func($function, $string);
}

$data = load_data("18.txt");

check($data, "operate_1");

check($data, "operate_2");