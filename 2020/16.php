<?php

require('libs/core.php');

function process_data($data) {
    $rules = [];
    $others = [];
    $mode = "rules";
    $i = 0; 
    while ($i < count($data)) {
        $line = $data[$i];    
        if (!empty($line)) {
            if (strpos($line, "your ticket:") === 0) {
                $ticket = explode(",", $data[++$i]);
            } elseif (strpos($line, "nearby tickets:") === 0) {
                $mode = "others";
            } elseif ($mode == "rules") {
                if (preg_match('/^([\w ]+): (\d+)\-(\d+) or (\d+)\-(\d+)$/', $line, $matches)) {
                    $rules[$matches[1]] = [[$matches[2], $matches[3]], [$matches[4], $matches[5]]];
                }           
            } elseif ($mode == "others") {
                $others[] = explode(",", $line);
            }
        }
        $i++;
    }
    return [$rules, $ticket, $others];
}

function check_1($data) {
    list($rules, $ticket, $others) = process_data($data);
    $invalid = [];
    foreach ($others as $o => $values) {
        foreach ($values as $value) {
            $valid = false;
            foreach ($rules as $rule => $ranges) {
                foreach($ranges as $range) {
                    if ($value >= $range[0] && $value <= $range[1]) {
                        $valid = true;
                        continue;
                    }
                }
            }
            if (!$valid) {
                $invalid[$o] = $value;
            } 
        }
    }   
    print array_sum($invalid) . "\n";
    return $invalid;
}

function check_2($data, $invalid) {
    list($rules, $ticket, $others) = process_data($data);
    $matches = [];
    for ($i = 0; $i < count($ticket); $i++) {
        foreach ($rules as $rule => $ranges) {
            $valid = true;
            foreach ($others as $o => $values) {
                if (isset($invalid[$o])) {
                    continue;
                }
                $vrange = false;
                foreach($ranges as $range) {
                    if ($values[$i] >= $range[0] && $values[$i] <= $range[1]) {
                        $vrange = true;
                    }
                }
                $valid = ($valid && $vrange);
                if (!$valid) {
                    break;
                }
            }
            if ($valid) {
                $matches[$i][] = $rule;
            }
        }  
    }
    $sorted = [];
    foreach ($matches as $i => $rules) {
        $sorted[$i] = count($rules);
    }
    asort($sorted);
    $changed = true;
    while ($changed) {
        $changed = false;
        foreach ($sorted as $i => $c) {
            if (count($matches[$i]) == 1) {
                foreach($matches as $j => $rules) {
                    if ($j == $i) {
                        continue;
                    }
                    $key = array_search(reset($matches[$i]), $matches[$j]);
                    if (false !== $key) {
                        unset($matches[$j][$key]);
                        $changed = true;
                    }
                }
            }
        }        
    }
    $sum = 1;
    foreach ($matches as $i => $columns) {
        foreach ($columns as $index => $rule) {
            if (strpos($rule, "departure") === 0) {
                $sum *= $ticket[$i];
            }            
        }
    }
    print "{$sum}\n";
}

$data = load_data("16.txt");

$invalid = check_1($data);

check_2($data, $invalid);
