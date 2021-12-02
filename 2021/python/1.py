import core
import sys

def part1(numbers):
	previous = sys.maxsize
	total = 0
	for value in numbers:
		value = int(value)
		if value > previous:
			total += 1
		previous = value
	print(total)

def part2(numbers):
	previous = sys.maxsize
	total = 0
	for i in range(0, len(numbers) - 2): 
		value = int(numbers[i]) + int(numbers[i + 1]) + int(numbers[i + 2])
		if value > previous:
			total += 1
		previous = value
	print(total)

numbers = core.load_data("1.txt")

part1(numbers)

part2(numbers)
