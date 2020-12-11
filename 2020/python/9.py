import core
import re

def check_1(numbers, max):
	array = numbers[0:max]
	i = max
	count = len(numbers)
	while i < count:
		found = False
		for l1, n1 in enumerate(array):
			for l2, n2 in enumerate(array):
				if (found == False) and (int(n1) + int(n2) == int(numbers[i])) and (l1 != l2):
					array.append(numbers[i])
					array = array[1:]
					found = True
					break
		if found == False:
			print("Could not find %d" % int(numbers[i]))
			return int(numbers[i])
		i += 1

def check_2(numbers, invalid):
	for i, value in enumerate(numbers):
		array = []
		for j in range(i, 0, -1):
			array.append(int(numbers[j]))
			count = sum(array)
			if count == invalid:
				array.sort()
				max = array[-1]
				min = array[0]
				print("Sum is %d" % (min + max))
				return
			if count > invalid:
				break

numbers = core.load_data("9.txt")

invalid = check_1(numbers, 25)

check_2(numbers, invalid)
