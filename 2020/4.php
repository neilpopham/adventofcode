<?php

require('libs/core.php');

function get_records($data) {
    $single = [];
    $records = [];
    foreach ($data as $i => $line) {
        if (empty(trim($line))) {
            $records[] = implode(" ", $single);
            $single = [];
        } else {
            $single[] = $line;
        }
    }
    $records[] = implode(" ", $single);
    return $records;
}

function validate_record($line) {
    if (preg_match_all('/(\w{3}):(\S+)/', $line, $matches)) {
        $fields = array_unique($matches[1]);
        if ((count($fields) >= 7) && ((count($fields) == 8) || (!in_array("cid", $fields)))) {
            return [true, $matches];
        }
    }
}

function validate_1($data) {
    $total = 0;
    foreach ($data as $i => $line) {
        if (validate_record($line)[0]) {
            $total++;
        }
    }
    print "\n{$total} valid\n";
}

function validate_2($data) {
    $total = 0;
    $hgt = ['cm' => [150, 193], 'in' => [59, 76]];
    foreach ($data as $i => $line) {
        list($valid, $matches) = validate_record($line);
        if ($valid) {
            $fields = array_combine($matches[1], $matches[2]);
            $valid = true;
            foreach ($fields as $key => $value) {
                switch ($key) {
                    case 'byr':
                        if (!preg_match('/^\d{4}$/', $value) || $value < 1920 || $value > 2002) {
                            $valid = false;
                        }
                        break;
                    case 'iyr':
                        if (!preg_match('/^\d{4}$/', $value) || $value < 2010 || $value > 2020) {
                            $valid = false;
                        }
                        break;
                    case 'eyr':
                        if (!preg_match('/^\d{4}$/', $value) || $value < 2020 || $value > 2030) {
                            $valid = false;
                        }
                        break;
                    case 'hgt':
                        if (!preg_match('/^(\d+)(cm|in)$/', $value, $matches)
                            || $matches[1] < $hgt[$matches[2]][0]
                            || $matches[1] > $hgt[$matches[2]][1]) {
                            $valid = false;
                        }
                        break;
                    case 'hcl':
                        if (!preg_match('/^#([\da-f]{6})$/', $value)) {
                            $valid = false;
                        }
                        break;
                    case 'ecl':
                        if (!in_array($value, ['amb', 'blu', 'brn', 'gry', 'grn', 'hzl', 'oth'])) {
                            $valid = false;
                        }
                        break;
                    case 'pid':
                        if (!preg_match('/^\d{9}$/', $value)) {
                            $valid = false;
                        }
                        break;
                }
            }
            if ($valid) {
                $total++;
            }
        }
    }
    print "\n{$total} valid\n";
}

$data = load_data("4.txt");

$data = get_records($data);

validate_1($data);

validate_2($data);
