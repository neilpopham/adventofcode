import core
import re

def get_records(data):
	single = []
	records = []
	for line in data:
		if len(line.strip()) == 0:
			records.append(" ".join(single))
			single = []
		else:
			single.append(line)
	records.append(" ".join(single))
	return records

def validate_record(line):
	matches = re.findall('(\w{3}):(\S+)', line)
	if (matches == None) or len(matches) < 7:
		return [False]
	fields = []
	for match in matches:
		fields.append(match[0])
	if (len(fields) == 8) or not ("cid" in fields):
		return [True, matches]
	return [False]

def validate_1(data):
	total = 0
	for line in data:
		response = validate_record(line)
		if response[0]:
			total += 1
	print("%d valid" % total)

def validate_2(data):
	total = 0
	hgt = {'cm' : [150, 193], 'in' : [59, 76]}
	for line in data:
		response = validate_record(line)
		if response[0]:
			valid = True
			for match in response[1]:
				if match[0] == "byr":
					if (re.match('^\d{4}$', match[1]) == None) or (int(match[1]) < 1920) or (int(match[1]) > 2002):
						valid = False
				elif match[0] == "iyr":
					if (re.match('^\d{4}$', match[1]) == None) or (int(match[1]) < 2010) or (int(match[1]) > 2020):
						valid = False
				elif match[0] == "eyr":
					if (re.match('^\d{4}$', match[1]) == None) or (int(match[1]) < 2020) or (int(match[1]) > 2030):
						valid = False
				elif match[0] == "hgt":
					m = re.match('^(\d+)(cm|in)$', match[1])
					if (m == None) or (int(m.group(1)) < hgt[m.group(2)][0]) or (int(m.group(1)) > hgt[m.group(2)][1]):
						valid = False
				elif match[0] == "hcl":
					m = re.match('^#([\da-f]{6})$', match[1])
					if m == None:
						valid = False
				elif match[0] == "ecl":
					if not match[1] in ['amb', 'blu', 'brn', 'gry', 'grn', 'hzl', 'oth']:
						valid = False
				elif match[0] == "pid":
					m = re.match('^\d{9}$', match[1])
					if m == None:
						valid = False
			if valid:
				total += 1
	print("%d valid" % total)

data = core.load_data("4.txt")

data = get_records(data);

validate_1(data);

validate_2(data);
