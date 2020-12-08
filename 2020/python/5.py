import core
import re

data = core.load_data("5.txt")

seats = []

for value in data:
	value = re.sub("[FL]", "0", value)
	value = re.sub("[BR]", "1", value)
	row = int(value[0:7], 2)
	column = int(value[7:], 2)
	id = row * 8 + column
	seats.append(id)

seats.sort()

min = seats[0]
max = seats[-1]

print("Max is %d" % max)

for i in range(min, max):
	if not i in seats:
		print("Seat %d is missing" % i)
