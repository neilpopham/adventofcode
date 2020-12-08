<?php

require('libs/core.php');

function test($data, $alter = false) {
    if ($alter) {
        $jmp = [];
        foreach ($data as $l => $line) {
            if (preg_match('/^jmp/', $data[$l])) {
                $jmp[] = $l;
            }
        }
    } else {
        $jmp = [PHP_INT_MAX];
    }
    foreach ($jmp as $j) {
        $a = 0;
        $l = 0;
        $done = [];
        while (isset($data[$l])) {
            if (preg_match('/^(nop|acc|jmp) (.+)$/', $data[$l], $matches)) {
                $done[$l] = 1;
                switch ($matches[1]) {
                    case "acc":
                        $a += $matches[2];
                        $l++;
                        break;
                    case "jmp":
                        if ($l == $j) {
                            $l++;
                        } else {
                            $l += $matches[2];
                        }
                        break;
                    case "nop":
                        $l++;
                }
                if (isset($done[$l])) {
                    if ($alter) {
                        $l = PHP_INT_MAX;
                    } else {
                        print("Line #{$l} has already run. Accumulator is {$a} \n");
                        return;
                    }
                }
            }
        }
        if ($l < PHP_INT_MAX) {
            print("Code complete. Accumulator is {$a} \n");
            return;
        }
    }
}

$data = load_data("8.txt");

test($data, false);

test($data, true);
