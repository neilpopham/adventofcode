import core
import re
from collections import Counter

def get_groups(data):
	groups = [[]]
	index = 0
	for line in data:
		if len(line.strip()) == 0:
			index += 1
			groups.append([])
		else:
			groups[index].append(line)
	return groups

def check_1(data):
	total = 0
	for group in data:
		combined = "".join(group)
		cntr = Counter(combined)
		total += len(cntr.items())
	print(total)

def check_2(data):
	total = 0
	for group in data:
		cntr = Counter(group[0])
		shared = cntr.items()
		for answers in group:
			cntr = Counter(answers)
			shared = list(set(shared) & set(cntr.items()))
		total += len(shared)
	print(total)

data = core.load_data("6.txt")

data = get_groups(data)

check_1(data)

check_2(data)

