<?php

require('libs/core.php');

$data = load_data("19.txt");

function get_parts($data) {
	$rules = [];
	$strings = [];
	$array = &$rules;
	foreach($data as $line) {
		if (empty($line)) {
			$array = &$strings;
		} else {
			$array[] = $line;
		}
	}
	return [$rules, $strings];
}

function check($data, $star2 = false) {
	list($r,$strings) = get_parts($data);

	$rules = [];
	foreach ($r as $key => $value) {
		if (preg_match('/^(\d+): "(\w)"$/', $value, $matches)) {
			$rules[$matches[1]] = $matches[2];
		} elseif (preg_match('/^(\d+): ([\d\s|]+)$/', $value, $matches)) {
			if ($star2) {
				if ($matches[1] == 8) {
					$matches[2] = "42 | 42 8";
				}
				if ($matches[1] == 11) {
					$matches[2] = "42 31 | 42 11 31";
				}
			}
			$rule = explode("|", $matches[2]);
			foreach ($rule as $key => $value) {
				$rule[$key] = explode(" ", trim($value));
			}
			$rules[$matches[1]] = $rule;
		}
	}
	ksort($rules);

	$chars = [];
	foreach ($rules as $key => $rule) {
		if (is_string($rule)) {
			$chars[$rule] = $rule;
		}
	}

	$found = true;
	while ($found == true) {
		$found = false;
		foreach ($rules as $key => $rule) {
			$rdone = true;
			if (is_string($rule)) {
				continue;
			}
			foreach ($rule as $p => $part) {
				$pdone = true;
				if (is_string($part)) {
					continue;
				}
				foreach ($part as $f => $ref) {
					if (!in_array($ref, $chars)) {
						if (is_string($rules[$ref])) {
							$rules[$key][$p][$f] = $rules[$ref];
						} else {
							$pdone = false;
							$rdone = false;
							$found = true;
						}
					}
				}
				if ($pdone) {
					$rules[$key][$p] = implode("", $rules[$key][$p]);
				}
			}
			if ($rdone) {
				$rules[$key] = '(' . implode("|", $rules[$key]) . ')';
				$rules[$key] = preg_replace(
					[
						'/\(([ab]{1})\|([ab]{1})\)/',
						'/\(([ab]+)\)/',
						'/\(([ab])([ab])\|\1([ab])\)/'
					],
					[
						'[$1$2]',
						'$1',
						'$1[$2$3]'
					],
					$rules[$key]
				);
			} elseif ($star2 && ($key == 8 || $key == 11)) {
				if (is_string($rules[$key][0])) {
					$done = true;
					foreach ($rules[$key][1] as $i => $value) {
						if ($value == $key) {
							$index = $i;
						} elseif (strval((int) $value) == $value) {
							$done = false;
						}
					}
					if ($done) {
						$rules[$key][1][$index] = "\g<key{$key}>";
						$rules[$key][1] = implode("", $rules[$key][$p]);
						$rules[$key] = "(?<key{$key}>" . implode("|", $rules[$key]) . ')';
					}
				}
			}
		}
	}

	$total = 0;
	$reg = '/^(' . $rules[0] . ')$/';
	foreach ($strings as $key => $string) {
		if (preg_match($reg, $string)) {
			$total++;
		}
	}
	print "{$total}\n";
}

check($data);

check($data, true);
