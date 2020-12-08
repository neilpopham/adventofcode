import core
import re

def validate_1(numbers):
	total = 0
	for line in numbers:
		matches = re.search('^(\d+)\-(\d+) (\w): (\w+)$', line) # None if not found
		if matches == None:
			continue
		else:
			count = matches.group(4).count(matches.group(3))
			valid = (count >= int(matches.group(1))) and (count <= int(matches.group(2)))
			if valid:
				total += 1
	print("%s are valid" % total)

def validate_2(numbers):
	total = 0
	for line in numbers:
		matches = re.search('^(\d+)\-(\d+) (\w): (\w+)$', line)
		if matches == None:
			continue
		else:
			char1 = matches.group(4)[int(matches.group(1)) - 1]
			char2 = matches.group(4)[int(matches.group(2)) - 1]
			valid1 = char1 == matches.group(3)
			valid2 = char2 == matches.group(3)
			valid = valid1 ^ valid2
			if valid:
				total += 1
	print("%s are valid" % total)

passwords = core.load_data("2.txt")

validate_1(passwords);

validate_2(passwords);
